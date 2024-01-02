<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * User Controller Test
     */
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
}