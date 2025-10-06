#!/bin/bash

# Incident Report Platform - Server Setup Script
# This script sets up a fresh Ubuntu server for the Incident Report Platform

set -e  # Exit on any error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Logging functions
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

info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

# Check if running as root
if [[ $EUID -ne 0 ]]; then
   error "This script must be run as root (use sudo)"
fi

# Update system packages
update_system() {
    log "Updating system packages..."
    apt update && apt upgrade -y
    apt install -y curl wget git unzip software-properties-common apt-transport-https ca-certificates gnupg lsb-release
    log "System packages updated"
}

# Install PHP 8.3
install_php() {
    log "Installing PHP 8.3 and extensions..."
    
    # Add PHP repository
    add-apt-repository ppa:ondrej/php -y
    apt update
    
    # Install PHP and extensions
    apt install -y php8.3 php8.3-fpm php8.3-mysql php8.3-xml \
        php8.3-curl php8.3-zip php8.3-gd php8.3-mbstring \
        php8.3-bcmath php8.3-tokenizer php8.3-fileinfo php8.3-cli \
        php8.3-redis php8.3-opcache
    
    # Configure PHP-FPM
    sed -i 's/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/' /etc/php/8.3/fpm/php.ini
    sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 10M/' /etc/php/8.3/fpm/php.ini
    sed -i 's/post_max_size = 8M/post_max_size = 10M/' /etc/php/8.3/fpm/php.ini
    sed -i 's/memory_limit = 128M/memory_limit = 256M/' /etc/php/8.3/fpm/php.ini
    
    # Enable OPcache
    cat >> /etc/php/8.3/fpm/conf.d/10-opcache.ini << EOF
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
EOF
    
    systemctl enable php8.3-fpm
    systemctl start php8.3-fpm
    
    log "PHP 8.3 installed and configured"
}

# Install Composer
install_composer() {
    log "Installing Composer..."
    
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
    chmod +x /usr/local/bin/composer
    
    log "Composer installed"
}

# Install Node.js and Bun
install_nodejs() {
    log "Installing Node.js 18..."
    
    curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
    apt install -y nodejs
    
    log "Installing Bun..."
    curl -fsSL https://bun.sh/install | bash
    source /root/.bashrc
    
    log "Node.js and Bun installed"
}

# Install MySQL
install_mysql() {
    log "Installing MySQL..."
    
    apt install -y mysql-server
    
    # Secure MySQL installation
    mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'root_password_change_me';"
    mysql -e "DELETE FROM mysql.user WHERE User='';"
    mysql -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
    mysql -e "DROP DATABASE IF EXISTS test;"
    mysql -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';"
    mysql -e "FLUSH PRIVILEGES;"
    
    systemctl enable mysql
    systemctl start mysql
    
    log "MySQL installed and secured"
}

# Install Nginx
install_nginx() {
    log "Installing Nginx..."
    
    apt install -y nginx
    
    # Remove default site
    rm -f /etc/nginx/sites-enabled/default
    
    systemctl enable nginx
    systemctl start nginx
    
    log "Nginx installed"
}

# Install Redis
install_redis() {
    log "Installing Redis..."
    
    apt install -y redis-server
    
    # Configure Redis
    sed -i 's/supervised no/supervised systemd/' /etc/redis/redis.conf
    sed -i 's/# maxmemory <bytes>/maxmemory 256mb/' /etc/redis/redis.conf
    sed -i 's/# maxmemory-policy noeviction/maxmemory-policy allkeys-lru/' /etc/redis/redis.conf
    
    systemctl enable redis-server
    systemctl start redis-server
    
    log "Redis installed and configured"
}

# Install Supervisor
install_supervisor() {
    log "Installing Supervisor..."
    
    apt install -y supervisor
    
    systemctl enable supervisor
    systemctl start supervisor
    
    log "Supervisor installed"
}

# Install Certbot
install_certbot() {
    log "Installing Certbot..."
    
    apt install -y certbot python3-certbot-nginx
    
    log "Certbot installed"
}

# Configure firewall
configure_firewall() {
    log "Configuring firewall..."
    
    ufw --force enable
    ufw allow 22/tcp
    ufw allow 80/tcp
    ufw allow 443/tcp
    
    log "Firewall configured"
}

# Create application user
create_app_user() {
    log "Creating application user..."
    
    adduser --system --group --home /var/www/incident-report incident-report
    usermod -a -G www-data incident-report
    
    mkdir -p /var/www/incident-report
    chown incident-report:www-data /var/www/incident-report
    
    log "Application user created"
}

# Setup log rotation
setup_log_rotation() {
    log "Setting up log rotation..."
    
    cat > /etc/logrotate.d/incident-report << EOF
/var/www/incident-report/storage/logs/*.log {
    daily
    missingok
    rotate 30
    compress
    delaycompress
    notifempty
    create 644 incident-report www-data
    postrotate
        systemctl reload php8.3-fpm
    endscript
}
EOF
    
    log "Log rotation configured"
}

# Create backup directory
create_backup_directory() {
    log "Creating backup directory..."
    
    mkdir -p /var/backups/incident-report
    chown incident-report:incident-report /var/backups/incident-report
    
    log "Backup directory created"
}

# Display next steps
display_next_steps() {
    log "Server setup completed successfully!"
    echo
    info "Next steps:"
    echo "1. Update MySQL root password: mysql -u root -p"
    echo "2. Create database and user for the application"
    echo "3. Clone your application repository"
    echo "4. Run the deployment script: ./scripts/deploy.sh"
    echo "5. Configure your domain and SSL certificate"
    echo
    info "Important files created:"
    echo "- Application user: incident-report"
    echo "- Application directory: /var/www/incident-report"
    echo "- Backup directory: /var/backups/incident-report"
    echo
    warning "Don't forget to:"
    echo "- Change MySQL root password"
    echo "- Configure your domain in Nginx"
    echo "- Set up SSL certificate with Certbot"
    echo "- Configure environment variables"
}

# Main setup function
main() {
    log "Starting server setup for Incident Report Platform..."
    
    update_system
    install_php
    install_composer
    install_nodejs
    install_mysql
    install_nginx
    install_redis
    install_supervisor
    install_certbot
    configure_firewall
    create_app_user
    setup_log_rotation
    create_backup_directory
    display_next_steps
    
    log "Server setup completed!"
}

# Run main function
main "$@"
