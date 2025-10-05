<template>
  <div id="app" class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <router-link to="/" class="flex items-center">
              <div class="flex-shrink-0">
                <h1 class="text-2xl font-bold text-red-600">IncidentReport</h1>
              </div>
            </router-link>
          </div>
          
          <div class="flex items-center space-x-4">
            <router-link 
              to="/" 
              class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium"
              :class="{ 'text-red-600': $route.name === 'home' }"
            >
              Home
            </router-link>
            <router-link 
              to="/report" 
              class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium"
              :class="{ 'text-red-600': $route.name === 'report' }"
            >
              Report Incident
            </router-link>
            <router-link 
              to="/map" 
              class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium"
              :class="{ 'text-red-600': $route.name === 'map' }"
            >
              Map
            </router-link>
            <router-link 
              to="/analytics" 
              class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium"
              :class="{ 'text-red-600': $route.name === 'analytics' }"
            >
              Analytics
            </router-link>
            
            <div v-if="user" class="flex items-center space-x-2">
              <span class="text-sm text-gray-700">{{ user.name }}</span>
              <button 
                @click="logout"
                class="bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium hover:bg-red-700"
              >
                Logout
              </button>
            </div>
            
            <div v-else class="flex items-center space-x-2">
              <router-link 
                to="/login" 
                class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium"
              >
                Login
              </router-link>
              <router-link 
                to="/register" 
                class="bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium hover:bg-red-700"
              >
                Register
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <router-view />
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h3 class="text-lg font-semibold mb-2">IncidentReport Bangladesh</h3>
          <p class="text-gray-400 mb-4">
            A community-driven platform for reporting and tracking incidents across Bangladesh
          </p>
          <div class="flex justify-center space-x-6">
            <a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a>
            <a href="#" class="text-gray-400 hover:text-white">Terms of Service</a>
            <a href="#" class="text-gray-400 hover:text-white">Contact</a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useAuthStore } from '../stores/auth';

const authStore = useAuthStore();

const user = computed(() => authStore.user);

const logout = () => {
  authStore.logout();
};
</script>
