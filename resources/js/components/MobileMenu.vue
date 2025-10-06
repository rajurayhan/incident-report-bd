<template>
  <div class="relative">
    <!-- Large clickable area -->
    <div 
      @click="toggleMobileMenu"
      class="text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-md transition-all duration-200 touch-manipulation active:scale-95 cursor-pointer"
      style="min-width: 60px; min-height: 60px; padding: 12px;"
      :class="{ 'text-red-600 bg-red-50': showMobileMenu }"
    >
      <div class="flex items-center justify-center w-full h-full">
        <svg v-if="!showMobileMenu" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
        <svg v-else class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </div>
    </div>
    
    <!-- Mobile Navigation Menu -->
    <div v-if="showMobileMenu">
      <!-- Backdrop -->
      <div 
        class="fixed top-16 left-0 right-0 bottom-0 bg-gray-900 bg-opacity-10 z-[9998]"
        @click="closeMobileMenu"
        style="backdrop-filter: blur(1px);"
      ></div>
      
      <!-- Menu -->
      <div class="fixed top-20 right-4 w-80 max-w-[calc(100vw-2rem)] bg-white rounded-lg shadow-xl py-2 z-[9999] border border-gray-200 max-h-[calc(100vh-6rem)] overflow-y-auto transform transition-all duration-300 ease-out animate-in slide-in-from-top-2 fade-in">
      <div class="px-2 pt-2 pb-3 space-y-1">
        <!-- Language Switcher -->
        <div class="px-3 py-2 border-b border-gray-200 mb-2">
          <LanguageSwitcher />
        </div>
        
        <!-- Mobile Navigation Links -->
        <router-link 
          v-for="item in navigationItems" 
          :key="item.name"
          :to="item.to" 
          class="block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200"
          :class="$route.name === item.routeName ? 'text-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600 hover:bg-gray-50'"
          @click="closeMobileMenu"
        >
          {{ $t(`nav.${item.name}`) }}
        </router-link>
        
        <!-- Mobile User Actions -->
        <div v-if="user" class="pt-4 border-t border-gray-200">
          <div class="px-3 py-2">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center text-white font-semibold">
                {{ getUserInitials() }}
              </div>
              <div>
                <div class="text-sm font-medium text-gray-900">{{ user.name || user.email }}</div>
                <div class="text-sm text-gray-500">{{ user.email }}</div>
              </div>
            </div>
          </div>
          <router-link 
            to="/profile" 
            class="block px-3 py-2 text-gray-700 hover:text-red-600 hover:bg-gray-50 rounded-md"
            @click="closeMobileMenu"
          >
            {{ $t('nav.profile') }}
          </router-link>
          <router-link 
            to="/my-reports" 
            class="block px-3 py-2 text-gray-700 hover:text-red-600 hover:bg-gray-50 rounded-md"
            @click="closeMobileMenu"
          >
            {{ $t('nav.myReports') }}
          </router-link>
          <router-link 
            to="/my-activity" 
            class="block px-3 py-2 text-gray-700 hover:text-red-600 hover:bg-gray-50 rounded-md"
            @click="closeMobileMenu"
          >
            {{ $t('nav.myActivity') }}
          </router-link>
          <button 
            @click="logout"
            class="block w-full text-left px-3 py-2 text-gray-700 hover:text-red-600 hover:bg-gray-50 rounded-md"
          >
            {{ $t('nav.logout') }}
          </button>
        </div>
        
        <!-- Mobile Guest Actions -->
        <div v-else class="pt-4 border-t border-gray-200 space-y-1">
          <router-link 
            to="/login" 
            class="block px-3 py-2 text-gray-700 hover:text-red-600 hover:bg-gray-50 rounded-md"
            @click="closeMobileMenu"
          >
            {{ $t('nav.login') }}
          </router-link>
          <router-link 
            to="/register" 
            class="block px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
            @click="closeMobileMenu"
          >
            {{ $t('nav.register') }}
          </router-link>
        </div>
      </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import LanguageSwitcher from './LanguageSwitcher.vue'

const router = useRouter()
const authStore = useAuthStore()

// Reactive state
const showMobileMenu = ref(false)

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

// Methods
const toggleMobileMenu = () => {
  showMobileMenu.value = !showMobileMenu.value
}

const closeMobileMenu = () => {
  showMobileMenu.value = false
}

const getUserInitials = () => {
  if (!user.value) return 'U'
  
  const name = user.value.name || user.value.email || 'User'
  const words = name.split(' ')
  
  if (words.length >= 2) {
    return (words[0][0] + words[1][0]).toUpperCase()
  }
  
  return name[0].toUpperCase()
}

const logout = () => {
  authStore.logout()
  closeMobileMenu()
  router.push('/login')
}

// Close menu when clicking outside
const handleClickOutside = (event) => {
  if (!event.target.closest('.relative') && !event.target.closest('.fixed')) {
    showMobileMenu.value = false
  }
}

// Lifecycle
onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>
