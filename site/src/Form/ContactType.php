<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse e-mail : ',
                'required' => true,
                'constraints' => new Assert\NotBlank(),
                'attr' => [
                    'class' => 'emailadress',
                    'placeholder' => 'exemple@exemple.com'
                ],
            ])
            ->add('text', TextareaType::class, [
                'label' => false,
                'required' => true,
                'constraints' => new Assert\NotBlank(),
                'attr' => [
                    'class' => 'textarea',
                    'placeholder' => 'Votre message ...'
                ]
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => ['class' => 'submit']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
