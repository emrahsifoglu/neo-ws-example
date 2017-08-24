<?php
namespace AppBundle\Document\Neo;

use Doctrine\ODM\MongoDB\DocumentRepository;

class NeoRepository extends DocumentRepository
{

    public function findOneFastest() {
        return $this->dm->createQueryBuilder(Neo::class)
            ->sort('speed', 'DESC')
            ->limit(1)
            ->readOnly()
            ->getQuery()
            ->getSingleResult();
    }

    public function findOneSlowest() {
        return $this->dm->createQueryBuilder(Neo::class)
            ->sort('speed', 'ASC')
            ->limit(1)
            ->readOnly()
            ->getQuery()
            ->getSingleResult();
    }

    public function findTotalCount() {
        return $this->dm->createQueryBuilder(Neo::class)
            ->count()
            ->getQuery()
            ->execute();
    }

    public function removeAll() {
        return $this->dm->createQueryBuilder(Neo::class)
            ->remove()
            ->getQuery()
            ->execute();
    }

}
