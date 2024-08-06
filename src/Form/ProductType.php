<?php
namespace App\Form;

use App\Entity\Product;
use Proxies\__CG__\App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

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
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'URL' => 'url',
                    'File' => 'file',
                ],
                'mapped' => false,
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('imageUrl', UrlType::class, [
                'label' => 'URL de l\'image',
                'required' => false,
                'constraints' => [
                    new Assert\Url(['groups' => ['url']])
                ],
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Fichier de l\'image',
                'required' => false,
                'constraints' => [
                    new Assert\File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ],
            ])
            ->add('sku', TextType::class, [
                'label' => 'SKU',
            ])
            ->add('stockQuantity', IntegerType::class, [
                'label' => 'Quantité en stock',
            ])
            ->add('discount', NumberType::class, [
                'label' => 'Remise ($)',
                'scale' => 2,
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Catégorie',
                'placeholder' => 'Choisissez une catégorie',
                'required' => false,
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
            'validation_groups' => function (FormInterface $form) {
                $data = $form->getData();
                if ($data->getImageUrl()) {
                    return ['Default', 'url'];
                } elseif ($data->getImageFile()) {
                    return ['Default', 'file'];
                }
                return ['Default'];
            },
        ]);
    }
}
