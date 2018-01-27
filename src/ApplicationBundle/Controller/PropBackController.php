<?php

namespace ApplicationBundle\Controller;

use ApplicationBundle\Entity\GhAdmin;
use ApplicationBundle\Form\GhAdminForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use ApplicationBundle\Entity\Ghouse;
use ApplicationBundle\Form\GhouseForm;

class PropBackController extends Controller
{
    public function loginAction(Request $request, $is_registered = "No", UserPasswordEncoderInterface $passwordEncoder, AuthenticationUtils $authUtils)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') && $this->get('security.authorization_checker')->isGranted('ROLE_GHADMIN')) {
            return $this->redirectToRoute('application_front_homepage');
        }
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        $admin = new GhAdmin();

        $reg_form = $this->createForm(GhAdminForm::class, $admin);

        $login_form = $this->createFormBuilder(null)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->getForm();

        $login_form->handleRequest($request);

        if ($login_form->isSubmitted()) {
            $email = $login_form->get('email')->getData();
            $check_user = $this->getDoctrine()
                ->getRepository(GhAdmin::class)
                ->findOneBy(array('email' => $email));

            if ($check_user) {
                $check_password = $passwordEncoder->isPasswordValid($check_user, $login_form->get('password')->getData());
                if ($check_password) {
                    $token = new UsernamePasswordToken($check_user, null, 'ghadmin_firewall', $check_user->getRoles());
                    $this->get('security.token_storage')->setToken($token);
                    $this->get('session')->set('_security_main', serialize($token));
                    $event = new InteractiveLoginEvent($request, $token);
                    $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
                    return $this->redirectToRoute('application_propback_dashboard');
                }

            }
            $error = "Error";
        }

        return $this->render('@Application/PropBackView/login.html.twig', array('form' => $reg_form->createView(),
            'login_form' => $login_form->createView(),
            'is_registered' => $is_registered,
            'last_username' => $lastUsername,
            'error' => $error,));
    }

    public
    function dashboardAction(Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_GHADMIN')) {
            return $this->redirectToRoute('application_propback_login');

        }
        return $this->render('@Application/PropBackView/dashboard.html.twig');

    }

    public
    function dashboardMaisonAction(Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_GHADMIN')) {
            return $this->redirectToRoute('application_propback_login');
        }

        $ghadmin = $this->getUser();
        $ghouse = new Ghouse();
        $ghouse_add_form = $this->createForm(GhouseForm::class, $ghouse);
        $ghouse_add_form->handleRequest($request);
        $ghouse->setDateCreated();
        if ($ghouse_add_form->isSubmitted()) {
            if (!$this->addGhouse($ghadmin, $ghouse)) {
                $this->addFlash("warning", "Un probleme est subis lors de votre action, veuillez ressayer plus tard");
                return $this->redirectToRoute('application_propback_maison');
            }
            $this->addFlash("success", "Votre maison a ete ajoute avec success, Une validation par l'administrateur est requis avant que votre maison peut etre lister dans notre site.");

        }
        return $this->render('@Application/PropBackView/maison.html.twig', array('ghouse_add_form' => $ghouse_add_form->createView()));
    }

    public function addGhouse($user, $ghouse)
    {

        $ghouse->setGhouseAdmin($user->getId());
        $ghouse->setIsValidated(0);
        $gimages = $ghouse->getGhImages();
        $gimages = $gimages->toArray();
        if (empty($gimages) or count($gimages) < 3) {
            $this->addFlash("warning", "Veuillez ajouter au moin troi images pour que vous pouvez ajouter votre maison.");
            return false;
        }
        try {

            $em = $this->getDoctrine()->getManager();
            $em->persist($ghouse);
            $em->flush();
            foreach ($gimages as $g) {
                $g->setGhouseId($ghouse);
                $ghouse->setGhImages($g);
            }//taw bdit bl foreign key
            $this->addImages($gimages, $ghouse->getId());
            foreach ($gimages as $g) {
                $em->persist($g);
                $em->flush();
            }
            return true;

        } catch (\Doctrine\DBAL\DBALException $e) {
            return false;
        }
    }

    public
    function addImages($ghimages,$id)
    {
        $re = true;
        foreach ($ghimages as $a) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $a->getGhImage();
            $fileName = md5(uniqid()) . '.' . $file->guessClientExtension();
            // Move the file to the directory where brochures are stored
            $uploadPath = /*$this->container->getParameter('kernel.project_dir') . */
                'uploads/' . $id;
            $file->move(
                $uploadPath,
                $fileName);
            $a->setPath($uploadPath . $fileName);
            /*try {
                $this->getDoctrine()->resetManager();
                $em = $this->getDoctrine()->getManager();
                $em->persist($a);
                $em->flush();
                $re = true;
            } catch (\Doctrine\DBAL\DBALException $e) {
                $this->addFlash("warning", "Un probleme est subis lors de l'ajout des images, veuillez ressayer plus tard.");
                $re = false;
            }*/
        }
        return $re;
    }

    public
    function dashboardCommentairesAction(Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_GHADMIN')) {
            return $this->redirectToRoute('application_propback_login');
        }
        return $this->render('@Application/PropBackView/commentaires.html.twig');
    }

    public
    function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') && $this->get('security.authorization_checker')->isGranted('ROLE_GHADMIN')) {
            return $this->redirectToRoute('application_front_homepage');
        }
        // 1) build the form
        $admin = new GhAdmin();
        $form = $this->createForm(GhAdminForm::class, $admin);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($admin->getVerifyPassword() == $admin->getPassword()) {
                try {
                    // 3) Encode the password (you could also do this via Doctrine listener)
                    $password = $passwordEncoder->encodePassword($admin, $admin->getPassword());
                    $admin->setPassword($password);
                    // 4) save the User!
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($admin);

                    $em->flush();
                    return $this->forward('ApplicationBundle:PropBack:login', array('is_registered' => 'Yes'));

                } catch (\Doctrine\DBAL\DBALException $e) {
                    return $this->forward('ApplicationBundle:PropBack:login', array('is_registered' => 'Error'));
                }
            } else {
                return $this->forward('ApplicationBundle:PropBack:login', array('is_registered' => 'Error'));
            }
        }
        return $this->forward('ApplicationBundle:PropBack:login', array('is_registered' => 'Error'));
    }
}
