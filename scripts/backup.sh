#!/bin/bash

# Incident Report Platform - Backup Script
# This script creates automated backups of the application and database

set -e  # Exit on any error

# Configuration
APP_NAME="incident-report"
APP_DIR="/var/www/$APP_NAME"
BACKUP_DIR="/var/backups/$APP_NAME"
DB_NAME="incident_report_prod"
DB_USER="incident_report_user"
DB_PASSWORD="your_password_here"
RETENTION_DAYS=7

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
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

# Create backup directory if it doesn't exist
create_backup_dir() {
    if [ ! -d "$BACKUP_DIR" ]; then
        mkdir -p "$BACKUP_DIR"
        chown incident-report:incident-report "$BACKUP_DIR"
        log "Created backup directory: $BACKUP_DIR"
    fi
}

# Database backup
backup_database() {
    log "Creating database backup..."
    
    local timestamp=$(date +%Y%m%d_%H%M%S)
    local db_backup_file="$BACKUP_DIR/database_$timestamp.sql"
    
    if mysqldump -u "$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" > "$db_backup_file"; then
        gzip "$db_backup_file"
        log "Database backup created: ${db_backup_file}.gz"
    else
        error "Database backup failed"
    fi
}

# Application files backup
backup_application() {
    log "Creating application files backup..."
    
    local timestamp=$(date +%Y%m%d_%H%M%S)
    local app_backup_file="$BACKUP_DIR/app_$timestamp.tar.gz"
    
    # Create backup excluding unnecessary files
    tar -czf "$app_backup_file" \
        --exclude='vendor' \
        --exclude='node_modules' \
        --exclude='storage/logs' \
        --exclude='storage/framework/cache' \
        --exclude='storage/framework/sessions' \
        --exclude='storage/framework/views' \
        --exclude='.git' \
        --exclude='*.log' \
        -C "$(dirname "$APP_DIR")" "$(basename "$APP_DIR")"
    
    if [ $? -eq 0 ]; then
        log "Application backup created: $app_backup_file"
    else
        error "Application backup failed"
    fi
}

# Storage files backup
backup_storage() {
    log "Creating storage files backup..."
    
    local timestamp=$(date +%Y%m%d_%H%M%S)
    local storage_backup_file="$BACKUP_DIR/storage_$timestamp.tar.gz"
    
    tar -czf "$storage_backup_file" \
        --exclude='logs' \
        --exclude='framework/cache' \
        --exclude='framework/sessions' \
        --exclude='framework/views' \
        -C "$APP_DIR" storage
    
    if [ $? -eq 0 ]; then
        log "Storage backup created: $storage_backup_file"
    else
        error "Storage backup failed"
    fi
}

# Cleanup old backups
cleanup_old_backups() {
    log "Cleaning up old backups (older than $RETENTION_DAYS days)..."
    
    find "$BACKUP_DIR" -name "*.sql.gz" -mtime +$RETENTION_DAYS -delete
    find "$BACKUP_DIR" -name "*.tar.gz" -mtime +$RETENTION_DAYS -delete
    
    log "Old backups cleaned up"
}

# Verify backup integrity
verify_backup() {
    local backup_file="$1"
    
    if [ -f "$backup_file" ]; then
        if gzip -t "$backup_file" 2>/dev/null; then
            log "Backup integrity verified: $backup_file"
            return 0
        else
            warning "Backup integrity check failed: $backup_file"
            return 1
        fi
    else
        warning "Backup file not found: $backup_file"
        return 1
    fi
}

# Send notification (customize based on your notification system)
send_notification() {
    local status="$1"
    local message="$2"
    
    # Example: Send email notification
    # echo "$message" | mail -s "Backup $status - Incident Report Platform" admin@yourdomain.com
    
    # Example: Send to Slack webhook
    # curl -X POST -H 'Content-type: application/json' \
    #     --data "{\"text\":\"Backup $status: $message\"}" \
    #     YOUR_SLACK_WEBHOOK_URL
    
    log "Notification sent: $status - $message"
}

