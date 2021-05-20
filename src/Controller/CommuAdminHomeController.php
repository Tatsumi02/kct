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
use App\Entity\Sites;
use App\Repository\SitesRepository;
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


    #[Route('/home', name: 'commu_admin_home')]
    public function index(Request $request): Response
    {
        $op = '';
        $op = $request->get('op');

        $commus = $this->returnCommu();
        
        if($commus == null){
            return new Response('Vous ne pouvez pas acceder a cette communaute');
        }

        return $this->render('commu_admin_home/index.html.twig', [
            'controller_name' => 'CommuAdminHomeController',
            'commus' => $commus,
            'op' => $op,
        ]);
    }

    /**
     * @Route("/site-build",name="commu_admin_site")
     */
    public function commu_admin_site(){

        $commus = $this->returnCommu();

        return $this->render('commu_admin_home/commu_admin_site.html.twig',[
            'commus'=> $commus
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


        return $this->render('commu_admin_home/commu_admin_perso.html.twig',[
            'commus' => $commus,
            'sites' => $sites
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


}
