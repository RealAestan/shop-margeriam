<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Course\Course;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class CourseType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, [
                'required' => true,
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'entry_type' => CourseTranslationType::class,
            ])
            ->add('pages', CollectionType::class, [
                'entry_type' => CoursePageType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
        ;

        $builder->addEventListener(FormEvents::SUBMIT, array($this, 'savePages'));
    }

    public function savePages(FormEvent $event)
    {
        /** @var Course $course */
        $course = $event->getData();
        foreach ($course->getPages() as $page) {
            $page->setCourse($course);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_course';
    }
}
