<?php

namespace App\Controller;

use App\Entity\Fugitif;
use App\Entity\Mandat;
use App\Entity\Nationalite;
use App\Entity\NationaliteFugitif;
use App\Entity\Search;
use App\Entity\TypeMandat;
use App\Repository\FugitifRepository;
use App\Repository\MandatRepository;
use App\Repository\NationaliteRepository;
use App\Repository\TypeMandatRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

// use Symfony\Component\String\Slugger\SluggerInterface;

class AppController extends AbstractController
{
    /**
     * @Route("/admin/{requested_page}",
     * defaults={"requested_page": 1},
     * requirements={
     *      "requested_page": "\d+"
     * }, name="app_backend")
     */
    public function index(EntityManagerInterface $em, $requested_page)
    {
        // if ($this->getUser() == null)
        //     $this->redirectToRoute('app_login');
            
        // retrieving nationalite objects
        $nationalites = $em->getRepository(Nationalite::class)
                           ->findAll();

        $typeMandats = $em->getRepository(TypeMandat::class)
                          ->findAll();

        // $mandatRepository = $em->getRepository(Mandat::class);

        // $nbMandats = $mandatRepository->getAllMandatsCount();

        // $offset = (($requested_page - 1) * $this->getParameter("MANDAT_DISPLAY_LIMIT"));

        // $mandats = $mandatRepository->findBy([], null, $this->getParameter("MANDAT_DISPLAY_LIMIT"), $offset);

        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'nationalites'  =>  $nationalites,
            'typeMandats'   =>  $typeMandats,
            // 'mandats'      =>  $mandats,
            // 'pages'         =>  round($nbMandats/$this->getParameter("MANDAT_DISPLAY_LIMIT")),
        ]);
    }

    /**
     * @Route("/admin/profile", name="app_user_profile_action")
     */
    public function userProfile()
    {
        // retrieving nationalite objects

        return $this->render('app/user_profile.html.twig');
    }

    /**
     * @Route("/admin/user_password_change", name="app_user_password_change_action")
     */
    public function changePassword(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($request->isMethod("POST")){

            $password1 = $request->get("password1");
            $password2 = $request->get("password2");
            
            if ($password1 !== $password2){
                $message = ["type"  =>  "danger", "content"   =>  "Entrées incohérentes"];
            }
            else{
                $user = $this->getUser();
                $user->setPassword($passwordEncoder->encodePassword(
                    $user,
                    $password1
                ));
                $em->persist($user);
                $em->flush();
                $message = ["type"  =>  "success", "content"   =>  "Données mises à jour"];
            }

        }

        return $this->render('app/user_profile.html.twig', ["message"   =>  $message]);
    }

    /**
     * @Route("/a-propos", name="app_about_action")
     */
    public function aboutPage()
    {
        return $this->render('about.html.twig');
    }

    /**
     * @Route("/admin/data-excel-file", name="app_data_import_action")
     */
    public function dataImport(Request $request/* , SluggerInterface $slugger */)
    {

        /** @var UploadedFile $brochureFile */
        $excelFile = $request->get('excel_file')->getData();

        // this condition is needed because the 'brochure' field is not required
        // so the PDF file must be processed only when a file is uploaded

        if ($excelFile) {
            $originalFilename = pathinfo($excelFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            // $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$excelFile->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $excelFile->move(
                    $this->getParameter('EXCEL_FILES_DIR'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
        }
        return $this->render('about.html.twig');
    }

    /**
     * @Route("/admin/search", name="app_search_action", methods="GET", options={"expose"=true})
     */

    public function searchObjects(Request $request, MandatRepository $mandatRepository) : Response
    {
        $search = new Search();

        $search->q = $request->query->get("q", "");
        $search->field = $request->query->get("field", null);

        $page = $request->query->get("page", 1);
        $search->limit = $this->getParameter("MANDAT_DISPLAY_LIMIT");
        $search->offset = (($page - 1) * $search->limit);

        //dd($search, $request);

        $mandats = $this->getDoctrine()->getManager()->getRepository(Mandat::class)->findSearch($search);
        if($mandats === null){
            $message = "Erreur : Le champ {$search->field} n'existe pas !";
            return $this->json($message, Response::HTTP_BAD_REQUEST);
        }   

        $nbMandats = sizeof($mandats);

        // $mandats = $mandatRepository->findBy([], null, $this->getParameter("MANDAT_DISPLAY_LIMIT"), $offset);

        $data = ["mandats"  => $mandats, "page"    =>  $page/* round($nbMandats/$search->limit) */];
        return $this->json($data, Response::HTTP_OK, [], [ "groups" => "infos_mandat" ]);
    }

    /**
     * @Route("/admin/warrant/{id}", name="app_warrant_deletion_action", methods="DELETE", options={"expose"=true})
     */

    public function deleteWarrant($id, MandatRepository $mandatRepository, EntityManagerInterface $em){

        $mandat = $mandatRepository->findOneBy(["id"    =>  $id]);
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
    }

    /**
     * @Route("/admin/warrant/{id}", name = "app_update_warrant_action", methods="PUT", options={"expose"=true})
     */

    public function updateWarrant(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,  MandatRepository $mandatRepository,
    NationaliteRepository $nationaliteRepository, TypeMandatRepository $typeMandatRepository, $id, FugitifRepository $fugitifRepository) : Response
    {
        $mandat = $mandatRepository->findOneBy(["id"    =>  $id]);
        $fugitif = $mandat->getFugitif();
        try {
            /** @var Mandat */
            $serializer->deserialize($request->getContent(), Mandat::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $mandat] /* [ "groups" => "search:read" ] */);

        } catch (NotEncodableValueException $e) {
            return $this->json($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $ex) {
            return $this->json($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $fugitif = $fugitifRepository->findOneBy(["nom" =>  $fugitif->getNom(),
                                                  "prenoms" =>  $fugitif->getPrenoms(),
                                                  /* "dateNaissance"   =>  $mandat->getFugitif()->getDateNaissance(),
                                                  "lieuNaissance"   =>  $mandat->getFugitif()->getLieuNaissance() */]);

        if ($fugitif){
            
            foreach ($mandat->getFugitif()->getListeNationalites() as $nat) {
                $nationalite = $nationaliteRepository->findOneBy(["libelle" => $nat->getNationalite()->getLibelle() ]);
                if($nationalite){
                    $mandat->getFugitif()->removeListeNationalite($nat);
                    $natfug = (new NationaliteFugitif())
                        ->setNationalite($nationalite);
                    $mandat->getFugitif()->addListeNationalite($natfug);
                }
                // $nat->setFugitif($fugitif);
            }

            // dd($mandat->getFugitif()->getListeNationalites());
    
            $fugitif->copy($mandat->getFugitif());
            $mandat->setFugitif($fugitif);

            foreach ($mandat->getFugitif()->getListeNationalites() as $nat) {
                $nat->setFugitif($fugitif);
            }

        }
        
        $typemandat = $typeMandatRepository->findOneBy(["libelle" => $mandat->getTypeMandat()->getLibelle() ]);
        if ($typemandat){
            $mandat->setTypeMandat($typemandat);
        }
        // dd($mandat);
        $em->flush();
        return $this->json($mandat, Response::HTTP_OK, [], [ "groups" => "infos_mandat" ]);
    }


    /**
     * @Route("/admin/warrant", name = "app_add_warrant_action", methods="POST", options={"expose"=true})
     */

    public function addWarrant(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,  MandatRepository $mandatRepository,
    NationaliteRepository $nationaliteRepository, TypeMandatRepository $typeMandatRepository) : Response
    {
        try {
            /** @var Mandat */
            $mandat = $serializer->deserialize($request->getContent(), Mandat::class, 'json', [ "groups" => "infos_mandat" ]);

        } catch (NotEncodableValueException $e) {
            return $this->json($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $ex) {
            return $this->json($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $fugitif = $mandat->getFugitif();
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
        $mandat->setFugitif($fugitif);
        
        $typemandat = $typeMandatRepository->findOneBy(["libelle" => $mandat->getTypeMandat()->getLibelle() ]);
        if ($typemandat){
            $mandat->setTypeMandat($typemandat);
        }

        $em->persist($mandat);
        $em->flush();
        return $this->json($mandat, Response::HTTP_OK, [], [ "groups" => "infos_mandat" ]);
    }
    
}
