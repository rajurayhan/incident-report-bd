<template>
  <div class="max-w-4xl mx-auto">
    <PageHeader 
      :title="$t('report.title')" 
      :subtitle="$t('report.subtitle')"
    />
    
    <!-- Sign Up Information Block for Unauthenticated Users -->
    <div v-if="!authStore.isAuthenticated" class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
      <div class="flex items-start">
        <div class="flex-shrink-0">
          <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-3 flex-1">
          <h3 class="text-lg font-medium text-blue-900 mb-2">
            {{ $t('signUpInfo.title') }}
          </h3>
          <p class="text-blue-700 mb-4">
            {{ $t('signUpInfo.message') }}
          </p>
          
          <div class="mb-4">
            <h4 class="text-sm font-medium text-blue-900 mb-2">
              {{ $t('signUpInfo.benefits.title') }}
            </h4>
            <ul class="text-sm text-blue-700 space-y-1">
              <li class="flex items-center">
                <svg class="h-4 w-4 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                {{ $t('signUpInfo.benefits.trackReports') }}
              </li>
              <li class="flex items-center">
                <svg class="h-4 w-4 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                {{ $t('signUpInfo.benefits.getUpdates') }}
              </li>
              <li class="flex items-center">
                <svg class="h-4 w-4 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                {{ $t('signUpInfo.benefits.verifyIncidents') }}
              </li>
              <li class="flex items-center">
                <svg class="h-4 w-4 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                {{ $t('signUpInfo.benefits.contribute') }}
              </li>
            </ul>
          </div>
          
          <div class="flex flex-col sm:flex-row gap-3">
            <router-link
              to="/register"
              class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors"
            >
              <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
              </svg>
              {{ $t('signUpInfo.signUpButton') }}
            </router-link>
            <router-link
              to="/login"
              class="inline-flex items-center px-4 py-2 bg-white text-blue-600 text-sm font-medium rounded-md border border-blue-600 hover:bg-blue-50 transition-colors"
            >
              <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
              </svg>
              {{ $t('signUpInfo.signInButton') }}
            </router-link>
          </div>
        </div>
      </div>
    </div>
    
    <div v-if="authStore.isAuthenticated" class="bg-white shadow-lg rounded-lg">

      <form @submit.prevent="submitReport" class="p-6 space-y-6">
        <!-- Basic Information -->
        <div class="space-y-4">
          <h2 class="text-lg font-semibold text-gray-900">{{ $t('report.basicInformation') }}</h2>
          
          <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
              {{ $t('report.incidentTitle') }} *
            </label>
            <input
              id="title"
              v-model="form.title"
              type="text"
              required
              :class="[
                'w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent',
                errors.title ? 'border-red-500' : 'border-gray-300'
              ]"
              :placeholder="$t('report.incidentTitlePlaceholder')"
            />
            <p v-if="errors.title" class="mt-1 text-sm text-red-600">{{ getFieldError('title') }}</p>
          </div>

          <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
              {{ $t('report.detailedDescription') }} *
            </label>
            <textarea
              id="description"
              v-model="form.description"
              required
              rows="4"
              :class="[
                'w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent',
                errors.description ? 'border-red-500' : 'border-gray-300'
              ]"
              :placeholder="$t('report.detailedDescriptionPlaceholder')"
            ></textarea>
            <p v-if="errors.description" class="mt-1 text-sm text-red-600">{{ getFieldError('description') }}</p>
          </div>

          <div>
            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
              {{ $t('report.category') }} *
            </label>
            <select
              id="category"
              v-model="form.category"
              required
              :class="[
                'w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent',
                errors.category ? 'border-red-500' : 'border-gray-300'
              ]"
            >
              <option value="">{{ $t('report.selectCategory') }}</option>
              <option 
                v-for="category in categories" 
                :key="category.value" 
                :value="category.value"
              >
                {{ category.label }}
              </option>
            </select>
            <p v-if="errors.category" class="mt-1 text-sm text-red-600">{{ getFieldError('category') }}</p>
          </div>

          <div>
            <label for="incident_date" class="block text-sm font-medium text-gray-700 mb-2">
              {{ $t('report.whenDidThisHappen') }}
            </label>
            <input
              id="incident_date"
              v-model="form.incident_date"
              type="datetime-local"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
            />
          </div>
        </div>

        <!-- Location -->
        <div class="space-y-4">
          <h2 class="text-lg font-semibold text-gray-900">{{ $t('report.location') }}</h2>
          
          <!-- Location Helper -->
          <div class="bg-blue-50 p-4 rounded-lg">
            <div class="flex items-center">
              <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-sm text-blue-800">
                <strong>{{ $t('report.tip') }}</strong> {{ $t('report.tipMessage') }}
              </span>
            </div> 
          </div>
          
          <!-- Map Pin Selector -->
          <MapPinSelector
            v-model="mapLocation"
            @location-changed="onLocationChanged"
            :initial-location="{ latitude: 23.8103, longitude: 90.4125 }"
          />

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">
                {{ $t('report.latitude') }}
              </label>
              <input
                id="latitude"
                v-model="form.latitude"
                type="number"
                step="any"
                disabled
                class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600 cursor-not-allowed"
                placeholder="23.8103"
              />
            </div>
            <div>
              <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">
                {{ $t('report.longitude') }}
              </label>
              <input
                id="longitude"
                v-model="form.longitude"
                type="number"
                step="any"
                disabled
                class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600 cursor-not-allowed"
                placeholder="90.4125"
              />
            </div>
          </div>

          <div>
            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
              {{ $t('report.address') }}
            </label>
            <input
              id="address"
              v-model="form.address"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
              :placeholder="$t('report.addressPlaceholder')"
            />
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label for="division" class="block text-sm font-medium text-gray-700 mb-2">
                {{ $t('report.division') }}
              </label>
              <select
                id="division"
                v-model="form.division"
                @change="onDivisionChange"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
              >
                <option value="">{{ $t('report.selectDivision') }}</option>
                <option v-for="division in divisions" :key="division" :value="division">
                  {{ division }}
                </option>
              </select>
            </div>
            <div>
              <label for="district" class="block text-sm font-medium text-gray-700 mb-2">
                {{ $t('report.district') }}
              </label>
              <select
                id="district"
                v-model="form.district"
                @change="onDistrictChange"
                :disabled="!form.division"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent disabled:bg-gray-100 disabled:cursor-not-allowed"
              >
                <option value="">{{ $t('report.selectDistrict') }}</option>
                <option v-for="district in availableDistricts" :key="district" :value="district">
                  {{ district }}
                </option>
              </select>
            </div>
            <div>
              <label for="thana" class="block text-sm font-medium text-gray-700 mb-2">
                {{ $t('report.thana') }}
              </label>
              <select
                id="thana"
                v-model="form.city"
                :disabled="!form.district"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent disabled:bg-gray-100 disabled:cursor-not-allowed"
              >
                <option value="">{{ $t('report.selectThana') }}</option>
                <option v-for="thana in availableThanas" :key="thana" :value="thana">
                  {{ thana }}
                </option>
              </select>
            </div>
          </div> 
        </div>

        <!-- Media Upload -->
        <div class="space-y-4">
          <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-900">{{ $t('report.mediaOptional') }}</h2>
            <span class="text-sm text-gray-500">{{ mediaFiles.length }}/3 {{ $t('report.files') }}</span>
          </div>
          
          <div 
            class="border-2 border-dashed rounded-lg p-6 transition-colors"
            :class="{
              'border-gray-300 bg-white': mediaFiles.length < 3,
              'border-gray-200 bg-gray-50': mediaFiles.length >= 3
            }"
          >
            <div class="text-center">
              <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              <div class="mt-4">
                <label 
                  for="media" 
                  :class="{
                    'cursor-pointer': mediaFiles.length < 3,
                    'cursor-not-allowed': mediaFiles.length >= 3
                  }"
                >
                  <span class="mt-2 block text-sm font-medium" :class="{
                    'text-gray-900': mediaFiles.length < 3,
                    'text-gray-500': mediaFiles.length >= 3
                  }">
                    {{ mediaFiles.length >= 3 ? $t('report.maxFilesReached') : $t('report.uploadPhotosVideos') }}
                  </span>
                  <span class="mt-1 block text-sm text-gray-500">
                    {{ $t('report.supportedFormatsShort') }}
                  </span>
                </label>
                <input
                  id="media"
                  ref="mediaInput"
                  type="file"
                  multiple
                  accept="image/*,video/*"
                  @change="handleMediaUpload"
                  :disabled="mediaFiles.length >= 3"
                  class="sr-only"
                />
              </div>
            </div>
          </div>

          <div v-if="mediaFiles.length > 0" class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div 
              v-for="(file, index) in mediaFiles" 
              :key="index"
              class="relative"
            >
              <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                <img 
                  v-if="file.type.startsWith('image/')" 
                  :src="file.preview" 
                  :alt="file.name"
                  class="w-full h-full object-cover"
                />
                <div 
                  v-else 
                  class="w-full h-full flex items-center justify-center bg-gray-200"
                >
                  <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                  </svg>
                </div>
              </div>
              <button
                type="button"
                @click="removeMedia(index)"
                class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-700"
              >
                ×
              </button>
            </div>
          </div>
        </div>


        <!-- Submit Button -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
          <button
            type="button"
            @click="$router.push('/')"
            class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors"
          >
            {{ $t('report.cancel') }}
          </button>
          <button
            type="submit"
            :disabled="loading"
            class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
          >
            <span v-if="loading">{{ $t('report.submitting') }}</span>
            <span v-else>{{ $t('report.submitReport') }}</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed, watch } from 'vue';
