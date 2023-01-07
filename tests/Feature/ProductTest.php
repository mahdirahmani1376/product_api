<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void{
        parent::setUp();
        $this->seed();
        $this->user = $this->createUser();
        $this->admin = $this->createUser(true);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_product_is_created_successfully(){
        Storage::fake();

        $user = $this->admin;

        $fileName = 'test.jpg';
        $payload = [
            "brand" => "top" ,
            "width" => 13 ,
            "height" => 13 ,
            "depth" => 13 ,
            "category" => "test" ,
            "data" => [
                '0' => [
                    "language_id" => 1 ,
                    "name" => "tom" ,
                    "meta_title" => "tom" ,
                    "meta_description" => "tom" ,
                    "meta_keywords" => "tom" ,
                    "canonical" => "tom" ,
                    "description" => "tom" ,
                    "english_name" => "tom" ,
                ],
                '1' => [
                    "language_id" => 2 ,
                    "name" => "tom" ,
                    "meta_title" => "tom" ,
                    "meta_description" => "tom" ,
                    "meta_keywords" => "tom" ,
                    "canonical" => "tom" ,
                    "description" => "tom" ,
                    "english_name" => "tom" ,
                ],
                '2' => [
                    "language_id" => 3 ,
                    "name" => "tom" ,
                    "meta_title" => "tom" ,
                    "meta_description" => "tom" ,
                    "meta_keywords" => "tom" ,
                    "canonical" => "tom" ,
                    "description" => "tom" ,
                    "english_name" => "tom" ,
                ],
                '3' => [
                    "language_id" => 4 ,
                    "name" => "tom" ,
                    "meta_title" => "tom" ,
                    "meta_description" => "tom" ,
                    "meta_keywords" => "tom" ,
                    "canonical" => "tom" ,
                    "description" => "tom" ,
                    "english_name" => "tom" ,
                ],
                '4' => [
                    "language_id" => 5 ,
                    "name" => "tom" ,
                    "meta_title" => "tom" ,
                    "meta_description" => "tom" ,
                    "meta_keywords" => "tom" ,
                    "canonical" => "tom" ,
                    "description" => "tom" ,
                    "english_name" => "tom" ,
                ],
            ],
            "image_url" => UploadedFile::fake()->image($fileName),
        ];

        $response = $this->actingAs($user)->postJson('/api/product',$payload);
        $response->assertStatus(200);

        Storage::assertExists($fileName);

    }

    public function createUser(bool $is_admin=false){
        if($is_admin === true){
            return User::factory()->create()->assignRole('Super Admin');
        }
        else{
            return User::factory()->create();
        }

    }

}
