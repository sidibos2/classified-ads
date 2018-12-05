<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdTest extends TestCase
{
    public function testStoreAd()
    {
        $num = rand(1, 100000);
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'TkpJe8qr9hjbqPwCHi0n',
        ])->json('POST', '/api/ad',
            [
                'title' => 'Test title 9' . $num,
                'description' => 'test description',
                'price' => 4.55
            ]
        );
        $response->assertStatus(200);
    }

    public function testUpdateAd()
    {
        $num = rand(1, 1000000);
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'TkpJe8qr9hjbqPwCHi0n',
        ])->json('PUT', '/api/ad/3',
            [
                'title' => 'Test title 9' . $num,
                'description' => 'test description ' . $num,
                'price' => 4.55
            ]
        );
        $response->assertStatus(200);
    }

    public function testGetAdsList()
    {
        $response = $this->json('GET', '/api/list-ad');
        $response->assertStatus(200);
            //->assertJsonCount(3);
    }
}
