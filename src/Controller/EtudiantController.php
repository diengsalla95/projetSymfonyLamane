<?php

namespace App\Controller;
use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

function prenom($chaine){
    $n='';
    for ($i=0;(isset($chaine[$i])) ; $i++) {
        if($i<2){
            $n.=$chaine[$i];
        }
    }
    return $n;
}

//php cette fonction permet de determiner la longueur d'une chaine.
function nmbr_carac_ch($chaine){
$n=0;
for ($i=0;(isset($chaine[$i])) ; $i++) { 
$n=$n+1;
}
return $n;
}

function Nom($chaine){
$nmbre=nmbr_carac_ch($chaine);
$n='';
for ($i=0;$i<$nmbre ; $i++) {
if($i>$nmbre-3){
    $n.=$chaine[$i];
}
}
return $n;
}
class EtudiantController extends AbstractController
{
    /**
     * @Route("/etudiant", name="etudiant_index")
     */
    public function index(EtudiantRepository $etudiantRepository)
    {
        $etudiants = $etudiantRepository->findAll();
        return $this->render('etudiant/index.html.twig', compact('etudiants'));
        
    }
    /**
     * @Route("/etudiant/create", name="etudiant_create")
     */
    public function create(Request $request):Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class,$etudiant);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $prenom=prenom($etudiant->getPrenom());
            $nom=Nom($etudiant->getNom());
            $mat=$prenom.''.$nom.'2020';
            $etudiant->setMatricule($mat);
             $em = $this->getDoctrine()->getManager();
             $em->persist($etudiant);
             $em->flush();
        }
        return $this->render('etudiant/create.html.twig', [
             'form'=> $form->createView(),
             'edit'=> $etudiant->getId() !==null 
        ]);
        
    }
    /**
     * @Route("/etudiant/{id<[0-9]+>}/edit", name="etudiant_edit")
     */
    public function edit(Request $request,Etudiant $etudiant):Response
    {
        $form = $this->createForm(EtudiantType::class,$etudiant);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
             $em = $this->getDoctrine()->getManager();
             $em->flush();
             $this->addFlash('success', 'We saved a battle with id ' );
            return $this->redirectToRoute('etudiant_index');
        }
        return $this->render('etudiant/create.html.twig', [
            'etudiant'=>$etudiant,
             'form'=> $form->createView(),
        ]);
    }
    /**
     * @Route("/etudiant/{id<[0-9]+>}/delete", name="etudiant_delete")
    */
    public function delete(Etudiant $etudiant)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($etudiant);
        $em->flush();
        $this->addFlash('success', 'Chambre supprimé aec succes ' );
        return $this->redirectToRoute('etudiant_index');
    }
}
