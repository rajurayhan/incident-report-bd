# Incident Report Platform - Bangladesh

A community-driven incident reporting platform designed specifically for Bangladesh, allowing citizens to report, verify, and receive alerts about various incidents including theft, sexual harassment, domestic violence, suspicious activities, traffic accidents, drugs, and cybercrime.

## Features

### MVP Features (Phase 1)
- **Incident Reporting**: Users can report incidents with detailed descriptions, categories, media uploads, and location data
- **Anonymous Reporting**: Option to report incidents anonymously for safety
- **Community Verification**: Users can verify or dispute reported incidents
- **Commenting System**: Community members can add comments and context to incidents
- **Location-based Alerts**: Users receive notifications about incidents in their area
- **Admin Dashboard**: Administrators can manage incidents and view analytics
- **Analytics Dashboard**: Public analytics showing incident trends and density maps

### Future Features (Phase 2)
- **Premium Features**: Advanced notifications, verified reports, AI assistant
- **Organization Access**: Analytics and API integration for NGOs and businesses
- **Authority Integration**: Direct integration with Bangladesh Police and local authorities
- **Mobile Apps**: Native iOS and Android applications
- **Multi-language Support**: Bengali language support

## Technology Stack

- **Backend**: Laravel 12 (PHP 8.3+)
- **Frontend**: Vue.js 3 with Composition API
- **Database**: MySQL (SQLite for development)
- **Authentication**: Laravel Sanctum
- **Package Manager**: Bun (instead of npm)
- **Styling**: Tailwind CSS
- **Maps**: Google Maps API / OpenStreetMap
- **State Management**: Pinia
- **Routing**: Vue Router 4

## Installation

### Prerequisites
- PHP 8.3 or higher
- Composer
- Node.js 18+ and Bun
- MySQL or SQLite

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd incident-report
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   bun install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   php artisan migrate
   ```

6. **Build frontend assets**
   ```bash
   bun run build
   ```

7. **Start development servers**
   ```bash
   # Terminal 1 - Laravel server
   php artisan serve
   
   # Terminal 2 - Vite dev server
   bun run dev
   ```

## Project Structure

```
incident-report/
├── app/
│   ├── Http/Controllers/Api/     # API controllers
│   ├── Models/                  # Eloquent models
│   └── Http/Middleware/         # Custom middleware
├── database/
│   ├── migrations/              # Database migrations
│   └── database.sqlite         # SQLite database (dev)
├── resources/
│   ├── js/
│   │   ├── components/          # Vue components
│   │   ├── stores/              # Pinia stores
│   │   └── app.js               # Main Vue app
│   └── views/
│       └── welcome.blade.php   # Main layout
├── routes/
│   ├── api.php                  # API routes
│   └── web.php                  # Web routes
└── public/
    └── build/                   # Compiled assets
```

## API Endpoints

### Public Endpoints
- `GET /api/incidents` - List incidents
- `GET /api/incidents/{id}` - Get incident details
- `GET /api/analytics/stats` - Get public statistics
- `POST /api/register` - User registration
- `POST /api/login` - User login

### Protected Endpoints (Requires Authentication)
- `POST /api/incidents` - Create incident
- `PUT /api/incidents/{id}` - Update incident
- `DELETE /api/incidents/{id}` - Delete incident
- `POST /api/incidents/{id}/comments` - Add comment
- `POST /api/incidents/{id}/verifications` - Add verification
- `POST /api/incidents/{id}/media` - Upload media

### Admin Endpoints (Requires Admin Role)
- `GET /api/admin/incidents` - Admin incident list
- `PUT /api/admin/incidents/{id}/status` - Update incident status
- `GET /api/admin/analytics` - Admin analytics

## Database Schema

### Core Tables
- `users` - User accounts with extended fields for location and preferences
- `incidents` - Main incident reports with location and metadata
- `incident_comments` - Community comments on incidents
- `incident_verifications` - User verifications/disputes
- `incident_media` - Uploaded photos/videos
- `user_alerts` - Notification tracking

### Key Features
- **Geospatial Support**: Latitude/longitude fields with spatial indexing
- **Anonymous Support**: Optional anonymous reporting with separate fields
- **Media Management**: File upload handling with moderation support
- **Verification System**: Community-driven verification with scoring

## Development Guidelines

### Code Style
- Follow PSR-12 coding standards for PHP
- Use Vue 3 Composition API for components
- Implement proper error handling and validation
- Write comprehensive API documentation

### Security Considerations
- All user inputs are validated and sanitized
- File uploads are restricted by type and size
- Sensitive data is encrypted
- Anonymous reporting protects user privacy
- Role-based access control for admin functions

### Performance Optimization
- Database queries are optimized with proper indexing
- Images are compressed and resized
- API responses are paginated
- Frontend assets are minified and cached

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support and questions, please contact the development team or create an issue in the repository.

## Roadmap

### Phase 1 (Current)
- [x] Basic incident reporting
- [x] User authentication
- [x] Community features
- [x] Admin dashboard
- [ ] Google Maps integration
- [ ] SMS notifications

### Phase 2 (Future)
- [ ] Mobile applications
- [ ] Premium features
- [ ] Organization access
- [ ] Authority integration
- [ ] Bengali language support
- [ ] AI-powered features

---

**Built with ❤️ for Bangladesh**