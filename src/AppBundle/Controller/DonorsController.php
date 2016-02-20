<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Donors;
use AppBundle\Form\DonorsType;

/**
 * Donors controller.
 *
 * @Route("/donors")
 */
class DonorsController extends Controller
{
    /**
     * Lists all Donors entities.
     *
     * @Route("/", name="donors_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $donors = $em->getRepository('AppBundle:Donors')->findAll();

        return $this->render('donors/index.html.twig', array(
            'donors' => $donors,
        ));
    }

    /**
     * Creates a new Donors entity.
     *
     * @Route("/new", name="donors_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $donor = new Donors();
        $form = $this->createForm('AppBundle\Form\DonorsType', $donor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($donor);
            $em->flush();

            return $this->redirectToRoute('donors_show', array('id' => $donors->getId()));
        }

        return $this->render('donors/new.html.twig', array(
            'donor' => $donor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Donors entity.
     *
     * @Route("/{id}", name="donors_show")
     * @Method("GET")
     */
    public function showAction(Donors $donor)
    {
        $deleteForm = $this->createDeleteForm($donor);

        return $this->render('donors/show.html.twig', array(
            'donor' => $donor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Donors entity.
     *
     * @Route("/{id}/edit", name="donors_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Donors $donor)
    {
        $deleteForm = $this->createDeleteForm($donor);
        $editForm = $this->createForm('AppBundle\Form\DonorsType', $donor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($donor);
            $em->flush();

            return $this->redirectToRoute('donors_edit', array('id' => $donor->getId()));
        }

        return $this->render('donors/edit.html.twig', array(
            'donor' => $donor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Donors entity.
     *
     * @Route("/{id}", name="donors_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Donors $donor)
    {
        $form = $this->createDeleteForm($donor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($donor);
            $em->flush();
        }

        return $this->redirectToRoute('donors_index');
    }

    /**
     * Creates a form to delete a Donors entity.
     *
     * @param Donors $donor The Donors entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Donors $donor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('donors_delete', array('id' => $donor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
