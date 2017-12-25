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
        return $this->render('@Application/PropBackView/maison.html.twig');
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
