<?php

namespace Tests\Feature;

use App\Models\Audio;
use App\services\GoutteService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery;

class AudioControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function testNotFound()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }



    public function test_link_to_promo()
    {

        $response = $this->postJson('/api/promo2mp3', ['category' => 'not_exists']);

        $response->assertStatus(404);
    }

    public function test_is_promo_data_exists()
    {
//        $mock = Mockery::mock(GoutteService::class);
//        $mock->shouldReceive('get_category')->with('Funny')->andReturnNull();
//        app()->instance(GoutteService::class, $mock);
//
         $audio =  Audio::factory()->make();

        $response = $this->postJson('/api/promo2mp3', ['category' => 'Funny'])
            ->assertStatus(200)->assertJson([
                    'id'=>"5c234a567a97fdd4677b2408",
                    'mp3' =>"http://localhost/api/mp3/5c234a567a97fdd4677b2408.mp3"
                ]
            );



//        $response = $this->postJson('/api/promo2mp3', ['category' => 'Funny']);

//        $response->assertStatus(200);

    }



}
