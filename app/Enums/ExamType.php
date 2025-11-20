<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static NORMAL()
 * @method static static SCHEDULED()
 * @method static static RANDOM()
 */
final class ExamType extends Enum
{
    const NORMAL = 0;
    const SCHEDULED = 1;
    const RANDOM = 2;
}
