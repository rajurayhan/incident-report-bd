<template>
  <div class="max-w-full mx-auto space-y-4">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">{{ $t('map.title') }}</h1>
        <p class="text-gray-600 mt-1">{{ $t('map.subtitle') }}</p>
      </div>
      <div class="flex items-center gap-4">
        <!-- View Toggle -->
        <ViewToggle 
          v-model="viewMode"
          :options="viewOptions"
          :label="$t('map.view')"
        />
        
        <!-- Stats -->
        <div class="flex items-center gap-2 px-4 py-2 bg-blue-50 rounded-lg border border-blue-200">
          <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
          </svg>
          <div class="text-sm">
            <span class="font-bold text-gray-900">{{ totalIncidents }}</span>
            <span class="text-gray-600 ml-1">{{ $t('map.incidents') }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <FilterBar 
      :filters="filters"
      @filter-change="handleFilterChange"
    />

    <!-- Main Content Area -->
    <div class="flex gap-6">
      <!-- Left Panel - Incident List -->
      <div class="w-96 bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-900">{{ $t('map.incidentList') }}</h3>
          <p class="text-sm text-gray-600">{{ $t('map.clickToHighlight') }}</p>
        </div>
        
        <div 
          ref="incidentListContainer"
          @scroll="handleScroll"
          class="h-96 overflow-y-auto"
        >
          <!-- Loading State -->
          <div v-if="loading && !loadingMore" class="p-4 text-center">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600 mx-auto"></div>
            <p class="text-gray-600 mt-2">{{ $t('map.loadingIncidents') }}</p>
          </div>
          
          <!-- Incident List -->
          <div v-else-if="incidents.length > 0" class="divide-y divide-gray-200">
            <div 
              v-for="incident in incidents" 
              :key="incident.id"
              @click="selectIncident(incident)"
              :class="[
                'p-4 cursor-pointer transition-colors hover:bg-gray-50',
                selectedIncident?.id === incident.id ? 'bg-blue-50 border-l-4 border-blue-500' : ''
              ]"
            >
              <div class="flex items-start justify-between mb-2">
                <h4 class="font-medium text-gray-900 text-sm line-clamp-2">{{ incident.title }}</h4>
                <div class="flex items-center space-x-1 ml-2">
                  <!-- Priority indicator -->
                  <div 
                    :class="[
                      'w-2 h-2 rounded-full',
                      getPriorityColor(incident.priority)
                    ]"
                  ></div>
                  <!-- Verification indicator -->
                  <div 
                    :class="[
                      'w-2 h-2 rounded-full border border-white',
                      incident.is_verified ? 'bg-blue-500' : 'bg-gray-400'
                    ]"
                  ></div>
                </div>
              </div>
              
              <div class="text-xs text-gray-600 space-y-1">
                <div><strong>{{ getCategoryLabel(incident.category) }}</strong></div>
                <div>{{ getStatusLabel(incident.status) }} • {{ getPriorityLabel(incident.priority) }}</div>
                <div>{{ formatDate(incident.incident_date || incident.created_at) }}</div>
                <div v-if="incident.address || incident.city">
                  📍 {{ incident.address || incident.city }}
                </div>
              </div>
              
              <div class="mt-2 flex items-center justify-between text-xs text-gray-500">
                <span>{{ incident.verification_count }} verifications</span>
                <span v-if="incident.has_media">📎 {{ incident.media_count }} files</span>
              </div>
            </div>
          </div>
          
          <!-- Empty State -->
          <div v-else class="p-4 text-center text-gray-500">
            <p>{{ $t('map.noIncidentsFound') }}</p>
            <p class="text-sm">{{ $t('map.tryAdjustingFilters') }}</p>
          </div>
          
          <!-- Loading More Indicator -->
          <div v-if="loadingMore" class="p-4 text-center">
            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-blue-600 mx-auto"></div>
            <p class="text-gray-600 text-sm mt-2">{{ $t('map.loadingMore') }}</p>
          </div>
          
          <!-- End of Results -->
          <div v-if="!hasMore && incidents.length > 0 && !loading" class="p-4 text-center text-gray-500 text-sm">
            {{ $t('map.noMoreIncidents') }}
          </div>
        </div>
      </div>

      <!-- Right Panel - Map -->
      <div class="flex-1 bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="relative">
          <!-- Loading Overlay -->
          <div v-if="loading" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-10">
            <div class="flex items-center space-x-2">
              <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
              <span class="text-gray-600">{{ $t('map.loadingMap') }}</span>
            </div>
          </div>

          <!-- Map -->
          <div id="map" class="h-96 w-full"></div>
          
          <!-- Map Controls -->
          <div class="absolute top-4 right-4 z-20 space-y-2">
            <button 
              @click="fitToBounds"
              class="bg-white shadow-md rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 block"
            >
              {{ $t('map.fitToData') }}
            </button>
            <button 
              v-if="selectedIncident"
              @click="clearSelection"
              class="bg-white shadow-md rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 block"
            >
              {{ $t('map.clearSelection') }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Legend -->
    <div class="mt-6 bg-white shadow-lg rounded-lg p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $t('map.legend') }}</h3>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="flex items-center space-x-2">
          <div class="w-4 h-4 bg-red-500 rounded-full"></div>
          <span class="text-sm text-gray-600">{{ $t('map.urgent') }}</span>
        </div>
        <div class="flex items-center space-x-2">
          <div class="w-4 h-4 bg-orange-500 rounded-full"></div>
          <span class="text-sm text-gray-600">{{ $t('map.high') }}</span>
        </div>
        <div class="flex items-center space-x-2">
          <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
          <span class="text-sm text-gray-600">{{ $t('map.medium') }}</span>
        </div>
        <div class="flex items-center space-x-2">
          <div class="w-4 h-4 bg-green-500 rounded-full"></div>
          <span class="text-sm text-gray-600">{{ $t('map.low') }}</span>
        </div>
      </div>
      <div class="mt-4 flex items-center space-x-4">
        <div class="flex items-center space-x-2">
          <div class="w-4 h-4 bg-blue-500 rounded-full border-2 border-white"></div>
          <span class="text-sm text-gray-600">{{ $t('map.verified') }}</span>
        </div>
        <div class="flex items-center space-x-2">
          <div class="w-4 h-4 bg-gray-500 rounded-full"></div>
          <span class="text-sm text-gray-600">{{ $t('map.unverified') }}</span>
        </div>
      </div>
      <div class="mt-4 text-sm text-gray-600">
        <p><strong>{{ $t('map.heatMapDescription') }}</strong></p>
        <p><strong>{{ $t('map.markersDescription') }}</strong></p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useI18n } from 'vue-i18n'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'
