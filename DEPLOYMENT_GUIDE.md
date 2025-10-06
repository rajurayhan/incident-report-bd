# Deployment Guide - Incident Report Platform

This guide provides comprehensive instructions for deploying the Incident Report Platform to production environments.

## Table of Contents

1. [Server Requirements](#server-requirements)
2. [Pre-deployment Setup](#pre-deployment-setup)
3. [Environment Configuration](#environment-configuration)
4. [Database Setup](#database-setup)
5. [Application Deployment](#application-deployment)
6. [Web Server Configuration](#web-server-configuration)
7. [SSL Certificate Setup](#ssl-certificate-setup)
8. [Security Configuration](#security-configuration)
9. [Performance Optimization](#performance-optimization)
10. [Monitoring & Maintenance](#monitoring--maintenance)
11. [Troubleshooting](#troubleshooting)

## Server Requirements

### Minimum Requirements
- **OS**: Ubuntu 20.04+ / CentOS 8+ / Debian 11+
- **PHP**: 8.3 or higher
- **Memory**: 2GB RAM minimum, 4GB+ recommended
- **Storage**: 20GB SSD minimum
- **CPU**: 2 cores minimum

### Required Software Stack
- **Web Server**: Nginx 1.18+ or Apache 2.4+
- **PHP Extensions**: 
  - php8.3-fpm
  - php8.3-mysql
  - php8.3-xml
  - php8.3-curl
  - php8.3-zip
  - php8.3-gd
  - php8.3-mbstring
  - php8.3-bcmath
  - php8.3-tokenizer
  - php8.3-fileinfo
- **Database**: MySQL 8.0+ or PostgreSQL 13+
- **Node.js**: 18+ (for building assets)
- **Bun**: Latest version (package manager)
- **Composer**: Latest version

### Optional but Recommended
- **Redis**: For caching and sessions
- **Supervisor**: For queue management
- **Certbot**: For SSL certificates

## Pre-deployment Setup

### 1. Server Preparation

```bash
# Update system packages
sudo apt update && sudo apt upgrade -y

# Install essential packages
sudo apt install -y curl wget git unzip software-properties-common

# Add PHP repository
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Install PHP 8.3 and extensions
sudo apt install -y php8.3 php8.3-fpm php8.3-mysql php8.3-xml \
    php8.3-curl php8.3-zip php8.3-gd php8.3-mbstring \
    php8.3-bcmath php8.3-tokenizer php8.3-fileinfo php8.3-cli

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js 18+
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs

# Install Bun
curl -fsSL https://bun.sh/install | bash
source ~/.bashrc

# Install MySQL
sudo apt install -y mysql-server
sudo mysql_secure_installation

# Install Nginx
sudo apt install -y nginx

# Install Redis (optional)
sudo apt install -y redis-server

# Install Supervisor
sudo apt install -y supervisor
```

### 2. Create Application User

```bash
# Create dedicated user for the application
sudo adduser --system --group --home /var/www/incident-report incident-report
sudo usermod -a -G www-data incident-report

# Create application directory
sudo mkdir -p /var/www/incident-report
sudo chown incident-report:www-data /var/www/incident-report
```

## Environment Configuration

### 1. Create Production Environment File

Create `/var/www/incident-report/.env` with the following configuration:

```bash
# Application Configuration
APP_NAME="Incident Report Platform"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=incident_report_prod
DB_USERNAME=incident_report_user
DB_PASSWORD=your_secure_password

# Cache Configuration
CACHE_STORE=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Session Configuration
SESSION_DRIVER=redis
SESSION_LIFETIME=120

# Queue Configuration
QUEUE_CONNECTION=redis

# Mail Configuration (configure based on your provider)
MAIL_MAILER=smtp
MAIL_HOST=smtp.your-provider.com
MAIL_PORT=587
MAIL_USERNAME=your-email@yourdomain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Incident Report Platform"

# File Storage
FILESYSTEM_DISK=local

# Sanctum Configuration
SANCTUM_STATEFUL_DOMAINS=yourdomain.com,www.yourdomain.com

# Google Maps API (if using)
GOOGLE_MAPS_API_KEY=your_google_maps_api_key

# Additional Security
BCRYPT_ROUNDS=12
```

### 2. Generate Application Key

```bash
cd /var/www/incident-report
php artisan key:generate
```

## Database Setup

### 1. Create Database and User

```bash
# Login to MySQL
sudo mysql -u root -p

# Create database and user
CREATE DATABASE incident_report_prod CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'incident_report_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON incident_report_prod.* TO 'incident_report_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 2. Run Migrations

```bash
cd /var/www/incident-report
php artisan migrate --force
php artisan db:seed --class=IncidentSeeder
```

## Application Deployment

### 1. Clone and Setup Application

```bash
# Switch to application user
sudo su - incident-report

# Clone repository
cd /var/www/incident-report
git clone https://github.com/your-repo/incident-report.git .

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node.js dependencies
bun install

# Build frontend assets
bun run build

# Set proper permissions
sudo chown -R incident-report:www-data /var/www/incident-report
sudo chmod -R 755 /var/www/incident-report
sudo chmod -R 775 /var/www/incident-report/storage
sudo chmod -R 775 /var/www/incident-report/bootstrap/cache
```

### 2. Configure Laravel for Production

```bash
# Clear and cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link
php artisan storage:link

# Optimize autoloader
composer dump-autoload --optimize
```

## Web Server Configuration

### Nginx Configuration

Create `/etc/nginx/sites-available/incident-report`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/incident-report/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    # Handle Laravel routes
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP handling
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Security headers
    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Static assets caching
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # File upload size limit
    client_max_body_size 10M;
}
```

Enable the site:

```bash
sudo ln -s /etc/nginx/sites-available/incident-report /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### PHP-FPM Configuration

Edit `/etc/php/8.3/fpm/pool.d/www.conf`:

```ini
user = incident-report
group = www-data
listen = /var/run/php/php8.3-fpm.sock
listen.owner = www-data
listen.group = www-data
listen.mode = 0660

pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 35
pm.max_requests = 1000
```

Restart PHP-FPM:

```bash
sudo systemctl restart php8.3-fpm
```

## SSL Certificate Setup

### Using Certbot (Let's Encrypt)

```bash
# Install Certbot
sudo apt install -y certbot python3-certbot-nginx

# Obtain SSL certificate
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Test auto-renewal
sudo certbot renew --dry-run
```

## Security Configuration

### 1. Firewall Setup

```bash
# Enable UFW firewall
sudo ufw enable

# Allow necessary ports
sudo ufw allow 22/tcp    # SSH
sudo ufw allow 80/tcp   # HTTP
sudo ufw allow 443/tcp  # HTTPS

# Check status
sudo ufw status
```

### 2. File Permissions

```bash
# Set secure permissions
sudo chown -R incident-report:www-data /var/www/incident-report
sudo find /var/www/incident-report -type f -exec chmod 644 {} \;
sudo find /var/www/incident-report -type d -exec chmod 755 {} \;
sudo chmod -R 775 /var/www/incident-report/storage
sudo chmod -R 775 /var/www/incident-report/bootstrap/cache
```

### 3. Environment Security

```bash
# Secure .env file
sudo chmod 600 /var/www/incident-report/.env
sudo chown incident-report:incident-report /var/www/incident-report/.env
```

## Performance Optimization

### 1. Queue Worker Setup

Create `/etc/supervisor/conf.d/incident-report-worker.conf`:

```ini
[program:incident-report-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/incident-report/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=incident-report
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/incident-report/storage/logs/worker.log
stopwaitsecs=3600
```

Start the worker:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start incident-report-worker:*
```

### 2. Redis Configuration

Edit `/etc/redis/redis.conf`:

```ini
# Basic settings
bind 127.0.0.1
port 6379
timeout 300
tcp-keepalive 60

# Memory management
maxmemory 256mb
maxmemory-policy allkeys-lru

# Persistence
save 900 1
save 300 10
save 60 10000
```

Restart Redis:

```bash
sudo systemctl restart redis-server
```

### 3. PHP Optimization

Edit `/etc/php/8.3/fpm/php.ini`:

```ini
# Performance settings
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=2
opcache.fast_shutdown=1

# Upload settings
upload_max_filesize=10M
post_max_size=10M
max_execution_time=300
memory_limit=256M
```

Restart PHP-FPM:

```bash
sudo systemctl restart php8.3-fpm
```

## Monitoring & Maintenance

### 1. Log Monitoring

```bash
# Monitor Laravel logs
tail -f /var/www/incident-report/storage/logs/laravel.log

# Monitor Nginx logs
tail -f /var/log/nginx/access.log
tail -f /var/log/nginx/error.log

# Monitor PHP-FPM logs
tail -f /var/log/php8.3-fpm.log
```

### 2. Health Check Script

Create `/var/www/incident-report/health-check.sh`:

```bash
#!/bin/bash

# Check if application is responding
curl -f http://localhost/api/analytics/stats > /dev/null 2>&1
if [ $? -eq 0 ]; then
    echo "Application is healthy"
else
    echo "Application is not responding"
    # Add notification logic here
fi

# Check database connection
php /var/www/incident-report/artisan tinker --execute="DB::connection()->getPdo();" > /dev/null 2>&1
if [ $? -eq 0 ]; then
    echo "Database connection is healthy"
else
    echo "Database connection failed"
fi
```

Make it executable:

```bash
chmod +x /var/www/incident-report/health-check.sh
```

### 3. Automated Backup Script

Create `/var/www/incident-report/backup.sh`:

```bash
#!/bin/bash

BACKUP_DIR="/var/backups/incident-report"
DATE=$(date +%Y%m%d_%H%M%S)

# Create backup directory
mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u incident_report_user -p'your_password' incident_report_prod > $BACKUP_DIR/database_$DATE.sql

# Application files backup (excluding vendor and node_modules)
tar -czf $BACKUP_DIR/app_$DATE.tar.gz \
    --exclude='vendor' \
    --exclude='node_modules' \
    --exclude='storage/logs' \
    --exclude='storage/framework/cache' \
    --exclude='storage/framework/sessions' \
    --exclude='storage/framework/views' \
    /var/www/incident-report

# Keep only last 7 days of backups
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete

echo "Backup completed: $DATE"
```

### 4. Cron Jobs

Add to crontab (`crontab -e`):

```bash
# Health check every 5 minutes
*/5 * * * * /var/www/incident-report/health-check.sh

# Daily backup at 2 AM
0 2 * * * /var/www/incident-report/backup.sh

# Clear Laravel caches daily at 3 AM
0 3 * * * cd /var/www/incident-report && php artisan cache:clear && php artisan config:cache

# Log rotation
0 0 * * * find /var/www/incident-report/storage/logs -name "*.log" -mtime +30 -delete
```

## Troubleshooting

### Common Issues

1. **Permission Errors**
   ```bash
   sudo chown -R incident-report:www-data /var/www/incident-report
   sudo chmod -R 775 /var/www/incident-report/storage
   ```

2. **Database Connection Issues**
   ```bash
   # Check MySQL service
   sudo systemctl status mysql
   
   # Test connection
   mysql -u incident_report_user -p incident_report_prod
   ```

3. **Queue Workers Not Processing**
   ```bash
   # Check supervisor status
   sudo supervisorctl status
   
   # Restart workers
   sudo supervisorctl restart incident-report-worker:*
   ```

4. **Asset Loading Issues**
   ```bash
   # Rebuild assets
   cd /var/www/incident-report
   bun run build
   
   # Clear Laravel caches
   php artisan cache:clear
   php artisan config:cache
   ```

5. **SSL Certificate Issues**
   ```bash
   # Check certificate status
   sudo certbot certificates
   
   # Renew if needed
   sudo certbot renew
   ```

### Log Locations

- **Laravel Logs**: `/var/www/incident-report/storage/logs/laravel.log`
- **Nginx Access**: `/var/log/nginx/access.log`
- **Nginx Error**: `/var/log/nginx/error.log`
- **PHP-FPM Logs**: `/var/log/php8.3-fpm.log`
- **Queue Worker Logs**: `/var/www/incident-report/storage/logs/worker.log`

### Performance Monitoring

```bash
# Check system resources
htop
df -h
free -h

# Check PHP-FPM status
sudo systemctl status php8.3-fpm

# Check Nginx status
sudo systemctl status nginx

# Check Redis status
sudo systemctl status redis-server
```

## Deployment Checklist

- [ ] Server requirements met
- [ ] All software installed and configured
- [ ] Database created and migrated
- [ ] Environment variables configured
- [ ] Application deployed and built
- [ ] Web server configured
- [ ] SSL certificate installed
- [ ] Security measures implemented
- [ ] Queue workers running
- [ ] Monitoring setup
- [ ] Backup procedures in place
- [ ] Health checks working
- [ ] Performance optimized

## Support

For deployment issues or questions:
1. Check the troubleshooting section above
2. Review application logs
3. Verify all configurations
4. Contact the development team

---

**Note**: This guide assumes a standard Ubuntu/Debian server setup. Adjust commands and paths as needed for your specific environment.
