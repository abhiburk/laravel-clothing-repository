<?php

namespace App\Enums;

class ClothingSizeEnums
{
    const SMALL = "Small";
    const MEDIUM = "Medium";
    const LARGE = "Large";

    public static function all(): array
    {
        return [
            self::SMALL,
            self::MEDIUM,
            self::LARGE
        ];
    }
}
