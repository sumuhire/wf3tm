<?php

//Homemade repository
namespace App\Repository;

use App\Entity\Task;
use Doctrine\ORM\EntityRepository;
use App\DTO\TaskSearch;



class TaskRepository extends EntityRepository
{
    public function findByTaskSearch(TaskSearch $dto)
    {
        //Define variable qui permet de creer une query
        $queryBuilder = $this->createQueryBuilder('ta');

        //Si l'objet $dto renvoie la propriété projet
        if(!empty($dto->project)){
            $queryBuilder ->andWhere(
                'ta.project = :project'
            );
            $queryBuilder->setParameter('project',$dto->project);

        }

        //Si l'objet $dto renvoie la propriété search alors essae de trouver un tritre comme search
        if(!empty($dto->search)){
            $queryBuilder ->andWhere(
                'ta.title like :search'
            );
            $queryBuilder->setParameter('search','%'.$dto->search. '%');

            
        }
          
        
         return $queryBuilder->getQuery()
            ->execute();
    }

//    /**
//     * @return Project[] Returns an array of Project objects
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
    public function findOneBySomeField($value): ?Project
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
