<?php

namespace ContactBookBundle\Controller;

use ContactBookBundle\Entity\Address;
use ContactBookBundle\Form\AddressType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AddressController extends Controller
{
    /**
     * @Route("/{id}/addAddress")
     * @Template(":Address:new.html.twig")
     * @Method("GET")
     */
    public function showNewAddressFormAction()
    {
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/{id}/addAddress")
     * @Template(":Address:new.html.twig")
     * @Method("POST")
     */
    public function createNewAddressAction(Request $request, $id)
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $contact = $this->getDoctrine()->getRepository('ContactBookBundle:Contact')->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Address not found');
        }

        $address->setContact($contact);
        $contact->addAddress($address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();
            return $this->redirectToRoute('contactbook_contact_showcontact', ['id' => $id]);
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/{id}/showAllAddresses")
     * @Template(":Address:show_all.html.twig")
     * @Method("GET")
     */
    public function showAllAddressesAction($id)
    {
        $addresses = $this->getDoctrine()->getRepository('ContactBookBundle:Address')->findById($id);

        if (!$addresses) {
            return $this->redirectToRoute('contactbook_contact_showcontact', array('id' => $id));
        }

        return ['addresses' => $addresses];
    }

    /**
     * @Route("/{id}/deleteAddress")
     */
    public function deleteAddressAction($id)
    {
        $contact = $this->getDoctrine()->getRepository('ContactBookBundle:Address')->find($id);
        if (!$contact){
            throw $this->createNotFoundException('Address not found');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();
        return $this->redirectToRoute('contactbook_contact_showallcontacts');
    }
}
