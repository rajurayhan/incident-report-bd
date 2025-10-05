<template>
  <div class="max-w-full mx-auto">
    <!-- Header -->
    <PageHeader 
      title="Incident Map" 
      subtitle="Interactive map with heat map visualization and incident list"
    >
      <template #actions>
        <!-- View Toggle -->
        <ViewToggle 
          v-model="viewMode"
          :options="viewOptions"
          label="View"
        />
        
        <!-- Filters -->
        <FilterBar 
          :filters="filters"
          @filter-change="handleFilterChange"
        />
        
        <!-- Stats -->
        <StatsDisplay 
          :value="totalIncidents" 
          label="incidents" 
        />
      </template>
    </PageHeader>

    <!-- Main Content Area -->
    <div class="flex gap-6">
      <!-- Left Panel - Incident List -->
      <div class="w-96 bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-900">Incident List</h3>
          <p class="text-sm text-gray-600">Click to highlight on map</p>
        </div>
        
        <div class="h-96 overflow-y-auto">
          <!-- Loading State -->
          <div v-if="loading" class="p-4 text-center">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600 mx-auto"></div>
            <p class="text-gray-600 mt-2">Loading incidents...</p>
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
                <div><strong>{{ incident.category_label }}</strong></div>
                <div>{{ incident.status_label }} • {{ incident.priority_label }}</div>
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
            <p>No incidents found</p>
            <p class="text-sm">Try adjusting your filters</p>
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
              <span class="text-gray-600">Loading map...</span>
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
              Fit to Data
            </button>
            <button 
              v-if="selectedIncident"
              @click="clearSelection"
              class="bg-white shadow-md rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 block"
            >
              Clear Selection
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Legend -->
    <div class="mt-6 bg-white shadow-lg rounded-lg p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Legend</h3>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="flex items-center space-x-2">
          <div class="w-4 h-4 bg-red-500 rounded-full"></div>
          <span class="text-sm text-gray-600">Urgent</span>
        </div>
        <div class="flex items-center space-x-2">
          <div class="w-4 h-4 bg-orange-500 rounded-full"></div>
          <span class="text-sm text-gray-600">High</span>
        </div>
        <div class="flex items-center space-x-2">
          <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
          <span class="text-sm text-gray-600">Medium</span>
        </div>
        <div class="flex items-center space-x-2">
          <div class="w-4 h-4 bg-green-500 rounded-full"></div>
          <span class="text-sm text-gray-600">Low</span>
        </div>
      </div>
      <div class="mt-4 flex items-center space-x-4">
        <div class="flex items-center space-x-2">
          <div class="w-4 h-4 bg-blue-500 rounded-full border-2 border-white"></div>
          <span class="text-sm text-gray-600">Verified</span>
        </div>
        <div class="flex items-center space-x-2">
          <div class="w-4 h-4 bg-gray-500 rounded-full"></div>
          <span class="text-sm text-gray-600">Unverified</span>
        </div>
      </div>
      <div class="mt-4 text-sm text-gray-600">
        <p><strong>Heat Map:</strong> Shows incident density - red areas indicate higher concentration of incidents</p>
        <p><strong>Markers:</strong> Individual incident locations with detailed popups</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'
import 'leaflet.heat'
import PageHeader from './PageHeader.vue'
import ViewToggle from './ViewToggle.vue'
import FilterBar from './FilterBar.vue'
import StatsDisplay from './StatsDisplay.vue'

// Reactive data
const map = ref(null)
const heatLayer = ref(null)
const incidents = ref([])
const totalIncidents = ref(0)
const loading = ref(false)
const mapBounds = ref(null)
const viewMode = ref('markers') // 'markers' or 'heatmap'
const selectedIncident = ref(null)
const selectedMarker = ref(null)

// Filters
const filters = ref({
  category: '',
  status: '',
  verified: false
})

// View options
const viewOptions = [
  { value: 'markers', label: 'Markers' },
  { value: 'heatmap', label: 'Heat Map' }
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
const loadIncidents = async () => {
  loading.value = true
  
  try {
    const params = new URLSearchParams()
    if (filters.value.category) params.append('category', filters.value.category)
    if (filters.value.status) params.append('status', filters.value.status)
    if (filters.value.verified) params.append('verified', 'true')
    
    const response = await fetch(`/api/incidents/map/data?${params}`)
    const data = await response.json()
    
    incidents.value = data.incidents
    totalIncidents.value = data.total
    mapBounds.value = data.bounds
    
    // Update map visualization
    updateMapVisualization()
    
    // Fit map to bounds if available
    if (mapBounds.value) {
      fitToBounds()
    }
    
  } catch (error) {
    console.error('Error loading incidents:', error)
  } finally {
    loading.value = false
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
  
  // Create marker
  const marker = L.marker([lat, lng], { icon })
  
  // Create popup content
  const popupContent = `
    <div class="p-2 min-w-64">
      <div class="flex items-start justify-between mb-2">
        <h3 class="font-semibold text-gray-900 text-sm">${incident.title}</h3>
        <span class="px-2 py-1 text-xs rounded-full ${
          incident.is_verified 
            ? 'bg-green-100 text-green-800' 
            : 'bg-gray-100 text-gray-800'
        }">
          ${incident.is_verified ? 'Verified' : 'Unverified'}
        </span>
      </div>
      
      <div class="space-y-1 text-xs text-gray-600 mb-3">
        <div><strong>Category:</strong> ${incident.category_label}</div>
        <div><strong>Status:</strong> ${incident.status_label}</div>
        <div><strong>Priority:</strong> ${incident.priority_label}</div>
        <div><strong>Location:</strong> ${incident.address || incident.city || 'Unknown'}</div>
        <div><strong>Date:</strong> ${new Date(incident.incident_date || incident.created_at).toLocaleDateString()}</div>
        ${incident.has_media ? `<div><strong>Media:</strong> ${incident.media_count} file(s)</div>` : ''}
      </div>
      
      <p class="text-xs text-gray-700 mb-3 line-clamp-3">${incident.description}</p>
      
      <div class="flex items-center justify-between">
        <div class="text-xs text-gray-500">
          ${incident.verification_count} verifications, ${incident.dispute_count} disputes
        </div>
        <a 
          href="/incident/${incident.id}" 
          class="text-xs text-blue-600 hover:text-blue-800 font-medium"
        >
          View Details →
        </a>
      </div>
    </div>
  `
  
  marker.bindPopup(popupContent)
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
  loadIncidents()
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