import 'leaflet.heat'
import ViewToggle from './ViewToggle.vue'
import FilterBar from './FilterBar.vue'

const router = useRouter()
const { t } = useI18n()

// Reactive data
const map = ref(null)
const heatLayer = ref(null)
const incidents = ref([])
const totalIncidents = ref(0)
const loading = ref(false)
const loadingMore = ref(false)
const mapBounds = ref(null)
const viewMode = ref('markers') // 'markers' or 'heatmap'
const selectedIncident = ref(null)
const selectedMarker = ref(null)
const incidentListContainer = ref(null)

// Pagination
const currentPage = ref(1)
const perPage = 20
const hasMore = ref(true)

// Filters
const filters = ref({
  category: '',
  status: '',
  verified: false,
  division: '',
  district: '',
  thana: '',
  date_from: '',
  date_to: ''
})

// View options
const viewOptions = [
  { value: 'markers', label: t('map.markers') },
  { value: 'heatmap', label: t('map.heatMap') }
]

// Initialize map
const initMap = () => {
  // Default center (Dhaka, Bangladesh)
  const defaultCenter = [23.8103, 90.4125]
  
  map.value = L.map('map').setView(defaultCenter, 10)
  
  // Add tile layer
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map.value)
  
  // Load incidents
  loadIncidents()
}

