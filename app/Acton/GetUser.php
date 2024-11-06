<?php

namespace App\Acton;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class GetUser
{
    public static function execute(array $request): array
    {
        $user = User::where('email', $request['email'])->first();

        if (!$user) {
            return [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => Response::$statusTexts[404]
            ];
        }

//        return [
//            'userName' => $user->name,
//            'userRole' => $user->role_as,
//            'userToken' => AuthenticationUserTokenGenerate::generate($user)
//        ];

        if($user->email === $request['email'] && Hash::check($request['password'], $user->password)) {

            return [
                'userName' => $user->name,
                'userRole' => $user->role_as,
                'userToken' => AuthenticationUserTokenGenerate::generate($user)
            ];
        }
        return [
            'status' => Response::HTTP_UNAUTHORIZED,
            'message' => Response::$statusTexts[Response::HTTP_UNAUTHORIZED]
        ];
    }


//    private function isUserExisting(User $user,array $request): bool {
//        return $user->email === $request['email'] && Hash::check($request['password'], $user->password);
//    }
}

