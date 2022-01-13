<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            // ->add('roles', ChoiceType::class, [
            //     'choices'=>[
            //     'Admin'=>'ROLE_ADMIN',
            // 'User'=>'ROLE_USER']
            //     ])
            ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('age')
            ->add('telephone')
            ->add('poste_role')
            ->add('genre')
            ->add('isVerified')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
