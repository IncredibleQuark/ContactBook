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
    public function createNewFormAction()
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

            return $this->redirectToRoute('contactbook_contact_createnewcontact');
        }

        return ['form' => $form->createView()];
    }
}
