<template>
  <nav 
    class="bg-white shadow-lg transition-all duration-300 ease-in-out"
    :class="{
      'fixed top-0 left-0 right-0 z-50 transform': isFloating,
      'relative z-50 transform -translate-y-full opacity-0': isHidden,
      'relative z-50 transform translate-y-0 opacity-100': !isFloating && !isHidden
    }"
  >
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <!-- Logo/Brand -->
        <div class="flex items-center">
          <router-link to="/" class="flex items-center">
            <div class="flex-shrink-0">
              <h1 class="text-2xl font-bold text-red-600">{{ $t('nav.logo') }}</h1>
            </div>
          </router-link>
        </div>
        
        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center space-x-4">
          <!-- Navigation Links -->
          <div class="flex items-center space-x-4">
            <router-link 
              v-for="item in navigationItems" 
              :key="item.name"
              :to="item.to" 
              class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200"
              :class="{ 'text-red-600 bg-red-50': $route.name === item.routeName }"
            >
              {{ $t(`nav.${item.name}`) }}
            </router-link>
          </div>
          
          <!-- Language Switcher -->
          <div class="border-l border-gray-200 pl-4">
            <LanguageSwitcher />
          </div>
          
          <!-- User Actions -->
          <div v-if="user" class="flex items-center space-x-2 pl-4 border-l border-gray-200">
            <UserMenu />
          </div>
          
          <!-- Guest Actions -->
          <div v-else class="flex items-center space-x-2 ml-4 pl-4 border-l border-gray-200">
            <router-link 
              to="/login" 
              class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200"
            >
              {{ $t('nav.login') }}
            </router-link>
            <router-link 
              to="/register" 
              class="bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium hover:bg-red-700 transition-colors duration-200"
            >
              {{ $t('nav.register') }}
            </router-link>
          </div>
        </div>
        
        <!-- Mobile Menu Button -->
        <div class="md:hidden flex items-center">
          <MobileMenu />
        </div>
      </div>
    </div>
  </nav>
  
  <!-- Spacer to prevent content jump when nav becomes fixed -->
  <div v-if="isFloating" class="h-16"></div>
</template>

<script setup>
import { computed, ref, onMounted, onUnmounted, watch } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRoute } from 'vue-router'
import UserMenu from './UserMenu.vue'
import MobileMenu from './MobileMenu.vue'
import LanguageSwitcher from './LanguageSwitcher.vue'

const authStore = useAuthStore()
const route = useRoute()

// Scroll detection for floating navigation
const isFloating = ref(false)
const isHidden = ref(false)
const lastScrollY = ref(0)
const scrollThreshold = 100 // Minimum scroll distance to trigger floating
const hideThreshold = 200 // Scroll distance to hide navigation when scrolling down

// Computed properties
const user = computed(() => authStore.user)

// Navigation items configuration
const navigationItems = [
  {
    name: 'home',
    to: '/',
    routeName: 'home'
  },
  {
    name: 'report',
    to: '/report',
    routeName: 'report'
  },
  {
    name: 'map',
    to: '/map',
    routeName: 'map'
  },
  {
    name: 'analytics',
    to: '/analytics',
    routeName: 'analytics'
  }
]

// Scroll handler
const handleScroll = () => {
  const currentScrollY = window.scrollY
  
  // Only activate floating on desktop (md and up)
  if (window.innerWidth >= 768) {
    if (currentScrollY > scrollThreshold) {
      // Scrolling down - hide navigation with smooth transition
      if (currentScrollY > lastScrollY.value && currentScrollY > hideThreshold) {
        isFloating.value = false
        isHidden.value = true
      }
      // Scrolling up - show floating navigation with smooth transition
      else if (currentScrollY < lastScrollY.value) {
        isFloating.value = true
        isHidden.value = false
      }
    } else {
      // Near top of page - always show normal navigation
      isFloating.value = false
      isHidden.value = false
    }
  } else {
    // On mobile, always use normal navigation
    isFloating.value = false
    isHidden.value = false
  }
  
  lastScrollY.value = currentScrollY
}

// Resize handler to reset floating on mobile
const handleResize = () => {
  if (window.innerWidth < 768) {
    isFloating.value = false
    isHidden.value = false
  }
}

// Reset navigation state when route changes
watch(() => route.path, () => {
  // Reset navigation to normal state when navigating to a new page
  isFloating.value = false
  isHidden.value = false
  lastScrollY.value = 0
})

// Lifecycle hooks
onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true })
  window.addEventListener('resize', handleResize)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  window.removeEventListener('resize', handleResize)
})
</script>

<style scoped>
/* Enhanced floating navigation styles */
nav.fixed {
  backdrop-filter: blur(10px);
  background-color: rgba(255, 255, 255, 0.95);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  transform: translateY(0) !important;
  opacity: 1 !important;
}

/* Smooth transitions for all navigation states */
nav {
  transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
  will-change: transform, opacity;
}

/* Hidden state - slides up and fades out */
nav.transform.-translate-y-full {
  transform: translateY(-100%);
  opacity: 0;
  pointer-events: none;
}

/* Normal state - visible and in place */
nav.transform.translate-y-0 {
  transform: translateY(0);
  opacity: 1;
}

/* Ensure proper z-index stacking */
nav {
  z-index: 50;
}

nav.fixed {
  z-index: 1000;
}

/* Prevent content jump when navigation becomes fixed */
nav + div {
  transition: height 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

/* Smooth backdrop blur transition */
nav.fixed {
  transition: backdrop-filter 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
}

/* Ensure dropdowns appear above hero section */
nav .relative {
  z-index: 60;
}
</style>