// Load incidents from API
const loadIncidents = async (reset = true) => {
  if (reset) {
    loading.value = true
    currentPage.value = 1
    incidents.value = []
    hasMore.value = true
  } else {
    loadingMore.value = true
  }
  
  try {
    const params = new URLSearchParams()
    if (filters.value.category) params.append('category', filters.value.category)
    if (filters.value.status) params.append('status', filters.value.status)
    if (filters.value.verified) params.append('verified', 'true')
    if (filters.value.division) params.append('division', filters.value.division)
    if (filters.value.district) params.append('district', filters.value.district)
    if (filters.value.thana) params.append('thana', filters.value.thana)
    if (filters.value.date_from) params.append('date_from', filters.value.date_from)
    if (filters.value.date_to) params.append('date_to', filters.value.date_to)
    params.append('page', currentPage.value.toString())
    params.append('per_page', perPage.toString())
    
    const response = await fetch(`/api/incidents/map/data?${params}`)
    const data = await response.json()
    
    if (reset) {
      incidents.value = data.incidents
      mapBounds.value = data.bounds
      
      // Update map visualization
      updateMapVisualization()
      
      // Fit map to bounds if available
      if (mapBounds.value) {
        fitToBounds()
      }
    } else {
      // Append new incidents
      incidents.value = [...incidents.value, ...data.incidents]
      // Update map with new markers
      if (viewMode.value === 'markers') {
        data.incidents.forEach(incident => addIncidentMarker(incident))
      } else {
        updateMapVisualization()
      }
    }
    
    totalIncidents.value = data.total
    hasMore.value = incidents.value.length < data.total
    
  } catch (error) {
    console.error('Error loading incidents:', error)
  } finally {
    loading.value = false
    loadingMore.value = false
  }
}

// Handle scroll for infinite loading
const handleScroll = (event) => {
  const container = event.target
  const scrollPosition = container.scrollTop + container.clientHeight
  const scrollHeight = container.scrollHeight
  
  // Load more when scrolled to 80% of the content
  if (scrollPosition >= scrollHeight * 0.8 && !loadingMore.value && hasMore.value && !loading.value) {
    currentPage.value++
    loadIncidents(false)
  }
}

// Update map visualization based on current view mode
const updateMapVisualization = () => {
  console.log('Updating map visualization, current mode:', viewMode.value)
  // Clear existing layers
  clearMapLayers()
  
  if (viewMode.value === 'heatmap') {
    console.log('Creating heat map')
    createHeatMap()
  } else {
    console.log('Creating markers')
    createMarkers()
  }
}

// Clear all map layers except base tile layer
const clearMapLayers = () => {
  map.value.eachLayer((layer) => {
    if (layer instanceof L.Marker || layer === heatLayer.value) {
      map.value.removeLayer(layer)
    }
  })
  heatLayer.value = null
  selectedMarker.value = null
}

// Create heat map
const createHeatMap = () => {
  console.log('Creating heat map with', incidents.value.length, 'incidents')
  if (incidents.value.length === 0) return
  
  // Prepare heat map data
  const heatData = incidents.value.map(incident => {
    const lat = parseFloat(incident.latitude)
    const lng = parseFloat(incident.longitude)
    
    if (isNaN(lat) || isNaN(lng)) return null
    
    // Weight based on priority and verification
    let weight = 1
    if (incident.priority === 'urgent') weight = 4
    else if (incident.priority === 'high') weight = 3
    else if (incident.priority === 'medium') weight = 2
    else if (incident.priority === 'low') weight = 1
    
    // Increase weight for verified incidents
    if (incident.is_verified) weight *= 1.5
    
    return [lat, lng, weight]
  }).filter(Boolean)
  
  console.log('Heat map data:', heatData)
  
  if (heatData.length > 0) {
    // Create heat layer
    heatLayer.value = L.heatLayer(heatData, {
      radius: 25,
      blur: 15,
      maxZoom: 18,
      max: 4,
      gradient: {
        0.2: '#ff6b6b',
        0.4: '#ff5252',
        0.6: '#f44336',
        0.8: '#d32f2f',
        1.0: '#b71c1c'
      }
    }).addTo(map.value)
    console.log('Heat layer created and added to map')
  }
}

// Create individual markers
const createMarkers = () => {
  incidents.value.forEach(incident => {
    addIncidentMarker(incident)
  })
}

