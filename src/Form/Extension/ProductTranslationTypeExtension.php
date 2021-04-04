<?php

namespace App\Form\Extension;

use BitBag\SyliusCmsPlugin\Form\Type\WysiwygType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductTranslationType as BaseProductTranslationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProductTranslationTypeExtension extends AbstractResourceType
{
    private $urlGenerator;

    public function __construct(string $dataClass, array $validationGroups = [], UrlGeneratorInterface $urlGenerator)
    {
        parent::__construct($dataClass, $validationGroups);
        $this->urlGenerator = $urlGenerator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', WysiwygType::class, [
                'required' => false,
                'label' => 'sylius.form.product.description',
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

    public function getExtendedTypes(): iterable
    {
        return [BaseProductTranslationType::class];
    }
}
