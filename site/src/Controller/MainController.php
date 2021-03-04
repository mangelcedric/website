<?php

namespace App\Controller;

use App\Entity\Link;
use App\Form\ContactType;
use App\Repository\LinkRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }

    /**
     * @Route("/cv", name="cv")
     */
    public function download()
    {
        $file = new File(__DIR__ . '/../../../CV_Cedric_Mangel.pdf');
        return $this->file($file, 'CV_Cedric_Mangel.pdf', ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @Route("/contact", name="contact", methods={"GET", "POST"})
     */
    public function contact(Request $request, MailerInterface $mailer, LinkRepository $linkRepository): Response
    {
        $mail = $request->get('contact');
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
            ->from($mail['email'])
            ->to(new Address('cedric.mangel@gmail.com'))
            ->htmlTemplate('email/email.html.twig')
            ->text($mail['text'])
            ->context([
                'username' => $mail['email'],
                'text' => $mail['text'],
                'useremail' => $mail['email']
                ]);
            $mailer->send($email);
            $this->addFlash('success', 'Votre email à bien été envoyé');

            return $this->redirectToRoute('contact');
        }

        return $this->render('main/contact.html.twig', [
            'form' => $form->createView(),
            'links' => $linkRepository->findAll()
        ]);
    }
}
