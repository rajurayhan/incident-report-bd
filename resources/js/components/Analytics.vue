<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ $t('analytics.title') }}</h1>
        <p class="mt-2 text-gray-600">{{ $t('analytics.subtitle') }}</p>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center py-12">
        <svg class="animate-spin h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
      </div>

      <div v-else>
        <!-- Main Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-blue-100 text-sm font-medium">{{ $t('analytics.totalReports') }}</p>
                <p class="text-4xl font-bold mt-2">{{ stats.totalReports }}</p>
                <p class="text-blue-100 text-xs mt-2">{{ $t('analytics.allTimeSubmissions') }}</p>
              </div>
              <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <span class="text-3xl">📊</span>
              </div>
            </div>
          </div>

          <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-green-100 text-sm font-medium">{{ $t('analytics.verifiedReports') }}</p>
                <p class="text-4xl font-bold mt-2">{{ stats.verifiedReports }}</p>
                <p class="text-green-100 text-xs mt-2">{{ verificationRate }}% {{ $t('analytics.verificationRate') }}</p>
              </div>
              <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <span class="text-3xl">✅</span>
              </div>
            </div>
          </div>

          <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-purple-100 text-sm font-medium">{{ $t('analytics.activeLocations') }}</p>
                <p class="text-4xl font-bold mt-2">{{ stats.activeLocations }}</p>
                <p class="text-purple-100 text-xs mt-2">{{ $t('analytics.districtsWithReports') }}</p>
              </div>
              <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <span class="text-3xl">📍</span>
              </div>
            </div>
          </div>

          <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-orange-100 text-sm font-medium">{{ $t('analytics.resolvedToday') }}</p>
                <p class="text-4xl font-bold mt-2">{{ stats.resolvedToday }}</p>
                <p class="text-orange-100 text-xs mt-2">{{ $t('analytics.casesClosedToday') }}</p>
              </div>
              <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <span class="text-3xl">🎯</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Category & Status Breakdown -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
          <!-- Category Breakdown -->
          <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">{{ $t('analytics.reportsByCategory') }}</h2>
            <div class="space-y-4">
              <div v-for="category in categoryBreakdown" :key="category.name" class="flex items-center justify-between">
                <div class="flex items-center space-x-3 flex-1">
                  <span class="text-2xl">{{ category.icon }}</span>
                  <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                      <span class="text-sm font-medium text-gray-700">{{ category.label }}</span>
                      <span class="text-sm font-semibold text-gray-900">{{ category.count }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                      <div
                        class="h-2 rounded-full transition-all"
                        :class="category.colorClass"
                        :style="{ width: `${category.percentage}%` }"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Status Breakdown -->
          <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">{{ $t('analytics.reportsByStatus') }}</h2>
            <div class="space-y-4">
              <div v-for="status in statusBreakdown" :key="status.name" class="flex items-center justify-between">
                <div class="flex items-center space-x-3 flex-1">
                  <span class="text-2xl">{{ status.icon }}</span>
                  <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                      <span class="text-sm font-medium text-gray-700">{{ status.label }}</span>
                      <span class="text-sm font-semibold text-gray-900">{{ status.count }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                      <div
                        class="h-2 rounded-full transition-all"
                        :class="status.colorClass"
                        :style="{ width: `${status.percentage}%` }"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Top Locations -->
        <div class="bg-white rounded-lg shadow-md p-6">
          <h2 class="text-xl font-bold text-gray-900 mb-6">{{ $t('analytics.topLocations') }}</h2>
          <div v-if="topLocations.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div
              v-for="location in topLocations"
              :key="location.district"
              class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition"
            >
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                  <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-sm font-semibold text-gray-900">{{ location.district }}</p>
                    <p class="text-xs text-gray-500">{{ location.division }}</p>
                  </div>
                </div>
                <span class="text-lg font-bold text-red-600">{{ location.count }}</span>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-8 text-gray-500">
            <p>{{ $t('analytics.noLocationData') }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useI18n } from 'vue-i18n'

// I18n
const { t } = useI18n()

// Reactive state
const loading = ref(true)
const stats = ref({
  totalReports: 0,
  verifiedReports: 0,
  activeLocations: 0,
  resolvedToday: 0
})
const analytics = ref({
  byCategory: {},
  byStatus: {},
  topLocations: []
})

// Computed
const verificationRate = computed(() => {
  if (stats.value.totalReports === 0) return 0
  return Math.round((stats.value.verifiedReports / stats.value.totalReports) * 100)
})

const categoryBreakdown = computed(() => {
  const categories = [
    { name: 'theft_robbery', label: t('analytics.categories.theftRobbery'), icon: '🔪', colorClass: 'bg-red-500' },
    { name: 'sexual_harassment', label: t('analytics.categories.sexualHarassment'), icon: '⚠️', colorClass: 'bg-pink-500' },
    { name: 'domestic_violence', label: t('analytics.categories.domesticViolence'), icon: '🏠', colorClass: 'bg-purple-500' },
    { name: 'suspicious_activities', label: t('analytics.categories.suspiciousActivities'), icon: '👀', colorClass: 'bg-yellow-500' },
    { name: 'traffic_accidents', label: t('analytics.categories.trafficAccidents'), icon: '🚗', colorClass: 'bg-orange-500' },
    { name: 'drugs', label: t('analytics.categories.drugs'), icon: '💊', colorClass: 'bg-green-500' },
    { name: 'cybercrime', label: t('analytics.categories.cybercrime'), icon: '💻', colorClass: 'bg-blue-500' }
  ]

  return categories.map(cat => {
    const count = analytics.value.byCategory[cat.name] || 0
    const percentage = stats.value.totalReports > 0 
      ? (count / stats.value.totalReports) * 100 
      : 0
    return { ...cat, count, percentage }
  })
})

const statusBreakdown = computed(() => {
  const statuses = [
    { name: 'pending', label: t('analytics.statuses.pending'), icon: '⏳', colorClass: 'bg-yellow-500' },
    { name: 'in_progress', label: t('analytics.statuses.inProgress'), icon: '🔍', colorClass: 'bg-blue-500' },
    { name: 'resolved', label: t('analytics.statuses.resolved'), icon: '✅', colorClass: 'bg-green-500' }
  ]

  return statuses.map(status => {
    const count = analytics.value.byStatus[status.name] || 0
    const percentage = stats.value.totalReports > 0 
      ? (count / stats.value.totalReports) * 100 
      : 0
    return { ...status, count, percentage }
  })
})

const topLocations = computed(() => {
  return analytics.value.topLocations || []
})

// Methods
const fetchAnalytics = async () => {
  loading.value = true
  try {
    // Fetch main stats
    const statsResponse = await fetch('/api/analytics/stats')
    if (statsResponse.ok) {
      const statsData = await statsResponse.json()
      console.log('Stats data:', statsData)
      stats.value = statsData
    }

    // Fetch detailed analytics
    const analyticsResponse = await fetch('/api/analytics/detailed')
    if (analyticsResponse.ok) {
      const analyticsData = await analyticsResponse.json()
      console.log('Analytics data:', analyticsData)
      analytics.value = analyticsData
    }
  } catch (error) {
    console.error('Error fetching analytics:', error)
  } finally {
    loading.value = false
  }
}

// Lifecycle
onMounted(() => {
  fetchAnalytics()
})
</script>
