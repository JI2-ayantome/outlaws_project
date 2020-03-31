<?php

namespace App\Controller;

use App\Entity\Fugitif;
use App\Entity\Mandat;
use App\Entity\Nationalite;
use App\Entity\Search;
use App\Entity\TypeMandat;
use App\Repository\MandatRepository;
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
     * @Route("/admin/mandats/{page}", name="app_mandats_fetch_action", options={"expose"=true})
     */
    public function fetchWarrants(Request $request, EntityManagerInterface $em, $page)
    {
        // if ($request->isXmlHttpRequest()){

            $mandatRepository = $em->getRepository(Mandat::class);

            $nbMandats = $mandatRepository->getAllMandatsCount();

            $offset = (($page - 1) * $this->getParameter("MANDAT_DISPLAY_LIMIT"));

            $mandats = $mandatRepository->findBy([], null, $this->getParameter("MANDAT_DISPLAY_LIMIT"), $offset);

            $data = ["mandats"  => $mandats, "pages"    =>  round($nbMandats/$this->getParameter("MANDAT_DISPLAY_LIMIT"))];
            return $this->json($data, Response::HTTP_OK, [], [ "groups" => "infos_mandat" ]);
        // }
        return new Response("Not an ajax request");
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

    public function searchObjects(Request $request, $page = 0, MandatRepository $mandatRepository) : Response
    {
        $search = new Search();

        $search->q = $request->query->get("q", "");
        $search->field = $request->query->get("field", null);

        //dd($search, $request);

        $data = $this->getDoctrine()->getManager()->getRepository(Mandat::class)->findSearch($search);
        if($data === null){
            $message = "Erreur : Le champ {$search->field} n'existe pas !";
            return $this->json($message, Response::HTTP_BAD_REQUEST);
        }   

        $nbMandats = sizeof($data);
        $offset = 0; //(($page - 1) * $this->getParameter("MANDAT_DISPLAY_LIMIT"));

        $mandats = $mandatRepository->findBy([], null, $this->getParameter("MANDAT_DISPLAY_LIMIT"), $offset);

        $data = ["mandats"  => $mandats, "pages"    =>  round($nbMandats/$this->getParameter("MANDAT_DISPLAY_LIMIT"))];
        return $this->json($data, Response::HTTP_OK, [], [ "groups" => "infos_mandat" ]);
    }

    /**
     * @Route("/admin/delete_warrant/{id}", name="app_warrant_deletion_action", methods="GET", options={"expose"=true})
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
























    // private function processExcelData($file){

	// 	$worksheet = $this->getWorkSheet($file);

	// 	global $numberOfRows, $numberOfColumns;

	// 	// $progressBar = new \ProgressBar\Manager(0, $numberOfRows);

	// 	for ($row=2; $row <= $numberOfRows; $row++) { 

	// 		# code...
	// 		$row_data = $this->getRowData($worksheet, $row);
	// 		$data = $this->getJsonString($row_data);

	// 		// $progressBar->update($row);
			
	// 		// break;
	// 	}
	// }

	// private function getWorkSheet($file){

	// 	$reader =  \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
	// 	$reader->setReadDataOnly(TRUE);
	// 	$spreadsheet = $reader->load($file);

	// 	$worksheet = $spreadsheet->getActiveSheet();

	// 	global $numberOfRows, $numberOfColumns, $headings;

	// 	$numberOfRows = $worksheet->getHighestRow();
	// 	$highestColumn = $worksheet->getHighestColumn();
	// 	$numberOfColumns = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

	// 	// getting the true or correct value of the maximum value of $numberOfColumns variable
	// 	$cellValue = $worksheet->getCellByColumnAndRow(0, 1)->getValue();
	// 	$i = 1;
	// 	$headings = [];
	// 	while ($cellValue != "" && $i <= $numberOfColumns) {
	// 		# code...
	// 		$cellValue = $worksheet->getCellByColumnAndRow($i, 1)->getValue();
	// 		$headings[] = $cellValue;
	// 		$i++;
	// 	}
	// 	$numberOfColumns = --$i;

	// 	return $worksheet;

	// }


	// private function processDatabaseData($file){
	// 	// code here ... 
	// }

	// private function getRowData($worksheet, $row){

	// 	// function designed for returning the data contained in an excel worksheet's row
	// 	global $numberOfColumns, $headings;

	// 	$row_data = [];
	// 	for ($col=1; $col < $numberOfColumns; $col++) { 
	// 		$row_data[$headings[$col-1]] = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
	// 	}

	// 	return $row_data;
	// }

	// private function getJsonString($data){

	// 	$xls_date = $data["date_mandat"];
	// 	$unix_date = ($xls_date - 25569) * 86400;
	// 	$xls_date = 25569 + ($unix_date / 86400);
	// 	$unix_date = ($xls_date - 25569) * 86400;
	// 	$date = date("Y-m-d", $unix_date);

	// 	$jsonString = 
	// 					'{
	// 					    "nom": "'.$data["nom"].'",
	// 					    "prenoms": "'.(($data["prenom"] == NULL) ? "ND" : $data["prenom"]).'",
	// 					    "nomMarital": "'.$data["nom_marital"].'",
	// 					    '.(($data["alias"] == NULL) ? '"alias": null,' : '"alias": "'.$data["alias"].'",').'
	// 					    '.(($data["surnom"] == NULL) ? '"surnom": null,' : '"surnom": "'.$data["surnom"].'",').'
	// 					    '.(($data["date_naissance"] == NULL) ? '"dateNaissance": null,' : '"dateNaissance": "'.$data["date_naissance"].'",').'
	// 					    "lieuNaissance": "'.$data["lieu_naissance"].'",
	// 					    '.(($data["adresse"] == NULL) ? '"adresse": null,' : '"adresse": "'.$data["adresse"].'",').'
	// 					    '.(($data["taille"] == NULL) ? '"taille": null,' : '"taille": "'.$data["taille"].'",').'
	// 					    '.(($data["poids"] == NULL) ? '"poids": null,' : '"poids": "'.$data["poids"].'",').'
	// 					    '.(($data["couleur_yeux"] == NULL) ? '"couleurYeux": null,' : '"couleurYeux": "'.$data["couleur_yeux"].'",').'
	// 					    '.(($data["couleur_peau"] == NULL) ? '"couleurPeau": null,' : '"couleurPeau": "'.$data["couleur_peau"].'",').'
	// 					    '.(($data["couleur_cheveux"] == NULL) ? '"couleurCheveux": null,' : '"couleurCheveux": "'.$data["couleur_cheveux"].'",').'
	// 					    "photoName": null,
	// 					    "photoSize": null,
	// 					    '.(($data["sexe"] == NULL) ? '"sexe": null,' : '"sexe": "'.$data["sexe"].'",').'
	// 					    "numeroPieceID": null,
	// 					    "numeroTelephone": null,
	// 					    '.(($data["observations"] == NULL) ? '"observations": null,' : '"observations": "'.$data["observations"].'",').'
	// 					    "mandats": [
	// 					        {
	// 					            "reference": null,
	// 					            "execute": '.(($data["en_fuite"] == 0) ? "true" : "false").',
	// 					            "infractions": "'.(($data["infraction"] == NULL) ? "ND" : $data["infraction"]).'",
	// 					            "chambres": "'.$data["cabinet_chambre"].'",
	// 					            "juridictions": "'.$data["juridiction"].'",
	// 					            "archived": false,
	// 					            "typeMandat": {
	// 					                "libelle": "'.(($data["type_mandat"] == NULL) ? "ND" : $data["type_mandat"]).'"
	// 					            },
	// 					            "dateEmission": "'.$date.'"
	// 					        }
	// 					    ],
	// 					    "listeNationalites": [
	// 					        {
	// 					            "nationalite": {
	// 					                "libelle": "'.(($data["nationalite"] == NULL) ? "ND" : $data["nationalite"]).'"
	// 					            },
	// 					            "principale": true
	// 					        }
	// 					    ]
	// 					}'
	// 					;

	// 	// echo $jsonString;
	//     return $jsonString;
	// }
}
