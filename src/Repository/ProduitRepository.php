<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Produit::class);
    }

//    /**
//     * @return Produit[] Returns an array of Produit objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
 
    // créer une méthode pour retourner les produits dont le prix est supérieur à un montant fourni en argument
    public function produitsDontLePrixEstSuperieurA($prix) {
        $qb = $this->createQueryBuilder('p');
        return $qb->andWhere('p.prix > :prix')
           ->setParameter('prix', $prix)
           ->getQuery()
           ->getResult();
    }

    // créer une méthode qui retourne les produits dont la categorie (id) est fourni en argument
    public function produitsParCategorie($id) {
        $qb = $this->createQueryBuilder('p');
        return $qb->innerJoin('p.categorie', 'c')
           ->addSelect('c')
           ->andWhere('c.id = :id')
           ->setParameter('id', $id)
           ->getQuery()
           ->getResult();
    }
}
