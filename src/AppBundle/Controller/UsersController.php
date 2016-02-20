<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Users;
use AppBundle\Form\UsersType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Repository\UsersRepository;
use AppBundle\Entity\LastDonations;

/**
 * Users controller.
 *
 * @Route("/api/v1/users")
 */
class UsersController extends Controller
{

    /**
     * Register User Api
     * 
     *@ApiDoc(
	 *  description="Register New User",
	 *  input="AppBundle\Form\UsersType",
	 *  parameters={
	 * 	},
	 *  statusCodes={
	 *         200="Returned when successful Response data = {'code':'200','message':'Success'}",
	 *         400="Returned when invalid date Response data = {'code':'200','message':'Please check the parameter'}",
	 *  }
	 * )
     * @Route("/", name="users_new")
     * @Method({"POST"})
     */
    public function newAction(Request $request)
    {
        $user = new Users();
        $params = array();
        $latestDonations = array();
        $params['dob'] = $request->request->get('dob');
        $params['device_token'] = $request->request->get('pushToken');
        $params['name'] = $request->request->get('fName').$request->request->get('lName');
        $params['gender'] = $request->request->get('gender');
        $params['phno'] = $request->request->get('mobileNumber');
        $params['email'] = $request->request->get('email');
        $params['bloodGroup'] = $request->request->get('bloodGroup');
        $params['location_name'] = $request->request->get('preferredLocationName');
        $params['latitude'] = $request->request->get('preferredLocationLat');
        $params['longitude'] = $request->request->get('preferredLocationLong');
        if($request->request->get('wholeBloodDate') != '')
        	$params['blood_date'] = $request->request->get('wholeBloodDate');
        if($request->request->get('platelatesDate') != '')
        	$params['platelates_date'] = $request->request->get('platelatesDate');
        if($request->request->get('plasmaDate') != '')
        	$params['plasma_date'] = $request->request->get('plasmaDate');
        
        $form = $this->createForm('AppBundle\Form\UsersType', $user);
        $form->submit($params);

        if ($form->isValid()) {
        	$user->setStatus(UsersRepository::ACTIVE_STATUS);
        	$em = $this->getDoctrine()->getManager();
        	$em->persist($user);
        	$em->flush();

            return array('code'=>Response::HTTP_ACCEPTED, 'message'=>'Success');
        }

        return array('code'=>Response::HTTP_BAD_REQUEST, 'message'=>'Please check the parameter');
    }
}
