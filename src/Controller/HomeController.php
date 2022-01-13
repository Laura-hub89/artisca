<?php

namespace App\Controller;

use App\Form\EditProfileType;
use App\Repository\ArticleRepository;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EventRepository $EventRepository , ArticleRepository $ArticleRepository): Response
    {
        return $this->render('home/index.html.twig', [ 
        'liste_event' => $EventRepository->findAll(),
        'article' => $ArticleRepository->findAll(),
        'ateliers' => $EventRepository->findBy(['type_event' => 1]),
        'evenements' => $EventRepository->findBy(['type_event' => 2]),
        ]);
    } 

    /**
     * @Route("/moncompte", name="moncompte")
     */
    public function moncompte(): Response
    {
        return $this->render('home/moncompte.html.twig');
    }

    /**
     * @Route("/moncompte/modifier", name="modifiermoncompte")
     */
    public function modifiermoncompte(Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_USER')) 
        {
            throw $this->createAccessDeniedException('Accès refusé !');
        }
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', ' Mise à jour effectuée !');
            return $this->redirectToRoute('moncompte');
        }

        return $this->render('home/modifiermoncompte.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/compte/modifier/passe", name="modifiermotdepasse")
     */
    public function modifierpasse(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();

            // On vérifie si les 2 mots de passe sont identiques
            if($request->request->get('editpassword') == $request->request->get('editpassword2')){
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('editpassword')));
                $em->flush();
                $this->addFlash('message', ' Votre mot de passe a bien été modifié');

                return $this->redirectToRoute('compte');
            }else{
                $this->addFlash('error', 'Attention ! Les deux mots de passe ne sont pas identiques.');
            }
        }
        
        return $this->render('home/modifiermotdepasse.html.twig');
    }

    /**
     * @Route("/atelier", name="atelier")
     */
    public function atelier(EventRepository $EventRepository): Response
    {
        return $this->render('home/atelier.html.twig', [ 
            'ateliers' => $EventRepository->findBy(['type_event' => 1]),
        ]);
    }
    /**
     * @Route("/atelier/{id}", name="atelier_detail")
     */
    public function atelierDetail($id, EventRepository $eventRepository): Response
    {
        $atelier = $eventRepository->find($id);

        return $this->render('home/atelier_detail.html.twig', [
            'atelier' => $atelier
        ]);
    }

     /**
     * @Route("/evenement", name="evenement")
     */
    public function evenement(EventRepository $EventRepository): Response
    {
        return $this->render('home/evenement.html.twig', [ 
            'events' => $EventRepository->findBy(['type_event' => 2]),
        ]);
    }
    
    /**
     * @Route("/evenement/{id}", name="evenement_detail")
     */
    public function evenementDetail($id, EventRepository $eventRepository): Response
    {
        $event = $eventRepository->find($id);

        return $this->render('home/evenement_detail.html.twig', [
           'event' => $event
        ]);
    }

    /**
     * @Route("/nous", name="nous")
     */
    public function nous(): Response
    {
        return $this->render('home/nous.html.twig');
    }

    /**
     * @Route("/mention", name="mention")
     */
    public function mention(): Response
    {
        return $this->render('home/mention.html.twig');
    }

    /**
     * @Route("/cgu", name="cgu")
     */
    public function cgu(): Response
    {
        return $this->render('home/cgu.html.twig');
    }

}

