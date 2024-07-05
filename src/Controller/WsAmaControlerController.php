<?php

namespace App\Controller;

use App\Repository\CursoRepository;
use App\Repository\TabsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use function PHPUnit\Framework\arrayHasKey;

class WsAmaControlerController extends AbstractController
{
    #[Route('/ws/cursos', name: 'app_ws_controller')]
    public function getAll(CursoRepository $curso): Response
    {
        return $this->convertToJson($curso->findAll());

    }

    #[Route('/ws/fotos', name: 'app_ws_fotos_controller')]
    public function getAllFotos(TabsRepository $tabsRepository): Response
    {
        return $this->convertToJson($tabsRepository->findAll());
    }

    #[Route('/ws/fotos/exterior', name: 'app_ws_fotos_interior_controller')]
    public function getAllFotosInterior(TabsRepository $tabsRepository): Response
    {

        //return $this->convertToJson($tabsRepository->findBy(array('id' => array(1, 2, 3,4,5,6))));
        // Construir la consulta para obtener los registros con nombre que empiece por 'markel'
        $queryBuilder = $tabsRepository->createQueryBuilder('t');
        $queryBuilder->where('t.texto LIKE :nombre')
            ->setParameter('nombre', 'exterior%');

        // Ejecutar la consulta y obtener los resultados
        $results = $queryBuilder->getQuery()->getResult();

        // Convertir los resultados a JSON y retornar la respuesta
        return $this->json($results);
    }

    #[Route('/ws/fotos/interior', name: 'app_ws_fotos_exterior_controller')]
    public function getAllFotosExterior(TabsRepository $tabsRepository): Response
    {

        //return $this->convertToJson($tabsRepository->findBy(array('id' => array(7,8,9,10,11,12))));
        // Construir la consulta para obtener los registros con nombre que empiece por 'markel'
        $queryBuilder = $tabsRepository->createQueryBuilder('t');
        $queryBuilder->where('t.texto LIKE :nombre')
            ->setParameter('nombre', 'interior%');

        // Ejecutar la consulta y obtener los resultados
        $results = $queryBuilder->getQuery()->getResult();

        // Convertir los resultados a JSON y retornar la respuesta
        return $this->json($results);
    }

    private function convertToJson($object):JsonResponse
    {
        $encoders=[new XmlEncoder(),new JsonEncoder()];
        $normalizers=[new DateTimeNormalizer(),new ObjectNormalizer()];
        $serializers= new Serializer($normalizers,$encoders);
        $normalized=$serializers->normalize($object,null,array(DateTimeNormalizer::FORMAT_KEY=>"Y/m/d"));
        $JsonContent=$serializers->serialize($normalized,"json");
        return JsonResponse::fromJsonString($JsonContent,200);
    }



}
