<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderTypesEnum extends Enum
{
    const LOWER = 'lower';
    const HIGHER = 'higher';
}