import { useIncidentStore } from '../stores/incidents';
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';
import { useI18n } from 'vue-i18n';
import PageHeader from './PageHeader.vue';
import MapPinSelector from './MapPinSelector.vue';
import { getDivisions, getDistricts, getThanas } from '../data/bangladesh-locations';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

// Configure toastr
toastr.options = {
  closeButton: true,
  debug: false,
  newestOnTop: true,
  progressBar: true,
  positionClass: 'toast-top-right',
  preventDuplicates: false,
  onclick: null,
  showDuration: '300',
  hideDuration: '1000',
  timeOut: '5000',
  extendedTimeOut: '1000',
  showEasing: 'swing',
  hideEasing: 'linear',
  showMethod: 'fadeIn',
  hideMethod: 'fadeOut'
};

const incidentStore = useIncidentStore();
const authStore = useAuthStore();
const router = useRouter();
const { t } = useI18n();

const loading = ref(false);
const mediaFiles = ref([]);
const mediaInput = ref(null);
const errors = ref({});
const mapLocation = ref({ latitude: null, longitude: null });

const form = reactive({
  title: '',
  description: '',
  category: '',
  incident_date: '',
  latitude: '',
  longitude: '',
  address: '',
  city: '',
  district: '',
  division: '',
});

const { categories } = incidentStore;

