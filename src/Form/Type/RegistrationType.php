<?php

namespace App\Form\Type;

use App\Constants\Lang;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mandateName', TextType::class, [
                'label' => 'Company / Mandate name',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 2, 'max' => 255]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                    new Length(['max' => 255]),
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'First name',
                'required' => false,
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Last name',
                'required' => false,
            ])
            ->add('locale', ChoiceType::class, [
                'label' => 'Language',
                'required' => false,
                'placeholder' => 'Select language',
                'choices' => $this->getLocaleChoices(),
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
                'mapped' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 6, 'max' => 4096]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'data_class' => null,
        ]);
    }

    private function getLocaleChoices(): array
    {
        $choices = [];
        foreach (Lang::getSupported() as $code) {
            $choices[strtoupper($code)] = $code;
        }

        return $choices;
    }
}
