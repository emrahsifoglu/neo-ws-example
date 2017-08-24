<?php
namespace AppBundle\Document\Neo;

use Doctrine\ODM\MongoDB\DocumentRepository;

class NeoRepository extends DocumentRepository
{

    public function getFastest() {
        return $this->dm->createQueryBuilder(Neo::class)
            ->sort('speed', 'DESC')
            ->limit(1)
            ->readOnly()
            ->getQuery()
            ->getSingleResult();
    }

    public function getSlowest() {
        return $this->dm->createQueryBuilder(Neo::class)
            ->sort('speed', 'ASC')
            ->limit(1)
            ->readOnly()
            ->getQuery()
            ->getSingleResult();
    }

    public function deleteAll() {
        return $this->dm->createQueryBuilder(Neo::class)
            ->remove()
            ->getQuery()
            ->execute();
    }

}
