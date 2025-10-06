#!/bin/bash

# Incident Report Platform - Health Check Script
# This script performs comprehensive health checks on the application

set -e  # Exit on any error

# Configuration
APP_NAME="incident-report"
APP_DIR="/var/www/$APP_NAME"
APP_URL="http://localhost"
API_ENDPOINT="$APP_URL/api/analytics/stats"
DB_NAME="incident_report_prod"
DB_USER="incident_report_user"
DB_PASSWORD="your_password_here"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Health check results
declare -A HEALTH_STATUS
HEALTH_STATUS["overall"]="HEALTHY"

# Logging functions
log() {
    echo -e "${GREEN}[$(date +'%Y-%m-%d %H:%M:%S')]${NC} $1"
}

error() {
    echo -e "${RED}[ERROR]${NC} $1"
    HEALTH_STATUS["overall"]="UNHEALTHY"
}

warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

# Check if service is running
check_service() {
    local service_name="$1"
    local service_display_name="$2"
    
    if systemctl is-active --quiet "$service_name"; then
        log "✓ $service_display_name is running"
        HEALTH_STATUS["$service_name"]="HEALTHY"
    else
        error "✗ $service_display_name is not running"
        HEALTH_STATUS["$service_name"]="UNHEALTHY"
    fi
}

# Check disk space
check_disk_space() {
    local threshold=85  # Alert if disk usage is above 85%
    local usage=$(df / | awk 'NR==2 {print $5}' | sed 's/%//')
    
    if [ "$usage" -lt "$threshold" ]; then
        log "✓ Disk space usage: ${usage}% (healthy)"
        HEALTH_STATUS["disk"]="HEALTHY"
    else
        warning "⚠ Disk space usage: ${usage}% (above ${threshold}% threshold)"
        HEALTH_STATUS["disk"]="WARNING"
    fi
}

# Check memory usage
check_memory() {
    local threshold=90  # Alert if memory usage is above 90%
    local usage=$(free | awk 'NR==2{printf "%.0f", $3*100/$2}')
    
    if [ "$usage" -lt "$threshold" ]; then
        log "✓ Memory usage: ${usage}% (healthy)"
        HEALTH_STATUS["memory"]="HEALTHY"
    else
        warning "⚠ Memory usage: ${usage}% (above ${threshold}% threshold)"
        HEALTH_STATUS["memory"]="WARNING"
    fi
}

# Check database connection
check_database() {
    if mysql -u "$DB_USER" -p"$DB_PASSWORD" -e "SELECT 1;" "$DB_NAME" > /dev/null 2>&1; then
        log "✓ Database connection is healthy"
        HEALTH_STATUS["database"]="HEALTHY"
    else
        error "✗ Database connection failed"
        HEALTH_STATUS["database"]="UNHEALTHY"
    fi
}

# Check Redis connection
check_redis() {
    if redis-cli ping > /dev/null 2>&1; then
        log "✓ Redis connection is healthy"
        HEALTH_STATUS["redis"]="HEALTHY"
    else
        error "✗ Redis connection failed"
        HEALTH_STATUS["redis"]="UNHEALTHY"
    fi
}

# Check application response
check_application() {
    local response_code=$(curl -s -o /dev/null -w "%{http_code}" "$API_ENDPOINT" || echo "000")
    
    if [ "$response_code" = "200" ]; then
        log "✓ Application is responding (HTTP $response_code)"
        HEALTH_STATUS["application"]="HEALTHY"
    else
        error "✗ Application is not responding properly (HTTP $response_code)"
        HEALTH_STATUS["application"]="UNHEALTHY"
    fi
}

# Check file permissions
check_permissions() {
    local issues=0
    
    # Check storage directory permissions
    if [ -w "$APP_DIR/storage" ]; then
        log "✓ Storage directory is writable"
    else
        error "✗ Storage directory is not writable"
        ((issues++))
    fi
    
    # Check bootstrap cache permissions
    if [ -w "$APP_DIR/bootstrap/cache" ]; then
        log "✓ Bootstrap cache directory is writable"
    else
        error "✗ Bootstrap cache directory is not writable"
        ((issues++))
    fi
    
    if [ $issues -eq 0 ]; then
        HEALTH_STATUS["permissions"]="HEALTHY"
    else
        HEALTH_STATUS["permissions"]="UNHEALTHY"
    fi
}

# Check log files
check_logs() {
    local log_file="$APP_DIR/storage/logs/laravel.log"
    local error_count=0
    
    if [ -f "$log_file" ]; then
        # Count errors in the last 100 lines
        error_count=$(tail -100 "$log_file" | grep -c "ERROR\|CRITICAL\|EMERGENCY" || echo "0")
        
        if [ "$error_count" -eq 0 ]; then
            log "✓ No recent errors in application logs"
            HEALTH_STATUS["logs"]="HEALTHY"
        else
            warning "⚠ Found $error_count recent errors in application logs"
            HEALTH_STATUS["logs"]="WARNING"
        fi
    else
        warning "⚠ Application log file not found"
        HEALTH_STATUS["logs"]="WARNING"
    fi
}

# Check queue workers
check_queue_workers() {
    if command -v supervisorctl &> /dev/null; then
        local worker_status=$(supervisorctl status "$APP_NAME-worker:*" 2>/dev/null | grep -c "RUNNING" || echo "0")
        
        if [ "$worker_status" -gt 0 ]; then
            log "✓ Queue workers are running ($worker_status active)"
            HEALTH_STATUS["queue"]="HEALTHY"
        else
            error "✗ No queue workers are running"
            HEALTH_STATUS["queue"]="UNHEALTHY"
        fi
    else
        warning "⚠ Supervisor not available - cannot check queue workers"
        HEALTH_STATUS["queue"]="UNKNOWN"
    fi
}