// Add incident marker to map
const addIncidentMarker = (incident) => {
  const lat = parseFloat(incident.latitude)
  const lng = parseFloat(incident.longitude)
  
  if (isNaN(lat) || isNaN(lng)) return
  
  // Determine marker color based on priority
  const priorityColors = {
    urgent: '#ef4444',    // red
    high: '#f97316',      // orange
    medium: '#eab308',     // yellow
    low: '#22c55e'        // green
  }
  
  const color = priorityColors[incident.priority] || '#6b7280'
  
  // Create custom icon
  const icon = L.divIcon({
    className: 'custom-div-icon',
    html: `
      <div style="
        background-color: ${color};
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid ${incident.is_verified ? '#3b82f6' : '#ffffff'};
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.3);
      ">
        <div style="
          width: 8px;
          height: 8px;
          background-color: white;
          border-radius: 50%;
        "></div>
      </div>
    `,
    iconSize: [20, 20],
    iconAnchor: [10, 10]
  })
  
  // Helper function to escape HTML
  const escapeHtml = (text) => {
    if (!text) return ''
    const div = document.createElement('div')
    div.textContent = text
    return div.innerHTML
  }
  
  // Create marker
  const marker = L.marker([lat, lng], { icon })
  
  // Create popup content with escaped text
  const popupContent = `
    <div class="p-2 min-w-64">
      <div class="flex items-start justify-between mb-2">
        <h3 class="font-semibold text-gray-900 text-sm">${escapeHtml(incident.title)}</h3>
        <span class="px-2 py-1 text-xs rounded-full ${
          incident.is_verified 
            ? 'bg-green-100 text-green-800' 
            : 'bg-gray-100 text-gray-800'
        }">
          ${incident.is_verified ? t('map.verified') : t('map.unverified')}
        </span>
      </div>
      
      <div class="space-y-1 text-xs text-gray-600 mb-3">
        <div><strong>${t('map.category')}:</strong> ${escapeHtml(getCategoryLabel(incident.category))}</div>
        <div><strong>${t('map.status')}:</strong> ${escapeHtml(getStatusLabel(incident.status))}</div>
        <div><strong>${t('map.priority')}:</strong> ${escapeHtml(getPriorityLabel(incident.priority))}</div>
        <div><strong>${t('map.location')}:</strong> ${escapeHtml(incident.address || incident.city || t('map.unknown'))}</div>
        <div><strong>${t('map.date')}:</strong> ${new Date(incident.incident_date || incident.created_at).toLocaleDateString()}</div>
        ${incident.has_media ? `<div><strong>${t('map.media')}:</strong> ${incident.media_count} ${t('map.files')}</div>` : ''}
      </div>
      
      <p class="text-xs text-gray-700 mb-3">${escapeHtml(incident.description).substring(0, 150)}${incident.description && incident.description.length > 150 ? '...' : ''}</p>
      
      <div class="flex items-center justify-between">
        <div class="text-xs text-gray-500">
          ${incident.verification_count} ${t('map.verifications')}, ${incident.dispute_count} ${t('map.disputes')}
        </div>
        <button 
          data-incident-id="${incident.id}"
          class="incident-details-btn text-xs text-blue-600 hover:text-blue-800 font-medium cursor-pointer hover:underline"
        >
          ${t('map.viewDetails')} →
        </button>
      </div>
    </div>
  `
  
  const popup = L.popup().setContent(popupContent)
  marker.bindPopup(popup)
  
  // Add click listener when popup opens
  marker.on('popupopen', (e) => {
    // Use setTimeout to ensure DOM is ready
    setTimeout(() => {
      const popupElement = e.popup.getElement()
      const btn = popupElement?.querySelector('.incident-details-btn')
      if (btn) {
        // Remove any existing listeners to prevent duplicates
        const newBtn = btn.cloneNode(true)
        btn.parentNode.replaceChild(newBtn, btn)
        
        // Add fresh click listener
        newBtn.addEventListener('click', (event) => {
          event.preventDefault()
          event.stopPropagation()
          const incidentId = newBtn.getAttribute('data-incident-id')
          if (incidentId) {
            router.push(`/incident/${incidentId}`)
          }
        })
      }
    }, 10)
  })
  
  marker.addTo(map.value)
  
  // Store marker reference for selection
  marker.incidentId = incident.id
}

