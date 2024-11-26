<?php

enum Spol
{
    case UNKNOWN;
    case MALE;
    case FEMALE;
}

/**
 * @template T as BackedEnum|UnitEnum
 * @param class-string<T> $enumClass
 * @param string $name
 * @return T|null
 */
function tryFromName(string $enumClass, string $name)
{
    $constName = $enumClass . '::' . $name;

    return is_subclass_of($enumClass, UnitEnum::class) && defined($constName)
        ? constant($constName)
        : null;
}

// enum(Spol::UNKNOWN)
var_dump(tryFromName(Spol::class, 'UNKNOWN'));

// enum(Spol::MALE)
var_dump(tryFromName(Spol::class, 'MALE'));

// enum(Spol::FEMALE)
var_dump(tryFromName(Spol::class, 'FEMALE'));

// NULL
var_dump(tryFromName(Spol::class, 'null'));
