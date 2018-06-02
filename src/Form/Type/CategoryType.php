<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adv_category', EntityType::class, array(
                'class'       => 'App\Entity\CategoryEntity',
                'placeholder' => '',
            ))
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();

                // this would be your entity
                $data = $event->getData();
                \dump($event); die();

                $category = $data->getAdvCategory();
                $subcategory = null === $category ? array() : $category->getSubcategory();

                $form->add('subcategory', EntityType::class, array(
                    'class' => 'App\Entity\SubcategoryEntity',
                    'placeholder' => '',
                    'choices' => $subcategory,
                ));
            }
        );
    }

    // ...
}