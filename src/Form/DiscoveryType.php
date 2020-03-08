<?php

namespace App\Form;

use App\Entity\Discovery;
use App\Entity\Continent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use App\EventSubscriber\Form\DiscoveryFormSubscriber;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DiscoveryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Le nom est obligatoire"
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Le description est obligatoire"
                    ])
                ]
            ])

            ->add('continent', EntityType::class, [
                'class' => Continent::class,
                'choice_label' => 'name',
                'placeholder' => '',
                'constraints' => [(
                    new NotBlank([
                        'message' => 'La catégorie est obligatoire'
                    ])
                )]
            ])
            // le champ image est créé dans le souscripteur de formulaire
            //->add('slug')
        ;

        $builder->addEventSubscriber(new DiscoveryFormSubscriber());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Discovery::class,
        ]);
    }
}
