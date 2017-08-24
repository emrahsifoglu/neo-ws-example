<?php
namespace AppBundle\Document\Neo;

use Doctrine\ODM\MongoDB\DocumentRepository;

class NeoRepository extends DocumentRepository
{

    public function findOneBySpeed($order, $hazardous = null) {
        $query = $this->dm->createQueryBuilder(Neo::class);

        if ($hazardous !== null && is_bool($hazardous)) {
            $query->field('isHazardous')->equals($hazardous);
        }

        return $query->sort('speed', $order)
            ->limit(1)
            ->readOnly()
            ->getQuery()
            ->getSingleResult();
    }

    public function findAllHazardous() {
        return $this->dm->createQueryBuilder(Neo::class)
            ->field('isHazardous')->equals(true) //->where("function() { return this.isHazardous == true; }")
            ->readOnly()
            ->getQuery()
            ->execute();
    }

    public function findTotalCount() {
        return $this->dm->createQueryBuilder(Neo::class)
            ->count()
            ->getQuery()
            ->execute();
    }

    public function findHazardousCount() {
        return $this->dm->createQueryBuilder(Neo::class)
            ->field('isHazardous')->equals(true) //->where("function() { return this.isHazardous == true; }")
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
