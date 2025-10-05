<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ $t('profile.profile') }}</h1>
        <p class="mt-2 text-gray-600">{{ $t('profile.updateProfile') }}</p>
      </div>

      <!-- Profile Card -->
      <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
          <!-- Profile Picture Section -->
          <div class="flex items-center space-x-6 mb-8 pb-6 border-b border-gray-200">
            <div class="w-24 h-24 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-lg">
              {{ getUserInitials() }}
            </div>
            <div class="flex-1">
              <h2 class="text-2xl font-bold text-gray-900">{{ user.name || 'User' }}</h2>
              <p class="text-gray-600">{{ user.email }}</p>
              <div class="mt-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                  <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  {{ $t('profile.activeAccount') }}
                </span>
              </div>
            </div>
          </div>

          <!-- Profile Form -->
          <form @submit.prevent="updateProfile" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Name -->
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ $t('auth.name') }}</label>
                <input
                  type="text"
                  id="name"
                  v-model="form.name"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                  :placeholder="$t('profile.enterYourName')"
                />
              </div>

              <!-- Email -->
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ $t('auth.email') }}</label>
                <input
                  type="email"
                  id="email"
                  v-model="form.email"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                  :placeholder="$t('profile.yourEmail')"
                />
              </div>

              <!-- Phone -->
              <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">{{ $t('auth.phone') }}</label>
                <input
                  type="tel"
                  id="phone"
                  v-model="form.phone"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                  :placeholder="$t('profile.phonePlaceholder')"
                />
              </div>

              <!-- City -->
              <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">{{ $t('profile.city') }}</label>
                <input
                  type="text"
                  id="city"
                  v-model="form.city"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                  :placeholder="$t('profile.yourCity')"
                />
              </div>
            </div>

            <!-- Success/Error Messages -->
            <div v-if="message" class="p-4 rounded-lg" :class="messageType === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'">
              <div class="flex items-center">
                <svg v-if="messageType === 'success'" class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <svg v-else class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                {{ message }}
              </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
              <button
                type="submit"
                :disabled="loading"
                class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <span v-if="loading" class="flex items-center">
                  <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  {{ $t('profile.updating') }}
                </span>
                <span v-else>{{ $t('profile.updateProfileButton') }}</span>
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Change Password Section -->
      <div class="bg-white shadow-md rounded-lg overflow-hidden mt-6">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $t('profile.changePassword') }}</h3>
          <form @submit.prevent="changePassword" class="space-y-6">
            <div class="grid grid-cols-1 gap-6">
              <!-- Current Password -->
              <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">{{ $t('profile.currentPassword') }}</label>
                <input
                  type="password"
                  id="current_password"
                  v-model="passwordForm.current_password"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                  :placeholder="$t('profile.enterCurrentPassword')"
                />
              </div>

              <!-- New Password -->
              <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">{{ $t('profile.newPassword') }}</label>
                <input
                  type="password"
                  id="new_password"
                  v-model="passwordForm.password"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                  :placeholder="$t('profile.enterNewPassword')"
                />
              </div>

              <!-- Confirm New Password -->
              <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">{{ $t('auth.confirmPassword') }}</label>
                <input
                  type="password"
                  id="password_confirmation"
                  v-model="passwordForm.password_confirmation"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                  :placeholder="$t('profile.confirmNewPassword')"
                />
              </div>
            </div>

            <!-- Success/Error Messages for Password -->
            <div v-if="passwordMessage" class="p-4 rounded-lg" :class="passwordMessageType === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'">
              <div class="flex items-center">
                <svg v-if="passwordMessageType === 'success'" class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <svg v-else class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                {{ passwordMessage }}
              </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
              <button
                type="submit"
                :disabled="passwordLoading"
                class="px-6 py-3 bg-gray-800 text-white font-semibold rounded-lg hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <span v-if="passwordLoading" class="flex items-center">
                  <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  {{ $t('profile.changing') }}
                </span>
                <span v-else>{{ $t('profile.changePasswordButton') }}</span>
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Account Statistics -->
      <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-6 rounded-lg shadow-md">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-600 text-sm">{{ $t('profile.reportsSubmitted') }}</p>
              <p class="text-2xl font-bold text-gray-900 mt-1">{{ stats.totalReports }}</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
              <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-600 text-sm">{{ $t('profile.verifiedReports') }}</p>
              <p class="text-2xl font-bold text-gray-900 mt-1">{{ stats.verifiedReports }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-600 text-sm">{{ $t('profile.memberSince') }}</p>
              <p class="text-2xl font-bold text-gray-900 mt-1">{{ memberSince }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
              <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useI18n } from 'vue-i18n'

const authStore = useAuthStore()
const { t } = useI18n()

// Reactive state
const form = ref({
  name: '',
  email: '',
  phone: '',
  city: ''
})

const loading = ref(false)
const message = ref('')
const messageType = ref('success')
const passwordLoading = ref(false)
const passwordMessage = ref('')
const passwordMessageType = ref('success')
const passwordForm = ref({
  current_password: '',
  password: '',
  password_confirmation: ''
})
const stats = ref({
  totalReports: 0,
  verifiedReports: 0
})

// Computed
const user = computed(() => authStore.user || {})
const memberSince = computed(() => {
  if (user.value.created_at) {
    return new Date(user.value.created_at).toLocaleDateString('en-US', { month: 'short', year: 'numeric' })
  }
  return 'N/A'
})

// Methods
const getUserInitials = () => {
  if (!user.value.name && !user.value.email) return 'U'
  const name = user.value.name || user.value.email
  const words = name.split(' ')
  if (words.length >= 2) {
    return (words[0][0] + words[1][0]).toUpperCase()
  }
  return name[0].toUpperCase()
}

const loadUserData = () => {
  console.log('Loading user data:', user.value)
  form.value = {
    name: user.value.name || '',
    email: user.value.email || '',
    phone: user.value.phone || '',
    city: user.value.city || ''
  }
  console.log('Form data loaded:', form.value)
}

const fetchUserStats = async () => {
  try {
    console.log('Fetching user stats with token:', authStore.token)
    const response = await fetch('/api/user/stats', {
      headers: {
        'Authorization': `Bearer ${authStore.token}`
      }
    })
    console.log('Stats response status:', response.status)
    if (response.ok) {
      const data = await response.json()
      console.log('Stats data:', data)
      stats.value = data
    } else {
      const errorData = await response.text()
      console.error('Error response:', errorData)
    }
  } catch (error) {
    console.error('Error fetching user stats:', error)
  }
}

const updateProfile = async () => {
  loading.value = true
  message.value = ''

  try {
    const response = await fetch('/api/user/profile', {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${authStore.token}`
      },
      body: JSON.stringify(form.value)
    })

    const data = await response.json()

    if (response.ok) {
      messageType.value = 'success'
      message.value = t('profile.profileUpdatedSuccessfully')
      authStore.updateUser(data.user)
      setTimeout(() => {
        message.value = ''
      }, 3000)
    } else {
      messageType.value = 'error'
      message.value = data.message || t('profile.failedToUpdateProfile')
    }
  } catch (error) {
    messageType.value = 'error'
    message.value = t('profile.errorUpdatingProfile')
  } finally {
    loading.value = false
  }
}

const changePassword = async () => {
  passwordLoading.value = true
  passwordMessage.value = ''

  try {
    const response = await fetch('/api/user/password', {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${authStore.token}`
      },
      body: JSON.stringify(passwordForm.value)
    })

    const data = await response.json()

    if (response.ok) {
      passwordMessageType.value = 'success'
      passwordMessage.value = t('profile.passwordChangedSuccessfully')
      // Clear form
      passwordForm.value = {
        current_password: '',
        password: '',
        password_confirmation: ''
      }
      setTimeout(() => {
        passwordMessage.value = ''
      }, 3000)
    } else {
      passwordMessageType.value = 'error'
      passwordMessage.value = data.message || t('profile.failedToChangePassword')
    }
  } catch (error) {
    passwordMessageType.value = 'error'
    passwordMessage.value = t('profile.errorChangingPassword')
  } finally {
    passwordLoading.value = false
  }
}

// Lifecycle
onMounted(async () => {
  // Wait for user data to be available
  if (!user.value && authStore.token) {
    await authStore.fetchUser()
  }
  
  // Now load the form data
  loadUserData()
  fetchUserStats()
})
</script>

