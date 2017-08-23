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
    public function indexAction()
    {
        return new JsonResponse([
            'hello' => 'world'
        ]);
    }

    /**
     * @Route("/feed", name="feed")
     */
    public function testAction() {
        $response = $this->get('app.neo_ws')->feedInLastDays(3);
        dump($response->getBody()->getContents());
        die();
    }

}
