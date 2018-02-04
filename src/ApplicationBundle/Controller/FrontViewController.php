<?php

namespace ApplicationBundle\Controller;

use ApplicationBundle\Entity\Ghouse;
use ApplicationBundle\Entity\GhUser;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class FrontViewController extends Controller
{
    public function homeAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, AuthenticationUtils $authUtils)
    {
        $is_connected = "No";
        $is_registered = "No";
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        $login_form = $this->get('form.factory')
            ->createNamedBuilder('login_form')
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->getForm();

        $register_form = $this->get('form.factory')
            ->createNamedBuilder('register_form')
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('verify_password', PasswordType::class)
            ->add('username', TextType::class)
            ->add('check_conditions', CheckboxType::class)
            ->getForm();

        $login_form->handleRequest($request);
        $register_form->handleRequest($request);
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {

            if ($request->request->has('login_form')) {

                if ($login_form->isSubmitted()) {
                    $username = $login_form->get('username')->getData();
                    $check_user = $this->getDoctrine()
                        ->getRepository(GhUser::class)
                        ->findOneBy(array('username' => $username));

                    if ($check_user) {
                        $check_password = $passwordEncoder->isPasswordValid($check_user, $login_form->get('password')->getData());
                        if ($check_password) {
                            $is_connected = "Yes";
                            $token = new UsernamePasswordToken($check_user, null, 'ghuser_firewall', $check_user->getRoles());
                            $this->get('security.token_storage')->setToken($token);
                            $this->get('session')->set('_security_main', serialize($token));
                            $event = new InteractiveLoginEvent($request, $token);
                            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

                            return $this->render('@Application/FrontView/home.html.twig', array('is_connected' => $is_connected,
                                'login_form' => $login_form->createView(),
                                'register_form' => $register_form->createView(),
                                'is_registered' => $is_registered));
                        }
                        $is_connected = "Error";
                    } else {
                        $is_connected = "Error";
                    }
                }
            }

            if ($request->request->has('register_form')) {
                if ($register_form->isSubmitted()) {
                    $is_registered = $this->registerUser($register_form, $passwordEncoder);
                }
            }
        }

        return $this->render('@Application/FrontView/home.html.twig', array('is_connected' => $is_connected,
            'login_form' => $login_form->createView(),
            'register_form' => $register_form->createView(),
            'is_registered' => $is_registered));
    }


    public function registerUser($form, $encoder)
    {
        if ($form->get('check_conditions')->getData()) {
            if ($form->get('password')->getData() == $form->get('verify_password')->getData()) {
                $check_user_by_email = $this->getDoctrine()
                    ->getRepository(GhUser::class)
                    ->findOneBy(array('email' => $form->get('email')->getData()));

                $check_user_by_username = $this->getDoctrine()
                    ->getRepository(GhUser::class)
                    ->findOneBy(array('username' => $form->get('username')->getData()));

                if (!$check_user_by_email) {
                    if (!$check_user_by_username) {
                        try {
                            $user = new GhUser();
                            $user->setUsername($form->get('username')->getData());
                            $user->setEmail($form->get('email')->getData());
                            $user->setPassword($encoder->encodePassword($user, $form->get('password')->getData()));
                            $em = $this->getDoctrine()->getManager();
                            $em->persist($user);
                            $em->flush();
                            return "Felicitation, votre compte a été crée, vous pouvez vous connecter";
                        } catch (\Doctrine\DBAL\DBALException $e) {
                            return "Veuillez essaye plus tard.";
                        }
                    }
                    return "Le username que vous avez choisit existe, essaye avec un autre username";
                }
                return "L'email que vous avez choisit existe, essaye avec un autre email";
            }
            return "Les deux passwords que vous avez saisit ne sont identique, veuillez verifier vos passwords";
        }
        return "Il faut que vous accepter les <strong>Les Conditions Générales d'Utilisation</strong>";
    }

    public function allGhousesAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $login_form = $this->get('form.factory')
            ->createNamedBuilder('login_form')
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->getForm();

        $register_form = $this->get('form.factory')
            ->createNamedBuilder('register_form')
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('verify_password', PasswordType::class)
            ->add('username', TextType::class)
            ->add('check_conditions', CheckboxType::class)
            ->getForm();
        $login_form->handleRequest($request);
        $register_form->handleRequest($request);
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($request->request->has('login_form')) {
                if ($login_form->isSubmitted()) {
                    $username = $login_form->get('username')->getData();
                    $password = $login_form->get('password')->getData();
                    $check_user = $this->getDoctrine()
                        ->getRepository(GhUser::class)
                        ->loadUserByUsername($username, $password, $passwordEncoder);
                    if (!$check_user) {
                        $this->addFlash("warning", "Veuillez verifier vos informations");
                        return $this->redirectToRoute("application_ghouse_all");
                    }
                    $this->addFlash("success", "Vous etes connectés");
                    $token = new UsernamePasswordToken($check_user, null, 'ghuser_firewall', $check_user->getRoles());
                    $this->get('security.token_storage')->setToken($token);
                    $this->get('session')->set('_security_main', serialize($token));
                    $event = new InteractiveLoginEvent($request, $token);
                    $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

                    return $this->redirectToRoute("application_ghouse_all");
                }
            }
        }

        $ghouses = $this->getDoctrine()
            ->getRepository(Ghouse::class)
            ->findAllValidated();
        return $this->render('@Application/FrontView/all-ghouse.html.twig', array('login_form' => $login_form->createView(),
            'register_form' => $register_form->createView(),
            'ghouses' => $ghouses));
    }

    public function allGhousesNewestAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        /*$login_form = $this->get('form.factory')
            ->createNamedBuilder('login_form')
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->getForm();

        $register_form = $this->get('form.factory')
            ->createNamedBuilder('register_form')
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('verify_password', PasswordType::class)
            ->add('username', TextType::class)
            ->add('check_conditions', CheckboxType::class)
            ->getForm();
        $login_form->handleRequest($request);
        $register_form->handleRequest($request);
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($request->request->has('login_form')) {
                if ($login_form->isSubmitted()) {
                    $username = $login_form->get('username')->getData();
                    $password = $login_form->get('password')->getData();
                    $check_user = $this->getDoctrine()
                        ->getRepository(GhUser::class)
                        ->loadUserByUsername($username, $password, $passwordEncoder);
                    if (!$check_user) {
                        $this->addFlash("warning", "Veuillez verifier vos informations");
                        return $this->redirectToRoute("application_ghouse_all_newest");
                    }
                    $this->addFlash("success", "Vous etes connectés");
                    $token = new UsernamePasswordToken($check_user, null, 'ghuser_firewall', $check_user->getRoles());
                    $this->get('security.token_storage')->setToken($token);
                    $this->get('session')->set('_security_main', serialize($token));
                    $event = new InteractiveLoginEvent($request, $token);
                    $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
                    return $this->redirectToRoute("application_ghouse_all_newest");
                }
            }
        }

        $ghouses = $this->getDoctrine()
            ->getRepository(Ghouse::class)
            ->findAllValidatedNewest();
        return $this->render('@Application/FrontView/all-ghouse.html.twig', array('login_form' => $login_form->createView(),
            'register_form' => $register_form->createView(),
            'ghouses' => $ghouses));*/
    }

    public function allGhousesParamAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            if ($request->request->get('critere')) {
                $critere = $request->request->get('critere');

                switch ($critere) {
                    case "newest":
                        $ghouses = $this->getDoctrine()
                            ->getRepository(Ghouse::class)
                            ->findAllValidatedNewest();
                        $rep = array();
                        foreach ($ghouses as $g) {
                            $rep[] = $g->serialize();
                        }
                        return new JsonResponse($rep);
                        break;
                    case "input":
                        $txt = $request->request->get('input');
                        $ghouses = $this->getDoctrine()
                            ->getRepository(Ghouse::class)
                            ->findByInput($txt);
                        $rep = array();
                        foreach ($ghouses as $g) {
                            $rep[] = $g->serialize();
                        }
                        return new JsonResponse($rep);
                        break;

                }

            }
        }
        return $this->redirectToRoute("application_ghouse_all");

    }

}