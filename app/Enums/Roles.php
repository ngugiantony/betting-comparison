<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static ADMIN()
 * @method static static TEACHER()
 * @method static static PARENT()
 */
final class Roles extends Enum
{
    public const ADMIN = 0;
    public const TEACHER = 1;
    public const PARENT = 2;
}
