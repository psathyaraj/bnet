<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Requests;
use AppBundle\Form\RequestsType;
/**
 * Requests controller.
 *
 * @Route("/requests")
 */
class RequestsController extends Controller
{
    /**
     * Lists all Requests entities.
     *
     * @Route("/", name="requests_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $requests = $em->getRepository('AppBundle:Requests')->findAll();

        return $this->render('requests/index.html.twig', array(
            'requests' => $requests,
        ));
    }

    /**
     * Creates a new Requests entity.
     *
     * @Route("/new", name="requests_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $this->get("request_donors")->sendPushNotification("1","1");
        /*$request = new Requests();
        $form = $this->createForm('AppBundle\Form\RequestsType', $request);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($request);
            $em->flush();

            return $this->redirectToRoute('requests_show', array('id' => $requests->getId()));
        }

        return $this->render('requests/new.html.twig', array(
            'request' => $request,
            'form' => $form->createView(),
        ));*/

        die("11111");
    }


/**
     * Finds and displays a Requests entity.
     *
     * @Route("/{id}/requestQR", name="requests_qr")
     * @Method("GET")
     */
    public function displayAction(Request $request)
    {
        \PHPQRCode\QRcode::png("test", __DIR__."/../../../web/tmp/qrcode.png", 'L', 4, 4);
        return $this->render('requests/display.html.twig', array(
                    'request' => $request
        ));

    }
    /**
     * Displays a form to edit an existing Requests entity.
     *
     * @Route("/{id}/edit", name="requests_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Requests $request)
    {
        $deleteForm = $this->createDeleteForm($request);
        $editForm = $this->createForm('AppBundle\Form\RequestsType', $request);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($request);
            $em->flush();

            return $this->redirectToRoute('requests_edit', array('id' => $request->getId()));
        }

        return $this->render('requests/edit.html.twig', array(
            'request' => $request,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Requests entity.
     *
     * @Route("/del/{id}", name="requests_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Requests $request)
    {
        $form = $this->createDeleteForm($request);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($request);
            $em->flush();
        }

        return $this->redirectToRoute('requests_index');
    }

    /**
     * Creates a form to delete a Requests entity.
     *
     * @param Requests $request The Requests entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Requests $request)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('requests_delete', array('id' => $request->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
