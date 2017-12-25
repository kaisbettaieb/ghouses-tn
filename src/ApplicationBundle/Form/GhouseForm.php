<?php

namespace ApplicationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ApplicationBundle\Entity\Ghouse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class GhouseForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('nom_prenom_prop', TextType::class)
            ->add('address', TextType::class)
            ->add('mapLng', NumberType::class, array('scale' => 20, 'attr'=> array('style'=>'display:none;')))
            ->add('mapLat', NumberType::class, array('scale' => 20, 'attr'=> array('style'=>'display:none;')))
            ->add('homeNum', NumberType::class)
            ->add('mobileNum', NumberType::class)
            ->add('aPropos', TextareaType::class)
            ->add('options', TextareaType::class)
            ->add('conditions', TextareaType::class)
            ->add('email', EmailType::class)
            ->add('mots_cles', TextareaType::class)
            ->add('prixNuit', NumberType::class)
            ->add('GhouseAdmin', HiddenType::class );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ghouse::class,
        ));
    }
}