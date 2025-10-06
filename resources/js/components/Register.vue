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
              :class="[
                'mt-1 appearance-none relative block w-full px-3 py-2 border placeholder-gray-500 text-gray-900 rounded-md focus:outline-none sm:text-sm',
                errors.name ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-red-500 focus:border-red-500'
              ]"
              :placeholder="$t('auth.yourFullName')"
            />
            <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ getFieldError('name') }}</p>
          </div>
          
          <div>
            <label for="username" class="block text-sm font-medium text-gray-700">{{ $t('auth.username') }}</label>
            <input
              id="username"
              v-model="form.username"
              name="username"
              type="text"
              required
              :class="[
                'mt-1 appearance-none relative block w-full px-3 py-2 border placeholder-gray-500 text-gray-900 rounded-md focus:outline-none sm:text-sm',
                errors.username ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-red-500 focus:border-red-500'
              ]"
              :placeholder="$t('auth.uniqueUsername')"
              pattern="[a-zA-Z0-9_]+"
              :title="$t('auth.usernamePattern')"
            />
            <p v-if="errors.username" class="mt-1 text-sm text-red-600">{{ getFieldError('username') }}</p>
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
              :class="[
                'mt-1 appearance-none relative block w-full px-3 py-2 border placeholder-gray-500 text-gray-900 rounded-md focus:outline-none sm:text-sm',
                errors.email ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-red-500 focus:border-red-500'
              ]"
              :placeholder="$t('auth.email')"
            />
            <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ getFieldError('email') }}</p>
          </div>
          
          <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">{{ $t('auth.phone') }}</label>
            <input
              id="phone"
              v-model="form.phone"
              name="phone"
              type="tel"
              required
              :class="[
                'mt-1 appearance-none relative block w-full px-3 py-2 border placeholder-gray-500 text-gray-900 rounded-md focus:outline-none sm:text-sm',
                errors.phone ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-red-500 focus:border-red-500'
              ]"
              :placeholder="$t('auth.phonePlaceholder')"
            />
            <p v-if="errors.phone" class="mt-1 text-sm text-red-600">{{ getFieldError('phone') }}</p>
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
              :class="[
                'mt-1 appearance-none relative block w-full px-3 py-2 border placeholder-gray-500 text-gray-900 rounded-md focus:outline-none sm:text-sm',
                errors.password ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-red-500 focus:border-red-500'
              ]"
              :placeholder="$t('auth.password')"
            />
            <p v-if="errors.password" class="mt-1 text-sm text-red-600">{{ getFieldError('password') }}</p>
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
              :class="[
                'mt-1 appearance-none relative block w-full px-3 py-2 border placeholder-gray-500 text-gray-900 rounded-md focus:outline-none sm:text-sm',
                errors.password ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-red-500 focus:border-red-500'
              ]"
              :placeholder="$t('auth.confirmPasswordPlaceholder')"
            />
            <p v-if="errors.password" class="mt-1 text-sm text-red-600">{{ getFieldError('password') }}</p>
          </div>
        </div>

        <div v-if="errors.general" class="rounded-md bg-red-50 p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800">
                {{ errors.general }}
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

const errors = ref({});
const loading = ref(false);

const handleRegister = async () => {
  loading.value = true;
  errors.value = {};

  try {
    const response = await authStore.register(form);
    // Email verification is temporarily disabled
    router.push('/');
  } catch (err) {
    if (err.errors) {
      errors.value = err.errors;
    } else {
      errors.value = { general: err.message || t('auth.registrationFailed') };
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
    'unique:': 'unique',
    'regex:': 'regex',
    'min:': 'min',
    'confirmed': 'confirmed',
    'email': 'email'
  };
  
  let rule = 'required';
  for (const [key, value] of Object.entries(ruleMap)) {
    if (error.includes(key)) {
      rule = value;
      break;
    }
  }
  
  return t(`auth.validation.${field}.${rule}`);
};
</script>
