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
        $event = $this->getDoctrine()->getRepository(Event::class)->NextConcert();
        $music = $this->getDoctrine()->getRepository(Music::class)->LastMusic();
        $article = $this->getDoctrine()->getRepository(Article::class)->sidebarArticles();
        $lastvideo = $this->getDoctrine()->getRepository(Video::class)->LastVideo();
        return $this->render('Liveagenda/liveagenda.html.twig', [
            'events' => $event,
            'music'=> $music,
            'musics' => $music,
            'articles' => $article,
            'lastvideos' => $lastvideo,]);
    }

//    /**
//     * @Route("/liveagenda", name="modal")
//     *
//     */
//    public function modal()
//    {
//        $repo = $this->getDoctrine()->getRepository(Event::class);
//        $event = $repo->findAll();
//
//        return $this->render('Liveagenda/modal.html.twig', [
//            'events' => $event,
//         ]);
//    }

}
