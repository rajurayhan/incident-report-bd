<?php

namespace App\Helpers;

class OpenGraphHelper
{
    public static function getMetaTags($page = 'default', $data = [])
    {
        $baseUrl = config('app.url');
        $appName = config('app.name', 'Incident Report');
        
        $defaults = [
            'title' => $appName,
            'description' => 'Community-driven incident reporting system for better safety and awareness.',
            'image' => $baseUrl . '/images/og/default.svg',
            'url' => $data['url'] ?? $baseUrl,
            'type' => 'website',
            'site_name' => $appName,
        ];
        
        $pageConfigs = [
            'home' => [
                'title' => $appName . ' - Community Safety Platform',
                'description' => 'Report and track incidents in your community. Stay informed and help keep your neighborhood safe.',
                'image' => $baseUrl . '/images/og/default.svg',
            ],
            'report' => [
                'title' => 'Report Incident - ' . $appName,
                'description' => 'Submit a new incident report to help keep your community informed and safe.',
                'image' => $baseUrl . '/images/og/report.svg',
            ],
            'map' => [
                'title' => 'Incident Map - ' . $appName,
                'description' => 'View incidents on an interactive map. See what\'s happening in your area.',
                'image' => $baseUrl . '/images/og/map.svg',
            ],
            'analytics' => [
                'title' => 'Analytics - ' . $appName,
                'description' => 'View incident statistics, trends, and insights for your community.',
                'image' => $baseUrl . '/images/og/analytics.svg',
            ],
            'admin' => [
                'title' => 'Admin Dashboard - ' . $appName,
                'description' => 'Manage incidents, users, and system settings.',
                'image' => $baseUrl . '/images/og/admin.svg',
            ],
            'login' => [
                'title' => 'Login - ' . $appName,
                'description' => 'Sign in to your account to report incidents and manage your reports.',
                'image' => $baseUrl . '/images/og/default.svg',
            ],
            'register' => [
                'title' => 'Register - ' . $appName,
                'description' => 'Create an account to start reporting incidents and contributing to community safety.',
                'image' => $baseUrl . '/images/og/default.svg',
            ],
            'profile' => [
                'title' => 'My Profile - ' . $appName,
                'description' => 'Manage your profile settings and view your incident reporting activity.',
                'image' => $baseUrl . '/images/og/default.svg',
            ],
            'my-reports' => [
                'title' => 'My Reports - ' . $appName,
                'description' => 'View and manage your submitted incident reports.',
                'image' => $baseUrl . '/images/og/default.svg',
            ],
            'my-activity' => [
                'title' => 'My Activity - ' . $appName,
                'description' => 'Track your activity and contributions to the community.',
                'image' => $baseUrl . '/images/og/default.svg',
            ],
            'incident' => [
                'title' => ($data['title'] ?? 'Incident Details') . ' - ' . $appName,
                'description' => $data['description'] ?? 'View detailed information about this incident.',
                'image' => $data['image'] ?? $baseUrl . '/images/og/default.svg',
                'type' => 'article',
            ],
        ];
        
        $config = array_merge($defaults, $pageConfigs[$page] ?? [], $data);
        
        return [
            'title' => $config['title'],
            'description' => $config['description'],
            'image' => $config['image'],
            'url' => $config['url'],
            'type' => $config['type'],
            'site_name' => $config['site_name'],
        ];
    }
    
    public static function generateMetaTags($page = 'default', $data = [])
    {
        $meta = self::getMetaTags($page, $data);
        
        return [
            'og:title' => $meta['title'],
            'og:description' => $meta['description'],
            'og:image' => $meta['image'],
            'og:url' => $meta['url'],
            'og:type' => $meta['type'],
            'og:site_name' => $meta['site_name'],
            'og:locale' => app()->getLocale(),
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $meta['title'],
            'twitter:description' => $meta['description'],
            'twitter:image' => $meta['image'],
        ];
    }
}
