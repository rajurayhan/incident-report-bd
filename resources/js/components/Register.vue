<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          {{ $t('auth.createAccount') }}
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          {{ $t('auth.orSignInExisting') }}
          <router-link to="/login" class="font-medium text-red-600 hover:text-red-500">
            {{ $t('nav.login') }}
          </router-link>
        </p>
      </div>
      
      <form class="mt-8 space-y-6" @submit.prevent="handleRegister">
        <div class="space-y-4">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">{{ $t('auth.name') }}</label>
            <input
              id="name"
              v-model="form.name"
              name="name"
              type="text"
              required
              class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
              :placeholder="$t('auth.yourFullName')"
            />
          </div>
          
          <div>
            <label for="username" class="block text-sm font-medium text-gray-700">{{ $t('auth.username') }}</label>
            <input
              id="username"
              v-model="form.username"
              name="username"
              type="text"
              required
              class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
              :placeholder="$t('auth.uniqueUsername')"
              pattern="[a-zA-Z0-9_]+"
              :title="$t('auth.usernamePattern')"
            />
          </div>
          
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">{{ $t('auth.emailAddress') }}</label>
            <input
              id="email"
              v-model="form.email"
              name="email"
              type="email"
              autocomplete="email"
              required
              class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
              :placeholder="$t('auth.email')"
            />
          </div>
          
          <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">{{ $t('auth.phone') }}</label>
            <input
              id="phone"
              v-model="form.phone"
              name="phone"
              type="tel"
              required
              class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
              :placeholder="$t('auth.phonePlaceholder')"
            />
          </div>
          
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">{{ $t('auth.password') }}</label>
            <input
              id="password"
              v-model="form.password"
              name="password"
              type="password"
              autocomplete="new-password"
              required
              class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
              :placeholder="$t('auth.password')"
            />
          </div>
          
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ $t('auth.confirmPassword') }}</label>
            <input
              id="password_confirmation"
              v-model="form.password_confirmation"
              name="password_confirmation"
              type="password"
              autocomplete="new-password"
              required
              class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
              :placeholder="$t('auth.confirmPasswordPlaceholder')"
            />
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
            <span v-if="loading">{{ $t('auth.creatingAccount') }}</span>
            <span v-else>{{ $t('auth.registerButton') }}</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import { useI18n } from 'vue-i18n';

const router = useRouter();
const authStore = useAuthStore();
const { t } = useI18n();

const form = reactive({
  name: '',
  username: '',
  email: '',
  phone: '',
  password: '',
  password_confirmation: '',
});

const error = ref('');
const loading = ref(false);

const handleRegister = async () => {
  loading.value = true;
  error.value = '';

  try {
    await authStore.register(form);
    router.push('/');
  } catch (err) {
    error.value = err.message || t('auth.registrationFailed');
  } finally {
    loading.value = false;
  }
};
</script>
