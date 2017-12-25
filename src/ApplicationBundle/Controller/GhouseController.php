<?php

namespace ApplicationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use ApplicationBundle\Form\GhouseForm;
use ApplicationBundle\Entity\Ghouse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GhouseController extends Controller
{
    public function ghouseAction($id)
    {
        return $this->render('@Application/GhouseView/ghouse.html.twig');
    }

    public function ghouseAddAction(Request $request)
    {
        $is_added = "No";
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') && $this->get('security.authorization_checker')->isGranted('ROLE_GHADMIN')) {
            $ghadmin = $this->getUser();
            $ghouse = new Ghouse();
            $ghouse_add_form = $this->createForm(GhouseForm::class, $ghouse);
            //$ghouse_add_form->get('GhouseAdmin')->setData($ghadmin->getId());
            $ghouse_add_form->handleRequest($request);
            if ($ghouse_add_form->isSubmitted()) {
                if ($ghouse_add_form->isValid()) {
                    $ghouse->setGhouseAdmin($ghadmin->getId());
                    try {
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($ghouse);
                        $is_added = "Yes";
                    } catch (\Doctrine\DBAL\DBALException $e) {
                        $is_added = "Error";
                    }
                }
                $is_added = "Error";
            }
            return $this->render('@Application/GhouseView/ajouter-ghouse.html.twig', array('ghouse_add_form' => $ghouse_add_form->createView(),
                'is_added' => $is_added));
        }
        return $this->redirectToRoute('application_front_homepage');
    }
}
