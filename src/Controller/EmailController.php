<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\NewsletterSubscriptionType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportException;
use Psr\Log\LoggerInterface;

#[Route('/email')]
class EmailController extends AbstractController
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    #[Route('/subscribe-newsletter', name: 'app_subscribeNewsletter')]
    public function subscribeNewsletter(Request $request, LoggerInterface $logger): Response
    {
        $form = $this->createForm(NewsletterSubscriptionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailAddress = $form->get('email')->getData();

            try {
                $email = (new Email())
                ->from('hello@example.com')
                ->to($emailAddress)
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Time for Symfony Mailer!')
                ->text('Sending emails is fun again!')
                ->html('<p>See Twig integration for better HTML integration!</p>');

                $this->mailer->send($email);
            } catch (TransportException $th) {
                $logger->error($th->getMessage());
            }
            
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('email/subscribeNewsletter.html.twig', ['form' => $form]);
    }
}
