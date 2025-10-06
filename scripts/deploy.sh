#!/bin/bash

# Incident Report Platform - Automated Deployment Script
# This script automates the deployment process for production environments

set -e  # Exit on any error

# Configuration
APP_NAME="incident-report"
APP_DIR="/var/www/$APP_NAME"
APP_USER="incident-report"
REPO_URL="https://github.com/your-repo/incident-report.git"
BRANCH="main"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Logging function
log() {
    echo -e "${GREEN}[$(date +'%Y-%m-%d %H:%M:%S')]${NC} $1"
}

error() {
    echo -e "${RED}[ERROR]${NC} $1"
    exit 1
}

warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

# Check if running as root
if [[ $EUID -eq 0 ]]; then
   error "This script should not be run as root. Please run as a regular user with sudo privileges."
fi

# Check if required commands exist
check_requirements() {
    log "Checking system requirements..."
    
    local missing_deps=()
    
    if ! command -v php &> /dev/null; then
        missing_deps+=("php")
    fi
    
    if ! command -v composer &> /dev/null; then
        missing_deps+=("composer")
    fi
    
    if ! command -v node &> /dev/null; then
        missing_deps+=("node")
    fi
    
    if ! command -v bun &> /dev/null; then
        missing_deps+=("bun")
    fi
    
    if ! command -v mysql &> /dev/null; then
        missing_deps+=("mysql")
    fi
    
    if ! command -v nginx &> /dev/null; then
        missing_deps+=("nginx")
    fi
    
    if [ ${#missing_deps[@]} -ne 0 ]; then
        error "Missing dependencies: ${missing_deps[*]}. Please install them first."
    fi
    
    log "All requirements satisfied"
}

# Create application user and directory
setup_user_and_directory() {
    log "Setting up application user and directory..."
    
    # Create user if it doesn't exist
    if ! id "$APP_USER" &>/dev/null; then
        sudo adduser --system --group --home "$APP_DIR" "$APP_USER"
        sudo usermod -a -G www-data "$APP_USER"
        log "Created user: $APP_USER"
    else
        log "User $APP_USER already exists"
    fi
    
    # Create application directory
    if [ ! -d "$APP_DIR" ]; then
        sudo mkdir -p "$APP_DIR"
        sudo chown "$APP_USER:www-data" "$APP_DIR"
        log "Created application directory: $APP_DIR"
    else
        log "Application directory already exists"
    fi
}

# Clone or update repository
deploy_code() {
    log "Deploying application code..."
    
    if [ -d "$APP_DIR/.git" ]; then
        log "Updating existing repository..."
        sudo -u "$APP_USER" git -C "$APP_DIR" fetch origin
        sudo -u "$APP_USER" git -C "$APP_DIR" reset --hard "origin/$BRANCH"
    else
        log "Cloning repository..."
        sudo -u "$APP_USER" git clone -b "$BRANCH" "$REPO_URL" "$APP_DIR"
    fi
    
    log "Code deployment completed"
}

# Install dependencies
install_dependencies() {
    log "Installing PHP dependencies..."
    sudo -u "$APP_USER" composer install --no-dev --optimize-autoloader --working-dir="$APP_DIR"
    
    log "Installing Node.js dependencies..."
    sudo -u "$APP_USER" bun install --cwd="$APP_DIR"
    
    log "Dependencies installed successfully"
}

# Build frontend assets
build_assets() {
    log "Building frontend assets..."
    sudo -u "$APP_USER" bun run build --cwd="$APP_DIR"
    log "Frontend assets built successfully"
}

# Setup environment
setup_environment() {
    log "Setting up environment configuration..."
    
    if [ ! -f "$APP_DIR/.env" ]; then
        if [ -f "$APP_DIR/.env.example" ]; then
            sudo -u "$APP_USER" cp "$APP_DIR/.env.example" "$APP_DIR/.env"
            log "Created .env file from .env.example"
        else
            error ".env.example file not found. Please create it first."
        fi
    else
        log ".env file already exists"
    fi
    
    # Generate application key if not set
    if ! grep -q "APP_KEY=base64:" "$APP_DIR/.env"; then
        sudo -u "$APP_USER" php "$APP_DIR/artisan" key:generate
        log "Generated application key"
    fi
}

# Run database migrations
run_migrations() {
    log "Running database migrations..."
    sudo -u "$APP_USER" php "$APP_DIR/artisan" migrate --force
    log "Database migrations completed"
}

# Optimize Laravel
optimize_laravel() {
    log "Optimizing Laravel for production..."
    
    sudo -u "$APP_USER" php "$APP_DIR/artisan" config:cache
    sudo -u "$APP_USER" php "$APP_DIR/artisan" route:cache
    sudo -u "$APP_USER" php "$APP_DIR/artisan" view:cache
    
    # Create storage link
    sudo -u "$APP_USER" php "$APP_DIR/artisan" storage:link
    
    log "Laravel optimization completed"
}

# Set permissions
set_permissions() {
    log "Setting proper file permissions..."
    
    sudo chown -R "$APP_USER:www-data" "$APP_DIR"
    sudo find "$APP_DIR" -type f -exec chmod 644 {} \;
    sudo find "$APP_DIR" -type d -exec chmod 755 {} \;
    sudo chmod -R 775 "$APP_DIR/storage"
    sudo chmod -R 775 "$APP_DIR/bootstrap/cache"
    sudo chmod 600 "$APP_DIR/.env"
    
    log "File permissions set successfully"
}

# Restart services
restart_services() {
    log "Restarting services..."
    
    sudo systemctl restart php8.3-fpm
    sudo systemctl restart nginx
    
    # Restart queue workers if supervisor is configured
    if command -v supervisorctl &> /dev/null; then
        sudo supervisorctl restart "$APP_NAME-worker:*" || warning "Queue workers not configured"
    fi
    
    log "Services restarted successfully"
}

# Health check
health_check() {
    log "Performing health check..."
    
    # Wait a moment for services to start
    sleep 5
    
    # Check if application responds
    if curl -f -s "http://localhost/api/analytics/stats" > /dev/null; then
        log "Health check passed - Application is responding"
    else
        warning "Health check failed - Application may not be responding properly"
    fi
}

# Main deployment function
main() {
    log "Starting deployment of $APP_NAME..."
    
    check_requirements
    setup_user_and_directory
    deploy_code
    install_dependencies
    build_assets
    setup_environment
    run_migrations
    optimize_laravel
    set_permissions
    restart_services
    health_check
    
    log "Deployment completed successfully!"
    log "Application is available at: $(grep APP_URL "$APP_DIR/.env" | cut -d '=' -f2)"
}

# Run main function
main "$@"
