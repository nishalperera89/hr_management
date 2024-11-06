<?php

namespace App\Acton;

use App\Models\User;

class AuthenticationUserTokenGenerate
{
    public static function generate(User $user): string
    {
        $roleMapping = [
            1 => ['token_name' => 'admin', 'ability' => ['server:admin']],
            2 => ['token_name' => 'manager', 'ability' => ['server:manager']],
            3 => ['token_name' => 'user', 'ability' => ['server:user']],
        ];

        if (isset($roleMapping[$user->role_as])) {
            $tokenData = $roleMapping[$user->role_as];
            return $user->createToken($tokenData['token_name'],$tokenData['ability'])->plainTextToken;
        }

        return '';
    }
}
