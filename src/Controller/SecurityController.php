<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SecurityController.php',
        ]);
    }

    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
    	// retrieving data from the request object
    	$email = $request->get("email");
    	$password = $request->get("password");

    	// creating the user object to inserted in the database
    	$user = new User();
    	$user->setEmail($email);
    	$user->setPassword($passwordEncoder->encodePassword(
            $user,
            $password
        ));

    	$em = $this->getDoctrine()->getManager();
    	$em->persist($user);
    	$em->flush();

    	return new Response(sprintf("User %s successfully created", $user->getUsername()));

        // return $this->render('auth/index.html.twig', [
        //     'controller_name' => 'AuthController',
        // ]);
    }

    /**
     * @Route("/app_login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/index.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/admin/login_check", name="app_login_check")
     */

    public function checkLogin()
    {

    }

    /**
     * @Route("/admin/logout", name="app_logout")
     */
    public function logout()
    {
        // throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

}