// Select incident from list
const selectIncident = (incident) => {
  selectedIncident.value = incident
  
  if (viewMode.value === 'markers') {
    // Find and highlight the corresponding marker
    map.value.eachLayer((layer) => {
      if (layer instanceof L.Marker && layer.incidentId === incident.id) {
        // Remove previous selection
        if (selectedMarker.value) {
          selectedMarker.value.setOpacity(0.5)
        }
        
        // Highlight selected marker
        layer.setOpacity(1)
        layer.setZIndexOffset(1000)
        layer.openPopup()
        selectedMarker.value = layer
        
        // Pan to marker
        map.value.panTo([incident.latitude, incident.longitude])
      }
    })
  } else {
    // For heat map, just pan to location
    map.value.panTo([incident.latitude, incident.longitude])
    map.value.setZoom(15)
  }
}

// Clear selection
const clearSelection = () => {
  selectedIncident.value = null
  
  if (selectedMarker.value) {
    selectedMarker.value.setOpacity(1)
    selectedMarker.value.setZIndexOffset(0)
    selectedMarker.value.closePopup()
    selectedMarker.value = null
  }
}

// Handle filter changes
const handleFilterChange = (newFilters) => {
  console.log('Filter changed:', newFilters)
  filters.value = { ...newFilters }
  loadIncidents(true)
}

// Watch for view mode changes
watch(viewMode, (newMode, oldMode) => {
  console.log('View mode changed from', oldMode, 'to', newMode)
  clearSelection()
  updateMapVisualization()
})

// Set view mode
const setViewMode = (mode) => {
  console.log('Setting view mode to:', mode)
  viewMode.value = mode
}

// Get priority color for list items
const getPriorityColor = (priority) => {
  const colors = {
    urgent: 'bg-red-500',
    high: 'bg-orange-500',
    medium: 'bg-yellow-500',
    low: 'bg-green-500'
  }
  return colors[priority] || 'bg-gray-500'
}

// Format date
const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString()
}

// Reactive functions for localized labels
const getCategoryLabel = (category) => {
  const categoryMap = {
    'theft_robbery': t('filters.categories.theftRobbery'),
    'sexual_harassment': t('filters.categories.sexualHarassment'),
    'domestic_violence': t('filters.categories.domesticViolence'),
    'suspicious_activities': t('filters.categories.suspiciousActivities'),
    'traffic_accidents': t('filters.categories.trafficAccidents'),
    'drugs': t('filters.categories.drugs'),
    'cybercrime': t('filters.categories.cybercrime')
  };
  return categoryMap[category] || category;
}

const getStatusLabel = (status) => {
  const statusMap = {
    'pending': t('filters.statuses.pending'),
    'in_progress': t('filters.statuses.inProgress'),
    'resolved': t('filters.statuses.resolved')
  };
  return statusMap[status] || t('incidentDetails.unknownStatus');
}

const getPriorityLabel = (priority) => {
  const priorityMap = {
    'low': t('incidentDetails.priority.low'),
    'medium': t('incidentDetails.priority.medium'),
    'high': t('incidentDetails.priority.high'),
    'urgent': t('incidentDetails.priority.urgent')
  };
  return priorityMap[priority] || t('incidentDetails.unknownPriority');
}

// Fit map to incident bounds
const fitToBounds = () => {
  if (mapBounds.value && map.value) {
    const bounds = L.latLngBounds(
      [mapBounds.value.south, mapBounds.value.west],
      [mapBounds.value.north, mapBounds.value.east]
    )
    map.value.fitBounds(bounds, { padding: [20, 20] })
  }
}

// Lifecycle hooks
onMounted(() => {
  initMap()
})

onUnmounted(() => {
  if (map.value) {
    map.value.remove()
  }
})
</script>

<style scoped>
.custom-div-icon {
  background: transparent !important;
  border: none !important;
}

/* Ensure map container has proper height */
#map {
  min-height: 400px;
}

/* Line clamp utility */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>