<?php
namespace App\Controller;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use App\Repository\PartidaRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
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
        $partidas = $partidaRepository->findAll();

        $partidaArray = array();
        foreach($partidas as $partida){
            $helper = array();
            $helper['id'] = $partida->getId();
            $helper['codigo'] = $partida->getCodigo();
            $helper['nombre'] = $partida->getNombre();
            $helper['nivel'] = $partida->getNivel();
            $helper['acumula'] = $partida->getAcumula();
            if ($partida->getPadre()){
                $helper['padre'] = $partida->getPadre()->getCodigo();
            } else {
                $helper['padre'] = null;
            }

            $partidaArray[] = $helper;
        }

       
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
            $partidaData['padre'] = $partida->getPadre()->getCodigo();
        } else {
            $partidaData['padre'] = null;
        }

        return  new JsonResponse($partidaData);
    }
}