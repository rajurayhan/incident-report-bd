<template>
  <div class="relative">
    <button 
      @click="toggleUserMenu"
      class="flex items-center space-x-2 text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200"
    >
      <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
        {{ getUserInitials() }}
      </div>
      <span>{{ user.name || user.email }}</span>
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
      </svg>
    </button>
    
    <!-- Dropdown Menu -->
    <div v-if="showUserMenu" 
         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
      <router-link 
        to="/profile" 
        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
        @click="closeUserMenu"
      >
        {{ $t('nav.profile') }}
      </router-link>
      <router-link 
        to="/my-reports" 
        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
        @click="closeUserMenu"
      >
        {{ $t('nav.myReports') }}
      </router-link>
      <router-link 
        to="/my-activity" 
        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
        @click="closeUserMenu"
      >
        {{ $t('nav.myActivity') }}
      </router-link>
      <div class="border-t border-gray-200"></div>
      <button 
        @click="logout"
        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
      >
        {{ $t('nav.logout') }}
      </button>
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
const showUserMenu = ref(false)

// Computed properties
const user = computed(() => authStore.user)

// Methods
const toggleUserMenu = () => {
  showUserMenu.value = !showUserMenu.value
}

const closeUserMenu = () => {
  showUserMenu.value = false
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
  closeUserMenu()
  router.push('/login')
}

// Close menu when clicking outside
const handleClickOutside = (event) => {
  if (!event.target.closest('.relative')) {
    showUserMenu.value = false
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
