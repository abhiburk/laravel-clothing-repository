<?php

namespace App\Enums;

class GenderEnums
{
    const MALE = "Male";
    const FEMALE = "Female";
    const UNISEX = "Unisex";

    public static function all(): array
    {
        return [
            self::MALE,
            self::FEMALE,
            self::UNISEX
        ];
    }
}
