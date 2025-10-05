<template>
  <Transition
    enter-active-class="transition-all duration-300 ease-out"
    enter-from-class="opacity-0 scale-75 translate-y-4"
    enter-to-class="opacity-100 scale-100 translate-y-0"
    leave-active-class="transition-all duration-200 ease-in"
    leave-from-class="opacity-100 scale-100 translate-y-0"
    leave-to-class="opacity-0 scale-75 translate-y-4"
  >
    <button
      v-if="showButton"
      @click="scrollToTop"
      class="fixed bottom-6 right-6 z-40 bg-red-600 hover:bg-red-700 text-white p-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-110 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
      :class="{ 'animate-bounce': isScrolling }"
      aria-label="Scroll to top"
    >
      <svg 
        class="w-6 h-6" 
        fill="none" 
        stroke="currentColor" 
        viewBox="0 0 24 24"
      >
        <path 
          stroke-linecap="round" 
          stroke-linejoin="round" 
          stroke-width="2" 
          d="M5 10l7-7m0 0l7 7m-7-7v18"
        />
      </svg>
    </button>
  </Transition>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const showButton = ref(false)
const isScrolling = ref(false)
const scrollThreshold = 300 // Show button after scrolling 300px

// Smooth scroll to top function
const scrollToTop = () => {
  isScrolling.value = true
  
  const currentScrollY = window.scrollY
  const startTime = performance.now()
  const duration = Math.min(600, currentScrollY * 0.4)
  
  const animateScroll = (currentTime) => {
    const elapsed = currentTime - startTime
    const progress = Math.min(elapsed / duration, 1)
    
    // Use easeOutCubic for smooth deceleration
    const easeOutCubic = 1 - Math.pow(1 - progress, 3)
    const scrollY = currentScrollY * (1 - easeOutCubic)
    
    window.scrollTo(0, scrollY)
    
    if (progress < 1) {
      requestAnimationFrame(animateScroll)
    } else {
      isScrolling.value = false
    }
  }
  
  requestAnimationFrame(animateScroll)
}

// Handle scroll events
const handleScroll = () => {
  const scrollY = window.scrollY
  showButton.value = scrollY > scrollThreshold
}

// Lifecycle hooks
onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true })
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
/* Custom bounce animation */
@keyframes bounce {
  0%, 20%, 53%, 80%, 100% {
    transform: translate3d(0, 0, 0);
  }
  40%, 43% {
    transform: translate3d(0, -8px, 0);
  }
  70% {
    transform: translate3d(0, -4px, 0);
  }
  90% {
    transform: translate3d(0, -2px, 0);
  }
}

.animate-bounce {
  animation: bounce 1s infinite;
}
</style>
