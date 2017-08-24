<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction() {
        return new JsonResponse([
            'hello' => 'world'
        ]);
    }

    /**
     * @Route("/feed", name="feed")
     */
    public function testAction() {
        dump($this->get('facade.neo')->deleteAll());

        $contents = $this->get('app.neo_ws')->feedInLastDays(3);

        foreach ($contents as $date => $objects) {
            foreach ($objects as $object) {
                $neo = $this->get('facade.neo')->createFromContent($object);
                $this->get('facade.neo')->save($neo, false);
            }
        }

        $this->get('facade.neo')->getDocumentManager()->flush();

        $hazardous = $this->get('facade.neo')->getHazardous();
        $fastest = $this->get('facade.neo')->getFastest();
        $slowest = $this->get('facade.neo')->getSlowest();

        dump($hazardous);
        dump($fastest);
        dump($slowest);

        die();
    }

}
