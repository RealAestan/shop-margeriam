<?php

declare(strict_types=1);

namespace App\Form\Type;

use BitBag\SyliusCmsPlugin\Form\Type\WysiwygType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CoursePageTranslationType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'sylius.form.course_page.name',
            ])
            ->add('slug', TextType::class, [
                'label' => 'sylius.form.course_page.slug',
            ])
            ->add('content', WysiwygType::class, [
                'label' => 'sylius.form.course_page.content',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_course_page_translation';
    }
}
