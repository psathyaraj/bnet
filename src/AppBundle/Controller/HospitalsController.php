<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Hospitals;
use AppBundle\Form\HospitalsType;
use AppBundle\Entity\AppBundle\Entity;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

/**
 * Hospitals controller.
 *
 * @Route("api/v1/hospitals")
 */
class HospitalsController extends Controller
{
	/**
	 * Register Hospital Api
	 *
	 *@ApiDoc(
	 *  description="Register New Hospital",
	 *  input="AppBundle\Entity\Hospitals",
	 *  parameters={
	 * 	},
	 *  statusCodes={
	 *         200="Returned when successful Response data = {'code':'200','message':'Success'}",
	 *         400="Returned when invalid date Response data = {'code':'400','message':'Please check the parameter'}",
	 *  }
	 * )
	 * @Route("/", name="hospitals_new")
	 * @Method({"POST"})
	 */
	public function newAction(Request $request)
	{
		 $params['name'] = $request->request->get('name');
		 $params['phno'] = $request->request->get('phno');
		 $params['latitude'] = $request->request->get('latitude');
		 $params['longitude'] = $request->request->get('longitude');
		$hospital = new Hospitals();
		$form = $this->createForm(HospitalsType::class	, $hospital);
		$form->submit($params);
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($hospital);
			$em->flush();
	
			return array('code'=>Response::HTTP_ACCEPTED, 'message'=>'Success');
		}
	
		return array('code'=>Response::HTTP_BAD_REQUEST, 'message'=>'Please check the parameter');
	}
}
