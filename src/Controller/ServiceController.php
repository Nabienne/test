<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
// use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Employer;
use App\Repository\EmployerRepository;
use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\Common\Persistence\ObjectManager;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="service")
     */
    public function index(EmployerRepository $liste)
    {
        $employe=$liste->findAll();
        return $this->render('service/modifemp.html.twig', [
            'controller_name' => 'ServiceController',
            'employe'  => $employe
        ]);
    }

     /**
     * @Route("/service", name="listservice")
     */
    public function service(ServiceRepository $liste)
    {
        $service=$liste->findAll();
        return $this->render('service/modifserv.html.twig', [
            'controller_name' => 'ServiceController',
            'service'  => $service
        ]);
    }

     /**
     * @Route("/service/modifemp", name="modifEmp")
     */
    public function modifEmp(EmployerRepository $liste)
    {
        $employe=$liste->findAll();
        return $this->render('service/modifemp.html.twig', [
            'controller_name' => 'ServiceController',
            'employe'  => $employe
        ]);
    }



     /**
     * @Route("/service/modifserv", name="modifserv")
     */
    public function modifServ(ServiceRepository $liste)
    {
        $service=$liste->findAll();
        return $this->render('service/modifserv.html.twig', [
            'controller_name' => 'ServiceController',
            'service'  => $service
        ]);
    }

    /**
     * @Route("/service/supprimer", name="supprime")
     */
    public function supp(EmployerRepository $liste)
    {
        $employe=$liste->findAll();
        return $this->render('service/supprimer.html.twig', [
            'controller_name' => 'ServiceController',
            'employe'  => $employe
        ]);
    }

     /**
     * @Route("/service/supprimerserv", name="supprim")
     */
    public function suppServ(ServiceRepository $liste)
    {
        $service=$liste->findAll();
        return $this->render('service/supprimerserv.html.twig', [
            'controller_name' => 'ServiceController',
            'service'  => $service
        ]);
    }

      /**
     * @Route("/service/lister", name="lister")
     */
    public function list(EmployerRepository $liste)
    {
        $employe=$liste->findAll();
        return $this->render('service/lister.html.twig', [
            'controller_name' => 'ServiceController',
            'employe'  => $employe
        ]);
    }

     /**
     * @Route("/service/listerserv", name="listerserv")
     */
    public function listserv(ServiceRepository $liste)
    {
        $service=$liste->findAll();
        return $this->render('service/listerserv.html.twig', [
            'controller_name' => 'ServiceController',
            'service'  => $service
        ]);
    }
    


    /**
     * @Route("/", name="accueil")
     */
    public function accueil()
    {
        return $this->render('service/accueil.html.twig');
    }

     /**
     * @Route("/service/formulaireserv", name="formulaireserv")
     *  @Route("/service/{id}/formulaireserv", name="editServ")
     */
    public function formulaireserv(Service $service=null,Request $requette1 , ObjectManager $menager)
    {
        if(!$service)
        {
            $service = new Service();  
        }
        
        $form1 = $this->createFormBuilder($service)
        ->add('libelle', TextType::class, ['attr' => ['placeholder' => 'type de service', 'class'=>'form-control']])
          ->getForm();
          $form1->handleRequest($requette1);
          if($form1->isSubmitted() && $form1->isValid() )
            {
                $menager->persist($service);
                $menager->flush();
                return $this->redirectToRoute('formulaireserv',['id'=>$service->getId()]); 
            }
          return $this->render('service/formulaireserv.html.twig', ['formSER' => $form1->createView(), 'editMode'=>$service->getId() !=null]);
   

    }

    /**
     * @Route("/service/formulairemp", name="formulairemp")
     * @Route("/service/{id}/formulairemp", name="editEmp")
     */
    public function formulairemp(Employer $employer=null,Request $requette, ObjectManager $menager)
    {
        if (!$employer){
            $employer = new Employer();
        }
        
        $form = $this->createFormBuilder($employer)
            ->add('matricule', TextType::class, ['attr' => ['placeholder' => 'Matricule', 'class'=>'form-control']])
            ->add('nom_complet', TextType::class, ['attr' => ['placeholder' => 'Nom Complet', 'class'=>'form-control']])
            ->add('date_naissance', DateType::class, ['widget' => 'single_text','format' => 'yyyy-MM-dd','attr' => ['placeholder' => 'Age', 'class'=>'form-control']])
            ->add('salaire', MoneyType::class, ['attr' => ['placeholder' => 'Salaire', 'class'=>'form-control']])
            ->add('service', EntityType::class, ['class' => Service::class, 'choice_label' => 'libelle'], ['attr' =>['class'=>'form-control']])

            ->getForm();
            $form->handleRequest($requette);
            if($form->isSubmitted() && $form->isValid() )
            {
                $menager->persist($employer);
                $menager->flush();
              return $this->redirectToRoute('formulairemp',['id'=>$employer->getId()]); 
            
            }
        return $this->render('service/formulairemp.html.twig', ['formEMP' => $form->createView(), 'editMode'=>$employer->getId() !=null]);
               
    }

    /**
     * @Route("/service/{id}/supprimer", name="supprimer")
     */
    public function supprime(Employer $employer, ObjectManager $menager)
    {
        $menager->remove($employer);
        $menager->flush();
        $this->addFlash('danger','Suppression réussie');
        return $this->render('service/supprimer.html.twig',['employe'=>$employer,'id'=>$employer->getId()]);
       
    }


    /**
     * @Route("/service/{id}/supprimerserv", name="supprimerserv")
     */
    public function supprim(Service $service, ObjectManager $menager)
    {
        $menager->remove($service);
        $menager->flush();
        $this->addFlash('danger','Suppression réussie');
        return $this->render('service/supprimerserv.html.twig',['service'=>$service,'id'=>$service->getId()]);
       
    }
   
}
