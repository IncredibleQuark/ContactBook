<?php

namespace ContactBookBundle\Controller;

use ContactBookBundle\Entity\Contact;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    /**
     * @Route("/new")
     * @Template(":Contact:new.html.twig")
     */
    public function createNewContactAction()
    {
        $post = new Contact();
        $form = $this->createFormBuilder($post)
            ->add('name', 'text')
            ->add('surname', 'text')
            ->add('description', 'text')
            ->add('save', 'submit', array('label' => 'Send'))->getForm();

        return ['form' => $form->createView()];
    }
}
