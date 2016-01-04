<?php

namespace AslakStudio\DocBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="aslak_doc")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('AslakStudioDocBundle:Default:index.html.twig',[
            "title" => $this->getParameter("aslak_doc.name")
        ]);
    }

    /**
     * @Route("/get", name="aslak_doc_get")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction()
    {
        $extracted = $this->get('doc.extractor')->extract();
        $final = $this->get('doc.parser')->parse($extracted);

        $encoders = array(new JsonEncoder());
        $normalizer = new ObjectNormalizer();

        $serializer = new Serializer([$normalizer], $encoders);

        $json = $serializer->serialize($final,'json');

        $response = new Response($json);
        $response->headers->set('Content-Type', 'application/json; charset=UTF-8');
        $response->setCharset('UTF-8');
        $response->setStatusCode(200);
        return $response;
    }
}
