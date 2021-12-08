<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;

    protected $table = 'user';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'network',
        'identity',
        'login',
        'nickname',
        'photo_id',
        'role_id',
    ];

    protected $hidden = [
        'remember_token',
        'identity',
        'network'
    ];

    private static $current = null;

    public static function setCurrentByToken($token)
    {
        self::$current = User::query()
            ->where('remember_token', $token)
            ->first();
        return self::$current;
    }

    public static function getCurrent(): ?self
    {
        if (self::$current) {
            return self::$current;
        }
        return auth()->user();
    }

    public function secureUser()
    {
        $arr = $this->toArray(true);
        $arr['token'] = $this->remember_token;
        return $arr;
    }

    public function toArray($extend = false)
    {
        $arr = parent::toArray();
        $arr['photo_url'] = $this->photoUrl();
        if ($extend) {
            if ($this->user_id != self::getCurrent()->user_id) {
                $follower = Follower::query()
                    ->where('reader_id', self::getCurrent()->user_id)
                    ->where('readable_id', $this->user_id)
                    ->first();
                $arr['reading'] = boolval($follower);
            }

            $readableNumber = Follower::query()
                ->selectRaw('count(readable_id) as "count"')
                ->where('reader_id', $this->user_id)
                ->first()['count'];
            $readerNumber = Follower::query()
                ->selectRaw('count(reader_id) as "count"')
                ->where('readable_id', $this->user_id)
                ->first()['count'];
            $arr['statistics'] = compact('readerNumber', 'readableNumber');
        }
        return $arr;
    }

    public function photoUrl()
    {
        if ($this->photo_id) {
            return $this->photo->getUrl();
        }
        return '/img/avatar.jpg';
    }

    public function photo()
    {
        return $this->belongsTo('App\Models\Photo', 'photo_id', 'photo_id');
    }

    public function isAdmin()
    {
        return $this->role_id == self::ROLE_ADMIN;
    }
}
