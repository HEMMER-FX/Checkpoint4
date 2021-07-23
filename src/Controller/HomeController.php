<?php

namespace App\Controller;

use App\Form\ContactGuestType;
use App\Repository\ContentRepository;
use App\Repository\ProjetRepository;
use App\Repository\TechnoRepository;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(
        TechnoRepository $technoRepository,
        ContentRepository $contentRepository,
        ProjetRepository $projetRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'technos' => $technoRepository->findAll(),
            'contents' => $contentRepository->findAll(),
            'projets' => $projetRepository->findAll(),
        ]);
    }
    
    /**
     * Method for send mail
     * @Route("/contact", name="send_mail_contact")
     */
    public function new(Request $request, MailerInterface $mailer): Response
    {
        $service = new ContactGuestType();
        $form = $this->createForm(ContactGuestType::class, $service);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $name = $_POST['contact_guest']['email'];
            $email = (new Email())
                ->from($name)
                ->to($this->getParameter('mailer_from'))
                ->subject('Contact formulaire')
                ->html(
                    '<h1><strong>Le contact ' . $name . ' </strong> vous à envoyé un message</h1>  
                    Au sujet de " <strong>'
                    . $_POST['contact_guest']['sujet'] . ' : </strong> "<br><br> Son message est le suivant : <br>'
                    . $_POST['contact_guest']['content']
                );

            $mailer->send($email);
            $this->addFlash('success', 'Votre message à bien était envoyé');
            return $this->redirectToRoute('home');
        }
        return $this->render('./components/formContact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("change-locale-fr/", name="local_fr")
     */
    public function setLocaleFr(Request $request): Response
    {
        $request->getSession()->set('_locale', 'fr');

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("change-locale-en/", name="local_en")
     */
    public function setLocaleEn(Request $request): Response
    {
        $request->getSession()->set('_locale', 'en');

        return $this->redirect($request->headers->get('referer'));
    }
    
}
