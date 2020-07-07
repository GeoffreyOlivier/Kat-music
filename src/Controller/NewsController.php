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
use Doctrine\ORM\EntityManagerInterface;
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
    public function singleArticle(ArticleRepository $repo, $id, EntityManagerInterface $em, Request $request)
    {
        $CommentaireArticle = new CommentaireArticle();
        $commentForm = $this->createForm(CommentaireArticleType::class, $CommentaireArticle);
        $commentForm -> handleRequest($request);
        $article = $this->getDoctrine()->getRepository(Article::class)->findOneBy(['id'=>$id]);

        if ($commentForm->isSubmitted() && $commentForm->isValid()){
            $CommentaireArticle->setArticle($article);
            $em->persist($CommentaireArticle);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            // On redirige vers la page de visualisation de l'annonce nouvellement créée
            return $this->redirectToRoute('article', array('id' => $id));
        }

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

//    /**
//    * @Route("/addCommentaireArticle/", name="add_CommentaireArticle")
//    */
//    public function addCommentaireArticle(EntityManagerInterface $em, Request $request)
//    {
//
//dd();
//        // On passe la méthode createView() du formulaire à la vue
//        // afin qu'elle puisse afficher le formulaire toute seule
//        return $this->render('news/article.html.twig', array(
//            'form' => $commentForm->createView(),
//        ));
//    }




}
