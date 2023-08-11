<?php

namespace App\Helpers;

class Helpers
{
    public static function getMonthFullName(string $month): string
    {
        return match (substr($month, 0, 3)) {
            'Jan', '1' => 'Janeiro',
            'Feb', 'Fev', '2' => 'Fevereiro',
            'Mar', '3' => 'Marco',
            'Apr', 'Abr', '4' => 'Abril',
            'May', 'Mai', '5' => 'Maio',
            'Jun', '6' => 'Junho',
            'Jul', '7' => 'Julho',
            'Aug', 'Ago', '8' => 'Agosto',
            'Sep', 'Set', '9' => 'Setembro',
            'Oct', 'Out', '10' => 'Outubro',
            'Nov', '11' => 'Novembro',
            'Dec', 'Dez', '12' => 'Dezembro'
        };
    }

    public static function getMonthDigits(string $month): string
    {
        return match (substr($month, 0, 3)) {
            'Jan' => 1,
            'Feb', 'Fev' => 2,
            'Mar' => 3,
            'Apr', 'Abr' => 4,
            'May', 'Mai' => 5,
            'Jun' => 6,
            'Jul' => 7,
            'Aug', 'Ago' => 8,
            'Sep', 'Set' => 9,
            'Oct', 'Out' => 10,
            'Nov' => 11,
            'Dec', 'Dez' => 12
        };
    }
}
