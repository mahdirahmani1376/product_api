<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_is_registered()
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users',$user->toArray());

    }

    public function test_user_is_logged_in(){
        $user = User::factory()->create();
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ];

        $response = $this->actingAs($user)->post('api/login',$data);
        dd($response);
        $this->assertTrue(Auth::check());
        $response->assertStatus(200);
        $this->assertDatabaseHas('personal_access_tokens',['tokenable_id'=>$user->id,'name'=>'access']);

    }
}
