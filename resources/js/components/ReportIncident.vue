<template>
  <div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-lg">
      <div class="px-6 py-4 border-b border-gray-200">
        <h1 class="text-2xl font-bold text-gray-900">Report an Incident</h1>
        <p class="text-gray-600 mt-1">
          Help keep your community safe by reporting incidents. All reports are anonymous by default.
        </p>
      </div>

      <form @submit.prevent="submitReport" class="p-6 space-y-6">
        <!-- Basic Information -->
        <div class="space-y-4">
          <h2 class="text-lg font-semibold text-gray-900">Basic Information</h2>
          
          <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
              Incident Title *
            </label>
            <input
              id="title"
              v-model="form.title"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
              placeholder="Brief description of the incident"
            />
          </div>

          <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
              Detailed Description *
            </label>
            <textarea
              id="description"
              v-model="form.description"
              required
              rows="4"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
              placeholder="Provide detailed information about what happened, when, and any other relevant details"
            ></textarea>
          </div>

          <div>
            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
              Category *
            </label>
            <select
              id="category"
              v-model="form.category"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
            >
              <option value="">Select a category</option>
              <option 
                v-for="category in categories" 
                :key="category.value" 
                :value="category.value"
              >
                {{ category.label }}
              </option>
            </select>
          </div>

          <div>
            <label for="incident_date" class="block text-sm font-medium text-gray-700 mb-2">
              When did this happen?
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
          <h2 class="text-lg font-semibold text-gray-900">Location</h2>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">
                Latitude
              </label>
              <input
                id="latitude"
                v-model="form.latitude"
                type="number"
                step="any"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                placeholder="23.8103"
              />
            </div>
            <div>
              <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">
                Longitude
              </label>
              <input
                id="longitude"
                v-model="form.longitude"
                type="number"
                step="any"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                placeholder="90.4125"
              />
            </div>
          </div>

          <div>
            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
              Address
            </label>
            <input
              id="address"
              v-model="form.address"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
              placeholder="Street address, area, city"
            />
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                City
              </label>
              <input
                id="city"
                v-model="form.city"
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                placeholder="Dhaka"
              />
            </div>
            <div>
              <label for="district" class="block text-sm font-medium text-gray-700 mb-2">
                District
              </label>
              <input
                id="district"
                v-model="form.district"
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                placeholder="Dhaka"
              />
            </div>
            <div>
              <label for="division" class="block text-sm font-medium text-gray-700 mb-2">
                Division
              </label>
              <input
                id="division"
                v-model="form.division"
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                placeholder="Dhaka"
              />
            </div>
          </div>

          <div class="bg-blue-50 p-4 rounded-lg">
            <div class="flex items-center">
              <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-sm text-blue-800">
                <strong>Tip:</strong> Click "Get Current Location" to automatically fill coordinates, or manually enter them.
              </span>
            </div>
            <button
              type="button"
              @click="getCurrentLocation"
              class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors"
            >
              Get Current Location
            </button>
          </div>
        </div>

        <!-- Media Upload -->
        <div class="space-y-4">
          <h2 class="text-lg font-semibold text-gray-900">Media (Optional)</h2>
          
          <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
            <div class="text-center">
              <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              <div class="mt-4">
                <label for="media" class="cursor-pointer">
                  <span class="mt-2 block text-sm font-medium text-gray-900">
                    Upload photos or videos
                  </span>
                  <span class="mt-1 block text-sm text-gray-500">
                    PNG, JPG, MP4 up to 10MB each
                  </span>
                </label>
                <input
                  id="media"
                  ref="mediaInput"
                  type="file"
                  multiple
                  accept="image/*,video/*"
                  @change="handleMediaUpload"
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

        <!-- Reporter Information -->
        <div class="space-y-4">
          <h2 class="text-lg font-semibold text-gray-900">Reporter Information</h2>
          
          <div class="flex items-center">
            <input
              id="is_anonymous"
              v-model="form.is_anonymous"
              type="checkbox"
              class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded"
            />
            <label for="is_anonymous" class="ml-2 block text-sm text-gray-700">
              Report anonymously (recommended for safety)
            </label>
          </div>

          <div v-if="!form.is_anonymous" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="reporter_name" class="block text-sm font-medium text-gray-700 mb-2">
                Your Name
              </label>
              <input
                id="reporter_name"
                v-model="form.reporter_name"
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                placeholder="Your full name"
              />
            </div>
            <div>
              <label for="reporter_phone" class="block text-sm font-medium text-gray-700 mb-2">
                Phone Number
              </label>
              <input
                id="reporter_phone"
                v-model="form.reporter_phone"
                type="tel"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                placeholder="+880 1XXX XXXXXX"
              />
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
            Cancel
          </button>
          <button
            type="submit"
            :disabled="loading"
            class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
          >
            <span v-if="loading">Submitting...</span>
            <span v-else>Submit Report</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useIncidentStore } from '../stores/incidents';
import { useRouter } from 'vue-router';

const incidentStore = useIncidentStore();
const router = useRouter();

const loading = ref(false);
const mediaFiles = ref([]);
const mediaInput = ref(null);

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
  is_anonymous: true,
  reporter_name: '',
  reporter_phone: '',
});

const { categories } = incidentStore;

onMounted(() => {
  // Set default incident date to now
  const now = new Date();
  form.incident_date = now.toISOString().slice(0, 16);
});

const getCurrentLocation = () => {
  if (!navigator.geolocation) {
    alert('Geolocation is not supported by this browser.');
    return;
  }

  navigator.geolocation.getCurrentPosition(
    (position) => {
      form.latitude = position.coords.latitude.toFixed(8);
      form.longitude = position.coords.longitude.toFixed(8);
    },
    (error) => {
      console.error('Error getting location:', error);
      alert('Unable to get your location. Please enter coordinates manually.');
    }
  );
};

const handleMediaUpload = (event) => {
  const files = Array.from(event.target.files);
  
  files.forEach(file => {
    if (file.size > 10 * 1024 * 1024) { // 10MB limit
      alert(`File ${file.name} is too large. Maximum size is 10MB.`);
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
    alert('Incident reported successfully! Thank you for helping keep the community safe.');
    
    // Redirect to incident details
    router.push(`/incident/${incident.id}`);
  } catch (error) {
    console.error('Error submitting report:', error);
    alert('Failed to submit report. Please try again.');
  } finally {
    loading.value = false;
  }
};
</script>
