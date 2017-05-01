<?php

namespace ContactBookBundle\Controller;

use ContactBookBundle\Entity\Email;
use ContactBookBundle\Form\EmailType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EmailController extends Controller
{
    /**
     * @Route("/{id}/addEmail")
     * @Template(":Email:new.html.twig")
     * @Method("GET")
     */
    public function showNewEmailFormAction()
    {
        $email = new Email();

        $form = $this->createForm(EmailType::class, $email);

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/{id}/addEmail")
     * @Template(":Email:new.html.twig")
     * @Method("POST")
     */
    public function createNewEmailAction(Request $request, $id)
    {
        $email = new Email();
        $form = $this->createForm(EmailType::class, $email);
        $contact = $this->getDoctrine()->getRepository('ContactBookBundle:Contact')->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Contact not found');
        }

        $email->setContact($contact);
        $contact->addEmail($email);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($email);
            $em->flush();
            return $this->redirectToRoute('contactbook_contact_showcontact', ['id' => $id]);
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/{id}/showAllEmails")
     * @Template(":Email:show_all.html.twig")
     * @Method("GET")
     */
    public function showAllEmailsAction($id)
    {
        $emails = $this->getDoctrine()->getRepository('ContactBookBundle:Email')->findById($id);

        if (!$emails) {
            return $this->redirectToRoute('contactbook_contact_showcontact', array('id' => $id));
        }

        return ['emails' => $emails];
    }

    /**
     * @Route("/{id}/deleteEmail")
     */
    public function deleteEmailAction($id)
    {
        $email = $this->getDoctrine()->getRepository('ContactBookBundle:Email')->find($id);
        if (!$email){
            throw $this->createNotFoundException('Email not found');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($email);
        $em->flush();
        return $this->redirectToRoute('contactbook_contact_showallcontacts');
    }
}
