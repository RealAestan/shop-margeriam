<?php

namespace App\Form\Extension;

use BitBag\SyliusCmsPlugin\Form\Type\WysiwygType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductTranslationType as BaseProductTranslationType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProductTranslationTypeExtension extends AbstractTypeExtension
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->remove('description')
            ->add('description', WysiwygType::class, [
                'required' => false,
                'label' => 'sylius.form.product.description',
                'config' => [
                    'extraPlugins' => 'image2',
                    'image2_altRequired' => true,
                    'filebrowserUploadUrl' => $this->urlGenerator->generate('bitbag_sylius_cms_plugin_admin_upload_editor_image'),
                ],
                'plugins' => [
                    'wordcount' => [
                        'path'     => '/bundles/fosckeditor/image2/', // with trailing slash
                        'filename' => 'plugin.js',
                    ],
                ],
            ])
            ->remove('shortDescription')
            ->add('shortDescription', WysiwygType::class, [
                'required' => false,
                'label' => 'sylius.form.product.short_description',
                'config' => [
                    'extraPlugins' => 'image2',
                    'image2_altRequired' => true,
                    'filebrowserUploadUrl' => $this->urlGenerator->generate('bitbag_sylius_cms_plugin_admin_upload_editor_image'),
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

    public static function getExtendedTypes(): iterable
    {
        return [BaseProductTranslationType::class];
    }
}
