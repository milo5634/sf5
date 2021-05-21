<?php

namespace App\Repository;

use App\Entity\Livre, App\Entity\Emprunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    /**
     * @return Livre[] Returns an array of Livre objects
     */

    public function findByMot($value)
    {
        /* 
SELECT l.*
FROM livre l
WHERE l.titre LIKE "%mot%"
*/

        return $this->createQueryBuilder('l')
            ->where("l.titre LIKE :mot")

            ->setParameter('mot', "%" . $value . "%")
            ->orderBy('l.auteur', 'ASC')
            ->AddOrderBy("l.titre")
            ->getQuery()
            ->getResult();
    }

    public function LivresNonDisponibles()
    {

        /* 
SELECT l.*
FROM livre l JOIN emprunt e ON l.id = e.livre_id
WHERE e.date_retour IS null 
*/
        return $this->createQueryBuilder("l")
            ->join(Emprunt::class, "e", "WITH", "l.id = e.livre")
            ->where("e.date_retour IS null")
            ->orderBy("l.auteur")
            ->AddOrderBy("l.titre")
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
