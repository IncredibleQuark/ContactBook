<?php

namespace ContactBookBundle\Controller;

use ContactBookBundle\Entity\Groups;
use ContactBookBundle\Form\GroupsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GroupsController extends Controller
{

    /**
     * @Route("/add/Group")
     * @Template(":Groups:new.html.twig")
     * @Method("GET")
     */
    public function showNewGroupFormAction()
    {
        $group = new Groups();

        $form = $this->createForm(GroupsType::class, $group);

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/add/Group")
     * @Template(":Groups:new.html.twig")
     * @Method("POST")
     */
    public function createNewGroupAction(Request $request)
    {
        $group = new Groups();

        $form = $this->createForm(GroupsType::class, $group);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($group);
            $em->flush();



            return $this->redirectToRoute('contactbook_groups_showallgroups');
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/groups/showAll")
     * @Template(":Groups:show_all.html.twig")
     */
    public function showAllGroupsAction()
    {
        $groups = $this->getDoctrine()->getRepository('ContactBookBundle:Groups')->findAll();


        return ['groups' => $groups];
    }

}
