<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static PLAIN()
 * @method static static BM5()
 */

final class SmsPassType extends Enum
{
    public const PLAIN = 0;
    public const BM5 = 1;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::PLAIN:
                return 'plain';
            case self::BM5:
                return 'bm5';
            default:
                return self::getKey($value);
        }
    }

}
