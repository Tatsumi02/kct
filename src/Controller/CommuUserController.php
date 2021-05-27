<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Communaute;
use App\Repository\CommunauteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\MembreCommu;
use App\Repository\MembreCommuRepository;
use App\Entity\DemandeCommu;
use App\Repository\DemandeCommuRepository;



/**
 *@Route("/commu/rp")
 *@IsGranted("ROLE_USER")
 */
class CommuUserController extends AbstractController
{
    #[Route('/', name: 'commu_user')]
    public function index(): Response
    {
        return $this->render('commu_user/index.html.twig', [
            'controller_name' => 'CommuUserController',
        ]);
    }

    /**
     * se controleur verifie l'etat de l'utilisateur avant de de le rediriger
     * @Route("/look-up", name="look_up")
     */
    public function look_up(){
        
        // on verifi si il est membre d'une commu
        $repository = $this -> getDoctrine() -> getRepository(MembreCommu::class);
        $membre_commus = $repository -> findBy(['membre_id'=>$this->getUser()->getId()]);
        
        // on verifi si il appartient a une commu deja
        $repository = $this -> getDoctrine() -> getRepository(DemandeCommu::class);
        $demande_commus = $repository -> findBy(['user_id'=>$this->getUser()->getId()]);


        $isMembre = false; // boleen pour donner l'etat sur de savoir si il est membre
        $sendRequest = false; // boleen pour donner l'etat sur de savoir si il a demander plutot a rejoindre une commu

        if($membre_commus != null){
            $isMembre = true;
        }

        if($demande_commus != null){
            $sendRequest = true;
            $isMembre = false;
        }

        // verifion si il est deja membre d'une commu ou pas
        if($isMembre == true){
            // recuperons l'id de la communaute. cela va nous permetre de pouvoir savoir dans quel communaute l'utilisateur se trouve
            $id_commu = 0;
            foreach($membre_commus as $mc){
                $id_commu = $mc->getCommuId();
            }

            return $this->redirectToRoute('in_commu',['commu_id'=>$id_commu]);
        } 

        // verifions si il a une demande en attente ou pas
        if($sendRequest == true){



            //  on redirige vers la page d'attente pour le faire patienter 
            return $this->redirectToRoute('wait_commu');
        }

        // au cas ou l'utilisateur n'a ni choisir une commu, ni demander a rejoindre une
        return $this->redirectToRoute('choix',['univers_id' => 1]);
    }


    /**
    *@Route("/approbable", name="wait_commu")
    */
    public function wait_commu(){
        // cherchons la commu qu'il a demander a rejoindre
        $repository = $this -> getDoctrine() -> getRepository(DemandeCommu::class);
        $demande_commus = $repository -> findBy(['user_id'=>$this->getUser()->getId()]);
        
        $id_commu = 0;

        foreach($demande_commus as $dc){
            $id_commu = $dc->getCommuId();
        }

        // cherchons maintent la commu associe
        $repository = $this -> getDoctrine() -> getRepository(Communaute::class);
        $fetch_commus = $repository -> findBy(['id'=>$id_commu]);
        

        // affichons la vue
        return $this->render('commu_user/wait_commu.html.twig',[
            'commus' => $fetch_commus,
        ]);
    }

    /**
    *@Route("/F45Ds{commu_id}4De54dPd78", name="in_commu")
    */
    public function in_commu($commu_id){

        // faisons une lecture dans la table communaute
        $repository = $this -> getDoctrine() -> getRepository(Communaute::class);
        $commus = $repository -> findBy(['id'=>$commu_id]);

        $auteur = 0; // cette variable va nous permettre de savoir si l'utilisateur en cours est l'auteur de la communaute ou pas
        $id_commu = 0; // cette variable va permettre de recuperer l'id de la commu en cours

        foreach($commus as $com){
            if($com->getCreateurId() == $this->getUser()->getId()){
                $auteur = 1; // puis que c'est l'auteur, on affecte la valeur 1.
            }

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

        return $this->render('commu_user/in_commu.html.twig',[
            'commus' => $commus,
            'auteur' => $auteur,
            'nb_demande' => $nb_demande,
        ]);
    }


}
