<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace App\Form\Extension;

use Sylius\Bundle\CoreBundle\Form\Type\Checkout\CompleteType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;

final class CompleteTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isTrue = new IsTrue();
        $isTrue->message = 'You should agree to our terms';
        $builder
            ->remove('notes')
            ->add('cgv', CheckboxType::class, [
                'required' => true,
                'label' => 'sylius.form.complete.cgv',
                'mapped' => false,
                'constraints' => [
                    $isTrue,
                ],
            ])
        ;
    }

    public static function getExtendedTypes(): array
    {
        return [CompleteType::class];
    }
}
