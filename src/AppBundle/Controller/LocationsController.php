<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Locations;
use AppBundle\Form\LocationsType;

/**
 * Locations controller.
 *
 * @Route("/locations")
 */
class LocationsController extends Controller
{
    /**
     * Lists all Locations entities.
     *
     * @Route("/", name="locations_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $locations = $em->getRepository('AppBundle:Locations')->findAll();

        return $this->render('locations/index.html.twig', array(
            'locations' => $locations,
        ));
    }

    /**
     * Creates a new Locations entity.
     *
     * @Route("/new", name="locations_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $location = new Locations();
        $form = $this->createForm('AppBundle\Form\LocationsType', $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();

            return $this->redirectToRoute('locations_show', array('id' => $locations->getId()));
        }

        return $this->render('locations/new.html.twig', array(
            'location' => $location,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Locations entity.
     *
     * @Route("/{id}", name="locations_show")
     * @Method("GET")
     */
    public function showAction(Locations $location)
    {
        $deleteForm = $this->createDeleteForm($location);

        return $this->render('locations/show.html.twig', array(
            'location' => $location,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Locations entity.
     *
     * @Route("/{id}/edit", name="locations_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Locations $location)
    {
        $deleteForm = $this->createDeleteForm($location);
        $editForm = $this->createForm('AppBundle\Form\LocationsType', $location);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();

            return $this->redirectToRoute('locations_edit', array('id' => $location->getId()));
        }

        return $this->render('locations/edit.html.twig', array(
            'location' => $location,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Locations entity.
     *
     * @Route("/{id}", name="locations_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Locations $location)
    {
        $form = $this->createDeleteForm($location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($location);
            $em->flush();
        }

        return $this->redirectToRoute('locations_index');
    }

    /**
     * Creates a form to delete a Locations entity.
     *
     * @param Locations $location The Locations entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Locations $location)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('locations_delete', array('id' => $location->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
