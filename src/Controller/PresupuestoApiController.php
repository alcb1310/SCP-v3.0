<?php
namespace App\Controller;

use Pagerfanta\Pagerfanta;
use App\Entity\Presupuesto;
use App\Repository\ObraRepository;
use Pagerfanta\Adapter\ArrayAdapter;
use App\Repository\PartidaRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PresupuestoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PresupuestoApiController extends AbstractController
{
    #[Route('/api/presupuestos', methods:'GET')]
    public function getAllPresupuesto(Request $request,PresupuestoRepository $presupuestoRepository):Response
    {
        $page = $request->query->get('page', 1);
        $presupuestos = $presupuestoRepository->findAll();

        $presupuestosJson = $this->makeArray($presupuestos);

        $adapter = new ArrayAdapter($presupuestosJson);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(15);


        $pagerfanta->setCurrentPage($page); // 1 by default

        $currentPageResults = $pagerfanta->getCurrentPageResults();

        $responseArray= array();

        $responseArray['results'] = $currentPageResults;
        $responseArray['has_previous'] = $pagerfanta->hasPreviousPage();
        $responseArray['has_next'] = $pagerfanta->hasNextPage();
        $responseArray['total_pages'] = $pagerfanta->getNbPages();
        $responseArray['current'] = $page;


        return new JsonResponse($responseArray);

    }

    #[Route('/api/presupuestos', methods:"POST")]
    public function addPresupuesto(Request $request, ObraRepository $obraRepository, PartidaRepository $partidaRepository, PresupuestoRepository $presupuestoRepository, EntityManagerInterface $em) : Response
    {
        $obraCod = $request->request->get('obra');
        $partidaCod = $request->request->get('partida');

        $obra = $obraRepository->findOneBy(['id' => $obraCod]);
        $partida = $partidaRepository->findOneBy(['id' =>$partidaCod]);

        $presupuesto = new Presupuesto();
        $presupuesto->setObra($obra);
        $presupuesto->setPartida($partida);
        $presupuesto->setCantini($request->request->get('cantidad'));
        $presupuesto->setCostoini($request->request->get('unitario'));
        $presupuesto->setTotalini($request->request->get('total'));
        $presupuesto->setRendidocant(0);
        $presupuesto->setRendidotot(0);
        $presupuesto->setPorgascan($request->request->get('cantidad'));
        $presupuesto->setPorgascost($request->request->get('unitario'));
        $presupuesto->setPorgastot($request->request->get('total'));
        $presupuesto->setPresactu($request->request->get('total'));

        try {
            $this->saveNewPresupuesto($presupuesto, $partidaRepository, $presupuestoRepository, $em);

            return new JsonResponse($this->makeArrayFromOne($presupuesto), 200);
        } catch (Exception $e){
            $error = array();
            $error['error']['mensaje'] = $e->getMessage();
            $error['error']['codigo'] = $e->getCode();
            return new JsonResponse($error, 403);
        }
    }



    /**
     * * Graba un presupuesto y actualiza todos los elementos padres
     *
     * @param  Presupuesto $presupuesto
     * @param PartidaRepository $partidaRepository
     * @param PresupuestoRepository $presupuestoRepository
     * @param EntityManagerInterface $em
     * @return true|Exception
     */
    private function saveNewPresupuesto(Presupuesto $presupuesto, PartidaRepository $partidaRepository, PresupuestoRepository $presupuestoRepository, EntityManagerInterface $em)
    {
        $partida = $presupuesto->getPartida();
        $em->beginTransaction();
        try {
            $em->persist($presupuesto);
            $em->flush();

            $padre = $partida->getPadre();
            while ($padre){
                $partida = $partidaRepository->findOneBy(['id' => $padre]); // *Obtiene la  partida para grabar el nuevo presupuesto

                $newPresupuesto = $presupuestoRepository->findOneBy([
                    'obra' => $presupuesto->getObra(),
                    'partida' => $partida,
                ]);

                if ($newPresupuesto){
                    //  * Actualiza una partida presupuestaria
                    $newPresupuesto->setTotalini($newPresupuesto->getTotalini() + $presupuesto->getTotalini());
                    $newPresupuesto->setRendidotot($newPresupuesto->getRendidotot() + $presupuesto->getRendidotot());
                    $presupuesto->setPresactu($newPresupuesto->getPresactu() + $presupuesto->getPresactu());

                    $em->flush();
                } else {
                    // * Crea una nueva partida presupuestaria
                    $newPresupuesto = new Presupuesto();
                    $newPresupuesto->setObra($presupuesto->getObra());
                    $newPresupuesto->setPartida($partida);
                    $newPresupuesto->setTotalini($presupuesto->getTotalini());
                    $newPresupuesto->setRendidotot(0);
                    $newPresupuesto->setPorgastot($presupuesto->getPorgastot());
                    $newPresupuesto->setPresactu($presupuesto->getPresactu());

                    $em->persist($newPresupuesto);
                    $em->flush();
                }

                $padre = $partida->getPadre(); // *Obtiene la siguiente partida padre
            }

            $em->commit();
            return true;
        } catch (Exception $e) {
            $em->rollback();
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * makeArrayFromOne
     *
     * @param  Presupuesto $presupuesto
     * @return array
     */
    private function makeArrayFromOne($presupuesto):array
    {
        $array = array();

        $array['id'] = $presupuesto->getId();
        $obra = $presupuesto->getObra();
        $array['obra']['id'] = $obra->getId();
        $array['obra']['nombre'] = $obra->getNombre();
        $partida = $presupuesto->getPartida();
        $array['partida']['id'] = $partida->getId();
        $array['partida']['codigo'] = $partida->getCodigo();
        $array['partida']['nombre'] = $partida->getNombre();
        $array['cantini'] = $presupuesto->getCantini();
        $array['costoini'] = $presupuesto->getCostoini();
        $array['totalini'] = $presupuesto->getTotalini();
        $array['rendidocan'] = $presupuesto->getRendidocant();
        $array['rendidotot'] = $presupuesto->getRendidotot();
        $array['porgascan'] = $presupuesto->getPorgascan();
        $array['porgasuni'] = $presupuesto->getPorgascost();
        $array['porgastot'] = $presupuesto->getPorgastot();
        $array['presactu'] = $presupuesto->getPresactu();

        return $array;
    }

    /**
     * makeArray
     *
     * @param  Presupuesto[] $presupuestos
     * @return array
     */
    private function makeArray($presupuestos): array
    {
        $helper = array();
        foreach ($presupuestos as $presupuesto){
            $helper[] = $this->makeArrayFromOne($presupuesto);
        }

        return $helper;
    }
}