<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_is_registered()
    {
        $data = [
            'name'=>'test',
            'email'=>'test@example.com',
            'password' => 'test',
        ];

        $response = $this->post('api/register',$data);
        $attibutes = $response->json()['data'];

        $this->assertEquals(
            ['name'=>'test', 'email'=>'test@example.com'],
            ['name'=>$attibutes['name'], 'email'=>$attibutes['email']],
        );
        $response->assertStatus(200);
        $this->assertDatabaseHas('users',[
            'name'=>'test',
            'email'=>'test@example.com',
            ]);

    }

    public function test_user_is_logged_in(){
        $UserData = [
            'email' => 'test@example.com',
            'password' => 'test',
        ];

        $user = User::factory()->create($UserData);

        $response = $this->post('api/login',$UserData);
        $this->assertEquals(true,Auth::check());
        $response->assertSee('token');
        $response->assertStatus(200);

    }
}
