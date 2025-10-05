<template>
  <nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <!-- Logo/Brand -->
        <div class="flex items-center">
          <router-link to="/" class="flex items-center">
            <div class="flex-shrink-0">
              <h1 class="text-2xl font-bold text-red-600">IncidentReport</h1>
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
              Login
            </router-link>
            <router-link 
              to="/register" 
              class="bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium hover:bg-red-700 transition-colors duration-200"
            >
              Register
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
</template>

<script setup>
import { computed } from 'vue'
import { useAuthStore } from '../stores/auth'
import UserMenu from './UserMenu.vue'
import MobileMenu from './MobileMenu.vue'
import LanguageSwitcher from './LanguageSwitcher.vue'

const authStore = useAuthStore()

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
</script>