<?php

namespace App\Models;

use App\Enums\DeliveryStatusEnum;
use App\Enums\SmsPassType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasUuids,HasFactory;

    protected $fillable = [
        "external_ref",
        "recipient",
        "text",
        "short_code",
        "pass_type",
        "status_description",
    ];

    protected $casts = [
        'pass_type' => SmsPassType::class,
        'delivery_status' => DeliveryStatusEnum::class,
    ];
}
