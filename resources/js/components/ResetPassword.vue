<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Set new password
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Enter your new password to complete the reset
        </p>
      </div>
      
      <form class="mt-8 space-y-6" @submit.prevent="handleResetPassword">
        <div class="space-y-4">
          <!-- Show email field only if not pre-filled from URL -->
          <div v-if="!route.query.email">
            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
            <input
              id="email"
              v-model="form.email"
              name="email"
              type="email"
              autocomplete="email"
              required
              :class="[
                'mt-1 appearance-none relative block w-full px-3 py-2 border rounded-md focus:outline-none sm:text-sm',
                errors.email ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-red-500 focus:border-red-500'
              ]"
              placeholder="Email address"
            />
            <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email[0] }}</p>
          </div>
          
          <!-- Show token field only if not pre-filled from URL -->
          <div v-if="!route.query.token">
            <label for="token" class="block text-sm font-medium text-gray-700">Reset Token</label>
            <input
              id="token"
              v-model="form.token"
              name="token"
              type="text"
              required
              :class="[
                'mt-1 appearance-none relative block w-full px-3 py-2 border rounded-md focus:outline-none sm:text-sm',
                errors.token ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-red-500 focus:border-red-500'
              ]"
              placeholder="Reset token"
            />
            <p v-if="errors.token" class="mt-1 text-sm text-red-600">{{ errors.token[0] }}</p>
          </div>

          <!-- Show confirmation when token and email are pre-filled -->
          <div v-if="route.query.token && route.query.email" class="rounded-md bg-blue-50 p-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">
                  Reset password for {{ route.query.email }}
                </h3>
                <div class="mt-2 text-sm text-blue-700">
                  <p>Please enter your new password below.</p>
                </div>
              </div>
            </div>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
            <input
              id="password"
              v-model="form.password"
              name="password"
              type="password"
              required
              :class="[
                'mt-1 appearance-none relative block w-full px-3 py-2 border rounded-md focus:outline-none sm:text-sm',
                errors.password ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-red-500 focus:border-red-500'
              ]"
              placeholder="New password (min 8 characters)"
            />
            <p v-if="errors.password" class="mt-1 text-sm text-red-600">{{ errors.password[0] }}</p>
          </div>

          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input
              id="password_confirmation"
              v-model="form.password_confirmation"
              name="password_confirmation"
              type="password"
              required
              :class="[
                'mt-1 appearance-none relative block w-full px-3 py-2 border rounded-md focus:outline-none sm:text-sm',
                errors.password_confirmation ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-red-500 focus:border-red-500'
              ]"
              placeholder="Confirm new password"
            />
            <p v-if="errors.password_confirmation" class="mt-1 text-sm text-red-600">{{ errors.password_confirmation[0] }}</p>
          </div>
        </div>

        <div v-if="success" class="rounded-md bg-green-50 p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-green-800">
                Password reset successfully! Redirecting to login...
              </h3>
            </div>
          </div>
        </div>

        <div v-if="error" class="rounded-md bg-red-50 p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800">
                {{ error }}
              </h3>
            </div>
          </div>
        </div>

        <div>
          <button
            type="submit"
            :disabled="loading"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span v-if="loading">Resetting...</span>
            <span v-else>Reset Password</span>
          </button>
        </div>

        <div class="text-center">
          <router-link to="/login" class="font-medium text-red-600 hover:text-red-500">
            Back to Sign In
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const route = useRoute()

const form = reactive({
  email: '',
  token: '',
  password: '',
  password_confirmation: ''
})

const error = ref('')
const errors = ref({})
const success = ref(false)
const loading = ref(false)

// Extract token and email from URL parameters
onMounted(() => {
  if (route.query.token) {
    form.token = route.query.token
  }
  if (route.query.email) {
    form.email = route.query.email
  }
})

const handleResetPassword = async () => {
  loading.value = true
  error.value = ''
  errors.value = {}
  success.value = false

  try {
    await axios.post('/api/reset-password', form)
    
    success.value = true
    setTimeout(() => {
      router.push('/login')
    }, 2000)
  } catch (err) {
    if (err.response?.data?.errors) {
      errors.value = err.response.data.errors
    } else {
      error.value = err.response?.data?.message || 'Failed to reset password. Please check your token and try again.'
    }
  } finally {
    loading.value = false
  }
}
</script>
