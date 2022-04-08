<?php
namespace App\Controller;

use App\Entity\Proveedor;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use App\Repository\ProveedorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProveedorController extends AbstractController
{
    #[Route('/api/proveedores', methods:'GET')]
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

    #[Route('/api/proveedores/{id}', methods:'GET')]
    public function getProveedor($id, ProveedorRepository $proveedorRepository)
    {
        $proveedor = $proveedorRepository->findOneBy(['id' => $id]);

        $proveedorJson = $this->makeArrayFromOne($proveedor);

        return new JsonResponse($proveedorJson);
    }

    #[Route('/api/proveedores-add', methods:'POST')]
    public function addProveedor(Request $request, ProveedorRepository $proveedorRepository, EntityManagerInterface $em): Response
    {
        try {
            $proveedor = new Proveedor();
            $proveedor->setRuc($request->request->get('ruc'));
            $proveedor->setNombre($request->request->get('nombre'));
            $proveedor->setContacto($request->request->get('contacto'));
            $proveedor->setEmail($request->request->get('email'));
            $proveedor->setTelefono($request->request->get('telefono'));

            $em->persist($proveedor);
            $em->flush();

            return new JsonResponse($this->makeArrayFromOne($proveedor));
        } catch (Exception $e){
            $error = array();
            $proveedorError = $proveedorRepository->findOneBy(['ruc' => $request->request->get('ruc')]);
            if ($proveedorError){
                $error['ruc'] = 'Proveedor con ese RUC ya existe';
            }

            $proveedorError = $proveedorRepository->findOneBy(['nombre' => $request->request->get('nombre')]);
            if ($proveedorError){
                $error['nombre'] = 'Proveedor con ese Nombre ya existe';
            }

            return new JsonResponse($error, 400);
        }
    }

    #[Route('/api/proveedores-edit/{id}', methods:'POST')]
    public function editProveedor($id, Request $request, ProveedorRepository $proveedorRepository, EntityManagerInterface $em): Response
    {
        try{
            $proveedor = $proveedorRepository->findOneBy(['id' => $id]);
            $proveedor->setRuc($request->request->get('ruc'));
            $proveedor->setNombre($request->request->get('nombre'));
            $proveedor->setContacto($request->request->get('contacto'));
            $proveedor->setEmail($request->request->get('email'));
            $proveedor->setTelefono($request->request->get('telefono'));

            $em->flush();

            $result = $this->makeArrayFromOne($proveedor);
            return new JsonResponse($result);
        } catch (Exception $e){
            $error = array();
            $proveedorError = $proveedorRepository->findOneBy(['ruc' => $request->request->get('ruc')]);
            if ($proveedorError){
                $error['ruc'] = 'Proveedor con ese RUC ya existe';
            }

            $proveedorError = $proveedorRepository->findOneBy(['nombre' => $request->request->get('nombre')]);
            if ($proveedorError){
                $error['nombre'] = 'Proveedor con ese Nombre ya existe';
            }

            return new JsonResponse($error, 400);
        }
    }
    
    /**
     * makeArrayFromOne
     *
     * @param Proveedor $proveedor
     * @return array
     */
    private function makeArrayFromOne( $proveedor): array
    {
        if ($proveedor === null){
            return array();
        }
        $helper = array();
        $helper['id'] = $proveedor->getId();
        $helper['ruc'] = $proveedor->getRuc();
        $helper['nombre'] = $proveedor->getNombre();
        $helper['contacto'] = $proveedor->getContacto();
        $helper['telefono'] = $proveedor->getTelefono();
        $helper['email'] = $proveedor->getEmail();

        return $helper;
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
            $helper = $this->makeArrayFromOne($proveedor);

            $proveedorArray[] = $helper;
        }

        return $proveedorArray;
    }
}