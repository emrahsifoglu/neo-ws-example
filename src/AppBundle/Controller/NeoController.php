<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/neo")
 */
class NeoController extends Controller
{

    /**
     * @Route("/hazardous", name="neo_hazardous")
     */
    public function hazardousAction() {
        $hazardous = $this->get('facade.neo')->getHazardous();

        return $this->prepareResponse($hazardous);
    }

    /**
     * @Route("/fastest", name="neo_fastest")
     * @param Request $request
     * @return Response
     */
    public function fastestAction(Request $request) {
        $hazardous = json_decode($request->get('hazardous'));

        $fastest = $this->get('facade.neo')->getFastest($hazardous);

        return $this->prepareResponse($fastest);
    }

    /**
     * @Route("/slowest", name="neo_slowest")
     * @param Request $request
     * @return Response
     */
    public function slowestAction(Request $request) {
        $hazardous = json_decode($request->get('hazardous'));

        $slowest = $this->get('facade.neo')->getSlowest($hazardous);

        return $this->prepareResponse($slowest);
    }

    private function prepareResponse($data) {
        $serializer = $this->get('jms_serializer');
        $serialized = $serializer->serialize($data,'json');

        $response = new Response($serialized);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
