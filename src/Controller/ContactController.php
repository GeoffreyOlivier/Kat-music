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
    public function Contact(Request $request, EntityManagerInterface $em, \Swift_Mailer $mailer)
    {

//        envoyer mail
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $message = (new \Swift_Message('Nouveau contact'))
                ->setFrom($contact['email'])
                ->setTo('geoff56150@gmail.com')
                ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig', compact('contact')
                    ),
                    'text/html'
                );
            $mailer->send($message);
            $this->addFlash('success','Le message à bien été envoyé');
            return $this->redirectToRoute('contact');
        }


//        affichage commentaire
        $repo = $this->getDoctrine()->getRepository(Commentaire::class);
        $comm = $repo->findAll();

//      ajout commentaire en base
        $commentaire = new Commentaire();
        $formcom = $this->createForm(CommentaireType::class, $commentaire);

        $formcom->handleRequest($request);
        if ($formcom->isSubmitted() && $formcom->isValid()) {
            $em->persist($commentaire);
            $em->flush();
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('send@example.com')
                ->setTo('geoff56150@gmail.com')
                ->setBody('You should see me from the profiler!');

            $mailer->send($message);
            $this->addFlash('success', 'Commentaire soumis, en attente de validation');
            return $this->redirectToRoute('contact');
        }
        return $this->render('index/contact.html.twig', [
            'controller_name' => 'MainController',
            'commentaires' => $comm,
            "formcom" => $formcom->createView(),
            "contactForm" => $form->createView()


        ]);


    }


}
