<?php

namespace App\Controller;

use App\Entity\Fugitif;
use App\Entity\Mandat;
use App\Entity\NationaliteFugitif;
use App\Repository\NationaliteRepository;
use App\Repository\TypeMandatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class CrudController extends AbstractController
{

    // /**
    //  * @Route("/crud", name="crud")
    //  */
    // public function index()
    // {
    //     return $this->render('crud/index.html.twig', [
    //         'controller_name' => 'CrudController',
    //     ]);
    // }

    /**
     * @Route("/api/fugitif/{id}", name = "update_fugitif", methods="PUT")
     */

    public function update(Fugitif $fugitif, Request $request, SerializerInterface $serializer, EntityManagerInterface $em, 
    NationaliteRepository $nationaliteRepository, TypeMandatRepository $typeMandatRepository) : Response
    {
        try {
            /** @var Fugitif */
            $serializer->deserialize($request->getContent(), Fugitif::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $fugitif] /* [ "groups" => "search:read" ] */);

        } catch (NotEncodableValueException $e) {
            return $this->json($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $ex) {
            return $this->json($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        foreach ($fugitif->getListeNationalites() as $nat) {
            $nationalite = $nationaliteRepository->findOneBy(["libelle" => $nat->getNationalite()->getLibelle() ]);
            if($nationalite){
                $fugitif->removeListeNationalite($nat);
                $natfug = (new NationaliteFugitif())
                    ->setFugitif($fugitif)
                    ->setNationalite($nationalite);
                $fugitif->addListeNationalite($natfug);
            }
        }
        
        foreach ($fugitif->getMandats() as $mandat) {
            $typemandat = $typeMandatRepository->findOneBy(["libelle" => $mandat->getTypeMandat()->getLibelle() ]);
            if ($typemandat){
                $mandat->setTypeMandat($typemandat);
            }
        }
        $em->flush();
        return $this->json($fugitif, Response::HTTP_OK, [], [ "groups" => "search:read" ]);
    }

    /**
     * @Route("/api/mandat/{id}", name = "data_deletion_path", methods="DELETE")
     */

    public function delete(Mandat $mandat, EntityManagerInterface $em) : Response
    {
        // insted of archiving the data, it's gonna be archived
        try {
            //code...
            $mandat->setArchived(true);
            // $em->remove($fugitif);
            $em->flush();
        } catch (\Throwable $th) {
            //throw $th;
            return $this->json("An error occured when performing the deletion", Response::HTTP_BAD_REQUEST, []);
        }
        return $this->json("Item deleted successfully", Response::HTTP_OK, []);

        // $params = json_decode($request->getContent(), true);

        // if ($params == null){
        //     $message = "Bad request";
        //     return $this->json($message, Response::HTTP_BAD_REQUEST);
        // }

        // $property = $params["property"];
        // $value = $params["value"];

        // $className = "App\\Entity\\".$className;
        // if (!class_exists($className)){
        //     $message = "Erreur : Cette classe n'existe pas !";
        //     return $this->json($message, Response::HTTP_BAD_REQUEST);
        // }

        // if (!property_exists($className, $property)){
        //     $message = "Erreur : Cette proprieté n'existe pas dans cette classe !";
        //     return $this->json($message, Response::HTTP_BAD_REQUEST);
        // }
    
        // $item = $em->getRepository($className)->findOneBy([$property => $value]);

        // if ($item == NULL){
        //     $message = "Erreur : Cet objet ".($property)." : ".($value)." n'existe pas !";
        //     return $this->json($message, Response::HTTP_BAD_REQUEST);
        // }

        // try {
        //     //code...
        //     $em->remove($item);
        //     $em->flush();

        //     return $this->json("Item deleted successfully", Response::HTTP_OK, []);

        // } catch (\Throwable $th) {
        //     //throw $th;
        //     return $this->json("An error occured while deleting the item with ".$property." as ".$value, Response::HTTP_BAD_REQUEST);
        // }                

    }

    /**
     * @Route("/api/fugitif", name = "add_fugitif", methods="POST")
     */

    public function add(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, 
    NationaliteRepository $nationaliteRepository, TypeMandatRepository $typeMandatRepository) : Response
    {
        
        try {
            /** @var Fugitif */
            $fugitif = $serializer->deserialize($request->getContent(), Fugitif::class, 'json', [ "groups" => "search:read" ]);

        } catch (NotEncodableValueException $e) {
            return $this->json($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $ex) {
            return $this->json($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        
        foreach ($fugitif->getListeNationalites() as $nat) {
            $nationalite = $nationaliteRepository->findOneBy(["libelle" => $nat->getNationalite()->getLibelle() ]);
            if($nationalite){
                $fugitif->removeListeNationalite($nat);
                $natfug = (new NationaliteFugitif())
                    ->setFugitif($fugitif)
                    ->setNationalite($nationalite);
                $fugitif->addListeNationalite($natfug);
            }
        }
        
        foreach ($fugitif->getMandats() as $mandat) {
            $typemandat = $typeMandatRepository->findOneBy(["libelle" => $mandat->getTypeMandat()->getLibelle() ]);
            if ($typemandat){
                $mandat->setTypeMandat($typemandat);
            }
            //$em->persist($mandat);
        }
        $em->persist($fugitif);
        $em->flush();
        return $this->json($fugitif, Response::HTTP_OK, [], [ "groups" => "search:read" ]);
        //dd($fugitif);

        // $className = "App\\Entity\\".$className;
        // if (!class_exists($className)){
        //     $message = "Erreur : Cette classe n'existe pas !";
        //     return $this->json($message, Response::HTTP_BAD_REQUEST);
        // }

        // // $reqContent = json_decode($request->getContent(), true);

        // // dd($reqContent);
        // $object = $serializer->deserialize($request->getContent(), $className, "json");

        // dd($object);
        //$jsonResponse = null;

        // try {

            //code...
            // $em->persist($object);
            // $em->flush();

            // $message = "Executed successfully";
            // $jsonResponse = $this->json($message, Response::HTTP_OK);

        // } catch (\Throwable $th) {

        //     //throw $th;
        //     $message = "An error occured";
        //     $jsonResponse = $this->json($message, Response::HTTP_BAD_REQUEST);

        // }

        //return $jsonResponse;
    }
}