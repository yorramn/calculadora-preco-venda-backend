<?php declare(strict_types=1);

namespace App\Enums\Product;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ProductStatusEnum extends Enum
{
    const UNAVALIABLE = 0;
    const AVALIABLE = 1;
}
