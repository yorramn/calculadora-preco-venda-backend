<?php declare(strict_types=1);

namespace App\Enums\Payment;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ProductTypePaymentEnum extends Enum
{
    const PHYSICAL = 0;
    const DIGITAL = 1;
    const SERVICE = 2;
}
