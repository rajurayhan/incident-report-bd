<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage user roles',
            
            // Incident permissions
            'view incidents',
            'create incidents',
            'edit incidents',
            'delete incidents',
            'verify incidents',
            'manage incident status',
            
            // Comment permissions
            'view comments',
            'create comments',
            'edit comments',
            'delete comments',
            'moderate comments',
            
            // Verification permissions
            'view verifications',
            'create verifications',
            'edit verifications',
            'delete verifications',
            
            // Media permissions
            'view media',
            'upload media',
            'delete media',
            'manage media',
            
            // Alert permissions
            'view alerts',
            'create alerts',
            'manage alerts',
            
            // Role & Permission management
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
            
            // Dashboard permissions
            'view dashboard',
            'view statistics',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $moderatorRole = Role::firstOrCreate(['name' => 'moderator']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign permissions to admin role (all permissions)
        $adminRole->syncPermissions(Permission::all());

        // Assign permissions to moderator role
        $moderatorPermissions = [
            'view users',
            'view incidents',
            'edit incidents',
            'verify incidents',
            'manage incident status',
            'view comments',
            'moderate comments',
            'view verifications',
            'create verifications',
            'view media',
            'view alerts',
            'view dashboard',
            'view statistics',
        ];
        $moderatorRole->syncPermissions($moderatorPermissions);

        // Assign permissions to user role
        $userPermissions = [
            'view incidents',
            'create incidents',
            'edit incidents',
            'view comments',
            'create comments',
            'view verifications',
            'create verifications',
            'view media',
            'upload media',
        ];
        $userRole->syncPermissions($userPermissions);

        // Create admin user
        $adminUser = User::firstOrCreate(
            [
                'email' => 'raju.rayhan@yandex.com', 
                'username' => 'admin'
            ],
            [
                'name' => 'Administrator',
                'password' => Hash::make('raju@2025'),
                'is_active' => true,
                'is_verified' => true,
                'role' => 'admin',
            ]
        );

        // Assign admin role to admin user
        if (!$adminUser->hasRole('admin')) {
            $adminUser->assignRole('admin');
        }

        // Create moderator user
        $moderatorUser = User::firstOrCreate(
            [
                'email' => 'moderator@incidentreportbd.com', 
                'username' => 'moderator'
            ],
            [
                'name' => 'Moderator',
                'username' => 'moderator',
                'password' => Hash::make('raju@2025'),
                'is_active' => true,
                'is_verified' => true,
                'role' => 'moderator',
            ]
        );

        // Assign moderator role to moderator user
        if (!$moderatorUser->hasRole('moderator')) {
            $moderatorUser->assignRole('moderator');
        }

        $this->command->info('Admin system seeded successfully!');
        $this->command->info('Admin credentials: admin@incidentreport.com / admin123');
        $this->command->info('Moderator credentials: moderator@incidentreport.com / moderator123');
    }
}
