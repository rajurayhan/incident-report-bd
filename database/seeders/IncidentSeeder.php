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
        // Try to use Bengali locale, fallback to English if intl extension is not available
        try {
            $faker = Faker::create('bn_BD'); // Use Bengali locale for Bangladesh context
        } catch (\Exception $e) {
            // Fallback to English locale if intl extension is not available
            $faker = Faker::create('en_US');
            $this->command->warn('Bengali locale not available, using English locale instead. Consider installing intl PHP extension for better localization.');
        }
        
        // Get a user to assign as reporter
        $user = User::first();
        if (!$user) {
            // Create a default user if none exists
            $user = User::create([
                'name' => 'Raju Rayhan',
                'email' => 'raju.rayhan@yandex.com',
                'password' => bcrypt('raju@2025'),
            ]);
        }

        // Bangladesh coordinates (approximate bounds)
        $bangladeshBounds = [
            'north' => 26.6,
            'south' => 20.7,
            'east' => 92.7,
            'west' => 88.0
        ];

        // Major cities in Bangladesh with their coordinates and administrative details
        $bangladeshLocations = [
            // Dhaka Division
            ['name' => 'Dhaka', 'lat' => 23.8103, 'lng' => 90.4125, 'division' => 'Dhaka', 'district' => 'Dhaka', 'thana' => 'Dhanmondi'],
            ['name' => 'Narayanganj', 'lat' => 23.6228, 'lng' => 90.4997, 'division' => 'Dhaka', 'district' => 'Narayanganj', 'thana' => 'Narayanganj Sadar'],
            ['name' => 'Gazipur', 'lat' => 23.9999, 'lng' => 90.4203, 'division' => 'Dhaka', 'district' => 'Gazipur', 'thana' => 'Gazipur Sadar'],
            ['name' => 'Tangail', 'lat' => 24.2513, 'lng' => 89.9167, 'division' => 'Dhaka', 'district' => 'Tangail', 'thana' => 'Tangail Sadar'],
            
            // Chittagong Division
            ['name' => 'Chittagong', 'lat' => 22.3569, 'lng' => 91.7832, 'division' => 'Chittagong', 'district' => 'Chittagong', 'thana' => 'Kotwali'],
            ['name' => 'Cox\'s Bazar', 'lat' => 21.4272, 'lng' => 91.9758, 'division' => 'Chittagong', 'district' => 'Cox\'s Bazar', 'thana' => 'Cox\'s Bazar Sadar'],
            ['name' => 'Comilla', 'lat' => 23.4607, 'lng' => 91.1809, 'division' => 'Chittagong', 'district' => 'Comilla', 'thana' => 'Comilla Sadar'],
            ['name' => 'Feni', 'lat' => 23.0144, 'lng' => 91.3966, 'division' => 'Chittagong', 'district' => 'Feni', 'thana' => 'Feni Sadar'],
            
            // Sylhet Division
            ['name' => 'Sylhet', 'lat' => 24.8949, 'lng' => 91.8687, 'division' => 'Sylhet', 'district' => 'Sylhet', 'thana' => 'Sylhet Sadar'],
            ['name' => 'Moulvibazar', 'lat' => 24.4827, 'lng' => 91.7774, 'division' => 'Sylhet', 'district' => 'Moulvibazar', 'thana' => 'Moulvibazar Sadar'],
            
            // Rajshahi Division
            ['name' => 'Rajshahi', 'lat' => 24.3745, 'lng' => 88.6042, 'division' => 'Rajshahi', 'district' => 'Rajshahi', 'thana' => 'Rajshahi Sadar'],
            ['name' => 'Bogra', 'lat' => 24.8482, 'lng' => 89.3711, 'division' => 'Rajshahi', 'district' => 'Bogra', 'thana' => 'Bogra Sadar'],
            ['name' => 'Pabna', 'lat' => 24.0064, 'lng' => 89.2372, 'division' => 'Rajshahi', 'district' => 'Pabna', 'thana' => 'Pabna Sadar'],
            
            // Khulna Division
            ['name' => 'Khulna', 'lat' => 22.8088, 'lng' => 89.2467, 'division' => 'Khulna', 'district' => 'Khulna', 'thana' => 'Khulna Sadar'],
            ['name' => 'Jessore', 'lat' => 23.1697, 'lng' => 89.2137, 'division' => 'Khulna', 'district' => 'Jessore', 'thana' => 'Jessore Sadar'],
            ['name' => 'Satkhira', 'lat' => 22.7183, 'lng' => 89.0705, 'division' => 'Khulna', 'district' => 'Satkhira', 'thana' => 'Satkhira Sadar'],
            
            // Barisal Division
            ['name' => 'Barisal', 'lat' => 22.7010, 'lng' => 90.3535, 'division' => 'Barisal', 'district' => 'Barisal', 'thana' => 'Barisal Sadar'],
            ['name' => 'Pirojpur', 'lat' => 22.5792, 'lng' => 89.9750, 'division' => 'Barisal', 'district' => 'Pirojpur', 'thana' => 'Pirojpur Sadar'],
            
            // Rangpur Division
            ['name' => 'Rangpur', 'lat' => 25.7439, 'lng' => 89.2752, 'division' => 'Rangpur', 'district' => 'Rangpur', 'thana' => 'Rangpur Sadar'],
            ['name' => 'Dinajpur', 'lat' => 25.6279, 'lng' => 88.6331, 'division' => 'Rangpur', 'district' => 'Dinajpur', 'thana' => 'Dinajpur Sadar'],
            
            // Mymensingh Division
            ['name' => 'Mymensingh', 'lat' => 24.7471, 'lng' => 90.4203, 'division' => 'Mymensingh', 'district' => 'Mymensingh', 'thana' => 'Mymensingh Sadar'],
            ['name' => 'Netrokona', 'lat' => 24.8833, 'lng' => 90.7167, 'division' => 'Mymensingh', 'district' => 'Netrokona', 'thana' => 'Netrokona Sadar'],
        ];

        // Bangladesh-specific incident categories with realistic descriptions
        $incidentTemplates = [
            'theft_robbery' => [
                'titles' => [
                    'Mobile phone snatched near market area',
                    'Motorcycle theft reported in residential area',
                    'Bag snatching incident at bus stand',
                    'House burglary in neighborhood',
                    'Pickpocketing at crowded market',
                    'Bike theft from parking area',
                    'Jewelry shop robbery attempt',
                    'ATM card fraud incident'
                ],
                'descriptions' => [
                    'A mobile phone was snatched from a pedestrian near the local market. The incident happened during evening hours when the area was crowded.',
                    'Motorcycle was stolen from outside a residential building. The bike was parked and locked but still got stolen.',
                    'A woman\'s handbag was snatched while she was waiting at the bus stand. The perpetrator fled on a motorcycle.',
                    'Burglary attempt was made at a house in the neighborhood. Some valuables were stolen while residents were away.',
                    'Pickpocketing incident occurred at the crowded market area. The victim lost wallet and cash.',
                    'Bicycle was stolen from the parking area near the shopping complex.',
                    'Attempted robbery at a jewelry shop. The shopkeeper managed to alert neighbors and the robbers fled.',
                    'ATM card fraud incident reported. Someone tried to withdraw money using a stolen card.'
                ]
            ],
            'sexual_harassment' => [
                'titles' => [
                    'Eve teasing incident near school',
                    'Inappropriate behavior on public transport',
                    'Street harassment reported',
                    'Workplace harassment complaint',
                    'Online harassment case',
                    'Unwanted advances at workplace',
                    'Catcalling incident on street',
                    'Harassment at educational institution'
                ],
                'descriptions' => [
                    'Eve teasing incident reported near a school area. Students were harassed by unknown persons.',
                    'Inappropriate behavior was reported on a public bus. A passenger made inappropriate comments.',
                    'Street harassment incident reported where a woman was followed and harassed.',
                    'Workplace harassment complaint filed by an employee against a colleague.',
                    'Online harassment case reported through social media platforms.',
                    'Unwanted advances were made at workplace by a senior colleague.',
                    'Catcalling incident occurred on a busy street during evening hours.',
                    'Harassment incident reported at an educational institution involving students.'
                ]
            ],
            'domestic_violence' => [
                'titles' => [
                    'Domestic violence incident reported',
                    'Family dispute turned violent',
                    'Spousal abuse case',
                    'Child abuse incident',
                    'Elder abuse reported',
                    'Domestic conflict escalated',
                    'Family violence incident',
                    'Domestic dispute with physical harm'
                ],
                'descriptions' => [
                    'Domestic violence incident was reported by a neighbor. Loud arguments and physical altercation were heard.',
                    'Family dispute escalated into physical violence. Police were called to intervene.',
                    'Spousal abuse case reported where one partner was physically harmed by the other.',
                    'Child abuse incident was reported by concerned neighbors who heard crying and shouting.',
                    'Elder abuse was reported where an elderly family member was being mistreated.',
                    'Domestic conflict escalated into physical violence requiring medical attention.',
                    'Family violence incident reported involving multiple family members.',
                    'Domestic dispute resulted in physical harm to one of the parties involved.'
                ]
            ],
            'suspicious_activities' => [
                'titles' => [
                    'Suspicious persons loitering in area',
                    'Unknown vehicle parked for long time',
                    'Suspicious activity near school',
                    'Drug dealing suspected in neighborhood',
                    'Suspicious gathering reported',
                    'Unknown persons asking personal questions',
                    'Suspicious behavior at public place',
                    'Unusual activity in residential area'
                ],
                'descriptions' => [
                    'Suspicious persons were seen loitering in the residential area for extended periods.',
                    'An unknown vehicle has been parked in the same spot for several days without explanation.',
                    'Suspicious activity was reported near a school where unknown persons were observing children.',
                    'Drug dealing activity is suspected in the neighborhood based on frequent suspicious meetings.',
                    'A suspicious gathering was reported where unknown persons were meeting regularly.',
                    'Unknown persons were asking personal questions about residents in the area.',
                    'Suspicious behavior was observed at a public place where someone was acting strangely.',
                    'Unusual activity was reported in the residential area that doesn\'t match normal patterns.'
                ]
            ],
            'traffic_accidents' => [
                'titles' => [
                    'Road accident involving motorcycle',
                    'Car collision at intersection',
                    'Pedestrian hit by vehicle',
                    'Bus accident on highway',
                    'CNG accident in city area',
                    'Truck collision on main road',
                    'Bicycle accident reported',
                    'Multi-vehicle collision'
                ],
                'descriptions' => [
                    'Road accident involving a motorcycle and a car. The motorcyclist sustained injuries.',
                    'Car collision occurred at a busy intersection during peak hours.',
                    'A pedestrian was hit by a speeding vehicle while crossing the road.',
                    'Bus accident occurred on the highway causing multiple injuries.',
                    'CNG (auto-rickshaw) accident happened in the city area involving another vehicle.',
                    'Truck collision occurred on the main road causing traffic disruption.',
                    'Bicycle accident was reported where a cyclist was injured.',
                    'Multi-vehicle collision occurred causing significant damage and injuries.'
                ]
            ],
            'drugs' => [
                'titles' => [
                    'Drug dealing activity reported',
                    'Substance abuse in public place',
                    'Drug paraphernalia found',
                    'Suspected drug manufacturing',
                    'Drug use in residential area',
                    'Illegal substance distribution',
                    'Drug-related gathering reported',
                    'Substance abuse at educational institution'
                ],
                'descriptions' => [
                    'Drug dealing activity was reported in the neighborhood. Suspicious transactions were observed.',
                    'Substance abuse was reported in a public place where individuals were using illegal drugs.',
                    'Drug paraphernalia was found abandoned in a public area.',
                    'Suspected drug manufacturing activity was reported in a residential building.',
                    'Drug use was reported in a residential area affecting the community.',
                    'Illegal substance distribution was observed in the neighborhood.',
                    'Drug-related gathering was reported where illegal substances were being used.',
                    'Substance abuse incident was reported at an educational institution involving students.'
                ]
            ],
            'cybercrime' => [
                'titles' => [
                    'Online fraud case reported',
                    'Social media account hacked',
                    'Phishing attempt detected',
                    'Online harassment through social media',
                    'Financial fraud via mobile banking',
                    'Identity theft incident',
                    'Online scam targeting elderly',
                    'Cyberbullying case reported'
                ],
                'descriptions' => [
                    'Online fraud case was reported where someone lost money through a fake online transaction.',
                    'Social media account was hacked and used to send malicious messages to contacts.',
                    'Phishing attempt was detected where fake emails were sent to steal personal information.',
                    'Online harassment was reported through social media platforms.',
                    'Financial fraud occurred through mobile banking where unauthorized transactions were made.',
                    'Identity theft incident was reported where personal information was misused.',
                    'Online scam targeted elderly individuals through fake investment schemes.',
                    'Cyberbullying case was reported involving harassment through digital platforms.'
                ]
            ]
        ];

        $statuses = ['pending', 'in_progress', 'resolved'];
        $priorities = ['low', 'medium', 'high', 'urgent'];


        $incidents = [];

        for ($i = 0; $i < 200; $i++) {
            // Choose a random location
            $location = $faker->randomElement($bangladeshLocations);
            
            // Add some randomness to coordinates
            $lat = $faker->latitude($location['lat'] - 0.05, $location['lat'] + 0.05);
            $lng = $faker->longitude($location['lng'] - 0.05, $location['lng'] + 0.05);
            
            // Choose a random category
            $category = $faker->randomElement(array_keys($incidentTemplates));
            $template = $incidentTemplates[$category];
            
            // Generate realistic incident data
            $title = $faker->randomElement($template['titles']);
            $description = $faker->randomElement($template['descriptions']);
            
            // Generate Bangladesh-specific metadata
            $metadata = [
                'weather' => $faker->randomElement(['sunny', 'rainy', 'cloudy', 'foggy']),
                'time_of_day' => $faker->randomElement(['morning', 'afternoon', 'evening', 'night']),
                'day_of_week' => $faker->dayOfWeek(),
                'season' => $faker->randomElement(['summer', 'monsoon', 'winter', 'spring']),
                'area_type' => $faker->randomElement(['residential', 'commercial', 'educational', 'transport', 'public']),
                'crowd_density' => $faker->randomElement(['low', 'medium', 'high']),
                'lighting_condition' => $faker->randomElement(['good', 'poor', 'dark'])
            ];

            // Generate Bangladesh-specific address
            $address = $this->generateBangladeshiAddress($location, $faker);
            

                $incidents[] = [
                    'id' => $faker->uuid(),
                'title' => $title,
                'description' => $description,
                'category' => $category,
                    'status' => $faker->randomElement($statuses),
                    'priority' => $faker->randomElement($priorities),
                    'latitude' => $lat,
                    'longitude' => $lng,
                'address' => $address,
                'city' => $location['name'],
                'district' => $location['district'],
                'division' => $location['division'],
                    'incident_date' => $faker->dateTimeBetween('-6 months', 'now'),
                'is_verified' => $faker->boolean(35), // 35% verified
                'verification_count' => $faker->numberBetween(0, 15),
                'dispute_count' => $faker->numberBetween(0, 5),
                'metadata' => json_encode($metadata),
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
        }

        // Insert all incidents
        Incident::insert($incidents);

        $this->command->info('Created 200 Bangladesh context incidents with realistic data!');
    }

    /**
     * Generate Bangladesh-specific address
     */
    private function generateBangladeshiAddress($location, $faker)
    {
        $streetNumbers = ['House #' . $faker->numberBetween(1, 999), 'Flat #' . $faker->numberBetween(1, 50)];
        $streetNames = [
            'Road', 'Street', 'Lane', 'Avenue', 'Boulevard', 'Gali', 'Moholla', 'Para'
        ];
        
        // Use a simple name generator that works without intl extension
        $simpleNames = ['Main', 'Central', 'New', 'Old', 'East', 'West', 'North', 'South', 'Green', 'Blue'];
        $streetName = $faker->randomElement($streetNumbers) . ', ' . 
                     $faker->randomElement($simpleNames) . ' ' . $faker->randomElement($streetNames) . ', ' . 
                     $location['name'] . ', ' . $location['district'];
        
        return $streetName;
    }

}