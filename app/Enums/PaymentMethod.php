<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static MPESA()
 * @method static static CREDIT_CARD()
 * @method static static DEBIT_CARD()
 * @method static static BANK_TRANSFER()
 * @method static static CASH()
 *
 */
final class PaymentMethod extends Enum
{
    public const MPESA = 1;
    public const CREDIT_CARD = 2;
    public const DEBIT_CARD = 3;
    public const BANK_TRANSFER = 4;
    public const CASH = 5;
}
