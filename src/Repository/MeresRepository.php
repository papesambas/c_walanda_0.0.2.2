<?php

namespace App\Repository;

use App\Entity\Meres;
use App\Data\SearchData;
use App\Data\SearchParentData;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Meres>
 */
class MeresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meres::class);
    }

    /**
     * Recherche des Meres en fonction des critères contenus dans l'objet SearchData.
     *
     * - Si le champ "q" est renseigné, on recherche sur m.fullname.
     * - Si des professions sont sélectionnées, on filtre sur m.profession.
     * - Si un téléphone est renseigné, on normalise le numéro et on le compare aux valeurs
     *   des champs "designation" des téléphones liés (dans telephone et telephone2).
     * - Si un NINA est renseigné, on effectue une jointure sur m.nina et on filtre par la propriété "designation".
     *
     * @param SearchData $searchData
     * @return Meres[]
     */
    public function findBySearchData(SearchData $searchData)
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->leftJoin('m.telephone1', 't1')
            ->leftJoin('m.telephone2', 't2')
            ->leftJoin('m.ninas', 'n')
            ->addSelect('t1', 't2', 'n');

        if (!empty($searchData->q)) {
            $queryBuilder
                ->andWhere('m.fullname LIKE :q')
                ->setParameter('q', '%' . $searchData->q . '%');
        }

        if (!empty($searchData->professions)) {
            $queryBuilder
                ->andWhere('m.profession IN (:professions)')
                ->setParameter('professions', $searchData->professions);
        }

        if (!empty($searchData->telephone)) {
            $normalizedTelephone = preg_replace('/\D/', '', $searchData->telephone);
            $queryBuilder
                ->andWhere('t1.numero LIKE :telephone OR t2.numero LIKE :telephone')
                ->setParameter('telephone', '%' . $normalizedTelephone . '%');
        }

        if (!empty($searchData->nina)) {
            $queryBuilder
                ->andWhere('n.designation LIKE :nina')
                ->setParameter('nina', '%' . $searchData->nina . '%');
        }

        return $queryBuilder->getQuery()->getResult();
    }


    public function findBySearchParentData(SearchParentData $searchParentData)
    {
        // Si SearchParentData est null ou que ses propriétés sont vides, retourner une liste vide
        if (
            $searchParentData === null ||
            (empty($searchParentData->qMere) && empty($searchParentData->telephoneMere) && empty($searchParentData->ninaMere))
        ) {
            return [];
        }
    
        $queryBuilder = $this->createQueryBuilder('m')
            ->leftJoin('m.telephone1', 't1')
            ->leftJoin('m.telephone2', 't2')
            ->leftJoin('m.ninas', 'n')
            ->addSelect('t1', 't2', 'n');
    
        // Recherche par fullname (insensible à la casse)
        if (!empty($searchParentData->qMere)) {
            $searchTerm = trim($searchParentData->qMere); // Supprimer les espaces inutiles
            $queryBuilder
                ->andWhere('LOWER(m.fullname) LIKE LOWER(:fullname)')
                ->setParameter('fullname', '%' . $searchTerm . '%')
                ;
        }
    
        // Recherche par téléphone
        if (!empty($searchParentData->telephoneMere)) {
            $normalizedTelephone = preg_replace('/\D/', '', $searchParentData->telephoneMere);
            $queryBuilder
                ->andWhere('t1.numero LIKE :telephoneMere OR t2.numero LIKE :telephoneMere')
                ->setParameter('telephoneMere', '%' . $normalizedTelephone . '%');
        }
    
        // Recherche par NINA
        if (!empty($searchParentData->ninaMere)) {
            $queryBuilder
                ->andWhere('n.designation LIKE :ninaMere')
                ->setParameter('ninaMere', '%' . $searchParentData->ninaMere . '%');
        }
    
        return $queryBuilder->getQuery()->getResult();
    }     


    public function findBySearchParentDataForInscription(SearchParentData $searchParentData)
    {
        // Si SearchParentData est null ou que ses propriétés sont vides, retourner une liste vide
        if (
            $searchParentData === null ||
            (empty($searchParentData->telephoneMere) && empty($searchParentData->ninaMere))
        ) {
            return [];
        }
        $queryBuilder = $this->createQueryBuilder('m')
            ->leftJoin('m.telephone1', 't1')
            ->leftJoin('m.telephone2', 't2')
            ->leftJoin('m.ninas', 'n')
            ->addSelect('t1', 't2', 'n');

        if (!empty($searchParentData->qMere)) {
            $queryBuilder
                ->andWhere('LOWER(m.fullname) LIKE LOWER(:qMere)')
                ->setParameter('qMere', strtolower($searchParentData->qMere) . '%');

        }

        if (!empty($searchParentData->telephoneMere)) {
            $normalizedTelephone = preg_replace('/\D/', '', $searchParentData->telephoneMere);
            $queryBuilder
                ->andWhere('t1.numero LIKE :telephoneMere OR t2.numero LIKE :telephoneMere')
                ->setParameter('telephoneMere', '%' . $normalizedTelephone . '%');
        }

        if (!empty($searchParentData->ninaMere)) {
            $queryBuilder
                ->andWhere('n.designation LIKE :ninaMere')
                ->setParameter('ninaMere', '%' . $searchParentData->ninaMere . '%');
        }

        return $queryBuilder->getQuery()->getResult();
    }

    //    /**
    //     * @return Meres[] Returns an array of Meres objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Meres
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