# Check SSL certificate (if HTTPS is configured)
check_ssl_certificate() {
    local domain=$(grep APP_URL "$APP_DIR/.env" | cut -d '=' -f2 | sed 's/https:\/\///' | sed 's/http:\/\///')
    
    if [[ "$domain" == *"localhost"* ]] || [[ "$domain" == *"127.0.0.1"* ]]; then
        info "Skipping SSL check for localhost"
        HEALTH_STATUS["ssl"]="SKIPPED"
        return
    fi
    
    if command -v openssl &> /dev/null; then
        local cert_info=$(echo | openssl s_client -servername "$domain" -connect "$domain:443" 2>/dev/null | openssl x509 -noout -dates 2>/dev/null || echo "")
        
        if [ -n "$cert_info" ]; then
            local expiry_date=$(echo "$cert_info" | grep "notAfter" | cut -d '=' -f2)
            local expiry_timestamp=$(date -d "$expiry_date" +%s)
            local current_timestamp=$(date +%s)
            local days_until_expiry=$(( (expiry_timestamp - current_timestamp) / 86400 ))
            
            if [ "$days_until_expiry" -gt 30 ]; then
                log "✓ SSL certificate is valid ($days_until_expiry days until expiry)"
                HEALTH_STATUS["ssl"]="HEALTHY"
            elif [ "$days_until_expiry" -gt 7 ]; then
                warning "⚠ SSL certificate expires in $days_until_expiry days"
                HEALTH_STATUS["ssl"]="WARNING"
            else
                error "✗ SSL certificate expires in $days_until_expiry days"
                HEALTH_STATUS["ssl"]="UNHEALTHY"
            fi
        else
            warning "⚠ Could not check SSL certificate"
            HEALTH_STATUS["ssl"]="WARNING"
        fi
    else
        warning "⚠ OpenSSL not available - cannot check SSL certificate"
        HEALTH_STATUS["ssl"]="UNKNOWN"
    fi
}

# Generate health report
generate_report() {
    echo
    log "=== HEALTH CHECK REPORT ==="
    echo
    
    local healthy_count=0
    local warning_count=0
    local unhealthy_count=0
    local unknown_count=0
    
    for component in "${!HEALTH_STATUS[@]}"; do
        if [ "$component" = "overall" ]; then
            continue
        fi
        
        case "${HEALTH_STATUS[$component]}" in
            "HEALTHY")
                echo -e "✓ ${component^}: ${GREEN}HEALTHY${NC}"
                ((healthy_count++))
                ;;
            "WARNING")
                echo -e "⚠ ${component^}: ${YELLOW}WARNING${NC}"
                ((warning_count++))
                ;;
            "UNHEALTHY")
                echo -e "✗ ${component^}: ${RED}UNHEALTHY${NC}"
                ((unhealthy_count++))
                ;;
            "UNKNOWN"|"SKIPPED")
                echo -e "? ${component^}: ${BLUE}${HEALTH_STATUS[$component]}${NC}"
                ((unknown_count++))
                ;;
        esac
    done
    
    echo
    echo "Summary:"
    echo "  Healthy: $healthy_count"
    echo "  Warnings: $warning_count"
    echo "  Unhealthy: $unhealthy_count"
    echo "  Unknown/Skipped: $unknown_count"
    echo
    
    if [ "${HEALTH_STATUS[overall]}" = "HEALTHY" ]; then
        echo -e "Overall Status: ${GREEN}HEALTHY${NC}"
    else
        echo -e "Overall Status: ${RED}UNHEALTHY${NC}"
    fi
}

# Send alert (customize based on your notification system)
send_alert() {
    local message="$1"
    
    # Example: Send email alert
    # echo "$message" | mail -s "Health Check Alert - Incident Report Platform" admin@yourdomain.com
    
    # Example: Send to Slack webhook
    # curl -X POST -H 'Content-type: application/json' \
    #     --data "{\"text\":\"🚨 Health Check Alert: $message\"}" \
    #     YOUR_SLACK_WEBHOOK_URL
    
    log "Alert sent: $message"
}

# Main health check function
main() {
    log "Starting health check for Incident Report Platform..."
    
    # System checks
    check_service "nginx" "Nginx"
    check_service "php8.3-fpm" "PHP-FPM"
    check_service "mysql" "MySQL"
    check_service "redis-server" "Redis"
    
    # Resource checks
    check_disk_space
    check_memory
    
    # Application checks
    check_database
    check_redis
    check_application
    check_permissions
    check_logs
    check_queue_workers
    check_ssl_certificate
    
    # Generate report
    generate_report
    
    # Send alert if unhealthy
    if [ "${HEALTH_STATUS[overall]}" = "UNHEALTHY" ]; then
        send_alert "System is unhealthy - immediate attention required"
    fi
    
    log "Health check completed"
}

# Quick check function
quick_check() {
    log "Performing quick health check..."
    
    check_service "nginx" "Nginx"
    check_service "php8.3-fpm" "PHP-FPM"
    check_application
    
    if [ "${HEALTH_STATUS[overall]}" = "HEALTHY" ]; then
        log "Quick check: System is healthy"
    else
        error "Quick check: System issues detected"
    fi
}

# Show usage
usage() {
    echo "Usage: $0 [full|quick]"
    echo
    echo "Commands:"
    echo "  full    - Perform comprehensive health check (default)"
    echo "  quick   - Perform quick health check"
    echo
    echo "Examples:"
    echo "  $0"
    echo "  $0 full"
    echo "  $0 quick"
}

# Main script logic
case "${1:-full}" in
    "full")
        main
        ;;
    "quick")
        quick_check
        ;;
    *)
        usage
        ;;
esac
