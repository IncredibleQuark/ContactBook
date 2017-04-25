<?php

namespace ContactBookBundle\Controller;

use ContactBookBundle\Entity\Contact;
use ContactBookBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    /**
     * @Route("/new")
     * @Template(":Contact:new.html.twig")
     * @Method("GET")
     */
    public function createNewContactAction()
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact,
                ['action' => $this->generateUrl('contactbook_contact_createnewcontact')]);

        return ['form' => $form->createView()];
    }
}
