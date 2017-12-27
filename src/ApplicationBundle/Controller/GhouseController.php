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
            $ghouse_add_form->handleRequest($request);
            if ($ghouse_add_form->isSubmitted()) {
                $is_added = $this->addGhouse($ghadmin, $ghouse);
            }
            return $this->render('@Application/GhouseView/ajouter-ghouse.html.twig', array('ghouse_add_form' => $ghouse_add_form->createView(),
                'is_added' => $is_added));
        }
        return $this->redirectToRoute('application_front_homepage');
    }

    public function addGhouse($user, $ghouse)
    {

        $ghouse->setGhouseAdmin($user->getId());
        $ghouse->setIsValidated(0);
        $gimages = $ghouse->getGhImages();
        $gimages = $gimages->toArray();
        try {
            foreach ($gimages as $a) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $a->getGhImage();
                $is_image = false;
                if ($file->guessExtension() == 'png' or $file->guessExtension() == 'jpeg') {
                   $is_image = true;
                }
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($ghouse);
            $em->flush();
            return $this->addImages($gimages, $ghouse->getId());
        } catch (\Doctrine\DBAL\DBALException $e) {
            return "Error";
        }
    }

    public
    function addImages($ghimages, $ghid)
    {
        foreach ($ghimages as $a) {
            $a->setGhouseId($ghid);
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $a->getGhImage();
            /*dump("guessExtension :" . $file->guessExtension());
            dump('getclientoriginalExention :' . $file->getClientOriginalExtension());
            dump('getCLientMimeType : ' . $file->getClientMimeType());
            dump('guessClientExtention : ' . $file->guessClientExtension());
            dump('getCLientSize : ' . $file->getClientSize());*/
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()) . '.' . $file->guessClientExtension();
            // Move the file to the directory where brochures are stored
            $uploadPath = $this->container->getParameter('kernel.project_dir') . '/web/uploads/' . $ghid;
            $file->move(
                $uploadPath,
                $fileName);
            $a->setPath($uploadPath . $fileName);
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($a);
                $em->flush();
                return "Yes";
            } catch (\Doctrine\DBAL\DBALException $e) {
                return "Error";
            }
        }
    }
}
