<?php

namespace ApplicationBundle\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use ApplicationBundle\Form\GhouseForm;
use ApplicationBundle\Entity\Ghouse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class GhouseController extends Controller
{
    public function ghouseAction($id)
    {
        return $this->render('@Application/GhouseView/ghouse.html.twig');
    }

    public function ghouseAddAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') && $this->get('security.authorization_checker')->isGranted('ROLE_GHADMIN')) {

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
            return $this->render('@Application/GhouseView/ajouter-ghouse.html.twig');
        }
        return $this->redirectToRoute('application_front_homepage');
    }
}
