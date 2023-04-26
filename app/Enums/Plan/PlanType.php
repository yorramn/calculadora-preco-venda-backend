<?php declare(strict_types=1);

namespace App\Enums\Plan;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PlanType extends Enum
{
    const MONTHLY = 0;
    const ANNUALLY = 1;
}
