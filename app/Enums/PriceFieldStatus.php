<?php 
namespace App\Enums;

enum PriceFieldStatus:int {
    case show_details = 1;
    case competitive_price = 2;
    case available_upon_request = 3;
    case unavailable =4;
    case others = 5;
    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}