<?php

namespace ContactBookBundle\Controller;

use ContactBookBundle\Entity\Telephone;
use ContactBookBundle\Form\TelephoneType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TelephoneController extends Controller
{
    /**
     * @Route("/{id}/addTelephone")
     * @Template(":Address:new.html.twig")
     * @Method("GET")
     */
    public function showNewTelephoneFormAction()
    {
        $telephone = new Telephone();

        $form = $this->createForm(TelephoneType::class, $telephone);

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/{id}/addTelephone")
     * @Template(":Telephone:new.html.twig")
     * @Method("POST")
     */
    public function createNewTelephoneAction(Request $request, $id)
    {
        $telephone = new Telephone();
        $form = $this->createForm(TelephoneType::class, $telephone);
        $contact = $this->getDoctrine()->getRepository('ContactBookBundle:Contact')->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Contact not found');
        }

        $telephone->setContact($contact);
        $contact->addTelephone($telephone);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($telephone);
            $em->flush();
            return $this->redirectToRoute('contactbook_contact_showcontact', ['id' => $id]);
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/{id}/showAllTelephones")
     * @Template(":Telephone:show_all.html.twig")
     * @Method("GET")
     */
    public function showAllTelephonesAction($id)
    {
        $telephones = $this->getDoctrine()->getRepository('ContactBookBundle:Telephone')->findById($id);

        if (!$telephones) {
            return $this->redirectToRoute('contactbook_contact_showcontact', array('id' => $id));
        }

        return ['telephones' => $telephones];
    }

    /**
     * @Route("/{id}/deleteTelephone")
     */
    public function deleteTelephoneAction($id)
    {
        $telephone = $this->getDoctrine()->getRepository('ContactBookBundle:Telephone')->find($id);
        if (!$telephone){
            throw $this->createNotFoundException('Telephone not found');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($telephone);
        $em->flush();
        return $this->redirectToRoute('contactbook_contact_showallcontacts');
    }
}
