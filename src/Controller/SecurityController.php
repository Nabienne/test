<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\IdentificationType;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="security_inscription")
     */
    public function inscription(Request $request, ObjectManager $menager, UserPasswordEncoderInterface $encoder)

    {
        $user= new User();
        $form= $this->createForm(IdentificationType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() )
        {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $menager->persist($user);
            $menager->flush();
            return $this->redirectToRoute('security_login'); 
            
         
        }
        return $this->render('security/inscription.html.twig', [
            'form' => $form->createView()
        ]); 
    }
      /**
     * @Route("/connexion", name="security_login")
     */
    public function login()
    {
        
        return $this->render('security/login.html.twig', );
    }
}
