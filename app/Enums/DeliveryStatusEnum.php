<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static QUEUED()
 * @method static static SENT()
 * @method static static DELIVERED()
 * @method static static UNDELIVERED()
 * @method static static FAILED()
 */

final class DeliveryStatusEnum extends Enum
{
    public const QUEUED = 0;
    public const SENT = 1;
    public const DELIVERED = 2;
    public const UNDELIVERED = 3;
    public const FAILED = 4;
}
