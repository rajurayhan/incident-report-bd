# Reusable Components Documentation

This document explains how to use the reusable navigation and footer components in the IncidentReport application.

## Navigation Component

The `Navigation.vue` component provides a fully responsive navigation bar with the following features:

### Features
- **Responsive Design**: Desktop and mobile layouts
- **User Authentication**: Shows different content for logged-in vs guest users
- **User Menu**: Dropdown menu with profile and logout options
- **Mobile Menu**: Collapsible mobile navigation
- **Active Route Highlighting**: Current page is highlighted
- **Smooth Transitions**: Hover effects and animations

### Usage

```vue
<template>
  <div>
    <Navigation />
    <!-- Your page content -->
  </div>
</template>

<script setup>
import Navigation from '@/components/Navigation.vue'
</script>
```

### Configuration

The navigation items are configured in the `navigationItems` array within the component:

```javascript
const navigationItems = [
  {
    name: 'home',
    label: 'Home',
    to: '/',
    routeName: 'home'
  },
  {
    name: 'report',
    label: 'Report Incident',
    to: '/report',
    routeName: 'report'
  },
  // ... more items
]
```

### Customization

To customize the navigation:

1. **Add/Remove Items**: Modify the `navigationItems` array
2. **Styling**: Update the Tailwind CSS classes
3. **User Menu**: Add/remove items in the user dropdown
4. **Branding**: Change the logo and brand name

## Footer Component

The `Footer.vue` component provides a consistent footer across all pages.

### Features
- **Brand Information**: Company name and description
- **Links**: Privacy Policy, Terms of Service, Contact
- **Social Media**: Twitter, Facebook, Pinterest links
- **Copyright**: Dynamic year display
- **Responsive Design**: Works on all screen sizes

### Usage

```vue
<template>
  <div>
    <!-- Your page content -->
    <Footer />
  </div>
</template>

<script setup>
import Footer from '@/components/Footer.vue'
</script>
```

### Customization

To customize the footer:

1. **Links**: Update the footer links array
2. **Social Media**: Add/remove social media icons
3. **Branding**: Change company name and description
4. **Styling**: Modify Tailwind CSS classes

## App.vue Structure

The main `App.vue` component now uses both reusable components:

```vue
<template>
  <div id="app" class="min-h-screen bg-gray-50">
    <Navigation />
    
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <router-view />
    </main>
    
    <Footer />
  </div>
</template>

<script setup>
import Navigation from './Navigation.vue'
import Footer from './Footer.vue'
</script>
```

## Benefits of Reusable Components

### 1. **Consistency**
- Same navigation and footer across all pages
- Consistent styling and behavior
- Unified user experience

### 2. **Maintainability**
- Single source of truth for navigation/footer
- Easy to update across entire application
- Reduced code duplication

### 3. **Scalability**
- Easy to add new pages/routes
- Simple to modify navigation items
- Flexible configuration options

### 4. **Performance**
- Components are cached and reused
- Smaller bundle sizes
- Better Vue.js optimization

## Adding New Navigation Items

To add a new navigation item:

1. **Update Navigation.vue**:
```javascript
const navigationItems = [
  // ... existing items
  {
    name: 'new-page',
    label: 'New Page',
    to: '/new-page',
    routeName: 'new-page'
  }
]
```

2. **Add Route** in `app.js`:
```javascript
const routes = [
  // ... existing routes
  { path: '/new-page', name: 'new-page', component: NewPage }
]
```

3. **Create Component** (if needed):
```vue
<!-- resources/js/components/NewPage.vue -->
<template>
  <div>
    <h1>New Page</h1>
  </div>
</template>
```

## Mobile Responsiveness

Both components are fully responsive:

- **Desktop**: Full navigation bar with all items visible
- **Tablet**: Responsive layout with proper spacing
- **Mobile**: Collapsible menu with touch-friendly controls

## Accessibility Features

- **Keyboard Navigation**: All interactive elements are keyboard accessible
- **Screen Reader Support**: Proper ARIA labels and semantic HTML
- **Focus Management**: Clear focus indicators
- **Color Contrast**: Meets WCAG guidelines

## Browser Support

- **Modern Browsers**: Chrome, Firefox, Safari, Edge
- **Mobile Browsers**: iOS Safari, Chrome Mobile
- **Progressive Enhancement**: Works without JavaScript (basic functionality)

## Future Enhancements

Potential improvements for the reusable components:

1. **Theme Support**: Dark/light mode toggle
2. **Internationalization**: Multi-language support
3. **Search Integration**: Global search functionality
4. **Notifications**: User notification system
5. **Breadcrumbs**: Dynamic breadcrumb navigation
