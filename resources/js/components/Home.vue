<template>
  <div class="space-y-12">
    <!-- Hero Section - Modern & Minimal -->
    <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-red-900 to-slate-900 text-white rounded-2xl">
      <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:20px_20px]"></div>
      <div class="relative z-10 px-8 py-16 md:py-24">
        <div class="max-w-4xl mx-auto text-center">
          <div class="inline-flex items-center px-4 py-2 bg-red-500/20 backdrop-blur-sm border border-red-400/30 rounded-full text-sm font-medium mb-8">
            <span class="mr-2">🚨</span>
            Community Safety Platform
          </div>
          <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
            Report Incidents,<br/>
            <span class="bg-gradient-to-r from-red-400 to-orange-400 bg-clip-text text-transparent">
              Keep Communities Safe
            </span>
          </h1>
          <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto">
            A community-driven platform for reporting and tracking incidents across Bangladesh. 
            Help keep your neighborhood safe.
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <router-link 
              to="/report" 
              class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-red-600 rounded-xl overflow-hidden transition-all duration-300 hover:bg-red-700 hover:shadow-lg hover:shadow-red-500/50 hover:scale-105"
            >
              <span class="relative z-10 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                Report Incident
              </span>
            </router-link>
            <router-link 
              to="/map" 
              class="group inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white border-2 border-white/30 backdrop-blur-sm rounded-xl transition-all duration-300 hover:bg-white/10 hover:border-white hover:scale-105"
            >
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
              </svg>
              View Map
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <!-- Incidents Near You -->
    <div v-if="userLocation && nearbyIncidents.length > 0" class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 border border-blue-100">
      <div class="flex justify-between items-center mb-6">
        <div>
          <h2 class="text-2xl font-bold text-gray-900">Incidents Near You</h2>
          <p class="text-sm text-gray-600 mt-1">Reports within {{ radiusKm }}km of your location</p>
        </div>
        <button 
          @click="refreshNearbyIncidents"
          class="inline-flex items-center px-4 py-2 text-sm font-semibold text-blue-600 hover:text-blue-700 hover:bg-blue-100 rounded-lg transition-colors"
        >
          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
          </svg>
          Refresh
        </button>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <router-link 
          v-for="incident in nearbyIncidents.slice(0, 4)" 
          :key="incident.id"
          :to="`/incident/${incident.id}`"
          class="group bg-white p-4 rounded-xl hover:shadow-md transition-all duration-200 border border-blue-100 hover:border-blue-300"
        >
          <div class="flex items-start space-x-3">
            <div 
              class="w-10 h-10 rounded-lg flex items-center justify-center text-white text-lg flex-shrink-0 group-hover:scale-110 transition-transform"
              :class="getCategoryColor(incident.category)"
            >
              {{ getCategoryIcon(incident.category) }}
            </div>
            <div class="flex-1 min-w-0">
              <h4 class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-1 mb-1">
                {{ incident.title }}
              </h4>
              <p class="text-xs text-gray-600 line-clamp-2 mb-2">
                {{ incident.description }}
              </p>
              <div class="flex items-center justify-between text-xs">
                <span class="text-blue-600 font-medium">
                  📍 {{ incident.distance ? `${incident.distance} km away` : incident.city }}
                </span>
                <span 
                  class="px-2 py-0.5 rounded-full font-medium"
                  :class="getStatusColor(incident.status)"
                >
                  {{ incident.status_label }}
                </span>
              </div>
            </div>
          </div>
        </router-link>
      </div>
      <div v-if="nearbyIncidents.length > 4" class="mt-4 text-center">
        <router-link 
          to="/map" 
          class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-700"
        >
          View all {{ nearbyIncidents.length }} nearby incidents
          <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
        </router-link>
      </div>
    </div>

    <!-- Location Request Banner -->
    <div v-else-if="!userLocation && !locationDenied && !loadingLocation" class="bg-white rounded-2xl p-8 border border-gray-200 text-center">
      <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
      </div>
      <h3 class="text-xl font-bold text-gray-900 mb-2">See Incidents Near You</h3>
      <p class="text-gray-600 mb-6">Allow location access to view incidents happening in your area</p>
      <button 
        @click="requestLocation"
        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors"
      >
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
        </svg>
        Enable Location
      </button>
    </div>

    <!-- Quick Stats - Modern Design -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <!-- Total Reports -->
      <div class="group relative bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-red-200">
        <div class="flex items-start justify-between mb-4">
          <div class="p-3 bg-red-50 rounded-xl group-hover:bg-red-100 transition-colors">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
          </div>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ stats.totalReports }}</h3>
        <p class="text-sm text-gray-600">Total Reports</p>
      </div>

      <!-- Verified Reports -->
      <div class="group relative bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-green-200">
        <div class="flex items-start justify-between mb-4">
          <div class="p-3 bg-green-50 rounded-xl group-hover:bg-green-100 transition-colors">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ stats.verifiedReports }}</h3>
        <p class="text-sm text-gray-600">Verified Reports</p>
      </div>

      <!-- Active Locations -->
      <div class="group relative bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-blue-200">
        <div class="flex items-start justify-between mb-4">
          <div class="p-3 bg-blue-50 rounded-xl group-hover:bg-blue-100 transition-colors">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
          </div>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ stats.activeUsers }}</h3>
        <p class="text-sm text-gray-600">Active Locations</p>
      </div>

      <!-- Resolved Today -->
      <div class="group relative bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-yellow-200">
        <div class="flex items-start justify-between mb-4">
          <div class="p-3 bg-yellow-50 rounded-xl group-hover:bg-yellow-100 transition-colors">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ stats.resolvedToday }}</h3>
        <p class="text-sm text-gray-600">Resolved Today</p>
      </div>
    </div>

    <!-- Recent Incidents - Modern Design -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
      <div class="px-8 py-6 border-b border-gray-100">
        <div class="flex justify-between items-center">
          <div>
            <h2 class="text-2xl font-bold text-gray-900">Recent Incidents</h2>
            <p class="text-sm text-gray-600 mt-1">Latest reports from your community</p>
          </div>
          <router-link 
            to="/map" 
            class="inline-flex items-center px-4 py-2 text-sm font-semibold text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors"
          >
            View All
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </router-link>
        </div>
      </div>
      
      <div v-if="loading" class="p-8">
        <div class="animate-pulse space-y-6">
          <div v-for="i in 3" :key="i" class="flex space-x-4">
            <div class="rounded-xl bg-gray-200 h-12 w-12"></div>
            <div class="flex-1 space-y-3 py-1">
              <div class="h-5 bg-gray-200 rounded w-3/4"></div>
              <div class="h-4 bg-gray-200 rounded w-1/2"></div>
            </div>
          </div>
        </div>
      </div>

      <div v-else-if="recentIncidents.length === 0" class="p-12 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
          <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <p class="text-gray-500 font-medium">No incidents reported yet</p>
        <p class="text-sm text-gray-400 mt-1">Be the first to report an incident!</p>
      </div>

      <div v-else class="divide-y divide-gray-100">
        <div 
          v-for="incident in recentIncidents" 
          :key="incident.id"
          class="p-6 hover:bg-gray-50 transition-all duration-200 cursor-pointer group"
          @click="$router.push(`/incident/${incident.id}`)"
        >
          <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
              <div 
                class="w-12 h-12 rounded-xl flex items-center justify-center text-white text-xl shadow-sm group-hover:scale-110 transition-transform"
                :class="getCategoryColor(incident.category)"
              >
                {{ getCategoryIcon(incident.category) }}
              </div>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-start justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-red-600 transition-colors">
                  {{ incident.title }}
                </h3>
                <div class="flex items-center gap-2 flex-shrink-0">
                  <span 
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium"
                    :class="getStatusColor(incident.status)"
                  >
                    {{ incident.status_label }}
                  </span>
                  <span v-if="incident.is_verified" class="flex items-center justify-center w-6 h-6 bg-green-100 rounded-full">
                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                  </span>
                </div>
              </div>
              <p class="mt-2 text-sm text-gray-600 line-clamp-2 leading-relaxed">
                {{ incident.description }}
              </p>
              <div class="mt-3 flex items-center text-xs text-gray-500 gap-4">
                <span class="inline-flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                  </svg>
                  {{ incident.category_label }}
                </span>
                <span class="inline-flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  {{ formatDate(incident.created_at) }}
                </span>
                <span v-if="incident.city" class="inline-flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  </svg>
                  {{ incident.city }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Categories - Modern Grid -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
      <div class="px-8 py-6 border-b border-gray-100">
        <h2 class="text-2xl font-bold text-gray-900">Report Categories</h2>
        <p class="text-sm text-gray-600 mt-1">Browse incidents by category</p>
      </div>
      <div class="p-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <div 
            v-for="category in categories" 
            :key="category.value"
            class="group p-5 border-2 border-gray-100 rounded-xl hover:border-red-300 hover:bg-red-50 transition-all duration-200 cursor-pointer hover:shadow-md"
            @click="filterByCategory(category.value)"
          >
            <div class="flex items-center space-x-3">
              <div 
                class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-lg shadow-sm group-hover:scale-110 transition-transform"
                :class="`bg-${category.color}-500`"
              >
                {{ getCategoryIcon(category.value) }}
              </div>
              <span class="font-semibold text-gray-900 group-hover:text-red-600 transition-colors">{{ category.label }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useIncidentStore } from '../stores/incidents';
import { useRouter } from 'vue-router';

const incidentStore = useIncidentStore();
const router = useRouter();

const stats = ref({
  totalReports: 0,
  verifiedReports: 0,
  activeUsers: 0,
  resolvedToday: 0,
});

const recentIncidents = ref([]);
const nearbyIncidents = ref([]);
const loading = ref(true);
const loadingLocation = ref(false);
const locationDenied = ref(false);
const userLocation = ref(null);
const radiusKm = 10;

const { categories } = incidentStore;

onMounted(async () => {
  try {
    // Fetch recent incidents
    await incidentStore.fetchIncidents({ limit: 5 });
    recentIncidents.value = incidentStore.incidents;
    
    // Fetch stats
    fetchStats();
    
    // Try to get user location (silently, don't prompt initially)
    if (localStorage.getItem('userLocation')) {
      const savedLocation = JSON.parse(localStorage.getItem('userLocation'));
      userLocation.value = savedLocation;
      fetchNearbyIncidents();
    }
  } catch (error) {
    console.error('Error fetching data:', error);
  } finally {
    loading.value = false;
  }
});

const fetchStats = async () => {
  try {
    const response = await fetch('/api/analytics/stats');
    if (response.ok) {
      const data = await response.json();
      stats.value = {
        totalReports: data.totalReports || 0,
        verifiedReports: data.verifiedReports || 0,
        activeUsers: data.activeLocations || 0,
        resolvedToday: data.resolvedToday || 0,
      };
    }
  } catch (error) {
    console.error('Error fetching stats:', error);
  }
};

const requestLocation = () => {
  loadingLocation.value = true;
  
  if (!navigator.geolocation) {
    alert('Geolocation is not supported by your browser');
    loadingLocation.value = false;
    return;
  }

  navigator.geolocation.getCurrentPosition(
    (position) => {
      userLocation.value = {
        latitude: position.coords.latitude,
        longitude: position.coords.longitude,
      };
      
      // Save to localStorage
      localStorage.setItem('userLocation', JSON.stringify(userLocation.value));
      
      fetchNearbyIncidents();
      loadingLocation.value = false;
    },
    (error) => {
      console.error('Error getting location:', error);
      locationDenied.value = true;
      loadingLocation.value = false;
    }
  );
};

const fetchNearbyIncidents = async () => {
  if (!userLocation.value) return;
  
  try {
    const params = new URLSearchParams({
      latitude: userLocation.value.latitude.toString(),
      longitude: userLocation.value.longitude.toString(),
      per_page: '6',
    });
    
    const response = await fetch(`/api/incidents?${params}`);
    if (response.ok) {
      const data = await response.json();
      nearbyIncidents.value = data.data || [];
    }
  } catch (error) {
    console.error('Error fetching nearby incidents:', error);
  }
};

const refreshNearbyIncidents = () => {
  fetchNearbyIncidents();
};

const getCategoryColor = (category) => {
  const categoryData = categories.find(c => c.value === category);
  return categoryData ? `bg-${categoryData.color}-500` : 'bg-gray-500';
};

const getCategoryIcon = (category) => {
  const icons = {
    theft_robbery: '🔒',
    sexual_harassment: '🚫',
    domestic_violence: '🏠',
    suspicious_activities: '👁️',
    traffic_accidents: '🚗',
    drugs: '💊',
    cybercrime: '💻',
  };
  return icons[category] || '⚠️';
};

const getStatusColor = (status) => {
  const colors = {
    pending: 'bg-yellow-100 text-yellow-800',
    in_progress: 'bg-blue-100 text-blue-800',
    resolved: 'bg-green-100 text-green-800',
  };
  return colors[status] || 'bg-gray-100 text-gray-800';
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-BD', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
};

const filterByCategory = (category) => {
  incidentStore.setFilters({ category });
  router.push('/map');
};
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
