<?php
namespace App\Controller;

use App\Entity\Partida;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use App\Repository\PartidaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PartidaApiController extends AbstractController
{
    #[Route('/api/partidas', methods:['GET'])]
    public function getAllPartidas(PartidaRepository $partidaRepository, Request $request): Response
    {
        $page = $request->query->get('page', 1);
        $partidas = $partidaRepository->findBy(
            array(),
            array('codigo' => 'ASC')
        );

        $partidaArray = $this->makeArray($partidas);
       
        $adapter = new ArrayAdapter($partidaArray);
        $pagerfanta = new Pagerfanta($adapter);


        $pagerfanta->setCurrentPage($page); // 1 by default

        $currentPageResults = $pagerfanta->getCurrentPageResults();
        $responseArray= array();

        $responseArray['results'] = $currentPageResults;
        $responseArray['has_previous'] = $pagerfanta->hasPreviousPage();
        $responseArray['has_next'] = $pagerfanta->hasNextPage();
        $responseArray['total_pages'] = $pagerfanta->getNbPages();
        $responseArray['current'] = $page;

        // dd ($pagerfanta->getNbPages(), $pagerfanta->hasPreviousPage(), $pagerfanta->hasNextPage());

        return new JsonResponse($responseArray);

    }

    #[Route('/api/partidas/{id}', methods:['GET'])]
    public function findPartidaById($id, PartidaRepository $partidaRepository): Response
    {
        $partida = $partidaRepository->findOneBy(['id' => $id]);

        $partidaData = [];
        $partidaData['codigo'] = $partida->getCodigo();
        $partidaData['nombre'] = $partida->getNombre();
        $partidaData['nivel'] = $partida->getNivel();
        $partidaData['acumula'] = $partida->getAcumula();
        if ($partida->getPadre()){
            $partidaData['padre'] = $partida->getPadre()->getId();
        } else {
            $partidaData['padre'] = null;
        }

        return  new JsonResponse($partidaData);
    }

    #[Route('/api/partidas-acumula')]
    public function getAllAcumula(PartidaRepository $partidaRepository): Response
    {
        $partidas = $partidaRepository->getAllAcumula();

        $partidaArray = $this->makeArray($partidas);

        return new JsonResponse($partidaArray);
    }

    #[Route('/api/partidas-add', methods:'POST')]
    public function add(Request $request, EntityManagerInterface $em, PartidaRepository $partidaRepository)
    {
        try{
            $codigoPadre = $request->request->get('padre');
            // dd($codigoPadre);
            $padre = $partidaRepository->findOneBy(['id' => $codigoPadre]);
            $partida = new Partida();
            $partida->setCodigo($request->request->get('codigo'));
            $partida->setNombre($request->request->get('nombre'));
            if ($request->request->get('acumula')){
                $partida->setAcumula($request->request->get('acumula'));
            } else {
                $partida->setAcumula(false);
            }
            $partida->setPadre($padre);
            $partida->setNivel($request->request->get('nivel'));

            $em->persist($partida);
            $em->flush();

            return new JsonResponse(json_encode($partida));
        } catch (Exception $e) {
            $error = $this->obtieneRazones($request->request->get('codigo'), $request->request->get('nombre'), $partidaRepository);

            return new JsonResponse($error, 400);
        }

    }

    #[Route('/api/partidas-edit/{id}', methods:'POST')]
    public function edit($id, Request $request, PartidaRepository $partidaRepository, EntityManagerInterface $em)
    {
        $partida = $partidaRepository->findOneBy(['id' => $id]);

        try {
            $codigoPadre = $request->request->get('padre');
            // dd($codigoPadre);
            $padre = $partidaRepository->findOneBy(['id' => $codigoPadre]);
            $partida->setCodigo($request->request->get('codigo'));
            $partida->setNombre($request->request->get('nombre'));
            if ($request->request->get('acumula')){
                $partida->setAcumula($request->request->get('acumula'));
            } else {
                $partida->setAcumula(false);
            }
            $partida->setPadre($padre);
            $partida->setNivel($request->request->get('nivel'));

            $em->flush();
            return new JsonResponse(json_encode($partida));

        } catch (Exception $e){
            $error = $this->obtieneRazones($request->request->get('codigo'), $request->request->get('nombre'), $partidaRepository);
            $error[] = $e->getMessage();

            return new JsonResponse($error, 400);
        }
    }

    private function obtieneRazones(String $codigo, String $nombre, PartidaRepository $partidaRepository)
    {
        $error = array();
        $data = $partidaRepository->findOneBy(['codigo' => $codigo]);
        if ($data){
            $error['codigo'] = "Codigo de partida ya existe";
        }
        $data = $partidaRepository->findOneBy(['nombre' => $nombre]);
        if ($data){
            $error['nombre'] = "Nombre de partida ya existe";
        }


        return $error;
    }
    
    /**
     * makeArray
     *
     * @param  Partida[] $partidas
     * @return array
     */
    private function makeArray($partidas): array
    {
        $partidaArray = array();
        foreach($partidas as $partida){
            $helper = array();
            $helper['id'] = $partida->getId();
            $helper['codigo'] = $partida->getCodigo();
            $helper['nombre'] = $partida->getNombre();
            $helper['nivel'] = $partida->getNivel();
            $helper['acumula'] = $partida->getAcumula();
            if ($partida->getPadre()){
                $helper['padre'] = $partida->getPadre()->getId();
                $helper['codigopadre'] = $partida->getPadre()->getCodigo();
            } else {
                $helper['padre'] = null;
                $helper['codigopadre'] = null;
            }

            $partidaArray[] = $helper;
        }

        return $partidaArray;
    }
}