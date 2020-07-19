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

class MusikController extends AbstractController
{
    /**
     * @Route("/musik", name="musik")
     *
     */
    public function musik(Request $request, PaginatorInterface  $paginator)
    {
       $repo = $this->getDoctrine()->getRepository(Music::class);
        $donnees = $repo->findAll();
        $article = $this->getDoctrine()->getRepository(Article::class)->sidebarArticles();
        $lastvideo = $this->getDoctrine()->getRepository(Video::class)->LastVideo();
        $nextconcert = $this->getDoctrine()->getRepository(Event::class)->Next3Concert();

        $music = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );
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
    public function video(Request $request, PaginatorInterface  $paginator)
    {
        $repo = $this->getDoctrine()->getRepository(Video::class);
        $donnees = $repo->findAll();
        $music = $this->getDoctrine()->getRepository(Music::class)->LastMusic();
        $article = $this->getDoctrine()->getRepository(Article::class)->sidebarArticles();
        $nextconcert = $this->getDoctrine()->getRepository(Event::class)->NextConcert();

        $video = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );
        return $this->render('index/video.html.twig', [
            'videos' => $video,
            'musics' => $music,
            'articles' => $article,
            'nextconcerts'=> $nextconcert,]);
    }



}
