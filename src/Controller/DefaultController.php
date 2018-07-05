<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Article;



class DefaultController extends Controller
{
    /**
     * @Route("/default", name="default")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    public function accueil() {
        return $this->render('default/accueil.html.twig',[
            'texte' => 'lorem ipsum',
            'titre' => 'test',
            'tableau' => [1,2,3,4,5],
            //'date' => new \Date("now")

        ] );
    }

    public function faq() {
        return $this->render('default/faq.html.twig');
    }

    public function design() {
        return $this->render('default/design.html.twig');
    }

    public function creer_article($titre, $contenu) {
        $entityManager = $this->getDoctrine()->getManager();
        $article = new Article();
        $article->setTitre($titre);
        $article->setContenu($contenu);
        $article->setCreatedAt(new \DateTime("now"));
        $entityManager->persist($article);
        $entityManager->flush();

        return new Response('Article crée, avec id = ' . $article->getId());
    }

    public function article($id) {
        $repository = $this->getDoctrine()->getRepository(Article::class);

        $article = $repository->find($id);
        return $this->render('default/article.html.twig', ['article' => $article]); 
    }

    public function articles() {
        $repository = $this->getDoctrine()->getRepository(Article::class);

        $articles = $repository->findAll();
        
        return $this->render('default/articles.html.twig', ['articles' => $articles]); 
    }

    public function articles_by($prop, $recherche) {
        $repository = $this->getDoctrine()->getRepository(Article::class);

        $articles = $repository->findBy(
            [ $prop => '%'.$recherche.'%' ] // TODO: recherche globale 
            );
        
        return $this->render('default/articles.html.twig', ['articles' => $articles]); 
    }

    public function update($id, $prop, $valeur) {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Article::class)->find($id);

        switch($prop) {
            case 'titre':
                $article->setTitre($valeur);
            break;
            case 'contenu':
                $article->setContenu($valeur);
            break;
            default:
            break;
        }
        $entityManager->flush();
        return $this->redirectToRoute('article', [ 'id' => $article->getId()]);
        
    }

    public function supprimer($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Article::class)->find($id);

        $entityManager->remove($article);
        $entityManager->flush();
        
        return $this->redirectToRoute('articles');
        
    }



}
