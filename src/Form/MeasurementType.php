<?php

namespace App\Form;

use App\Entity\Location;             // <- ważne: duże "L"
use App\Entity\Measurement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// typy pól
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

// walidacje
use Symfony\Component\Validator\Constraints as Assert;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // DATA POMIARU
            ->add('date', DateType::class, [
                'label'   => 'Data pomiaru',
                'widget'  => 'single_text',
                'html5'   => true,
            ])

            // TEMPERATURA (°C)
            ->add('celsius', NumberType::class, [
                'label' => 'Temperatura (°C)',
                'scale' => 1,

            ])

            // LOKALIZACJA (z listy encji)
            ->add('location', EntityType::class, [
                'class'       => Location::class,
                'label'       => 'Lokalizacja',
                'placeholder' => '— wybierz lokalizację —',
                'choice_label' => function (Location $l) {
                    // dostosuj gdybyś miała inne pola (np. country/city)
                    return sprintf('%s — %s', $l->getCountry(), $l->getCity());
                },

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
            // grupy walidacji ustawiasz w KONTROLERZE (create/edit)
        ]);
    }
}
