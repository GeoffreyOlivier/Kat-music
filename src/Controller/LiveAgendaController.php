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

class LiveAgendaController extends AbstractController
{
    /**
     * @Route("/liveagenda", name="liveagenda")
     *
     */
    public function liveagenda()
    {
        $repo = $this->getDoctrine()->getRepository(Event::class);
        $event = $repo->findAll();
        $music = $this->getDoctrine()->getRepository(Music::class)->LastMusic();
        $article = $this->getDoctrine()->getRepository(Article::class)->sidebarArticles();
        $lastvideo = $this->getDoctrine()->getRepository(Video::class)->LastVideo();
        return $this->render('index/liveagenda.html.twig', [
            'events' => $event,
            'music'=> $music,
            'musics' => $music,
            'articles' => $article,
            'lastvideos' => $lastvideo,]);
    }

}
