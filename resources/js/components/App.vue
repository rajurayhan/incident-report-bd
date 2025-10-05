<template>
  <div id="app" class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <Navigation />

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <router-view />
    </main>

    <!-- Footer -->
    <Footer />
    
    <!-- Scroll to Top Button -->
    <ScrollToTop />
  </div>
</template>

<script setup>
import Navigation from './Navigation.vue'
import Footer from './Footer.vue'
import ScrollToTop from './ScrollToTop.vue'
</script>
