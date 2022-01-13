<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('date_debut', DateType::class, [ 'widget'=> 'single_text'])
            ->add('date_fin', DateType::class, [ 'widget'=> 'single_text'])
            ->add('lieu')
            ->add('description')
            ->add('prix')
            ->add('place')
            ->add('type_event')
            ->add('image',FileType::class,[ 'label' => 'Télécharger', 'data_class' => null])
            ->add('lien')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
