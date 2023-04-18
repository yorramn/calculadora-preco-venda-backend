<?php declare(strict_types=1);

namespace App\Enums\Quotes;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class QuoteStatusEnum extends Enum
{
    const REPROVED = 0;
    const APPROVED = 1;
    const ANALYSIS = 2;
}
