<template>
  <button
    @click="toggleLanguage"
    class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:text-red-600 rounded-md transition-all duration-300 ease-in-out hover:bg-red-50"
    :title="`Switch to ${nextLanguageName}`"
  >
    <!-- Language Flag/Icon -->
    <div class="w-5 h-5 flex items-center justify-center">
      <span v-if="currentLocale === 'en'" class="text-lg">🇺🇸</span>
      <span v-else class="text-lg">🇧🇩</span>
    </div>
    
    <!-- Language Name -->
    <span class="font-medium">{{ currentLanguageName }}</span>
    
    <!-- Toggle Switch Icon -->
    <svg class="w-4 h-4 transition-all duration-300" :class="{ 'scale-110 text-red-600': isTransitioning }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
    </svg>
  </button>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { locale } = useI18n()
const isTransitioning = ref(false)

const languages = [
  { code: 'en', name: 'English' },
  { code: 'bn', name: 'বাংলা' }
]

const currentLocale = computed(() => locale.value)

const currentLanguageName = computed(() => {
  const lang = languages.find(l => l.code === currentLocale.value)
  return lang ? lang.name : 'English'
})

const nextLanguageName = computed(() => {
  const currentIndex = languages.findIndex(l => l.code === currentLocale.value)
  const nextIndex = (currentIndex + 1) % languages.length
  return languages[nextIndex].name
})

const toggleLanguage = () => {
  isTransitioning.value = true
  
  // Find current language index and switch to next
  const currentIndex = languages.findIndex(l => l.code === currentLocale.value)
  const nextIndex = (currentIndex + 1) % languages.length
  const nextLanguage = languages[nextIndex]
  
  // Change language
  locale.value = nextLanguage.code
  localStorage.setItem('locale', nextLanguage.code)
  
  // Reset transition state after animation
  setTimeout(() => {
    isTransitioning.value = false
  }, 300)
}
</script>

