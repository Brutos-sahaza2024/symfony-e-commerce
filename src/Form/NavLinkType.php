<?php

namespace App\Form;

use App\Entity\NavLink;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class NavLinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
            $builder
                ->add('NameLink', TextType::class, [
                    'label' => 'Nom du lien',
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 2, 'max' => 255]),
                    ],
                ])
                ->add('NameUrl', TextType::class, [
                    'label' => 'URL',
                    'constraints' => [
                        new Assert\NotBlank()
                    ],
                ])
                ->add('Category', ChoiceType::class, [
                    'label' => 'Catégorie',
                    'choices' => [
                        'Produit' => 'produit',
                        'Contact' => 'contact'
                    ],
                    'multiple' => false,
                    'expanded' => true,
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NavLink::class,
        ]);
    }
}
