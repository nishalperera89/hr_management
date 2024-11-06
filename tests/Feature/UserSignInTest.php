<?php


use App\Acton\GetUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;



final class UserSignInTest extends TestCase
{
    use RefreshDatabase;
    public function test_admin_user_can_sign_into_the_system()
    {
        // A - Arrange
        $adminUser = User::factory()->create();

        $userLoginDetails = [
            'email' => $adminUser->email,
            'password' => '12345678' //$adminUser->password
        ];

        // A - Action (Act)
        $response = $this->post('api/user-sign-in',$userLoginDetails);

        // A - Assertion
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'userName',
            'userRole',
            'userToken'
        ]);
    }

    public function test_return_bad_response_when_credentials_are_invalid()
    {
        // A - Arrange
        $adminUser = User::factory()->create();

        $userLoginDetails = [
            'email' => $adminUser->email,
            'password' => '123456789' //$adminUser->password
        ];

        // A - Action (Act)
        $response = $this->post('api/user-sign-in',$userLoginDetails);

        // A - Assertion
        $response->assertStatus(200);
        $response->assertExactJson([
            'status' => Response::HTTP_UNAUTHORIZED,
            'message' => Response::$statusTexts[Response::HTTP_UNAUTHORIZED]
        ]);
    }

    public function test_if_not_existing_admin_user_should_want_to_bad_response() {

        // A - Arrange
        $adminLoginDetails = [
            'email' => 'test@gmail.com',
            'password' => '12345678'
        ];

        // A - Action (Act)
        $response = GetUser::execute($adminLoginDetails);

        // A - Assertion
        $this->assertEquals(['status' => Response::HTTP_NOT_FOUND],$response);
    }
}
