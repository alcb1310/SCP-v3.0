<?php
namespace App\Controller;

use App\Entity\Obra;
use App\Repository\ObraRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ObraApiController extends AbstractController
{
    #[Route('/api/obras', methods:'GET')]
    public function getObras(ObraRepository $obraRepository): Response
    {
        $obra = $obraRepository->findAll();

        return new JsonResponse($this->makeArray($obra));
    }

    #[Route('/api/obras/{id}', methods:'GET')]
    public function getOneObra($id, ObraRepository $obraRepository): Response
    {
        $obra = $obraRepository->findOneBy(['id' => $id]);

        return new JsonResponse($this->makeArrayFromOne($obra));

    }

    #[Route('/api/obras-add', methods:'POST')]
    public function addObra(Request $request, ObraRepository $obraRepository, EntityManagerInterface $em): Response
    {
        if ($request->request->get('nombre') === ''){
            $error['nombre'] = "Ingrese un nombre de obra";
            return new JsonResponse($error, 400);
        }
        try{
            $obra = new Obra();
            $obra->setNombre($request->request->get('nombre'));
            $obra->setCasas($request->request->get('casas'));
            $obra->setActivo($request->request->get('activo'));

            $em->persist($obra);
            $em->flush();

            return new JsonResponse($this->makeArrayFromOne($obra));
        } catch (Exception $e){
            $error = $this->findReasons($request->request->get('nombre'), intval($request->request->get('casas')), $obraRepository);
            $error['code'] = $e->getCode();
            $error['message'] = $e ->getMessage();
            return new JsonResponse($error, 400);
        }
    }

    #[Route('/api/obras-edit/{id}')]
    public function editObra($id, Request $request, ObraRepository $obraRepository, EntityManagerInterface $em): Response
    {
        if ($request->request->get('nombre') === ''){
            $error['nombre'] = 'Ingrese un nombre de obra';
            return new JsonResponse($error, 400);
        }

        try{
            $obra = $obraRepository->findOneBy(['id' => $id]);
            $obra->setNombre($request->request->get('nombre'));
            $obra->setCasas($request->request->get('casas'));
            $obra->setActivo($request->request->get('activo'));

            $em->flush();

            return new JsonResponse($this->makeArrayFromOne($obra));
        } catch (Exception $e){
            $error = $this->findReasons($request->request->get('nombre'), intval($request->request->get('casas')), $obraRepository);
            $error['code'] = $e->getCode();
            $error['message'] = $e ->getMessage();
            return new JsonResponse($error, 400);
        }
    }
    
    /**
     * findReasons
     *
     * @param  String $nombre
     * @param  Integer $casas
     * @param ObraRepository $obraRepository
     * @return array
     */
    private function findReasons($nombre, $casas, $obraRepository):array
    {
        $error = array();
        $data = $obraRepository->findOneBy(['nombre' => $nombre]);
        if ($data){
            $error['nombre'] = 'Nombre de obra ya existe';
        }        

        if ($casas === 0){
            $error['casas'] = 'Numero de casas no puede ser 0';
        }

        return $error;
    }
    
    /**
     * makeArrayFromOne
     *
     * @param  Obra $obra
     * @return array
     */
    public function makeArrayFromOne($obra): array
    {
        if ($obra === null){
            return null;
        }

        $helper = array();
        $helper['id'] = $obra->getId();
        $helper['nombre'] = $obra->getNombre();
        $helper['casas'] = $obra->getCasas();
        $helper['activo'] = $obra->getActivo();

        return $helper;
    }
    
    /**
     * makeArray
     *
     * @param  Obra[] $obras
     * @return array
     */
    private function makeArray($obras): array
    {
        $helper = array();

        foreach($obras as $obra){
            $helper[] = $this->makeArrayFromOne($obra);
        }

        return $helper;
    }
}