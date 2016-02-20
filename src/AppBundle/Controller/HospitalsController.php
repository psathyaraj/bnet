<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Hospitals;
use AppBundle\Form\HospitalsType;

/**
 * Hospitals controller.
 *
 * @Route("/hospitals")
 */
class HospitalsController extends Controller
{
    /**
     * Lists all Hospitals entities.
     *
     * @Route("/", name="hospitals_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $hospitals = $em->getRepository('AppBundle:Hospitals')->findAll();

        return $this->render('hospitals/index.html.twig', array(
            'hospitals' => $hospitals,
        ));
    }

    /**
     * Creates a new Hospitals entity.
     *
     * @Route("/new", name="hospitals_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $hospital = new Hospitals();
        $form = $this->createForm('AppBundle\Form\HospitalsType', $hospital);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hospital);
            $em->flush();

            return $this->redirectToRoute('hospitals_show', array('id' => $hospitals->getId()));
        }

        return $this->render('hospitals/new.html.twig', array(
            'hospital' => $hospital,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Hospitals entity.
     *
     * @Route("/{id}", name="hospitals_show")
     * @Method("GET")
     */
    public function showAction(Hospitals $hospital)
    {
        $deleteForm = $this->createDeleteForm($hospital);

        return $this->render('hospitals/show.html.twig', array(
            'hospital' => $hospital,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Hospitals entity.
     *
     * @Route("/{id}/edit", name="hospitals_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Hospitals $hospital)
    {
        $deleteForm = $this->createDeleteForm($hospital);
        $editForm = $this->createForm('AppBundle\Form\HospitalsType', $hospital);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hospital);
            $em->flush();

            return $this->redirectToRoute('hospitals_edit', array('id' => $hospital->getId()));
        }

        return $this->render('hospitals/edit.html.twig', array(
            'hospital' => $hospital,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Hospitals entity.
     *
     * @Route("/{id}", name="hospitals_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Hospitals $hospital)
    {
        $form = $this->createDeleteForm($hospital);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($hospital);
            $em->flush();
        }

        return $this->redirectToRoute('hospitals_index');
    }

    /**
     * Creates a form to delete a Hospitals entity.
     *
     * @param Hospitals $hospital The Hospitals entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Hospitals $hospital)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hospitals_delete', array('id' => $hospital->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