# Main backup function
main() {
    log "Starting backup process..."
    
    create_backup_dir
    backup_database
    backup_application
    backup_storage
    cleanup_old_backups
    
    # Verify latest backups
    local latest_db=$(ls -t "$BACKUP_DIR"/database_*.sql.gz 2>/dev/null | head -1)
    local latest_app=$(ls -t "$BACKUP_DIR"/app_*.tar.gz 2>/dev/null | head -1)
    local latest_storage=$(ls -t "$BACKUP_DIR"/storage_*.tar.gz 2>/dev/null | head -1)
    
    local verification_failed=false
    
    if [ -n "$latest_db" ]; then
        verify_backup "$latest_db" || verification_failed=true
    fi
    
    if [ -n "$latest_app" ]; then
        verify_backup "$latest_app" || verification_failed=true
    fi
    
    if [ -n "$latest_storage" ]; then
        verify_backup "$latest_storage" || verification_failed=true
    fi
    
    if [ "$verification_failed" = true ]; then
        send_notification "FAILED" "Some backups failed integrity check"
        error "Backup verification failed"
    else
        send_notification "SUCCESS" "All backups completed successfully"
        log "Backup process completed successfully"
    fi
}

# Restore function
restore() {
    local backup_type="$1"
    local backup_file="$2"
    
    if [ -z "$backup_type" ] || [ -z "$backup_file" ]; then
        error "Usage: $0 restore <database|application|storage> <backup_file>"
    fi
    
    log "Starting restore process for $backup_type..."
    
    case "$backup_type" in
        "database")
            if [ -f "$backup_file" ]; then
                gunzip -c "$backup_file" | mysql -u "$DB_USER" -p"$DB_PASSWORD" "$DB_NAME"
                log "Database restored from: $backup_file"
            else
                error "Database backup file not found: $backup_file"
            fi
            ;;
        "application")
            if [ -f "$backup_file" ]; then
                tar -xzf "$backup_file" -C "$(dirname "$APP_DIR")"
                chown -R incident-report:www-data "$APP_DIR"
                log "Application restored from: $backup_file"
            else
                error "Application backup file not found: $backup_file"
            fi
            ;;
        "storage")
            if [ -f "$backup_file" ]; then
                tar -xzf "$backup_file" -C "$APP_DIR"
                chown -R incident-report:www-data "$APP_DIR/storage"
                log "Storage restored from: $backup_file"
            else
                error "Storage backup file not found: $backup_file"
            fi
            ;;
        *)
            error "Invalid backup type. Use: database, application, or storage"
            ;;
    esac
}

# List available backups
list_backups() {
    log "Available backups:"
    echo
    echo "Database backups:"
    ls -la "$BACKUP_DIR"/database_*.sql.gz 2>/dev/null || echo "No database backups found"
    echo
    echo "Application backups:"
    ls -la "$BACKUP_DIR"/app_*.tar.gz 2>/dev/null || echo "No application backups found"
    echo
    echo "Storage backups:"
    ls -la "$BACKUP_DIR"/storage_*.tar.gz 2>/dev/null || echo "No storage backups found"
}

# Show usage
usage() {
    echo "Usage: $0 [backup|restore|list]"
    echo
    echo "Commands:"
    echo "  backup                    - Create full backup"
    echo "  restore <type> <file>     - Restore from backup"
    echo "  list                      - List available backups"
    echo
    echo "Restore types:"
    echo "  database                  - Restore database"
    echo "  application               - Restore application files"
    echo "  storage                   - Restore storage files"
    echo
    echo "Examples:"
    echo "  $0 backup"
    echo "  $0 restore database /var/backups/incident-report/database_20240101_120000.sql.gz"
    echo "  $0 list"
}

# Main script logic
case "${1:-backup}" in
    "backup")
        main
        ;;
    "restore")
        restore "$2" "$3"
        ;;
    "list")
        list_backups
        ;;
    *)
        usage
        ;;
esac
