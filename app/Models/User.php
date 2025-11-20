<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\CentyOtpVerified;
use App\Jobs\SendUserOtp;

class User extends Authenticatable
{
    use HasUuids, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'role',
        'email',
        'phone_number',
        'centy_plus_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_verified_at' => 'datetime',
        'password' => 'hashed',
        'centy_plus_otp_verified' => CentyOtpVerified::class
    ];

    
    public static function boot()
    {
        parent::boot();

        self::creating(function ($user) {
            if ($user->role === 'parent') {
                $user->centy_plus_id = 'CNT' . '-' . $user->phone_number;
            } elseif ($user->role === 'teacher') {
                $user->centy_plus_id = self::generateTeacherSequence();
            }
        });
    }

    protected static function generateTeacherSequence()
    {
        // Retrieve the last student/teacher
        $lastUser = static::where('role', 'teacher')->latest('id')->first();

        if ($lastUser) {
            $sequence = intval(substr($lastUser->centy_plus_id, -7)) + 1; // Extract sequence and increment
        } else {
            $sequence = 1;
        }

        return str_pad($sequence, 7, '0', STR_PAD_LEFT);
    }


    protected static function generateStudentSequence($guardian_id, $guardian_phone_number)
    {
        //Get count of all students that belong to parent.
        $students_count = Student::where('guardian_id', $guardian_id)->count();
        return $students_count.'-'.$guardian_phone_number;

    }

    public function needsOTPVerification(){
        if ($this->centy_plus_otp_verified->value === CentyOtpVerified::INACTIVE){
           $this->centy_plus_otp = rand(1000, 9999);
           $this->save();

           // Send OTP to user's phone number
           dispatch(new SendUserOtp($this));

           return true;
        } elseif ($this->centy_plus_otp_verified->value === CentyOtpVerified::SENT) {
            return true;
        }

        return false;
    }

    public function isOTPValid($otp){
        return $this->centy_plus_otp === $otp && $this->centy_plus_otp_verified->value === CentyOtpVerified::SENT;
    }

//newsite
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function getActiveSubscription()
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->with('plan')
            ->first();
    }
}
