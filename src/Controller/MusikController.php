<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Event;
use App\Entity\Music;
use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class MusikController extends AbstractController
{
    /**
     * @Route("/musik", name="musik")
     *
     */
    public function musik()
    {
       $repo = $this->getDoctrine()->getRepository(Music::class);
        $music = $repo->findAll();
        $article = $this->getDoctrine()->getRepository(Article::class)->sidebarArticles();
        $lastvideo = $this->getDoctrine()->getRepository(Video::class)->LastVideo();
        $nextconcert = $this->getDoctrine()->getRepository(Event::class)->NextConcert();
        return $this->render('index/music.html.twig', [
            'musics' => $music,
            'articles' => $article,
            'lastvideos' => $lastvideo,
            'nextconcerts'=> $nextconcert,

            ]);
    }






    /**
     * @Route("/video", name="video")
     *
     */
    public function video()
    {
        $repo = $this->getDoctrine()->getRepository(Video::class);
        $video = $repo->findAll();
        $music = $this->getDoctrine()->getRepository(Music::class)->LastMusic();
        $article = $this->getDoctrine()->getRepository(Article::class)->sidebarArticles();
        $nextconcert = $this->getDoctrine()->getRepository(Event::class)->NextConcert();
        return $this->render('index/video.html.twig', [
            'videos' => $video,
            'musics' => $music,
            'articles' => $article,
            'nextconcerts'=> $nextconcert,]);
    }



}
