<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Incident;
use App\Models\User;
use Faker\Factory as Faker;

class IncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Get a user to assign as reporter
        $user = User::first();
        if (!$user) {
            // Create a default user if none exists
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Bangladesh coordinates (approximate bounds)
        $bangladeshBounds = [
            'north' => 26.6,
            'south' => 20.7,
            'east' => 92.7,
            'west' => 88.0
        ];

        // Major cities in Bangladesh with their approximate coordinates
        $cities = [
            ['name' => 'Dhaka', 'lat' => 23.8103, 'lng' => 90.4125],
            ['name' => 'Chittagong', 'lat' => 22.3569, 'lng' => 91.7832],
            ['name' => 'Sylhet', 'lat' => 24.8949, 'lng' => 91.8687],
            ['name' => 'Rajshahi', 'lat' => 24.3745, 'lng' => 88.6042],
            ['name' => 'Khulna', 'lat' => 22.8088, 'lng' => 89.2467],
            ['name' => 'Barisal', 'lat' => 22.7010, 'lng' => 90.3535],
            ['name' => 'Rangpur', 'lat' => 25.7439, 'lng' => 89.2752],
            ['name' => 'Mymensingh', 'lat' => 24.7471, 'lng' => 90.4203],
            ['name' => 'Comilla', 'lat' => 23.4607, 'lng' => 91.1809],
            ['name' => 'Narayanganj', 'lat' => 23.6228, 'lng' => 90.4997],
        ];

        $categories = [
            'theft_robbery',
            'sexual_harassment',
            'domestic_violence',
            'suspicious_activities',
            'traffic_accidents',
            'drugs',
            'cybercrime'
        ];

        $statuses = ['pending', 'in_progress', 'resolved'];
        $priorities = ['low', 'medium', 'high', 'urgent'];

        $incidents = [];

        for ($i = 0; $i < 800; $i++) {
            // Choose a random city or generate random coordinates within Bangladesh
            if ($faker->boolean(70)) { // 70% chance to be near a major city
                $city = $faker->randomElement($cities);
                $lat = $faker->latitude($city['lat'] - 0.1, $city['lat'] + 0.1);
                $lng = $faker->longitude($city['lng'] - 0.1, $city['lng'] + 0.1);
            } else { // 30% chance to be random within Bangladesh
                $lat = $faker->latitude($bangladeshBounds['south'], $bangladeshBounds['north']);
                $lng = $faker->longitude($bangladeshBounds['west'], $bangladeshBounds['east']);
            }

            // Create some clusters for better heat map visualization
            if ($faker->boolean(20)) { // 20% chance to create a cluster
                $clusterLat = $faker->latitude($bangladeshBounds['south'], $bangladeshBounds['north']);
                $clusterLng = $faker->longitude($bangladeshBounds['west'], $bangladeshBounds['east']);
                
                // Generate 3-8 incidents in the same cluster
                $clusterSize = $faker->numberBetween(3, 8);
                for ($j = 0; $j < $clusterSize && $i < 200; $j++) {
                    $incidents[] = [
                        'id' => $faker->uuid(),
                        'title' => $faker->sentence(3),
                        'description' => $faker->paragraph(2),
                        'category' => $faker->randomElement($categories),
                        'status' => $faker->randomElement($statuses),
                        'priority' => $faker->randomElement($priorities),
                        'latitude' => $faker->latitude($clusterLat - 0.05, $clusterLat + 0.05),
                        'longitude' => $faker->longitude($clusterLng - 0.05, $clusterLng + 0.05),
                        'address' => $faker->address(),
                        'city' => $faker->city(),
                        'district' => $faker->city(),
                        'division' => $faker->randomElement(['Dhaka', 'Chittagong', 'Sylhet', 'Rajshahi', 'Khulna', 'Barisal', 'Rangpur', 'Mymensingh']),
                        'incident_date' => $faker->dateTimeBetween('-6 months', 'now'),
                        'is_verified' => $faker->boolean(30), // 30% verified
                        'is_anonymous' => $faker->boolean(20), // 20% anonymous
                        'user_id' => $user->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $i++;
                }
                $i--; // Adjust counter since we added multiple incidents
            } else {
                $incidents[] = [
                    'id' => $faker->uuid(),
                    'title' => $faker->sentence(3),
                    'description' => $faker->paragraph(2),
                    'category' => $faker->randomElement($categories),
                    'status' => $faker->randomElement($statuses),
                    'priority' => $faker->randomElement($priorities),
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'address' => $faker->address(),
                    'city' => $faker->city(),
                    'district' => $faker->city(),
                    'division' => $faker->randomElement(['Dhaka', 'Chittagong', 'Sylhet', 'Rajshahi', 'Khulna', 'Barisal', 'Rangpur', 'Mymensingh']),
                    'incident_date' => $faker->dateTimeBetween('-6 months', 'now'),
                    'is_verified' => $faker->boolean(30), // 30% verified
                    'is_anonymous' => $faker->boolean(20), // 20% anonymous
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert all incidents
        Incident::insert($incidents);

        $this->command->info('Created 200 fake incidents for heat map visualization!');
    }
}