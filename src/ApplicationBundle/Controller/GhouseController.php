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
        $check_maison = $this->getDoctrine()
            ->getRepository(Ghouse::class)
            ->findOneBy(array('id' => $id));
        if ($check_maison) {
            if ($check_maison->getIsValidated() == 0) {
                return $this->render('@Application/404.html.twig');
            }
            return $this->render('@Application/GhouseView/ghouse.html.twig', array('maison' => $check_maison));
        }
        return $this->render('@Application/404.html.twig');


    }

}
