<?php

namespace Tests\Unit;

use App\User;
use App\Ad;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdTest extends TestCase
{
    const TOKEN = 'TkpJe8qr9hjbqPwCHi0n';

    public $user;
    public $adId;

    public function setUp()
    {
        parent::setUp();
        $this->user = User::where('api_token', self::TOKEN)->first();
    }

    public function testUserExists()
    {
        $this->assertEquals(self::TOKEN, $this->user->api_token);
    }

    public function testStoreAd()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => self::TOKEN,
        ])->json('POST', '/api/ad',
            [
                'title' => 'Test title 1',
                'description' => 'test description',
                'price' => 4.55
            ]
        );
        $response->assertStatus(200);
    }

    public function testUserHasOnAd()
    {
        $userAd = Ad::where('user_id', $this->user->id)->first()->toArray();
        $this->assertNotEmpty($userAd);
    }

    public function testStoreAdWithWrongToken()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Wrong Token',
        ])->json('POST', '/api/ad',
            [
                'title' => 'Test title 1',
                'description' => 'test description',
                'price' => 4.55
            ]
        );
        $response->assertStatus(400);
    }

    public function testUpdateAd()
    {
        $ad = new Ad;
        $ad->user_id = $this->user->id;
        $ad->title = 'This is a test 1';
        $ad->description = 'This is a description';
        $ad->price = 4.55;
        $ad->save();

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => self::TOKEN,
        ])->json('PUT', '/api/ad/' . $ad->id,
            [
                'title' => 'Test title 1 - updated',
                'description' => 'test description ',
                'price' => 4.55
            ]
        );
        $response->assertStatus(200)
            ->assertJson(['response' => 'Ad updated']);
    }

    public function testGetAdsList()
    {
        $response = $this->json('GET', '/api/list-ad');
        $response->assertStatus(200);
    }

    public function testCleanupTable()
    {
        Ad::where('user_id', 1)->delete();
        $this->assertTrue(true);
    }
}
