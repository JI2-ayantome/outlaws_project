<?php

namespace App\Controller;

use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\FugitifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/api/search", name="api_search_action", methods="GET", options={"expose"=true})
     */

    public function index(Request $request, FugitifRepository $repository) : Response
    {
        $search = new Search();

        $search->q = $request->query->get("q", "");
        $search->field = $request->query->get("field", null);

        //dd($search, $request);

        $data = $repository->findSearch($search);
        if($data === null){
            $message = "Erreur : Le champ {$search->field} n'existe pas !";
            return $this->json($message, Response::HTTP_BAD_REQUEST);
        }   
        return $this->json($data, Response::HTTP_OK, [], [ "groups" => "search:read" ]);
    }

    /**
     * @Route("/api/{entity}", name = "entity_path", methods="GET")
     */
    public function findClassObjects(Request $request, $entity){

        $entity = "App\\Entity\\".$entity;

        if (!class_exists($entity)){
            $message = "Erreur : Cette classe n'existe pas !";
            return $this->json($message, Response::HTTP_BAD_REQUEST);
        }

        $data = $this->getDoctrine()
                            ->getManager()
                            ->getRepository($entity)
                            ->findAll();

        $data = ["className" => $entity, "objects"  =>  $data];
                            
        return $this->json($data, Response::HTTP_OK, [], [ "groups" => "search:read" ]);
    }

}
