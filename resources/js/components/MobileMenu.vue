<template>
  <div class="relative">
    <button 
      @click="toggleMobileMenu"
      class="text-gray-700 hover:text-red-600 p-2 rounded-md transition-colors duration-200"
    >
      <svg v-if="!showMobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
      <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </button>
    
    <!-- Mobile Navigation Menu -->
    <div v-if="showMobileMenu" class="absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
      <div class="px-2 pt-2 pb-3 space-y-1">
        <!-- Mobile Navigation Links -->
        <router-link 
          v-for="item in navigationItems" 
          :key="item.name"
          :to="item.to" 
          class="block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200"
          :class="$route.name === item.routeName ? 'text-red-600 bg-red-50' : 'text-gray-700 hover:text-red-600 hover:bg-gray-50'"
          @click="closeMobileMenu"
        >
          {{ item.label }}
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
            Profile
          </router-link>
          <router-link 
            to="/my-reports" 
            class="block px-3 py-2 text-gray-700 hover:text-red-600 hover:bg-gray-50 rounded-md"
            @click="closeMobileMenu"
          >
            My Reports
          </router-link>
          <router-link 
            to="/my-activity" 
            class="block px-3 py-2 text-gray-700 hover:text-red-600 hover:bg-gray-50 rounded-md"
            @click="closeMobileMenu"
          >
            My Activity
          </router-link>
          <button 
            @click="logout"
            class="block w-full text-left px-3 py-2 text-gray-700 hover:text-red-600 hover:bg-gray-50 rounded-md"
          >
            Logout
          </button>
        </div>
        
        <!-- Mobile Guest Actions -->
        <div v-else class="pt-4 border-t border-gray-200 space-y-1">
          <router-link 
            to="/login" 
            class="block px-3 py-2 text-gray-700 hover:text-red-600 hover:bg-gray-50 rounded-md"
            @click="closeMobileMenu"
          >
            Login
          </router-link>
          <router-link 
            to="/register" 
            class="block px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
            @click="closeMobileMenu"
          >
            Register
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

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
  {
    name: 'map',
    label: 'Map',
    to: '/map',
    routeName: 'map'
  },
  {
    name: 'analytics',
    label: 'Analytics',
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
  if (!event.target.closest('.relative')) {
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
