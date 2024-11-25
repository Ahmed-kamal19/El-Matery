<?php 
namespace App\Enums;

enum FeatureOrPossibility:int
{
        case posibility = 1;
        case feature =2;
        public static function values(): array
        {
            return array_column(self::cases(), 'name', 'value');
        }
}