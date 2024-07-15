<?php
namespace App\Models\Sanctum;

use Laravel\Sanctum\PersonalAccessToken;


class SanctumPersonalAccessToken extends PersonalAccessToken
{
    protected $table = 'personal_access_tokens';


    public function tokenable()
    {
        return $this->morphTo('tokenable');
    }

    public static function findToken($token)
    {

        if (empty($token)) {
            return null;
        }

        return static::where('token', hash('sha256', $token))->first();
    }
}
