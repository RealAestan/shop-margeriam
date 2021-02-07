<?php

declare(strict_types=1);

namespace App\Form\Type;

use BitBag\SyliusCmsPlugin\Form\Type\WysiwygType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CoursePageTranslationType extends AbstractResourceType
{
    private $urlGenerator;

    public function __construct(string $dataClass, array $validationGroups = [], UrlGeneratorInterface $urlGenerator)
    {
        parent::__construct($dataClass, $validationGroups);
        $this->urlGenerator = $urlGenerator;
    }

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
                'config' => [
                    'extraPlugins' => 'image2',
                    'image2_altRequired' => true,
                    'filebrowserUploadUrl' => $this->urlGenerator->generate('bitbag_sylius_cms_plugin_admin_upload_editor_image'),
//                    filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
//                    filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                ],
                'plugins' => [
                    'wordcount' => [
                        'path'     => '/bundles/fosckeditor/image2/', // with trailing slash
                        'filename' => 'plugin.js',
                    ],
                ],
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
