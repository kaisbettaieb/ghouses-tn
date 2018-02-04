<?php

namespace ApplicationBundle\Repository;

/**
 * GhouseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GhouseRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllValidated()
    {
        return $this->findBy(array('is_validated' => 1));
    }

    public function findAllValidatedNewest()
    {
        return $this->findBy(array('is_validated' => 1), array('dateCreated' => 'DESC'));

    }

    public function findByInput($input)
    {
        return $this->createQueryBuilder('p')
            ->join('p.gh_images', 'c')
            ->where('c.ghouseId = p.id')
            ->andWhere('p.is_validated = 1')
            ->andWhere('p.nom LIKE :nom')
            ->setParameter('nom', '%' . $input . '%')
            ->getQuery()
            ->getResult();

    }
}
