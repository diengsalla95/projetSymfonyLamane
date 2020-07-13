<?php

namespace App\Controller;
use App\Entity\Chambre;
use App\Form\ChambreType;
use App\Repository\ChambreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChambreController extends AbstractController
{
    /**
     * @Route("/", name="chambre_accueil")
     */
    public function accueil()
    {
        return $this->render('accueil.html.twig');
    }
    /**
     * @Route("/chambre", name="chambre_index")
     */
    public function index(ChambreRepository $chambreRepository)
    {
        $chambres = $chambreRepository->findAll();
        return $this->render('chambre/index.html.twig', compact('chambres'));
        // return $this->render('chambre/index.html.twig', [
        //     'chambres'=>'$chambres',
        // ]);
    }

    /**
     * @Route("/chambre/create", name="chambre_create")
     */
    public function create(Request $request):Response
    {
        function createNumber($number){
            if(preg_match("#[0-9]{4}#",$number)){
                return  "_".$number;
            }else{
                $numberNew = (string)$number;
                $taille = strlen($numberNew);
                if ($taille<4){
                    $restant = 4-$taille;
                    for ($i=0; $i < $restant; $i++) { 
                        $number = "0".$number;
                    }
                    return "_".$number;
                }
            }
        }
    
        function generateNumber($numBat,$num){
            $num = createNumber($num);
            return $numBat."".$num;
        }
        
        $chambre = new Chambre();
        // $n=generateNumber(10,14);
        // $chambre->setNumChambre($n);
        $form = $this->createForm(ChambreType::class,$chambre);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
            $id=$chambre->getNumChambre();
            $num=$chambre->getNumChambre();
            $n=generateNumber($id,$num);
            $chambre->setNumChambre($n);
             $em = $this->getDoctrine()->getManager();
             $em->persist($chambre);
             $em->flush();
        }
        return $this->render('chambre/create.html.twig', [
             'form'=> $form->createView(),
             'edit'=> $chambre->getId() !==null 
        ]);
        
    }
    /**
     * @Route("/chambre/{id<[0-9]+>}/edit", name="chambre_edit")
     */
    public function edit(Request $request,Chambre $chambre):Response
    {
        $form = $this->createForm(ChambreType::class,$chambre);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
             $em = $this->getDoctrine()->getManager();
             $em->flush();
             $this->addFlash('success', 'We saved a battle with id ' );
            return $this->redirectToRoute('chambre_index');
        }
        return $this->render('chambre/create.html.twig', [
            'chambre'=>$chambre,
             'form'=> $form->createView(),
             'edit'=> $chambre->getId() !==null 
        ]);
    }
    /**
     * @Route("/chambre/{id<[0-9]+>}/delete", name="chambre_delete")
    */
    public function delete(Chambre $chambre)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($chambre);
        $em->flush();
        $this->addFlash('success', 'Chambre supprimé aec succes ' );
        return $this->redirectToRoute('chambre_index');
       
    }
}
