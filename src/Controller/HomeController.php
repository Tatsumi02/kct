<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Security\UserAuthenticator;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\User;
use App\Repository\UserRepository;


class HomeController extends AbstractController
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    #[Route('/', name: 'home')]
    public function index(): Response
    {
        if($this->getUser() != null){
            return $this->redirectToRoute('look_up');
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(){
     
        return $this->render('home/inscription.html.twig');
    }

    /**
     * @Route("/traitement-inscription", name="traitement_inscription")
     */
    public function traitement_inscription(Request $request,UserAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler){
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $genre = $request->request->get('genre');
        $email = $request->request->get('email');
        $date = $request->request->get('date');
        $username = $request->request->get('username');
        $password = $request->request->get('password2');

        $user = new User();

        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setGenre($genre);
        $user->setEmail($email);
        $user->setDateNaissance($date);
        $user->setUsername($username);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $password
        ));

        $user->setRoles(["ROLE_USER"]);
        $user->setPdp('default-avatar-596x596.jpg');
        $user->setEtat('actif');
        $user->setDateInscription(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $guardHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $authenticator,
            'main'
          ); 

         return $this->redirectToRoute('voie');
    }


}
