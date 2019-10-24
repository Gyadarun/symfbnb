<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegitrationType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * Show and deal with the login form
     * 
     * @Route("/login", name="account_login")
     * 
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {   
        $error = $utils->getLastAuthenticationError();
        $useremail = $utils->getLastUsername();
      
        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'useremail' => $useremail
        ]);
    }

    /**
     * Logout
     * 
     * @Route("/logout", name="account_logout")
     * 
     * @return void
     */
    public function logout()
    {

    }

    /**
     * Show registration form
     *
     * @Route("/register", name="account_register")
     * 
     * @return Response
     */
    public function register()
    {
        $user = new User();

        $form = $this->createForm(RegitrationType::class, $user);

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
