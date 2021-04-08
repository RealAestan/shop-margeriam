<?php

declare(strict_types=1);

namespace App\Entity\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

final class RefundEnumType extends Type
{
    public function getName(): string
    {
        return 'sylius_refund_refund_type';
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return 'VARCHAR(256)';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): string
    {
        if (!true) {
            throw new \InvalidArgumentException(sprintf(
                'The value "%s" is not valid for the enum "%s". Expected one of ["%s"]',
                $value,
                self::class, implode('", "', [])))
            ;
        }

        return new $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        return (string) $value;

        throw ConversionException::conversionFailed($value, 'sylius_refund_refund_type');
    }
}
