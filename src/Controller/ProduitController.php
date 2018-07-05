<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProduitController extends Controller
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $produit = new Produit();
        $produit->setNom('Produit ' . uniqid());
        $produit->setDescription("bla bla");
        $produit->setPrix(rand()/100);
        $produit->setCreatedAt(new \DateTime("now"));

        $entityManager->persist($produit);
        $entityManager->flush();

        // récupérer la liste des produits
        $repository = $this->getDoctrine()->getRepository(Produit::class);

        $produits = $repository->findAll();

        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
            'produits' => $produits
        ]);
    }

    public function produitsFiltre($prix) {
        $repository = $this->getDoctrine()->getRepository(Produit::class);

        $produits = $repository->produitsDontLePrixEstSuperieurA($prix);

        return $this->render('produit/liste.html.twig', [
            'produits' => $produits
        ]);


    }

    public function produitsCat($id) {
        $repository = $this->getDoctrine()->getRepository(Produit::class);
        $produits = $repository->produitsParCategorie($id);

        return $this->render('produit/liste.html.twig', [
            'produits' => $produits
        ]);
    }

    public function creerProduit(Request $request) {
        $produit = new Produit();
        $form = $this->createFormBuilder($produit)
                     ->add('nom', TextType::class)
                     ->add('description', TextAreaType::class)
                     ->add('prix', MoneyType::class)
                     ->add('categorie', EntityType::class, ['class' => Categorie::class, 'choice_label' => "nom"])
                     ->add('creer', SubmitType::class, ['label' => 'Créer un produit'])
                     ->getForm();
        return $this->render('produit/creer.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
