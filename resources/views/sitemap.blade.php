<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>{{ config('app.url') }}</loc>
    <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
    <changefreq>daily</changefreq>
    <priority>1.0</priority>
  </url>
  <url>
    <loc>{{ config('app.url') }}/report</loc>
    <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc>{{ config('app.url') }}/map</loc>
    <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
    <changefreq>daily</changefreq>
    <priority>0.9</priority>
  </url>
  <url>
    <loc>{{ config('app.url') }}/analytics</loc>
    <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.7</priority>
  </url>
  <url>
    <loc>{{ config('app.url') }}/login</loc>
    <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.5</priority>
  </url>
  <url>
    <loc>{{ config('app.url') }}/register</loc>
    <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.5</priority>
  </url>
</urlset>
