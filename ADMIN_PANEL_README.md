# Admin Panel - Incident Report System

A complete admin panel for the incident reporting platform with role-based access control using Spatie Laravel Permission.

## Features

### 🔐 Authentication & Authorization
- **Role-based Access Control (RBAC)** using Spatie Laravel Permission
- **Three User Roles**: Admin, Moderator, User
- **Granular Permissions** for all system operations
- **Secure Admin Login** with dedicated login page

### 📊 Dashboard
- **Real-time Statistics**: Users, incidents, comments, verifications
- **Visual Charts**: Incidents by category and status
- **Recent Activity**: Latest incidents and user registrations
- **Quick Actions**: Direct links to management sections

### 👥 User Management
- **Complete CRUD Operations**: Create, read, update, delete users
- **Role Assignment**: Assign and manage user roles
- **Status Management**: Activate/deactivate users
- **Advanced Filtering**: Search by name, email, username, role, status
- **Bulk Actions**: Toggle user status, assign roles

### 🚨 Incident Management
- **Full Incident Control**: View, edit, delete incidents
- **Status Management**: Pending, In Progress, Resolved
- **Verification System**: Mark incidents as verified/unverified
- **Priority Levels**: Low, Medium, High, Urgent
- **Category Filtering**: Filter by incident categories
- **Advanced Search**: Search by title, description, address

### 💬 Content Moderation
- **Comment Management**: View, moderate, delete comments
- **Verification Management**: Manage incident verifications
- **Media Management**: Handle uploaded images and files
- **Alert Management**: Manage user alerts and notifications

### 🛡️ System Administration
- **Role Management**: Create, edit, delete roles
- **Permission Management**: Granular permission control
- **Role-Permission Assignment**: Assign permissions to roles
- **User-Role Assignment**: Assign roles to users

## Installation & Setup

### 1. Install Dependencies
```bash
composer require spatie/laravel-permission
```

### 2. Run Migrations
```bash
php artisan migrate
```

### 3. Seed Admin Data
```bash
php artisan db:seed --class=AdminSeeder
```

### 4. Access Admin Panel
Navigate to `/admin/login` and use the following credentials:

**Admin Account:**
- Email: `raju.rayhan@yandex`
- Password: `raju@2025`

**Moderator Account:**
- Email: `moderator@incidentreportbd.com`
- Password: `raju@2025`

## Admin Panel Structure

```
/admin/
├── /login                 # Admin login page
├── /                      # Dashboard
├── /users                 # User management
├── /incidents             # Incident management
├── /comments              # Comment moderation
├── /verifications         # Verification management
├── /media                 # Media management
├── /alerts                # Alert management
├── /roles                 # Role management
└── /permissions           # Permission management
```

## Permissions System

### Admin Role
- Full access to all features
- Can manage users, incidents, comments, verifications
- Can create/edit/delete roles and permissions
- Can access all statistics and reports

### Moderator Role
- Can view and edit incidents
- Can verify/unverify incidents
- Can moderate comments
- Can view users and basic statistics
- Cannot manage roles or permissions

### User Role
- Can view incidents
- Can create incidents
- Can comment on incidents
- Can verify incidents
- Can upload media

## Key Features

### 🎨 Clean & Modern UI
- **Tailwind CSS** for responsive design
- **Font Awesome** icons for better UX
- **Minimal Design** focused on functionality
- **Mobile Responsive** layout

### ⚡ Real-time Updates
- **AJAX Operations** for quick status updates
- **Live Data Refresh** without page reload
- **Instant Feedback** for user actions

### 🔍 Advanced Filtering
- **Multi-criteria Search** across all entities
- **Date Range Filtering** for incidents
- **Status-based Filtering** for all content
- **Role-based Filtering** for users

### 📱 Responsive Design
- **Mobile-first** approach
- **Tablet Optimized** layouts
- **Desktop Enhanced** features
- **Cross-browser** compatibility

## Security Features

- **CSRF Protection** on all forms
- **Role-based Middleware** protection
- **Permission Checks** on all actions
- **Secure File Uploads** with validation
- **Input Sanitization** and validation

## Customization

### Adding New Permissions
1. Add permission to `AdminSeeder.php`
2. Assign to appropriate roles
3. Update controllers to check permissions
4. Add UI elements based on permissions

### Adding New Roles
1. Create role in `AdminSeeder.php`
2. Define permissions for the role
3. Update middleware if needed
4. Add role-specific UI elements

### Customizing Views
- All views are in `resources/views/admin/`
- Layout is in `resources/views/admin/layouts/app.blade.php`
- Use Tailwind CSS classes for styling
- Follow the existing design patterns

## API Integration

The admin panel is designed to work alongside the existing API endpoints. All admin operations respect the same data models and business logic as the main application.

## Support

For issues or questions about the admin panel:
1. Check the Laravel logs in `storage/logs/`
2. Verify database migrations are up to date
3. Ensure all permissions are properly seeded
4. Check middleware configuration

## Contributing

When adding new features to the admin panel:
1. Follow the existing code structure
2. Add appropriate permissions
3. Update the navigation if needed
4. Test with different user roles
5. Ensure mobile responsiveness
