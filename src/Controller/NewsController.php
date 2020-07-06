<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Entity\Event;
use App\Entity\Music;
use App\Entity\Video;
use App\Entity\CommentaireArticle;
use App\Repository\ArticleRepository;
use App\Form\CommentaireArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



class NewsController extends AbstractController
{
    /**
     * @Route("/news", name="news")
     *
     */
    public function show()
    {

        $article = $this->getDoctrine()->getRepository(Article::class)->Articles();
        $music = $this->getDoctrine()->getRepository(Music::class)->LastMusic();
        $lastvideo = $this->getDoctrine()->getRepository(Video::class)->LastVideo();
        $nextconcert = $this->getDoctrine()->getRepository(Event::class)->NextConcert();
        return $this->render('news/news.html.twig', [
            'articles' => $article,
            'musics' => $music,
            'lastvideos' => $lastvideo,
            'nextconcerts' => $nextconcert,
        ]);
    }

    /**
     * @Route("/news/show/{id}", name="article")
     */
    public function singleArticle(ArticleRepository $repo, $id)
    {


        $article = $repo->find($id);
        $music = $this->getDoctrine()->getRepository(Music::class)->LastMusic();
        $lastvideo = $this->getDoctrine()->getRepository(Video::class)->LastVideo();
        $nextconcert = $this->getDoctrine()->getRepository(Event::class)->NextConcert();
        $CommentaireArticle = new CommentaireArticle();
        $form = $this->createForm(CommentaireArticleType::class, $CommentaireArticle);

        return $this->render('news/article.html.twig', [
            'article' => $article,
            'form' => $form->createView(), 
            'musics' => $music,
            'lastvideos' => $lastvideo,
            'nextconcerts' => $nextconcert,          
            
        ]);
    }

    /**
    * @Route("/addCommentaireArticle/", name="add_CommentaireArticle")
    */
    public function addCommentaireArticle(Request $request)
    {
        // On créer un nouveau CommentaireArticle
        $CommentaireArticle = new CommentaireArticle();
        // Ici, on préremplit avec la date d'aujourd'hui, par exemple
        // Cette date sera donc préaffichée dans le formulaire, cela facilite le travail de l'utilisateur
        $CommentaireArticle->setCreatedAt(new \Datetime());
        // On crée le FormBuilder grâce au service form factory
        $form = $this->createForm(CommentaireArticleType::class, $CommentaireArticle);
        // Si la requête est en POST
        if ($request->isMethod('POST')) {
            // On fait le lien Requête <-> Formulaire
            // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
            $form->handleRequest($request);

            // On vérifie que les valeurs entrées sont correctes
            // (Nous verrons la validation des objets en détail dans le prochain chapitre)
            if ($form->isValid()) {
                // On enregistre notre objet $advert dans la base de données, par exemple
                $em = $this->getDoctrine()->getManager();
                $em->persist($CommentaireArticle);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

                // On redirige vers la page de visualisation de l'annonce nouvellement créée
                return $this->redirectToRoute('client', array('id' => $CommentaireArticle->getId()));
            }
        }
        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('news/article.html.twig', array(
            'form' => $form->createView(),
        ));
    }




}
