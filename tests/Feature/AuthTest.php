<?php

namespace Tests\Feature;

use App\Jobs\UserRegisterJob;
use App\Mail\UserVerificationEmail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
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

        $response = $this->postJson('api/register',$data);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json
                ->where('data.name', $data['name'])
                ->where('data.email', $data['email'])
                ->missing('data.password')
                ->etc()
            );

        $response->assertStatus(200);
        $this->assertDatabaseHas('users',[
            'name'=>'test',
            'email'=>'test@example.com',
            ]);

    }

    public function test_user_is_logged_in(){
        $UserData = [
            'name'=>'test',
            'email'=>'test@example.com',
            'password' => 'test',
        ];

        $this->post('api/register',$UserData);
        $response = $this->post('api/login',$UserData);
        $this->assertEquals(true,Auth::check());

        $response->assertJson(fn(AssertableJson $json)=>
        $json
            ->has('data.access_token')
            ->has('data.token_type')
            ->has('data.expires_in')
            ->etc()
        );

        $response->assertStatus(200);

    }

    public function test_email_verification_is_sent_after_register(){
        Bus::fake();

        $UserData = [
            'email'     => 'test@example.com',
            'name'      => 'test',
            'password'  => 'test',
        ];

        $response = $this->post('api/register',$UserData);
        Bus::assertDispatched(UserRegisterJob::class);
    }

    public function test_user_register_job(){
        Mail::fake();
        $user = User::factory()->create();
        $token = Str::random(120);
        $job = new UserRegisterJob($user,$token);
        $job->handle();
        Mail::assertSent(UserVerificationEmail::class);
    }

    public function test_user_is_verified_after_email_verification(){
        $UserData = [
            'email'     => 'test@example.com',
            'name'      => 'test',
            'password'  => 'test',
        ];

        $this->post('api/register',$UserData);

        $user = User::where('email',$UserData['email'])->first();
        $this->actingAs($user)->get("api/email/verify/$user->email_verified_token");

        $this->assertNotNull($user->email_verified_at);
    }


}
