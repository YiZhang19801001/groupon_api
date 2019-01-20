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
}
