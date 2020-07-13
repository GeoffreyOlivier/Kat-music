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
use App\Repository\CommentaireArticleRepository;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use ReCaptcha\ReCaptcha;


class NewsController extends AbstractController
{
    /**
     * @Route("/news", name="news")
     *
     */
    public function show(CommentaireArticleRepository $commentaireRepository)
    {

        $article = $this->getDoctrine()->getRepository(Article::class)->Articles();
        $music = $this->getDoctrine()->getRepository(Music::class)->LastMusic();
        $lastvideo = $this->getDoctrine()->getRepository(Video::class)->LastVideo();
        $nextconcert = $this->getDoctrine()->getRepository(Event::class)->Next3Concert();
        $nombreCom = array();
        for ($i = 0; $i < count($article); $i++){
            $count=count($commentaireRepository->findBy(array('Valide'=>1,'Article'=>$article[$i])));
            array_push($nombreCom,$count);
        }

        return $this->render('news/news.html.twig', [
           'listeCount' => $nombreCom,
            'articles' => $article,
            'musics' => $music,
            'lastvideos' => $lastvideo,
            'nextconcerts' => $nextconcert,
        ]);
    }

    /**
     * @Route("/news/show/{id}", name="article")
     */
    public function singleArticle(ArticleRepository $repo,CommentaireArticleRepository $commentaireRepository, $id, EntityManagerInterface $em, Request $request)
    {



        $CommentaireArticle = new CommentaireArticle();
        $commentForm = $this->createForm(CommentaireArticleType::class, $CommentaireArticle);
        $commentForm -> handleRequest($request);
        $article = $this->getDoctrine()->getRepository(Article::class)->findOneBy(['id'=>$id]);


        if ($commentForm->isSubmitted() && $commentForm->isValid()){
            $recaptcha = new ReCaptcha('6Leo2q8ZAAAAANnLnk8qBW4ScLQYlan_fUj-n8jb');
            $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());
            if($resp->isSuccess()){
                $CommentaireArticle->setArticle($article);
                $this->addFlash('success','Le commentaire à bien été envoyé, il seras traité au plus vite');
                $em->persist($CommentaireArticle);
                $em->flush();
                return $this->redirectToRoute('article', array('id' => $id));
            }

        }
        $article = $repo->find($id);
        $music = $this->getDoctrine()->getRepository(Music::class)->LastMusic();
        $lastvideo = $this->getDoctrine()->getRepository(Video::class)->LastVideo();
        $nextconcert = $this->getDoctrine()->getRepository(Event::class)->NextConcert();
        $countvalide = $commentaireRepository->findBy(array('Valide'=>1, 'Article'=>$id));


        return $this->render('news/article.html.twig', [
            'countvalide' => $countvalide,
            'article' => $article,
            'form' => $commentForm->createView(),
            'musics' => $music,
            'lastvideos' => $lastvideo,
            'nextconcerts' => $nextconcert,

        ]);
    }

}
