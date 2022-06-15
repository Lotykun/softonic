<?php

namespace App\Repository;

use App\Entity\ApplicationCompatible;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Application>
 *
 * @method ApplicationCompatible|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApplicationCompatible|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApplicationCompatible[]    findAll()
 * @method ApplicationCompatible[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicationCompatibleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApplicationCompatible::class);
    }

    public function add(ApplicationCompatible $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ApplicationCompatible $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return ApplicationCompatible
     */
    public function create()
    {
        return new ApplicationCompatible();
    }

//    /**
//     * @return Application[] Returns an array of Application objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Application
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
