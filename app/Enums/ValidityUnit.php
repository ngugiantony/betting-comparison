<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static DAY()
 * @method static static WEEK()
 * @method static static MONTH()
 */
final class ValidityUnit extends Enum
{
    public const DAY = 0;
    public const WEEK = 1;
    public const MONTH = 2;
}
