<?php

namespace EticketBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OrderType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class)
            ->add('type', EntityType::class, array(
                'class'        => 'EticketBundle:Type',
                'choice_label' => 'name',
                'multiple'     => false,
                'expanded'     => true,
            ))

            ->add('adresse',     EmailType::class)
            ->add('tickets', CollectionType::class, array(
                'entry_type'   => TicketType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('save',      SubmitType::class);
    }
    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EticketBundle\Entity\Order'
        ));
    }




}
