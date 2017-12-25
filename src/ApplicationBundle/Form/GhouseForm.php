<?php

namespace ApplicationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ApplicationBundle\Entity\Ghouse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GhouseForm extends AbstractType
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_maison', TextType::class)
            ->add('nom_prenom_prop', TextType::class)
            ->add('adresse', TextType::class)
            ->add('mapLng', NumberType::class, array('scale' => 20))
            ->add('mapLat', NumberType::class, array('scale' => 20))
            ->add('home_num', NumberType::class)
            ->add('phone_num', NumberType::class)
            ->add('a_propos', TextareaType::class)
            ->add('offres', TextareaType::class)
            ->add('conditions', TextareaType::class)
            ->add('email', EmailType::class)
            ->add('mots_cles', TextareaType::class)
            ->add('prix_nuit', NumberType::class);

        $user = $this->tokenStorage->getToken()->getUser();
        if (!$user) {
            throw new \LogicException(
                "Il faut que vous connectez pour avoir l'access a cette fonction!"
            );
        }
        $builder
            ->add('ghadmin_id', array('default' => 'bar'));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ghouse::class,
        ));
    }
}