// Location dropdowns
const divisions = ref(getDivisions());
const availableDistricts = computed(() => {
  if (!form.division) return [];
  return getDistricts(form.division);
});

const availableThanas = computed(() => {
  if (!form.division || !form.district) return [];
  return getThanas(form.division, form.district);
});

const onDivisionChange = () => {
  form.district = '';
  form.city = '';
};

const onDistrictChange = () => {
  form.city = '';
};

onMounted(() => {
  // Set default incident date to now
  const now = new Date();
  form.incident_date = now.toISOString().slice(0, 16);
});

// Watch for manual coordinate changes to sync with map
watch([() => form.latitude, () => form.longitude], ([lat, lng]) => {
  if (lat && lng && !isNaN(parseFloat(lat)) && !isNaN(parseFloat(lng))) {
    mapLocation.value = { 
      latitude: parseFloat(lat), 
      longitude: parseFloat(lng) 
    };
  } else if (!lat || !lng) {
    mapLocation.value = { latitude: null, longitude: null };
  }
});

const getCurrentLocation = () => {
  if (!navigator.geolocation) {
    toastr.error(t('report.geolocationNotSupported'));
    return;
  }

  navigator.geolocation.getCurrentPosition(
    (position) => {
      const lat = position.coords.latitude;
      const lng = position.coords.longitude;
      
      form.latitude = lat.toFixed(8);
      form.longitude = lng.toFixed(8);
      
      // Update map location
      mapLocation.value = { latitude: lat, longitude: lng };
      
      toastr.success(t('report.locationDetected'));
    },
    (error) => {
      console.error('Error getting location:', error);
      toastr.error(t('report.unableToGetLocation'));
    }
  );
};

