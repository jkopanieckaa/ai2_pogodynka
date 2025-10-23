<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// typy pól
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

// walidacje
use Symfony\Component\Validator\Constraints as Assert;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class, [
                'label' => 'City',
                'attr'  => ['placeholder' => 'Enter city name'],

            ])
            ->add('country', ChoiceType::class, [
                'label' => 'Country',
                'placeholder' => 'Select country',
                'choices' => [
                    'Poland'         => 'PL',
                    'Germany'        => 'DE',
                    'France'         => 'FR',
                    'Spain'          => 'ES',
                    'Italy'          => 'IT',
                    'United Kingdom' => 'GB',
                    'United States'  => 'US',
                ],
                'invalid_message' => 'Wybierz kraj z listy.',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Wybierz państwo.',
                        'groups'  => ['create','edit'],
                    ]),
                    new Assert\Length([
                        'min' => 2, 'max' => 2,
                        'groups' => ['create','edit'],
                    ]),
                ],
            ])
            ->add('latitude', NumberType::class, [
                'label' => 'Latitude',
                'scale' => 6,

            ])
            ->add('longitude', NumberType::class, [
                'label' => 'Longitude',
                'scale' => 6,

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,

        ]);
    }
}
