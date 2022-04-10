<?php
namespace App\Controller;

use Pagerfanta\Pagerfanta;
use App\Entity\Presupuesto;
use Pagerfanta\Adapter\ArrayAdapter;
use App\Repository\PresupuestoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        return new JsonResponse($presupuestosJson);
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