const onLocationChanged = (location) => {
  if (location.latitude && location.longitude) {
    form.latitude = location.latitude.toFixed(8);
    form.longitude = location.longitude.toFixed(8);
  } else {
    form.latitude = '';
    form.longitude = '';
  }
};

const handleMediaUpload = (event) => {
  const files = Array.from(event.target.files);
  
  // Check if adding these files would exceed the 3-file limit
  if (mediaFiles.value.length + files.length > 3) {
    toastr.warning(t('report.maxFilesExceeded'));
    event.target.value = '';
    return;
  }
  
  files.forEach(file => {
    // Check if we've already reached the limit
    if (mediaFiles.value.length >= 3) {
      toastr.warning(t('report.maxFilesReached'));
      return;
    }

    if (file.size > 10 * 1024 * 1024) { // 10MB limit
      toastr.error(t('report.fileTooLarge', { fileName: file.name }));
      return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
      mediaFiles.value.push({
        file,
        name: file.name,
        type: file.type,
        size: file.size,
        preview: e.target.result,
      });
    };
    reader.readAsDataURL(file);
  });

  // Clear the input
  event.target.value = '';
};

const removeMedia = (index) => {
  mediaFiles.value.splice(index, 1);
};

const submitReport = async () => {
  loading.value = true;
  errors.value = {};
  
  try {
    const formData = new FormData();
    
    // Add form fields
    Object.keys(form).forEach(key => {
      if (form[key] !== '') {
        formData.append(key, form[key]);
      }
    });

    // Add media files
    mediaFiles.value.forEach((mediaFile, index) => {
      formData.append(`media[${index}]`, mediaFile.file);
    });

    const incident = await incidentStore.createIncident(formData);
    
    // Show success message
    toastr.success(t('report.successMessage'));
    
    // Redirect to incident details
    router.push(`/incident/${incident.id}`);
  } catch (error) {
    console.error('Error submitting report:', error);
    if (error.errors) {
      errors.value = error.errors;
      toastr.error(t('report.validationError'));
    } else {
      toastr.error(t('report.errorMessage'));
    }
  } finally {
    loading.value = false;
  }
};

const getFieldError = (field) => {
  if (!errors.value[field]) return '';
  
  const error = errors.value[field][0];
  const errorKey = error.split(' ')[0]; // Extract the validation rule
  
  // Map Laravel validation rules to our translation keys
  const ruleMap = {
    'The': 'required',
    'required': 'required',
    'max:': 'max',
    'in:': 'in',
    'date': 'date',
    'numeric': 'numeric',
    'between:': 'between',
    'email': 'email',
    'array': 'array',
    'file': 'file',
    'mimes:': 'mimes'
  };
  
  let rule = 'required';
  for (const [key, value] of Object.entries(ruleMap)) {
    if (error.includes(key)) {
      rule = value;
      break;
    }
  }
  
  return t(`report.validation.${field}.${rule}`);
};
</script>
