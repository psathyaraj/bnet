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
use AppBundle\Entity\Requests;
use AppBundle\Form\RequestsType;
use AppBundle\Repository\RequestsRepository;

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
	
	/**
	 * Register Hospital Api
	 *
	 *@ApiDoc(
	 *  description="Register New Requests for Blood, Plasma, Platelets",
	 *  input="AppBundle\Entity\Requests",
	 *  parameters={
	 * 	},
	 *  statusCodes={
	 *         200="Returned when successful Response data = {'code':'200','message':'Success'}",
	 *         400="Returned when invalid date Response data = {'code':'400','message':'Please check the parameter'}",
	 *  }
	 * )
	 * @Route("/requests", name="hospital_request")
	 * @Method({"POST"})
	 */
	public function newRequests(Request $request)
	{
		$hospital = $this->getUser();
		$params['type'] = $request->request->get('type');
		$params['blood_group'] = $request->request->get('blood_group');
		$params['qty'] = $request->request->get('qty');
		$params['patient_name'] = $request->request->get('patient_name');
		$params['within_hours'] = $request->request->get('within_hours');
		
		$requests = new Requests();
		$form = $this->createForm(RequestsType::class, $requests);
		$form->submit($params);
		if ($form->isValid()) {
			$requests->setStatus(RequestsRepository::STATUS_PENDING);
			$requests->setHospital($hospital);
			$em = $this->getDoctrine()->getManager();
			$em->persist($requests);
			$em->flush();
			
			$this->get("request_donors")->sendPushNotification($requests);
	
			return array('code'=>Response::HTTP_ACCEPTED, 'message'=>'Success');
		}
	
		return array('code'=>Response::HTTP_BAD_REQUEST, 'message'=>'Please check the parameter');
	}
}
