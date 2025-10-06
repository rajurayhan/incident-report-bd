<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Email Verification Required
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Please verify your email address to continue using the platform
        </p>
      </div>
      
      <div class="mt-8 space-y-6">
        <div class="rounded-md bg-yellow-50 p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-yellow-800">
                Verification Required
              </h3>
              <div class="mt-2 text-sm text-yellow-700">
                <p>You need to verify your email address before you can:</p>
                <ul class="mt-2 list-disc list-inside space-y-1">
                  <li>Report incidents</li>
                  <li>Add comments</li>
                  <li>Upvote or downvote</li>
                  <li>Verify incidents</li>
                </ul>
              </div>
            </div>
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
                {{ successMessage }}
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

        <div class="space-y-4">
          <button
            @click="resendVerificationEmail"
            :disabled="loading"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span v-if="loading">Sending...</span>
            <span v-else>Resend Verification Email</span>
          </button>

          <button
            @click="refreshUser"
            :disabled="loading"
            class="group relative w-full flex justify-center py-2 px-4 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span v-if="loading">Checking...</span>
            <span v-else>Check Verification Status</span>
          </button>
        </div>

        <div class="text-center">
          <button
            @click="logout"
            class="font-medium text-gray-600 hover:text-gray-500"
          >
            Sign Out
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import { useAuthStore } from '../stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const error = ref('')
const success = ref(false)
const successMessage = ref('')
const loading = ref(false)

const resendVerificationEmail = async () => {
  loading.value = true
  error.value = ''
  success.value = false

  try {
    const response = await axios.post('/api/email/verification-notification')
    success.value = true
    successMessage.value = response.data.message
  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to send verification email. Please try again.'
  } finally {
    loading.value = false
  }
}

const refreshUser = async () => {
  loading.value = true
  error.value = ''
  success.value = false

  try {
    await authStore.fetchUser()
    if (authStore.user?.email_verified_at) {
      success.value = true
      successMessage.value = 'Email verified successfully! You can now use all features.'
      setTimeout(() => {
        router.push('/')
      }, 2000)
    } else {
      error.value = 'Email not yet verified. Please check your email and click the verification link.'
    }
  } catch (err) {
    error.value = 'Failed to check verification status. Please try again.'
  } finally {
    loading.value = false
  }
}

const logout = async () => {
  await authStore.logout()
  router.push('/login')
}
</script>
