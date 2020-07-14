<?php

namespace App\Controller;

// use Doctrine\Common\Persistence\ObjectManager;
// use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ContactController extends AbstractController
{

    /**
     * @Route("/contakt", name="contact")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param \Swift_Mailer $mailer
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function Contact(Request $request, EntityManagerInterface $em )
    {

//        envoyer mail
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            require_once '../mailer.php';
            $transport = (new \Swift_SmtpTransport('smtp.gmail.com',587,'tls'))
            ->setUsername(EMAIL)
            ->setPassword(PASS)
            ;



            $contact = $form->getData();
            $mailer = new \Swift_Mailer($transport);
            $message = (new \Swift_Message('Nouveau contact'))
            ->setFrom($contact['email'])
            ->setTo('test.send.mail.dev@gmail.com')
            ->setBody(
                $this->render('emails/contact.html.twig', [
                        'email' => $contact['email'],
                        'message' => $contact['message'],
                        'nom' => $contact['nom']
                ]));
            $mailer->send($message);
            $this->addFlash('success','Le message à bien été envoyé');
            return $this->redirectToRoute('contact');
        }


//        affichage commentaire
        $livreDorPair = $this->getDoctrine()->getRepository(Commentaire::class)->CommentairePair();
        $livreDorImpair = $this->getDoctrine()->getRepository(Commentaire::class)->CommentaireImpair();


//      ajout commentaire en base
        $commentaire = new Commentaire();
        $formcom = $this->createForm(CommentaireType::class, $commentaire);

        $formcom->handleRequest($request);
        if ($formcom->isSubmitted() && $formcom->isValid()) {
            $em->persist($commentaire);
            $em->flush();

            $this->addFlash('success', 'Commentaire soumis, en attente de validation');
            return $this->redirectToRoute('contact');
        }
        return $this->render('index/contact.html.twig', [
            'controller_name' => 'MainController',
            'livreDorPair' => $livreDorPair,
            'livreDorImpair'=> $livreDorImpair,
            "formcom" => $formcom->createView(),
            "contactForm" => $form->createView()


        ]);


    }


}
