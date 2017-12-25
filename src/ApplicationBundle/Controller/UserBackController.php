<?php

namespace ApplicationBundle\Controller;

use ApplicationBundle\Entity\GhUser;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserBackController extends Controller
{
    public function profileDashboardAction($id)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') && $this->get('security.authorization_checker')->isGranted('ROLE_GHUSER')) {
            return $this->render('@Application/UserBackView/dashboard.twig');
        }
        return $this->redirectToRoute('application_front_homepage');

    }

    public function editProfileAction($id, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $email_changed = "No";
        $password_changed = "No";
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') && $this->get('security.authorization_checker')->isGranted('ROLE_GHUSER')) {
            $edit_email_form = $this->get('form.factory')
                ->createNamedBuilder('edit_email_form')
                ->add('email', EmailType::class)
                ->add('verify_email', EmailType::class)
                ->getForm();
            $edit_password_form = $this->get('form.factory')
                ->createNamedBuilder('edit_password_form')
                ->add('password', PasswordType::class)
                ->add('verify_password', PasswordType::class)
                ->add('old_password', PasswordType::class)
                ->getForm();

            $edit_email_form->handleRequest($request);
            $edit_password_form->handleRequest($request);

            if ($request->request->has('edit_email_form')) {
                if ($edit_email_form->isSubmitted()) {
                    $email_changed = $this->editEmail($edit_email_form);
                }
            }
            if ($request->request->has('edit_password_form')) {
                if ($edit_password_form->isSubmitted()) {
                    $password_changed = $this->editPassword($edit_password_form, $passwordEncoder);
                }
            }

            return $this->render('@Application/UserBackView/editProfile.html.twig', array('edit_email_form' => $edit_email_form->createView(),
                'edit_password_form' => $edit_password_form->createView(),
                'password_changed' => $password_changed,
                'email_changed' => $email_changed));
        }
        return $this->redirectToRoute('application_front_homepage');
    }

    public function editEmail($form)
    {
        $user = $this->getUser();
        if ($form->get('email')->getData() == $form->get('verify_email')->getData()) {
            $check_user = $this->getDoctrine()
                ->getRepository(GhUser::class)
                ->findOneBy(array('email' => $user->getEmail()));

            $check_exists = $this->getDoctrine()
                ->getRepository(GhUser::class)
                ->findOneBy(array('email' => $form->get('email')->getData()));

            if ($check_user) {
                if (!$check_exists) {
                    try {
                        $em = $this->getDoctrine()->getManager();
                        $check_user->setEmail($form->get('email')->getData());
                        $em->flush();
                        return "Yes";
                    } catch (\Doctrine\DBAL\DBALException $e) {
                        return "Error";
                    }
                }
                return "Exist";
            }
            return "Error";
        }
        return "DontMatch";
    }

    public
    function editPassword($form, $passwordEncoder)
    {
        $user = $this->getUser();

        if ($form->get('password')->getData() == $form->get('verify_password')->getData()) {
            $check_user = $this->getDoctrine()
                ->getRepository(GhUser::class)
                ->find($user->getId());

            if ($check_user) {
                $check_password = $passwordEncoder->isPasswordValid($check_user, $form->get('password')->getData());
                if (!$check_password) {
                    try {
                        $password = $passwordEncoder->encodePassword($check_user, $check_password);
                        $em = $this->getDoctrine()->getManager();
                        $check_user->setPassword($password);
                        $em->flush();
                        return "Yes";
                    } catch (\Doctrine\DBAL\DBALException $e) {
                        return "Error";
                    }
                }
                return "FailPassword";
            }
            return "Error";
        }
        return "DontMatch";
    }

    public
    function profileAction($username)
    {
        return new Response('<html>yes</html>');
    }
}
