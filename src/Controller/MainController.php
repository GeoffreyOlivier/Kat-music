<?php

namespace App\Controller;



use App\Entity\Article;
use App\Entity\Event;
use App\Entity\Music;
use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



class MainController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function Index()
    {

       $video = $this->getDoctrine()->getRepository(Video::class)->LastVideo();
       $music = $this->getDoctrine()->getRepository(Music::class)->lastMusic();
       $article = $this->getDoctrine()->getRepository(Article::class)->LastArticle();

        return $this->render('index/index.html.twig', [
            'musics' => $music,
            'articles' => $article,
            'videos' => $video,
        ]);
    }








}
