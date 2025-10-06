<template>
  <div class="map-pin-selector">
    <div class="mb-4 flex justify-between items-center">
      <h3 class="text-lg font-medium text-gray-900">{{ $t('report.mapPinSelector.title') }}</h3>
      <div class="flex space-x-2">
        <button
          type="button"
          @click="getCurrentLocation"
          :disabled="loadingLocation"
          class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <svg v-if="loadingLocation" class="animate-spin -ml-1 mr-2 h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <svg v-else class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
          {{ $t('report.mapPinSelector.getCurrentLocation') }}
        </button>
        <button
          type="button"
          @click="clearPin"
          :disabled="!hasPin"
          class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
          {{ $t('report.mapPinSelector.clearPin') }}
        </button>
      </div>
    </div>

    <div class="relative">
      <div 
        ref="mapContainer" 
        class="w-full h-96 border border-gray-300 rounded-lg overflow-hidden bg-gray-100"
        :class="{ 'cursor-crosshair': !hasPin }"
        style="min-height: 384px;"
      ></div>
      
      <!-- Loading overlay -->
      <div v-if="mapLoading" class="absolute inset-0 bg-gray-100 flex items-center justify-center">
        <div class="text-center">
          <svg class="animate-spin h-8 w-8 text-gray-500 mx-auto mb-2" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <p class="text-sm text-gray-600">{{ $t('report.mapPinSelector.loadingMap') }}</p>
        </div>
      </div>

      <!-- Instructions overlay -->
      <div v-if="!mapLoading && !hasPin" class="absolute top-4 left-4 bg-white bg-opacity-90 px-3 py-2 rounded-lg shadow-sm">
        <p class="text-sm text-gray-600">
          <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          {{ $t('report.mapPinSelector.clickToDropPin') }}
        </p>
      </div>
    </div>

    <!-- Coordinates display -->
    <div v-if="hasPin" class="mt-4 p-3 bg-gray-50 rounded-lg">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm font-medium text-gray-700">{{ $t('report.mapPinSelector.selectedLocation') }}</p>
          <p class="text-sm text-gray-600">
            {{ $t('report.latitude') }}: {{ pinLatitude.toFixed(6) }}, 
            {{ $t('report.longitude') }}: {{ pinLongitude.toFixed(6) }}
          </p>
        </div>
        <button
          type="button"
          @click="copyCoordinates"
          class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-600 hover:text-gray-800"
        >
          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
          </svg>
          {{ $t('report.mapPinSelector.copyCoordinates') }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed, watch, nextTick } from 'vue';
import { useI18n } from 'vue-i18n';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

// Fix for default markers in Leaflet with Vite
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
  iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
  iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
});

const { t } = useI18n();

const props = defineProps({
  modelValue: {
    type: Object,
    default: () => ({ latitude: null, longitude: null })
  },
  initialLocation: {
    type: Object,
    default: () => ({ latitude: 23.8103, longitude: 90.4125 }) // Default to Dhaka, Bangladesh
  }
});

const emit = defineEmits(['update:modelValue', 'location-changed']);

const mapContainer = ref(null);
const map = ref(null);
const marker = ref(null);
const mapLoading = ref(true);
const loadingLocation = ref(false);

// Pin coordinates
const pinLatitude = ref(props.modelValue.latitude || props.initialLocation.latitude);
const pinLongitude = ref(props.modelValue.longitude || props.initialLocation.longitude);

const hasPin = computed(() => {
  return pinLatitude.value !== null && pinLongitude.value !== null;
});

// Initialize map
onMounted(() => {
  nextTick(() => {
    initMap();
  });
});

onUnmounted(() => {
  if (map.value) {
    map.value.remove();
  }
});

const initMap = () => {
  if (!mapContainer.value) return;
  
  mapLoading.value = true;
  
  // Default to Dhaka coordinates if no pin is set
  const centerLat = pinLatitude.value || props.initialLocation.latitude;
  const centerLng = pinLongitude.value || props.initialLocation.longitude;
  
  // Create map
  map.value = L.map(mapContainer.value, {
    center: [centerLat, centerLng],
    zoom: 13,
    zoomControl: true,
    dragging: true,
    touchZoom: true,
    doubleClickZoom: true,
    scrollWheelZoom: true,
    boxZoom: true,
    keyboard: true
  });

  // Add tile layer with proper attribution
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    maxZoom: 19
  }).addTo(map.value);

  // Add click event to drop pin
  map.value.on('click', (e) => {
    dropPin(e.latlng.lat, e.latlng.lng);
  });

  // Add initial pin if coordinates exist
  if (hasPin.value) {
    addMarker(pinLatitude.value, pinLongitude.value);
  }

  // Ensure map is properly sized
  setTimeout(() => {
    if (map.value) {
      map.value.invalidateSize();
    }
    mapLoading.value = false;
  }, 100);
};

