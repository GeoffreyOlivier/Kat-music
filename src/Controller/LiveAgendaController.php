<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Event;
use App\Entity\Music;
use App\Entity\Video;
use Knp\Component\Pager\PaginatorInterface;
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
    public function liveagenda(Request $request, PaginatorInterface  $paginator)
    {
        $donnees = $this->getDoctrine()->getRepository(Event::class)->NextConcert();
        $music = $this->getDoctrine()->getRepository(Music::class)->LastMusic();
        $article = $this->getDoctrine()->getRepository(Article::class)->sidebarArticles();
        $lastvideo = $this->getDoctrine()->getRepository(Video::class)->LastVideo();

        $event = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4// Nombre de résultats par page
        );

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
