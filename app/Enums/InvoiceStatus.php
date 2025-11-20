<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static UNPAID()
 * @method static static PAID()
 * @method static static OVERDUE()
 * @method static static PARTIALLY_PAID()
 */
final class InvoiceStatus extends Enum
{
    public const UNPAID = 0;
    public const PAID = 1;
    public const OVERDUE = 2;
    public const PARTIALLY_PAID = 3;
}
