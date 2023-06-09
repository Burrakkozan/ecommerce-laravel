<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use JeffGreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser,MustVerifyEmail
{

    use HasApiTokens, HasFactory, Notifiable,HasRoles,TwoFactorAuthenticatable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
     protected $guarded = [];

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
    ];

    public static function generateUserName($username){
        if($username == null){
            $username = Str::lower(Str::random(8));
        }
        if(User::where('username',$username)->exists()){
            $username = Str::lower(Str::random(3));
        }
        return $username;
    }


    public function canAccessFilament(): bool
    {
        return $this->hasRole('Admin');
    }
    public function orders(){
        return $this->hasMany(Order::class,'user_id','id');
    }
   public function OrderItem(){
        return $this->hasMany(OrderItem::class,'user_id','id');
    }


}
