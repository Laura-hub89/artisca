<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            
            $message = (new Email())
                ->from($contactFormData['email'])
                ->to('association@artisca.fr')
                ->subject('vous avez reçu un email')
                ->text('Sender : '.$contactFormData['email'].' '.
                    $contactFormData['message']);
            $mailer->send($message);
            $this->addFlash('success', 'Votre message a été envoyé');
            
            return new RedirectResponse('/');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

}