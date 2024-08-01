<?php
namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du produit',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'currency' => 'EUR',
            ])
            ->add('createdAt', DateTimeType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text',
            ])
            ->add('imageUrl', UrlType::class, [
                'label' => 'URL de l\'image',
            ])
            ->add('sku', TextType::class, [
                'label' => 'SKU',
            ])
            ->add('stockQuantity', IntegerType::class, [
                'label' => 'Quantité en stock',
            ])
            ->add('discount', NumberType::class, [
                'label' => 'Remise (%)',
                'scale' => 2,
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'Catégorie',
                'choices' => [
                    'Électronique' => 'electronique',
                    'Mode' => 'vetements',
                    'Maison' => 'maison',
                    'Sport' => 'sport',
                ],
            ])
            ->add('rating', NumberType::class, [
                'label' => 'Note',
                'scale' => 1,
            ])
            ->add('numberOfReviews', IntegerType::class, [
                'label' => 'Nombre d\'avis',
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false,
            ])
            ->add('isFeatured', CheckboxType::class, [
                'label' => 'Produit en vedette',
                'required' => false,
            ])
            ->add('isNewArrival', CheckboxType::class, [
                'label' => 'Nouvelle arrivée',
                'required' => false,
            ])
            ->add('isOnPromotion', CheckboxType::class, [
                'label' => 'En promotion',
                'required' => false,
            ])
            ->add('promotionStartDate', DateType::class, [
                'label' => 'Date de début de la promotion',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('promotionEndDate', DateType::class, [
                'label' => 'Date de fin de la promotion',
                'widget' => 'single_text',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
