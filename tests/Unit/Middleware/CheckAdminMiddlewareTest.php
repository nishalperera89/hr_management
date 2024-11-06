<?php

namespace Tests\Middleware;

use App\Http\Middleware\AdminCheckMiddleware;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CheckAdminMiddlewareTest extends TestCase
{
    public function test_handle_allow_access_route_for_admin_user()
    {
        // A - Arrange
        $request = Request::create('api/test-user','GET');

        $adminUser = User::factory()->create([
            'role_as' => 1
        ]);

        Sanctum::actingAs($adminUser,['server:admin']);

        // A - Action
        $adminCheckMiddleware = new AdminCheckMiddleware();

        $response = $adminCheckMiddleware->handle($request, function () {
            return response()->json();
        });

        //dd($response->getContent());

        // A - Assertion
        $this->assertEquals(200, $response->getStatusCode());

    }

    public function test_return_bad_response_when_user_unauthorized()
    {
        // A - Arrange
        $request = Request::create('api/test-user','GET');

        $adminUser = User::factory()->create([
            'role_as' => 2
        ]);

        Sanctum::actingAs($adminUser,['server:manager']);

        // A - Action
        $adminCheckMiddleware = new AdminCheckMiddleware();

        $response = $adminCheckMiddleware->handle($request, function() {
            return response()->json();
        });

        // A - Assertion
        $this->assertJson($response->getContent());
        $this->assertSame('Unauthorized', json_decode($response->getContent(),TRUE)['message']);

    }

}
