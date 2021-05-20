<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Communaute;
use App\Repository\CommunauteRepository;
use App\Entity\DemandeCommu;
use App\Repository\DemandeCommuRepository;



/**
 * @Route("/voie")
 * @IsGranted("ROLE_USER")
 */
class VoieController extends AbstractController
{
    #[Route('/', name: 'voie')]
    public function index(): Response
    {

        
        return $this->render('voie/index.html.twig', [
            'controller_name' => 'VoieController',
        ]);
    }

    /**
     * @Route("/choix/{univers_id}",name="choix")
     */
    public function choix($univers_id){

        return $this->render('voie/choix.html.twig');
    }

    /**
     * @Route("/build-com", name="build_com")
     */
    public function build_com(Request $request){
        $p = 0;
        $p = $request->get('p');
        return $this->render('voie/build_com.html.twig',['p'=>$p]);
    }

    /**
     * @Route("/traitement-communaute", name="traitement_communaute")
     */
    public function traitement_communaute(Request $request){
        $nom = $request->request->get('nom');
        $reglement = $request->request->get('reglement');
        $description = $request->request->get('description');

        // faisons dabor une recherche pour verifier si une communaute portant se nom existe deja ou pas
        $repository = $this -> getDoctrine() -> getRepository(Communaute::class);
        $communautes = $repository -> findBy(['nom'=>$nom,]);
        $comp = 0;

        foreach($communautes as $com){
           $comp++;
        }

    if($comp == 0){

        $commu = new Communaute();

        $commu->setNom($nom);
        $commu->setUniversId(1);
        $commu->setCreateurId($this->getUser()->getId());
        $commu->setReglement($reglement);
        $commu->setDateCreation(new \Datetime());
        $commu->setDescription($description);
        $commu->setEtat('actif');

        $em = $this->getDoctrine()->getManager();
        $em->persist($commu);
        $em->flush();

        return $this->redirectToRoute('commu_admin_home');

    }else{
         return $this->redirectToRoute('build_com',['p'=>1]);
    }

    }

    /**
     * @Route("/choix-communaute", name="join_commu")
     */
    public function join_commu(){
        $repository = $this -> getDoctrine() -> getRepository(Communaute::class);
        $communautes = $repository -> findBy(['etat'=>'actif',]);

        $repository = $this -> getDoctrine() -> getRepository(DemandeCommu::class);
        $request_exist = $repository -> findBy(['user_id'=>$this->getUser()->getId()]);

        $isExist = false;
        $commu_id = 0;
        $compt = 0;
        foreach($request_exist as $re){
            $commu_id = $re->getCommuId();
            $compt++;
        }

        if($compt != 0){ $isExist = true; }
        if($isExist == true ){ return $this->redirectToRoute('you_request_exist',['commu_id'=>$commu_id]); }

        return $this->render('voie/join_commu.html.twig',[
            'communautes' => $communautes,
        ]);
    }

    /**
     * @Route("/send-request/{commu_id}",name="send_request")
     */
    public function send_request($commu_id){
        $demandeCommu = new DemandeCommu();
        $demandeCommu->setUserId($this->getUser()->getId());
        $demandeCommu->setCommuId($commu_id);
        $demandeCommu->setDateDemande(new \Datetime());
        $demandeCommu->setEtat('non_approuver');

        $em = $this->getDoctrine()->getManager();
        $em->persist($demandeCommu);
        $em->flush();

        return $this->redirectToRoute('view_page_request');
        
    }

    /**
     * @Route("/requete-en-cours",name="view_page_request")
     */
    public function view_page_request(){
        $repository = $this -> getDoctrine() -> getRepository(DemandeCommu::class);
        $communautess = $repository -> findBy(['user_id' => $this->getUser()->getId()]);
        
        $commu_id = 0;

        foreach($communautess as $comm){
           $commu_id = $comm->getCommuId();
        }

        $repository = $this -> getDoctrine() -> getRepository(Communaute::class);
        $communautes = $repository -> findBy(['id' =>$commu_id]);

        //nous verifions si la demande est nul
        if($commu_id == 0){
            return $this->redirectToRoute('choix',['univers_id'=>1]);
        }

        return $this->render('voie/view_page_request.html.twig',[
            'communautes' => $communautes,
        ]);
    }

    /**
     * @Route("/del_request_commu/{commu_id}",name="del_request_commu")
     */
    public function del_request_commu($commu_id){
        $repository = $this -> getDoctrine() -> getRepository(DemandeCommu::class);
        $communautes = $repository -> findBy(['commu_id' => $commu_id]);
        
        foreach($communautes as $co){
            $em = $this->getDoctrine()->getManager();
            $em->remove($co);
            $em->flush();
        }
        return $this->redirectToRoute("build_com");
        
    }

    /**
     * @Route("/null_request_commu/{commu_id}", name="null_request_commu")
     */
    public function null_request_commu($commu_id){
        $repository = $this -> getDoctrine() -> getRepository(DemandeCommu::class);
        $communautes = $repository -> findBy(['commu_id' => $commu_id]);
        
        foreach($communautes as $co){
            $em = $this->getDoctrine()->getManager();
            $em->remove($co);
            $em->flush();
        }

        return $this->redirectToRoute('choix',['univers_id'=>1]);
    }

    /**
     * @Route("/{commu_id}/you-request-exist", name="you_request_exist")
     */
    public function you_request_exist($commu_id){
        $repository = $this -> getDoctrine() -> getRepository(Communaute::class);
        $communautes = $repository -> findBy(['id' => $commu_id]);
        
        return $this->render('voie/you_request_exist.html.twig',[
            'communautes' => $communautes
        ]);
    }



}

