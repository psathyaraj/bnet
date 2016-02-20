<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\LastDonations;
use AppBundle\Form\LastDonationsType;

/**
 * LastDonations controller.
 *
 * @Route("/lastdonations")
 */
class LastDonationsController extends Controller
{
    /**
     * Lists all LastDonations entities.
     *
     * @Route("/", name="lastdonations_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lastDonations = $em->getRepository('AppBundle:LastDonations')->findAll();

        return $this->render('lastdonations/index.html.twig', array(
            'lastDonations' => $lastDonations,
        ));
    }

    /**
     * Creates a new LastDonations entity.
     *
     * @Route("/new", name="lastdonations_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $lastDonation = new LastDonations();
        $form = $this->createForm('AppBundle\Form\LastDonationsType', $lastDonation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lastDonation);
            $em->flush();

            return $this->redirectToRoute('lastdonations_show', array('id' => $lastdonations->getId()));
        }

        return $this->render('lastdonations/new.html.twig', array(
            'lastDonation' => $lastDonation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a LastDonations entity.
     *
     * @Route("/{id}", name="lastdonations_show")
     * @Method("GET")
     */
    public function showAction(LastDonations $lastDonation)
    {
        $deleteForm = $this->createDeleteForm($lastDonation);

        return $this->render('lastdonations/show.html.twig', array(
            'lastDonation' => $lastDonation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing LastDonations entity.
     *
     * @Route("/{id}/edit", name="lastdonations_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, LastDonations $lastDonation)
    {
        $deleteForm = $this->createDeleteForm($lastDonation);
        $editForm = $this->createForm('AppBundle\Form\LastDonationsType', $lastDonation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lastDonation);
            $em->flush();

            return $this->redirectToRoute('lastdonations_edit', array('id' => $lastDonation->getId()));
        }

        return $this->render('lastdonations/edit.html.twig', array(
            'lastDonation' => $lastDonation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a LastDonations entity.
     *
     * @Route("/{id}", name="lastdonations_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, LastDonations $lastDonation)
    {
        $form = $this->createDeleteForm($lastDonation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lastDonation);
            $em->flush();
        }

        return $this->redirectToRoute('lastdonations_index');
    }

    /**
     * Creates a form to delete a LastDonations entity.
     *
     * @param LastDonations $lastDonation The LastDonations entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LastDonations $lastDonation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lastdonations_delete', array('id' => $lastDonation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
