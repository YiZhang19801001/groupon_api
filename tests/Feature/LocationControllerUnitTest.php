<?php

namespace Tests\Feature;

use App\Location;
use Tests\TestCase;

class LocationControllerUnitTest extends TestCase
{
    public function test_show_all_location_correctly()
    {
        // 'name', 'open', 'address', 'telephone'

        factory(Location::class)->create([
            'name' => 'shop 1',
            'address' => 'address 1',
            'telephone' => 'telephoe 1',
            'open' => json_encode(["2019-2-22", "2019-2-21"]),
        ]);
        factory(Location::class)->create([
            'name' => 'shop 2',
            'address' => 'address 2',
            'telephone' => 'telephoe 2',
            'open' => json_encode(["2019-2-23", "2019-2-19"]),
        ]);

        $response = $this->json('get', '/api/locations', [])
            ->assertStatus(200)
            ->assertJson([
                'locations' => [
                    [
                        'name' => 'shop 1',
                        'address' => 'address 1',
                        'telephone' => 'telephoe 1',
                        'open' => ['2019-2-22', '2019-2-21'],
                    ],
                    [
                        'name' => 'shop 2',
                        'address' => 'address 2',
                        'telephone' => 'telephoe 2',
                        'open' => ['2019-2-23', '2019-2-19'],
                    ],
                ],
            ]);

    }
    public function test_create_location_with_correct_input()
    {
        $payload = [
            'name' => 'shop 1',
            'address' => 'address 1',
            'telephone' => 'telephoe 1',
            'open' => ["2019-2-22", "2019-2-21"],
        ];

        $response = $this->json('post', '/api/locations', $payload)
            ->assertStatus(201)
            ->assertJson([
                'location' => [
                    'location_id' => 1,
                    'name' => 'shop 1',
                    'address' => 'address 1',
                    'telephone' => 'telephoe 1',
                    'open' => json_encode(["2019-2-22", "2019-2-21"]),
                ],
            ]);
    }
    public function test_create_location_fail_with_input_missing_properties()
    {
        $payload = [];
        $response = $this->json('post', '/api/locations', $payload)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'name' => ['The name field is required.'],
                    'address' => ['The address field is required.'],
                    'telephone' => ['The telephone field is required.'],
                ],
            ]);
    }
    public function test_create_location_fail_with_input_missing_open()
    {
        $payload = [
            'name' => 'shop 1',
            'address' => 'address 1',
            'telephone' => 'telephoe 1',
        ];

        $response = $this->json('post', '/api/locations', $payload)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'open' => ['The open is not valid.'],

                ],
            ]);

    }
    public function test_create_location_fail_with_input_incorrect_open_datatype()
    {
        $payload = [
            'name' => 'shop 1',
            'address' => 'address 1',
            'telephone' => 'telephoe 1',
            'open' => 'abc',
        ];

        $response = $this->json('post', '/api/locations', $payload)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'open' => ['The open is not valid.'],

                ],
            ]);
    }
}
