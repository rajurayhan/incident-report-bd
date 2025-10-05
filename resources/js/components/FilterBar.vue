<template>
  <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <!-- Compact Filter Bar -->
    <div class="p-4">
      <div class="flex flex-wrap items-center gap-3">
        <!-- Filter Icon & Title -->
        <div class="flex items-center gap-2 text-gray-700 font-medium">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
          </svg>
          <span class="text-sm">Filters</span>
        </div>

        <!-- Active Filter Count Badge -->
        <div v-if="activeFilterCount > 0" class="flex items-center gap-2">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
            {{ activeFilterCount }} active
          </span>
        </div>

        <!-- Quick Filters -->
        <div class="flex flex-wrap items-center gap-2 flex-1">
          <!-- Category -->
          <div class="relative">
            <select 
              v-model="localFilters.category" 
              @change="handleFilterChange"
              class="appearance-none pl-9 pr-8 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white hover:border-gray-400 transition-colors"
              :class="localFilters.category ? 'border-blue-500 bg-blue-50' : ''"
            >
              <option value="">Category</option>
              <option value="theft_robbery">🔒 Theft / Robbery</option>
              <option value="sexual_harassment">🚫 Sexual Harassment</option>
              <option value="domestic_violence">🏠 Domestic Violence</option>
              <option value="suspicious_activities">👁️ Suspicious Activities</option>
              <option value="traffic_accidents">🚗 Traffic Accidents</option>
              <option value="drugs">💊 Drugs</option>
              <option value="cybercrime">💻 Cybercrime</option>
            </select>
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
          </div>

          <!-- Status -->
          <div class="relative">
            <select 
              v-model="localFilters.status" 
              @change="handleFilterChange"
              class="appearance-none pl-9 pr-8 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white hover:border-gray-400 transition-colors"
              :class="localFilters.status ? 'border-blue-500 bg-blue-50' : ''"
            >
              <option value="">Status</option>
              <option value="pending">⏳ Pending</option>
              <option value="in_progress">🔄 In Progress</option>
              <option value="resolved">✅ Resolved</option>
            </select>
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
          </div>

          <!-- Verified Toggle -->
          <label class="inline-flex items-center gap-2 px-3 py-2 border border-gray-300 rounded-lg text-sm cursor-pointer hover:bg-gray-50 transition-colors"
                 :class="localFilters.verified ? 'border-green-500 bg-green-50' : ''">
            <input 
              type="checkbox" 
              v-model="localFilters.verified" 
              @change="handleFilterChange"
              class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
            >
            <svg class="w-4 h-4" :class="localFilters.verified ? 'text-green-600' : 'text-gray-400'" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span :class="localFilters.verified ? 'text-green-700 font-medium' : 'text-gray-700'">Verified</span>
          </label>

          <!-- More Filters Toggle -->
          <button 
            @click="showAdvanced = !showAdvanced"
            class="inline-flex items-center gap-2 px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition-colors"
            :class="showAdvanced ? 'bg-gray-50 border-gray-400' : ''"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
            </svg>
            <span>{{ showAdvanced ? 'Less' : 'More' }}</span>
            <svg class="w-4 h-4 transition-transform" :class="showAdvanced ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>
        </div>

        <!-- Clear Button -->
        <button 
          v-if="hasActiveFilters"
          @click="clearFilters"
          class="inline-flex items-center gap-1.5 px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
          Clear
        </button>
      </div>
    </div>

    <!-- Advanced Filters (Collapsible) -->
    <div v-if="showAdvanced" class="border-t border-gray-200 bg-gray-50 p-4">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
        <!-- Location Section -->
        <div class="space-y-2">
          <label class="text-xs font-medium text-gray-700 flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            </svg>
            Location
          </label>
          <select 
            v-model="localFilters.division" 
            @change="onDivisionChange"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
          >
            <option value="">All Divisions</option>
            <option v-for="division in divisions" :key="division" :value="division">
              {{ division }}
            </option>
          </select>
        </div>

        <div class="space-y-2">
          <label class="text-xs font-medium text-gray-700 flex items-center gap-1 opacity-50">
            District
          </label>
          <select 
            v-model="localFilters.district" 
            @change="onDistrictChange"
            :disabled="!localFilters.division"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white disabled:bg-gray-100 disabled:cursor-not-allowed"
          >
            <option value="">All Districts</option>
            <option v-for="district in availableDistricts" :key="district" :value="district">
              {{ district }}
            </option>
          </select>
        </div>

        <!-- Date Range Section -->
        <div class="space-y-2">
          <label class="text-xs font-medium text-gray-700 flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            From Date
          </label>
          <input 
            type="date" 
            v-model="localFilters.date_from" 
            @change="handleFilterChange"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
          />
        </div>

        <div class="space-y-2">
          <label class="text-xs font-medium text-gray-700 flex items-center gap-1">
            To Date
          </label>
          <input 
            type="date" 
            v-model="localFilters.date_to" 
            @change="handleFilterChange"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
import { getDivisions, getDistricts } from '../data/bangladesh-locations'

const props = defineProps({
  filters: {
    type: Object,
    default: () => ({
      category: '',
      status: '',
      verified: false,
      division: '',
      district: '',
      date_from: '',
      date_to: ''
    })
  }
})

const emit = defineEmits(['filter-change'])

const localFilters = ref({ 
  category: '',
  status: '',
  verified: false,
  division: '',
  district: '',
  date_from: '',
  date_to: '',
  ...props.filters 
})

const showAdvanced = ref(false)

// Location data
const divisions = ref(getDivisions())

const availableDistricts = computed(() => {
  if (!localFilters.value.division) return []
  return getDistricts(localFilters.value.division)
})

const hasActiveFilters = computed(() => {
  return localFilters.value.category !== '' ||
         localFilters.value.status !== '' ||
         localFilters.value.verified !== false ||
         localFilters.value.division !== '' ||
         localFilters.value.district !== '' ||
         localFilters.value.date_from !== '' ||
         localFilters.value.date_to !== ''
})

const activeFilterCount = computed(() => {
  let count = 0
  if (localFilters.value.category) count++
  if (localFilters.value.status) count++
  if (localFilters.value.verified) count++
  if (localFilters.value.division) count++
  if (localFilters.value.district) count++
  if (localFilters.value.date_from) count++
  if (localFilters.value.date_to) count++
  return count
})

const onDivisionChange = () => {
  localFilters.value.district = ''
  handleFilterChange()
}

const onDistrictChange = () => {
  handleFilterChange()
}

const handleFilterChange = () => {
  emit('filter-change', localFilters.value)
}

const clearFilters = () => {
  localFilters.value = {
    category: '',
    status: '',
    verified: false,
    division: '',
    district: '',
    date_from: '',
    date_to: ''
  }
  handleFilterChange()
}

// Watch for external changes to filters
watch(() => props.filters, (newFilters) => {
  localFilters.value = { ...localFilters.value, ...newFilters }
}, { deep: true })
</script>
