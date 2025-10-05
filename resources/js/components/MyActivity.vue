<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">{{ $t('activity.myActivity') }}</h1>
    <p class="mt-2 text-gray-600">{{ $t('activity.viewComments') }}</p>
      </div>

      <!-- Tabs -->
      <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
          <button
            @click="activeTab = 'comments'"
            :class="[
              'py-4 px-1 border-b-2 font-medium text-sm transition',
              activeTab === 'comments'
                ? 'border-red-500 text-red-600'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
            ]"
          >
            Comments ({{ comments.length }})
          </button>
          <button
            @click="activeTab = 'verifications'"
            :class="[
              'py-4 px-1 border-b-2 font-medium text-sm transition',
              activeTab === 'verifications'
                ? 'border-red-500 text-red-600'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
            ]"
          >
            Verifications ({{ verifications.length }})
          </button>
        </nav>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center py-12">
        <svg class="animate-spin h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
      </div>

      <!-- Comments Tab -->
      <div v-else-if="activeTab === 'comments'">
        <div v-if="comments.length > 0" class="space-y-4">
          <div v-for="comment in comments" :key="comment.id" class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-start justify-between mb-3">
              <router-link
                :to="`/incident/${comment.incident.id}`"
                class="flex-1 text-blue-600 hover:text-blue-800 font-semibold"
              >
                {{ comment.incident.title }}
              </router-link>
              <span class="text-sm text-gray-500">{{ formatDate(comment.created_at) }}</span>
            </div>
            
            <div class="mb-3">
              <p class="text-gray-700">{{ comment.content }}</p>
            </div>
            
            <div class="flex items-center gap-4 text-sm">
              <span class="flex items-center gap-1 text-green-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                </svg>
                {{ comment.likes_count || 0 }} upvotes
              </span>
              <span class="flex items-center gap-1 text-red-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
                {{ comment.dislikes_count || 0 }} downvotes
              </span>
              <span class="ml-auto px-3 py-1 rounded-full text-xs font-medium"
                    :class="getCategoryColorClass(comment.incident.category)">
                {{ comment.incident.category }}
              </span>
            </div>
          </div>
        </div>
        <div v-else class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
          </svg>
          <p class="mt-4 text-gray-600">You haven't commented on any incidents yet.</p>
        </div>
      </div>

      <!-- Verifications Tab -->
      <div v-else-if="activeTab === 'verifications'">
        <div v-if="verifications.length > 0" class="space-y-4">
          <div v-for="verification in verifications" :key="verification.id" class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-start justify-between mb-3">
              <router-link
                :to="`/incident/${verification.incident.id}`"
                class="flex-1 text-blue-600 hover:text-blue-800 font-semibold"
              >
                {{ verification.incident.title }}
              </router-link>
              <span class="text-sm text-gray-500">{{ formatDate(verification.created_at) }}</span>
            </div>
            
            <div class="mb-3 flex items-center gap-2">
              <span v-if="verification.verification_type === 'confirm'"
                    class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                ✓ Confirmed
              </span>
              <span v-else
                    class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                ✗ Disputed
              </span>
            </div>
            
            <div v-if="verification.comment" class="mb-3">
              <p class="text-gray-700 text-sm italic">"{{ verification.comment }}"</p>
            </div>
            
            <div class="flex items-center gap-4 text-sm">
              <span class="px-3 py-1 rounded-full text-xs font-medium"
                    :class="getCategoryColorClass(verification.incident.category)">
                {{ verification.incident.category }}
              </span>
              <span class="px-3 py-1 rounded-full text-xs font-medium"
                    :class="getStatusColorClass(verification.incident.status)">
                {{ verification.incident.status }}
              </span>
            </div>
          </div>
        </div>
        <div v-else class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <p class="mt-4 text-gray-600">You haven't verified any incidents yet.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useAuthStore } from '../stores/auth'
import axios from 'axios'

const authStore = useAuthStore()
const activeTab = ref('comments')
const comments = ref([])
const verifications = ref([])
const loading = ref(true)

const fetchComments = async () => {
  try {
    // Ensure axios has the auth header
    if (authStore.token) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${authStore.token}`
    }
    const response = await axios.get('/api/user/comments')
    console.log('Comments response:', response.data)
    comments.value = response.data || []
  } catch (error) {
    console.error('Error fetching comments:', error)
    console.error('Error details:', error.response?.data || error.message)
    comments.value = []
  }
}

const fetchVerifications = async () => {
  try {
    // Ensure axios has the auth header
    if (authStore.token) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${authStore.token}`
    }
    const response = await axios.get('/api/user/verifications')
    console.log('Verifications response:', response.data)
    verifications.value = response.data || []
  } catch (error) {
    console.error('Error fetching verifications:', error)
    console.error('Error details:', error.response?.data || error.message)
    verifications.value = []
  }
}

const formatDate = (dateString) => {
  const date = new Date(dateString)
  const now = new Date()
  const diffMs = now - date
  const diffMins = Math.floor(diffMs / 60000)
  const diffHours = Math.floor(diffMs / 3600000)
  const diffDays = Math.floor(diffMs / 86400000)

  if (diffMins < 1) return 'just now'
  if (diffMins < 60) return `${diffMins} min${diffMins > 1 ? 's' : ''} ago`
  if (diffHours < 24) return `${diffHours} hour${diffHours > 1 ? 's' : ''} ago`
  if (diffDays < 7) return `${diffDays} day${diffDays > 1 ? 's' : ''} ago`
  
  return date.toLocaleDateString('en-US', { 
    month: 'short', 
    day: 'numeric', 
    year: date.getFullYear() !== now.getFullYear() ? 'numeric' : undefined 
  })
}

const getCategoryColorClass = (category) => {
  const colors = {
    theft_robbery: 'bg-red-100 text-red-800',
    sexual_harassment: 'bg-pink-100 text-pink-800',
    domestic_violence: 'bg-purple-100 text-purple-800',
    suspicious_activities: 'bg-orange-100 text-orange-800',
    traffic_accidents: 'bg-yellow-100 text-yellow-800',
    drugs: 'bg-indigo-100 text-indigo-800',
    cybercrime: 'bg-blue-100 text-blue-800',
  }
  return colors[category] || 'bg-gray-100 text-gray-800'
}

const getStatusColorClass = (status) => {
  const colors = {
    pending: 'bg-yellow-100 text-yellow-800',
    in_progress: 'bg-blue-100 text-blue-800',
    resolved: 'bg-green-100 text-green-800',
  }
  return colors[status] || 'bg-gray-100 text-gray-800'
}

onMounted(async () => {
  loading.value = true
  await Promise.all([fetchComments(), fetchVerifications()])
  loading.value = false
})
</script>

