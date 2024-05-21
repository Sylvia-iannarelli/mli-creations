<?php

namespace App\Form;

use App\Entity\MainColor;
use App\Entity\Material;
use App\Entity\Product;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ProductTypeEdit extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du produit',
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('photo', FileType::class, [
                'label' => 'Changer la photo',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Image(['maxSize' => '356k'])
                ],
                "help" => "* Taille maximum : 356 kB"
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix du produit TTC (en €)',
                'attr' => [
                    'placeholder' => 'Prix'
                ]
            ])
            ->add('type', EntityType::class, [
                "label" => "Type**",
                "class" => Type::class,
                "multiple" => false,
                "expanded" => true,
                "choice_label" => "name",
                "help" => "** une seule réponse possible"
            ])
            ->add('mainColor', EntityType::class, [
                "label" => "Couleur principale**",
                "class" => MainColor::class,
                "multiple" => false,
                "expanded" => true,
                "choice_label" => "name",
                "help" => "** une seule réponse possible"
            ])
            ->add('materials', EntityType::class, [
                "label" => "Matériaux***",
                "class" => Material::class,
                "multiple" => true,
                "expanded" => true,
                "choice_label" => "name",
                "help" => "*** plusieurs réponses possibles"
            ])
            ->add('delivery_time', TextType::class, [
                'label' => 'Délais de livraison approximatifs',
                'attr' => [
                    'placeholder' => 'Délais'
                ]
            ])
            ->add('available', CheckboxType::class, [
                'label' => 'Disponibilité',
                'required' => false
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    "Star nouvelle collection" => "star",
                    "Nouvelle collection" => "nouvelle-collection",
                    "Coups de cœur" => "coups-de-cœur"
                ],
                'expanded' => true,
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description",
                "attr" => [
                    "placeholder" => "Description détaillée du bijou"
                ],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
