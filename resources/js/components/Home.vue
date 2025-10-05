<template>
  <div class="space-y-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-red-600 to-red-800 text-white rounded-lg p-8">
      <div class="max-w-3xl">
        <h1 class="text-4xl font-bold mb-4">
          Report Incidents, Keep Communities Safe
        </h1>
        <p class="text-xl mb-6">
          A community-driven platform for reporting and tracking incidents across Bangladesh. 
          Help keep your neighborhood safe by reporting incidents and staying informed.
        </p>
        <div class="flex space-x-4">
          <router-link 
            to="/report" 
            class="bg-white text-red-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors"
          >
            Report Incident
          </router-link>
          <router-link 
            to="/map" 
            class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-red-600 transition-colors"
          >
            View Map
          </router-link>
        </div>
      </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      <StatsCard 
        label="Total Reports" 
        :value="stats.totalReports"
        icon-bg-class="bg-red-100"
      >
        <template #icon>
          <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
          </svg>
        </template>
      </StatsCard>

      <StatsCard 
        label="Verified Reports" 
        :value="stats.verifiedReports"
        icon-bg-class="bg-green-100"
      >
        <template #icon>
          <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </template>
      </StatsCard>

      <StatsCard 
        label="Active Users" 
        :value="stats.activeUsers"
        icon-bg-class="bg-blue-100"
      >
        <template #icon>
          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
        </template>
      </StatsCard>

      <StatsCard 
        label="Resolved Today" 
        :value="stats.resolvedToday"
        icon-bg-class="bg-yellow-100"
      >
        <template #icon>
          <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </template>
      </StatsCard>
    </div>

    <!-- Recent Incidents -->
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
          <h2 class="text-xl font-semibold text-gray-900">Recent Incidents</h2>
          <router-link 
            to="/map" 
            class="text-red-600 hover:text-red-700 font-medium"
          >
            View All
          </router-link>
        </div>
      </div>
      
      <div v-if="loading" class="p-6">
        <div class="animate-pulse space-y-4">
          <div v-for="i in 3" :key="i" class="flex space-x-4">
            <div class="rounded-full bg-gray-200 h-10 w-10"></div>
            <div class="flex-1 space-y-2 py-1">
              <div class="h-4 bg-gray-200 rounded w-3/4"></div>
              <div class="h-4 bg-gray-200 rounded w-1/2"></div>
            </div>
          </div>
        </div>
      </div>

      <div v-else-if="recentIncidents.length === 0" class="p-6 text-center text-gray-500">
        No incidents reported yet. Be the first to report an incident!
      </div>

      <div v-else class="divide-y divide-gray-200">
        <div 
          v-for="incident in recentIncidents" 
          :key="incident.id"
          class="p-6 hover:bg-gray-50 transition-colors cursor-pointer"
          @click="$router.push(`/incident/${incident.id}`)"
        >
          <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
              <div 
                class="w-10 h-10 rounded-full flex items-center justify-center text-white font-semibold"
                :class="getCategoryColor(incident.category)"
              >
                {{ getCategoryIcon(incident.category) }}
              </div>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900 truncate">
                  {{ incident.title }}
                </h3>
                <div class="flex items-center space-x-2">
                  <span 
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                    :class="getStatusColor(incident.status)"
                  >
                    {{ incident.status_label }}
                  </span>
                  <span v-if="incident.is_verified" class="text-green-600">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                  </span>
                </div>
              </div>
              <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                {{ incident.description }}
              </p>
              <div class="mt-2 flex items-center text-sm text-gray-500 space-x-4">
                <span>{{ incident.category_label }}</span>
                <span>{{ formatDate(incident.created_at) }}</span>
                <span v-if="incident.city">{{ incident.city }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Categories -->
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-900">Report Categories</h2>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <div 
            v-for="category in categories" 
            :key="category.value"
            class="p-4 border border-gray-200 rounded-lg hover:border-red-300 hover:bg-red-50 transition-colors cursor-pointer"
            @click="filterByCategory(category.value)"
          >
            <div class="flex items-center space-x-3">
              <div 
                class="w-8 h-8 rounded-full flex items-center justify-center text-white font-semibold"
                :class="`bg-${category.color}-500`"
              >
                {{ getCategoryIcon(category.value) }}
              </div>
              <span class="font-medium text-gray-900">{{ category.label }}</span>
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
import StatsCard from './StatsCard.vue';

const incidentStore = useIncidentStore();
const router = useRouter();

const stats = ref({
  totalReports: 0,
  verifiedReports: 0,
  activeUsers: 0,
  resolvedToday: 0,
});

const recentIncidents = ref([]);
const loading = ref(true);

const { categories } = incidentStore;

onMounted(async () => {
  try {
    await incidentStore.fetchIncidents({ limit: 5 });
    recentIncidents.value = incidentStore.incidents;
    
    // Fetch stats (you'll need to create this API endpoint)
    // const statsResponse = await axios.get('/api/stats');
    // stats.value = statsResponse.data;
  } catch (error) {
    console.error('Error fetching data:', error);
  } finally {
    loading.value = false;
  }
});

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
