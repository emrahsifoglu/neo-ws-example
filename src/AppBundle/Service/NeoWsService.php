<?php
namespace AppBundle\Service;

use AppBundle\Document\Neo\NeoFacade;
use DateTime;
use GuzzleHttp\Client as Client;

class NeoWsService
{

    /** @var Client */
    private $client;

    /** @var string */
    private $endPoint;

    /** @var string */
    private $apiKey;

    public function __construct(
        Client $client,
        array $neoWs
    ) {
        $this->client = $client;
        $this->endPoint = $neoWs['end_point'];
        $this->apiKey = $neoWs['api_key'];
    }

    public function feedInLastDays($days = 3, $detailed = true) {
        $endDate = new DateTime();
        $startDate = (new DateTime())->modify("-{$days} day");
        return $this->feedBetweenDates($endDate, $startDate, $detailed);
    }

    public function feedBetweenDates(DateTime $endDate, DateTime $startDate = null, $detailed = true) {
        $query = [
            'end_date' => $endDate->format('Y-m-d'),
            'api_key' => $this->apiKey,
            'detailed' => $detailed,
        ];

        if ($startDate) {
            $query['start_date'] = $startDate->format('Y-m-d');
        }

        $contents = $this->client->request('GET', $this->getFeedUrl(), [
            'query' => $query
        ]);

        return $this->parseContents($contents->getBody()->getContents());
    }

    private function getFeedUrl() {
        return $this->endPoint . '/feed';
    }

    private function parseContents($content) {
        $content = (array)json_decode($content, true);

        $nearEarthObjects = $content['near_earth_objects'];

        return $nearEarthObjects;
    }

}
