<?php

namespace App\Enums;

enum SupplierType: string
{
    case DISTRIBUTOR = 'distributor';

    case WHOLESALER = 'Pengecer';

    case PRODUCER = 'Produsen';

    public function label(): string
    {
        return match ($this) {
            self::DISTRIBUTOR => __('Distributor'),
            self::WHOLESALER => __('Pengecer'),
            self::PRODUCER => __('Produsen'),
        };
    }
}
