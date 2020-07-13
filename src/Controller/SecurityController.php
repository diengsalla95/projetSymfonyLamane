<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */ 
    public function Registration(Request $request,UserPasswordEncoderInterface $encoder):Response
    {
        $user= new User();  
        $form=$this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $hash=$encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
       }
        return $this->render('security/Registre.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/connexion", name="security_login")
     */ 
    public function login(){
        return $this->render('security/login.html.twig');
    }
    /**
     * @Route("/deconnexion", name="security_logout")
     */ 
    public function logout(){}
}
