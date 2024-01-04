<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Password\PasswordService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_the_dashboard()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard', ['user' => $user]));

        $response->assertOk();
    }

    public function test_user_can_update_profile()
    {   
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->patch(route('profile.update', ['user' => $user->id]), [
                'firstname' => 'Update first name',
                'lastname' => 'Update last name',
                'username' => 'Update username',
                'email' => 'update@example.com',
                'phone' => 'Update phone number',
                'address' => 'Update the email address',
                'postcode' => 'Update postcode',
            ]);
        
        $response->assertRedirect();
    }

    public function test_user_can_logout_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('logout');

        $this->assertGuest();
        $response->assertRedirect();
    }

    public function test_password_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('dashboard')
            ->patch('/password', [
                'old_password' => 'old_password',
                'new_password' => 'new_password',
                'new_password_confirmation' => 'new_password_confirmation',
            ]);

        $response
            ->assertRedirect();

        $this->assertTrue(! Hash::check('new_password', $user->refresh()->password));
    }
}