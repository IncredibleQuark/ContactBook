<?php

namespace ContactBookBundle\Controller;

use ContactBookBundle\Entity\Contact;
use ContactBookBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/new")
     * @Template(":Contact:new.html.twig")
     * @Method("GET")
     */
    public function showNewFormAction()
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact,
            ['action' => $this->generateUrl('contactbook_contact_createnewcontact')]);

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/new")
     * @Template(":Contact:new.html.twig")
     * @Method("POST")
     */
    public function createNewContactAction(Request $request)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($contact);
            $em->flush();

            $id= $contact->getId();

            return $this->redirectToRoute('contactbook_contact_showcontact', array('id' => $id));
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/{id}/edit")
     * @Template(":Contact:edit.html.twig")
     * @Method("GET")
     */
    public function showEditFormAction($id)
    {
        $contact = $this->getDoctrine()->getRepository('ContactBookBundle:Contact')->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Not found!');
        }

        $form = $this->createForm(ContactType::class, $contact);

        return ['formPrimary' => $form->createView(), 'id' => $id];
    }


    /**
     * @Route("/{id}/edit")
     * @Template(":Contact:edit.html.twig")
     * @Method("POST")
     */
    public function createEditFormAction(Request $request, $id)
    {
        $contact = $this->getDoctrine()->getRepository('ContactBookBundle:Contact')->find($id);
        if (!$contact) {
            throw $this->createNotFoundException('Contact not found');
        }
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return $this->redirectToRoute('contactbook_contact_showcontact', array('id' => $id));
        }

        return ['formPrimary' => $form->createView()];
    }


    /**
     * @Route("/{id}")
     * @Template(":Contact:show.html.twig")
     * @Method("GET")
     */
    public function showContactAction($id)
    {
        $contact = $this->getDoctrine()->getRepository('ContactBookBundle:Contact')->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Contact not found');
        }

        return ['contact' => $contact];
    }

    /**
     * @Route("/")
     * @Template(":Contact:show_all.html.twig")
     * @Method("GET")
     */
    public function showAllContactsAction()
    {
        $contacts = $this->getDoctrine()->getRepository('ContactBookBundle:Contact')->sort();

        if (!$contacts) {
            return $this->redirectToRoute('contactbook_contact_createnewcontact');
        }

        return ['contacts' => $contacts];
    }

    /**
     * @Route("/delete/{id}")
     */
    public function deleteContactAction($id)
    {
        $contact = $this->getDoctrine()->getRepository('ContactBookBundle:Contact')->find($id);
        if (!$contact){
            throw $this->createNotFoundException('Contact not found');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();
        return $this->redirectToRoute('contactbook_contact_showallcontacts');
    }

    /**
     * @Route("/searchResult")
     * @Template(":Contact:search_result.html.twig")
     * @Method("POST")
     */
    public function searchContactAction(Request $request)
    {
        $word = $request->request->get('search');

        $contacts = $this->getDoctrine()->getRepository('ContactBookBundle:Contact')->findBySurname($word);
        return ['contacts' => $contacts];
    }



}
