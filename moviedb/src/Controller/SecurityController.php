<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
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

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        // on va traiter l'inscription d'un nouvel utilisateur
        // création d'un formulaire d'inscription
        $form = $this->createForm(UserType::class);

        // handleRequest permet de relier les informations de la requête avec le formulaire
        $form->handleRequest($request);

        // Si le formulaire a bien été envoyé et est valide
        if($form->isSubmitted() && $form->isValid()) {

            // Récupération des données du formulaire
            $user = $form->getData();
            //Ajout du rôle ROLE_USER a l'utilisateur par défaut
            $user->setRoles(['ROLE_USER']);

            // On doit encoder le mot de passe avant d'enregistrer l'utilisateur
            $plainPassword = $user->getPassword();
            $encodedPassword = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encodedPassword);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // Redirection vers la page de connexion
            return $this->redirectToRoute('app_login');
        }

        
        return $this->render('security/register.html.twig', ['registerForm' => $form->createView()]);
    }
}
