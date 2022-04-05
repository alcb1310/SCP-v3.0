<?php
namespace App\Controller;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use App\Repository\ProveedorRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProveedorController extends AbstractController
{
    #[Route('/api/proveedores')]
    public function getAllProveedores(Request $request, ProveedorRepository $proveedorRepository): Response
    {
        $page = $request->query->get('page', 1);
        $proveedores = $proveedorRepository->findBy(array(), array('nombre' => 'ASC'));

        $proveedorArray = $this->makeArray($proveedores);
       
        $adapter = new ArrayAdapter($proveedorArray);
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
    
    /**
     * makeArray
     *
     * @param  Proveedor[] $proveedor
     * @return array
     */
    private function makeArray($proveedores): array
    {
        $proveedorArray = array();
        
        foreach ($proveedores as $proveedor){
            $helper = array();
            $helper['id'] = $proveedor->getId();
            $helper['ruc'] = $proveedor->getRuc();
            $helper['nombre'] = $proveedor->getNombre();
            $helper['contacto'] = $proveedor->getContacto();
            $helper['telefono'] = $proveedor->getTelefono();
            $helper['email'] = $proveedor->getEmail();

            $proveedorArray[] = $helper;
        }

        return $proveedorArray;
    }
}