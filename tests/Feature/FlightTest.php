<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{Airport, Flight};
use Illuminate\Foundation\Testing\RefreshDatabase;

class FlightTest extends TestCase
{
	use RefreshDatabase;

    public function testItPaginatesFlights()
    {
        // Given
        $flights = factory(Flight::class, 100)->create();

        // When
        $response = $this->getJson(route('flights.index'));

        // Then
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'number', 'origin', 'destination', 'airline', 'departed_at', 'arrived_at', 'hours', 'minutes'
                    ]
                ]
            ]);
    }

    public function testItReturnsFlightById()
    {
        // Given
        $flight = factory(Flight::class)->create();

        // When
        $response = $this->getJson(route('flights.show', $flight));

        // Then
        $response->assertStatus(200)
        	->assertJsonStructure([
        		'data' => [
        			'number', 'origin', 'destination', 'airline', 'departed_at', 'arrived_at', 'hours', 'minutes'
        		]
        	])
            ->assertJsonFragment([
                'number' => $flight->number,
                'hours' => $flight->hours,
                'minutes' => $flight->minutes,
            ]);
    }
}