const addMarker = (lat, lng) => {
  // Remove existing marker
  if (marker.value) {
    map.value.removeLayer(marker.value);
  }

  // Create custom icon
  const customIcon = L.divIcon({
    className: 'custom-pin',
    html: `
      <div style="
        background-color: #dc2626;
        width: 20px;
        height: 20px;
        border-radius: 50% 50% 50% 0;
        transform: rotate(-45deg);
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        position: relative;
      ">
        <div style="
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%) rotate(45deg);
          width: 8px;
          height: 8px;
          background-color: white;
          border-radius: 50%;
        "></div>
      </div>
    `,
    iconSize: [20, 20],
    iconAnchor: [10, 20],
    popupAnchor: [0, -20]
  });

  // Add marker
  marker.value = L.marker([lat, lng], { icon: customIcon })
    .addTo(map.value)
    .bindPopup(`
      <div class="text-center">
        <p class="font-medium">${t('report.mapPinSelector.incidentLocation')}</p>
        <p class="text-sm text-gray-600">${lat.toFixed(6)}, ${lng.toFixed(6)}</p>
      </div>
    `);
};

const dropPin = (lat, lng) => {
  pinLatitude.value = lat;
  pinLongitude.value = lng;
  
  addMarker(lat, lng);
  
  // Emit changes
  emit('update:modelValue', { latitude: lat, longitude: lng });
  emit('location-changed', { latitude: lat, longitude: lng });
};

const getCurrentLocation = () => {
  if (!navigator.geolocation) {
    alert(t('report.geolocationNotSupported'));
    return;
  }

  loadingLocation.value = true;

  navigator.geolocation.getCurrentPosition(
    (position) => {
      const lat = position.coords.latitude;
      const lng = position.coords.longitude;
      
      // Update coordinates
      pinLatitude.value = lat;
      pinLongitude.value = lng;
      
      // Add marker
      addMarker(lat, lng);
      
      // Center map on location
      if (map.value) {
        map.value.setView([lat, lng], 15);
      }
      
      // Emit changes
      emit('update:modelValue', { latitude: lat, longitude: lng });
      emit('location-changed', { latitude: lat, longitude: lng });
      
      loadingLocation.value = false;
    },
    (error) => {
      console.error('Error getting location:', error);
      alert(t('report.unableToGetLocation'));
      loadingLocation.value = false;
      
      // Center on Dhaka if location fails
      if (map.value) {
        map.value.setView([props.initialLocation.latitude, props.initialLocation.longitude], 13);
      }
    },
    {
      enableHighAccuracy: true,
      timeout: 10000,
      maximumAge: 300000 // 5 minutes
    }
  );
};

const clearPin = () => {
  if (marker.value) {
    map.value.removeLayer(marker.value);
    marker.value = null;
  }
  
  pinLatitude.value = null;
  pinLongitude.value = null;
  
  // Emit changes
  emit('update:modelValue', { latitude: null, longitude: null });
  emit('location-changed', { latitude: null, longitude: null });
};

const copyCoordinates = () => {
  const coords = `${pinLatitude.value.toFixed(6)}, ${pinLongitude.value.toFixed(6)}`;
  navigator.clipboard.writeText(coords).then(() => {
    // You could add a toast notification here
    console.log('Coordinates copied to clipboard');
  });
};

// Watch for external changes to coordinates
watch(() => props.modelValue, (newValue) => {
  if (newValue.latitude !== pinLatitude.value || newValue.longitude !== pinLongitude.value) {
    pinLatitude.value = newValue.latitude;
    pinLongitude.value = newValue.longitude;
    
    if (hasPin.value && map.value) {
      addMarker(pinLatitude.value, pinLongitude.value);
      map.value.setView([pinLatitude.value, pinLongitude.value], 13);
    } else if (map.value) {
      // Center on Dhaka if no pin
      map.value.setView([props.initialLocation.latitude, props.initialLocation.longitude], 13);
    }
  }
}, { deep: true });
</script>

<style scoped>
.custom-pin {
  background: transparent !important;
  border: none !important;
}

.map-pin-selector :deep(.leaflet-container) {
  height: 100%;
  width: 100%;
}

.map-pin-selector :deep(.leaflet-popup-content-wrapper) {
  border-radius: 8px;
}

.map-pin-selector :deep(.leaflet-popup-tip) {
  background: white;
}
</style>
