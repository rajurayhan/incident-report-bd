# Open Graph (OG) Meta Tags Implementation

This document describes the comprehensive Open Graph meta tags implementation for the Incident Report application.

## Overview

The application now includes:
- Dynamic OG meta tags for all pages
- Relevant OG images for different page types
- Structured data (JSON-LD) for better SEO
- Sitemap.xml for search engines
- Proper robots.txt configuration

## Files Added/Modified

### New Files Created

1. **OG Images** (`/public/images/og/`)
   - `default.svg` - Default OG image for general pages
   - `report.svg` - OG image for report incident page
   - `map.svg` - OG image for incident map page
   - `analytics.svg` - OG image for analytics page
   - `admin.svg` - OG image for admin dashboard

2. **Helper Classes**
   - `app/Helpers/OpenGraphHelper.php` - Generates OG meta tags for different pages
   - `app/Http/Controllers/MetaController.php` - API endpoint for dynamic meta tags

3. **Vue Components**
   - `resources/js/components/MetaTagsManager.vue` - Dynamically updates meta tags
   - `resources/js/components/StructuredDataManager.vue` - Manages structured data

4. **SEO Files**
   - `resources/views/sitemap.blade.php` - Dynamic sitemap generation
   - Updated `public/robots.txt` - Search engine directives

### Modified Files

1. **resources/views/welcome.blade.php**
   - Added comprehensive meta tags
   - Added OG, Twitter Card, and additional SEO meta tags

2. **resources/js/components/App.vue**
   - Added MetaTagsManager and StructuredDataManager components

3. **routes/api.php**
   - Added meta-tags API endpoint

4. **routes/web.php**
   - Added sitemap.xml route

## Features

### Dynamic Meta Tags
- Automatically updates meta tags based on current route
- Fetches incident-specific data for incident detail pages
- Uses incident media as OG image when available

### Page-Specific OG Images
- **Home/Default**: Blue gradient with report icon
- **Report**: Orange gradient with plus icon
- **Map**: Green gradient with map and location pin
- **Analytics**: Purple gradient with chart icon
- **Admin**: Red gradient with shield icon

### Structured Data
- Organization schema
- Website schema
- WebApplication schema
- Event schema for incident pages

### SEO Optimization
- Proper canonical URLs
- Sitemap with all public pages
- Robots.txt with proper directives
- Meta descriptions and keywords

## API Endpoints

### GET /api/meta-tags
Returns dynamic meta tags based on the current path.

**Query Parameters:**
- `path` - The current page path

**Response:**
```json
{
  "og:title": "Page Title",
  "og:description": "Page description",
  "og:image": "https://domain.com/image.svg",
  "og:url": "https://domain.com/path",
  "og:type": "website",
  "og:site_name": "Incident Report",
  "og:locale": "en",
  "twitter:card": "summary_large_image",
  "twitter:title": "Page Title",
  "twitter:description": "Page description",
  "twitter:image": "https://domain.com/image.svg"
}
```

## Usage

The meta tags are automatically managed by the Vue.js components. No manual intervention is required.

### For Developers

To add new page-specific meta tags:

1. Add the page configuration to `OpenGraphHelper::getMetaTags()`
2. Create a new OG image in `/public/images/og/`
3. Update the page configuration with the new image path

### Testing OG Tags

You can test the OG tags using:
- Facebook Sharing Debugger: https://developers.facebook.com/tools/debug/
- Twitter Card Validator: https://cards-dev.twitter.com/validator
- LinkedIn Post Inspector: https://www.linkedin.com/post-inspector/

## Configuration

Update the following in your `.env` file:
- `APP_URL` - Your application URL
- `APP_NAME` - Your application name

Update `public/robots.txt` with your actual domain:
- Replace `https://your-domain.com` with your actual domain

## Benefits

1. **Better Social Sharing**: Rich previews when sharing links on social media
2. **Improved SEO**: Better search engine understanding and ranking
3. **Professional Appearance**: Consistent branding across all platforms
4. **Dynamic Content**: Incident-specific meta tags for better engagement
5. **Search Engine Friendly**: Proper sitemap and robots.txt configuration
