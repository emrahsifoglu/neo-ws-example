<?php
namespace AppBundle\Document\Neo;

use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;

class NeoFacade
{

    private $documentManager;

    public function __construct(
        DocumentManager $documentManager
    ) {
        $this->documentManager = $documentManager;
    }

    public function createFromContent(array $content) {
        $date = DateTime::createFromFormat('Y-m-d', $content['close_approach_data'][0]['close_approach_date']);
        $date->setTime(0,0,0);

        $neo = new Neo();
        $neo->setDate($date);
        $neo->setReference($content['neo_reference_id']);
        $neo->setName($content['name']);
        $neo->setSpeed($content['close_approach_data'][0]['relative_velocity']['kilometers_per_hour']);
        $neo->setIsHazardous($content['is_potentially_hazardous_asteroid']);

        return $neo;
    }

    public function save(Neo $neo, $andFlush = true) {
        $this->documentManager->persist($neo);
        if ($andFlush) {
            $this->documentManager->flush();
        }
    }

    public function getDocumentManager() {
        return $this->documentManager;
    }

    public function getRepository() {
        return $this->documentManager->getRepository(Neo::class);
    }

    public function getFastest($hazardous = false) {
        return $this->getRepository()->findOneBySpeed('DESC', $hazardous);
    }

    public function getSlowest($hazardous = false) {
        return $this->getRepository()->findOneBySpeed('ASC', $hazardous);
    }

    public function getHazardous() {
        $hazardous = [];
        $cursor = $this->getRepository()->findAllHazardous() ?: [];

        foreach($cursor as $neo) {
            $hazardous[] = $neo;
        }

        return $hazardous;
    }

    public function getTotalCount() {
        return $this->getRepository()->findTotalCount();
    }

    public function getHazardousCount() {
        return $this->getRepository()->findHazardousCount();
    }

    public function removeAll() {
        return $this->getRepository()->removeAll();
    }

}
