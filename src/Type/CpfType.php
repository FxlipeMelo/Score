<?php

namespace App\Type;

use App\ValueObject\Cpf;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * My custom datatype
 */
class CpfType extends Type
{

    public function getName(): string
    {
        return 'cpf_type';
    }
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Cpf
    {
        if ($value !== null) {
            return new Cpf($value);
        }

        return null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->__toString();

    }
}
