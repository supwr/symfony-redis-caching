<?php

namespace AppBundle\Controller;



use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Predis\Client;
use Doctrine\Common\Cache\PredisCache;




class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @Route("/employees", name="employees")
     * @Method("GET")
     */
    public function employeeAction(Request $request)
    {

        $predis = new PredisCache(new Client());

        $em = $this->getDoctrine()->getEntityManager()->createQueryBuilder();
        $employees = $em->select('e')
            ->from('AppBundle:Employees','e')
            ->getQuery()
            ->setResultCacheDriver($predis)
            ->setResultCacheLifetime(86400)
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);


        return new JsonResponse(array("employees" => $employees), 200);
    }

}
