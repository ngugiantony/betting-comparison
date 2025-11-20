<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static INACTIVE()
 * @method static static SENT()
 * @method static static VERIFIED()
 */

final class CentyOtpVerified extends Enum
{
    public const INACTIVE = 0;
    public const SENT = 1;
    public const VERIFIED = 2;

}
