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
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') && $this->get('security.authorization_checker')->isGranted('ROLE_GHADMIN')) {
            $ghadmin = $this->getUser();
            $ghouse = new Ghouse();
            $ghouse_add_form = $this->createForm(GhouseForm::class, $ghouse);
            $ghouse_add_form->get('GhouseAdmin')->setData($ghadmin->getId());
            $ghouse_add_form->handleRequest($request);
            /*$ghouse_add_form = $this->get('form.factory')
                ->createNamedBuilder('ghouse_add_form')
                ->add('nom_maison', TextType::class)
                ->add('nom_prenom_prop', TextType::class)
                ->add('adresse', TextType::class)
                ->add('mapLng', NumberType::class, array('scale' => 20))
                ->add('mapLat', NumberType::class, array('scale' => 20))
                ->add('home_num', NumberType::class)
                ->add('phone_num', NumberType::class)
                ->add('a_propos', TextareaType::class)
                ->add('f')
                ->getForm();*/
            return $this->render('@Application/GhouseView/ajouter-ghouse.html.twig', array('ghouse_add_form' =>$ghouse_add_form->createView()));
        }
        return $this->redirectToRoute('application_front_homepage');
    }
}
