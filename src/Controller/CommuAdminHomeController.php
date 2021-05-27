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
use App\Entity\Sites;
use App\Repository\SitesRepository;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\MembreCommu;
use App\Repository\MembreCommuRepository;
use App\Entity\Personnage;
use App\Repository\PersonnageRepository;



/**
 *@Route("/commu/admin")
 *@IsGranted("ROLE_USER")
 */
class CommuAdminHomeController extends AbstractController
{

   
    public function returnCommu(){
        $repository = $this -> getDoctrine() -> getRepository(Communaute::class);
        $commus = $repository -> findBy(['createur_id'=>$this->getUser()->getId()]);
        return $commus;
    }

    public function pushDemande(){
        $id_commu = 0;

        $commus = $this->returnCommu();

        foreach($commus as $com){
            $id_commu = $com->getId(); // on prend l'id de la commu
        }

         // maitenant nous devons ramener le nombre de demande a rejoindre la communaute de l'auteur, pour qu'il puisse savoir qu'il a des demandes pour decider d'accepter ou pas
        // premiere chose a faire est de recuperer l'id de la communaute en fonction de l'id de l'auteur qui est actuellement actif
        
        // recuperons les demandes a rejoindre cette commu en fonction de l'id de la commu et de l'etat de la demande 
        $repository = $this -> getDoctrine() -> getRepository(DemandeCommu::class);
        $demandes = $repository -> findBy(['commu_id'=>$id_commu,'etat'=>'non_approuver']);

        $nb_demande = 0; // cette variable va permetre de savoir combient de demandes sont faits

        foreach($demandes as $de){
            $nb_demande++;
        }

        return $nb_demande;
    }



    #[Route('/home', name: 'commu_admin_home')]
    public function index(Request $request): Response
    {
        $op = '';
        $op = $request->get('op');

        $commus = $this->returnCommu();
        
        if($commus == null){
            return new Response('Vous ne pouvez pas acceder a cette communaute');
        }

       $nb_demande = $this->pushDemande();

        return $this->render('commu_admin_home/index.html.twig', [
            'controller_name' => 'CommuAdminHomeController',
            'commus' => $commus,
            'nb_demande' => $nb_demande,
            'op' => $op,
        ]);
    }

    /**
     * @Route("/site-build",name="commu_admin_site")
     */
    public function commu_admin_site(){

        $commus = $this->returnCommu();
        $nb_demande = $this->pushDemande();

        return $this->render('commu_admin_home/commu_admin_site.html.twig',[
            'commus'=> $commus,
            'nb_demande' => $nb_demande
        ]);
    }

    /**
     * @Route("/site-traitement", name="commu_admin_siteTraitement")
     */
    public function commu_admin_siteTraitement(Request $request){
        $nom = $request->request->get('nom');
        $type = $request->request->get('type');
        $element = $request->request->get('element');
        $description = $request->request->get('description');
        $histoire = $request->request->get('histoire');

        $site = new Sites();
        $site->setSite($nom);
        $site->setUniversId(1);
        $site->setType($type);
        $site->setUserId($this->getUser()->getId());
        $site->setDescription($description);
        $site->setHistoire($histoire);
        $site->setEtat('actif');
        $site->setDateCreation(new \DateTime());
        $site->setElement($element);

        $em = $this->getDoctrine()->getManager();
        $em->persist($site);
        $em->flush();

        return $this->redirectToRoute('commu_admin_home',['op'=>1]);

    }

    /**
     * @Route("/perso", name="commu_admin_perso")
     */
    public function commu_admin_perso(){

        $commus = $this->returnCommu();
        $repository = $this -> getDoctrine() -> getRepository(Sites::class);
        $sites = $repository -> findBy(['user_id'=>$this->getUser()->getId()]);

        $nb_demande = $this->pushDemande();

        return $this->render('commu_admin_home/commu_admin_perso.html.twig',[
            'commus' => $commus,
            'sites' => $sites,
            'nb_demande' => $nb_demande
        ]);
    }

    /**
     * @Route("/perso-traitement", name="commu_admin_persoTraitement")
     */
    public function commu_admin_persoTraitement(Request $request){
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $site_id = $request->request->get('site');
        $ref = $request->request->get('ref');

        $perso = new Personnage();

        $perso->setNom($nom);
        $perso->setPrenom($prenom);
        $perso->setSiteId($site_id);
        $perso->setLienRef($ref);
        $perso->setUniverId(1);
        $perso->setUserId($this->getUser()->getId());
        $perso->setEtat('dispo');

        $em = $this->getDoctrine()->getManager();
        $em->persist($perso);
        $em->flush();

        return $this->redirectToRoute('commu_admin_home',['op'=>1]);

    }

    
    /**
     * @Route("/les-membres", name="membres")
     */
    public function membre(){

        $commus = $this->returnCommu();
        $nb_demande = $this->pushDemande();

        // on va dabord recuperer l'id de la communaute
        $id_commu = 0;
        foreach($commus as $co){
            $id_commu = $co->getId();
        }

        $repository = $this -> getDoctrine() -> getRepository(DemandeCommu::class);
        $demandes = $repository -> findBy(['commu_id'=>$id_commu,'etat'=>'non_approuver']);

        foreach($demandes as $com){
            $repository = $this -> getDoctrine() -> getRepository(User::class);
            $demandeurs = $repository -> findBy(['id'=>$com->getUserId()]);
    
        }

        return $this->render('commu_admin_home/membre.html.twig',[
            'commus' => $commus,
            'nb_demande' => $nb_demande,
            'demandeurs' => $demandeurs,
            'id_commu'=>$id_commu
        ]);
    }

    /**
     * @Route("/accepter_membre-{commu_id}-{demandeur_id}", name="accepter_membre")
     */
    public function accepter_membre($commu_id,$demandeur_id){

        $repository = $this -> getDoctrine() -> getRepository(DemandeCommu::class);
        $demandeurs = $repository -> findBy(['user_id'=>$demandeur_id]);
        // nous allons dabord supprimer le demandeur dans la table des demandes
        foreach($demandeurs as $demand){
            $em = $this->getDoctrine()->getManager();
            $em->remove($demand);
            $em->flush();
        }

        // maintenant, nous allons ajouter le demandeur dans la table des participants a une communaute

        $membre = new MembreCommu();
        $membre->setCommuId($commu_id);
        $membre->setMembreId($demandeur_id);
        $membre->setDateAjout(new \Datetime());
        $membre->setEtat('actif');

        $em = $this->getDoctrine()->getManager();
        $em->persist($membre);
        $em->flush();

        // pour fini, on redirige vers la route de chargement
        return $this->redirectToRoute('look_up');
    }



}
