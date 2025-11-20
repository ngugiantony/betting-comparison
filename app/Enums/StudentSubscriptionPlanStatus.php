<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;


/**
 * @method static static INACTIVE()
 * @method static static ACTIVE()
 * @method static static SUSPENDED()
 */
final class StudentSubscriptionPlanStatus extends Enum
{
    public const EXPIRED = 0;
    public const ACTIVE = 1;
    public const INACTIVE = 2;
    public const CANCELLED = 3;
}