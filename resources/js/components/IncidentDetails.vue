<template>
  <div class="max-w-4xl mx-auto">
    <div v-if="loading" class="bg-white shadow-lg rounded-lg p-6">
      <div class="animate-pulse">
        <div class="h-8 bg-gray-200 rounded w-1/3 mb-4"></div>
        <div class="h-4 bg-gray-200 rounded w-2/3 mb-2"></div>
        <div class="h-4 bg-gray-200 rounded w-1/2"></div>
      </div>
    </div>

    <div v-else-if="error" class="bg-white shadow-lg rounded-lg p-6">
      <div class="text-red-600">
        <h2 class="text-xl font-bold mb-2">Error</h2>
        <p>{{ error }}</p>
      </div>
    </div>

    <div v-else-if="incident" class="bg-white shadow-lg rounded-lg p-6">
      <!-- Header -->
      <PageHeader 
        :title="incident.title"
        :subtitle="`${incident.category_label} • ${incident.status_label} • ${incident.priority_label}`"
      >
        <template #actions>
          <div class="text-right text-sm text-gray-500">
            <p>Reported: {{ formatDate(incident.created_at) }}</p>
            <p v-if="incident.incident_date">Incident Date: {{ formatDate(incident.incident_date) }}</p>
          </div>
        </template>
      </PageHeader>

      <!-- Description -->
      <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
        <p class="text-gray-700 leading-relaxed">{{ incident.description }}</p>
      </div>

      <!-- Location -->
      <div v-if="incident.latitude && incident.longitude" class="mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Location</h3>
        
        <!-- Address Information -->
        <div class="text-gray-700 mb-4">
          <p v-if="incident.address" class="mb-2">
            <span class="font-medium">Address:</span> {{ incident.address }}
          </p>
          <p v-if="incident.city" class="mb-2">
            <span class="font-medium">Area:</span> {{ incident.city }}, {{ incident.district }}, {{ incident.division }}
          </p>
          <p class="text-sm text-gray-500 mb-4">
            <span class="font-medium">Coordinates:</span> {{ incident.latitude }}, {{ incident.longitude }}
          </p>
        </div>

        <!-- Google Map -->
        <div class="relative">
          <div id="incident-map" class="w-full h-96 rounded-lg overflow-hidden border border-gray-200 shadow-sm"></div>
          
          <!-- Map Controls -->
          <div class="absolute top-4 right-4 z-10 flex flex-col space-y-2">
            <button @click="centerMap" 
                    class="bg-white hover:bg-gray-50 text-gray-700 px-3 py-2 rounded-lg shadow-md transition-colors duration-200 text-sm font-medium">
              <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              Center
            </button>
            
            <button @click="toggleMapType" 
                    class="bg-white hover:bg-gray-50 text-gray-700 px-3 py-2 rounded-lg shadow-md transition-colors duration-200 text-sm font-medium">
              <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
              </svg>
              {{ mapType === 'roadmap' ? 'Satellite' : 'Map' }}
            </button>
          </div>

          <!-- Map Info -->
          <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-2 rounded-lg shadow-md text-sm text-gray-700">
            <div class="flex items-center space-x-2">
              <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
              </svg>
              <span>Incident Location</span>
            </div>
          </div>
        </div>

        <!-- Additional Location Actions -->
        <div class="mt-4 flex flex-wrap gap-2">
          <a :href="getGoogleMapsUrl()" 
             target="_blank" 
             class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg>
            Open in Google Maps
          </a>
          
          <button @click="copyCoordinates" 
                  class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            Copy Coordinates
          </button>
        </div>
      </div>

      <!-- Reporter Info -->
      <div v-if="!incident.is_anonymous" class="mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Reporter Information</h3>
        <div class="text-gray-700">
          <p v-if="incident.user">{{ incident.user.name }}</p>
          <p v-if="incident.reporter_phone">{{ incident.reporter_phone }}</p>
          <p v-if="incident.reporter_email">{{ incident.reporter_email }}</p>
        </div>
      </div>

      <!-- Media Slider -->
      <div v-if="incident.media && incident.media.length > 0" class="mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Media</h3>
        
        <!-- CSS Radio Button Slider -->
        <div class="media-slider">
          <!-- Radio Inputs for Navigation -->
          <input 
            v-for="(media, index) in incident.media" 
            :key="`radio-${media.id}`"
            type="radio" 
            :name="`slider-${incident.id}`" 
            :id="`slide-${incident.id}-${index}`"
            :checked="index === 0"
            class="slider-radio"
            @change="updateSliderIndex(index)"
          >
          
          <!-- Slides Container -->
          <div class="slides-container">
            <div 
              v-for="(media, index) in incident.media" 
              :key="`slide-${media.id}`"
              class="slide"
              @click="openGallery(index)"
            >
              <!-- Image Slide -->
              <div v-if="media.file_type === 'image'" class="slide-content">
                <img 
                  :src="getMediaUrl(media)" 
                  :alt="media.file_name"
                  class="slide-image"
                  @load="console.log('Image loaded:', media.file_name)"
                  @error="console.log('Image failed to load:', $event.target.src)"
                >
                
                <!-- Zoom Overlay -->
                <div class="zoom-overlay">
                  <svg class="zoom-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                  </svg>
                </div>
              </div>
              
              <!-- Video Slide -->
              <div v-else-if="media.file_type === 'video'" class="slide-content video-slide">
                <div class="video-placeholder">
                  <div class="video-icon">▶️</div>
                  <div class="video-title">{{ media.file_name }}</div>
                  <div class="video-type">{{ media.file_type }}</div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Navigation Dots -->
          <div class="navigation-dots">
            <label 
              v-for="(media, index) in incident.media" 
              :key="`dot-${media.id}`"
              :for="`slide-${incident.id}-${index}`"
              class="nav-dot"
            ></label>
          </div>
          
          <!-- Slide Counter -->
          <div class="slide-counter">
            <span class="current-slide">{{ currentSliderIndex + 1 }}</span>
            <span class="slide-separator">/</span>
            <span class="total-slides">{{ incident.media.length }}</span>
          </div>
        </div>
      </div>

      <!-- Modern Minimal Gallery Modal -->
      <div v-if="showGallery" 
           class="fixed inset-0 bg-black/95 z-50 flex items-center justify-center"
           @click="closeGallery">
        
        <!-- Close Button -->
        <button @click="closeGallery" 
                class="absolute top-6 right-6 z-20 text-white/70 hover:text-white transition-colors duration-200">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>

        <!-- Navigation -->
        <button v-if="currentImageIndex > 0" 
                @click.stop="previousImage" 
                class="absolute left-6 top-1/2 -translate-y-1/2 z-20 text-white/70 hover:text-white transition-colors duration-200">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"></path>
          </svg>
        </button>

        <button v-if="currentImageIndex < imageMedia.length - 1" 
                @click.stop="nextImage" 
                class="absolute right-6 top-1/2 -translate-y-1/2 z-20 text-white/70 hover:text-white transition-colors duration-200">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"></path>
          </svg>
        </button>

        <!-- Image Counter -->
        <div class="absolute top-6 left-6 z-20 text-white/70 text-sm font-medium">
          {{ currentImageIndex + 1 }} / {{ imageMedia.length }}
        </div>

        <!-- Main Image Container -->
        <div class="relative max-w-[90vw] max-h-[90vh] flex items-center justify-center" @click.stop>
          <img :src="getMediaUrl(imageMedia[currentImageIndex])" 
               :alt="imageMedia[currentImageIndex].file_name"
               class="max-w-full max-h-full object-contain rounded-lg"
               :style="{ transform: `scale(${zoomLevel})`, transition: 'transform 0.2s ease-out' }"
               @wheel="handleWheel"
               ref="galleryImage">
        </div>

        <!-- Minimal Controls -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex items-center space-x-1 bg-white/10 backdrop-blur-sm rounded-full px-3 py-2">
          <button @click.stop="zoomOut" 
                  class="text-white/70 hover:text-white transition-colors duration-200 p-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 12H4"></path>
            </svg>
          </button>
          <span class="text-white/70 text-xs px-2 font-medium">{{ Math.round(zoomLevel * 100) }}%</span>
          <button @click.stop="zoomIn" 
                  class="text-white/70 hover:text-white transition-colors duration-200 p-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path>
            </svg>
          </button>
          <div class="w-px h-4 bg-white/20 mx-1"></div>
          <button @click.stop="resetZoom" 
                  class="text-white/70 hover:text-white transition-colors duration-200 p-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
          </button>
        </div>

        <!-- Minimal Thumbnails -->
        <div v-if="imageMedia.length > 1" 
             class="absolute bottom-20 left-1/2 -translate-x-1/2 z-20 flex space-x-2 max-w-[80vw] overflow-x-auto">
          <div v-for="(media, index) in imageMedia" :key="media.id" 
               @click.stop="goToImage(index)"
               class="flex-shrink-0 w-12 h-12 rounded-lg overflow-hidden cursor-pointer transition-all duration-200"
               :class="index === currentImageIndex ? 'ring-2 ring-white' : 'opacity-50 hover:opacity-75'">
            <img :src="getMediaUrl(media)" 
                 :alt="media.file_name"
                 class="w-full h-full object-cover">
          </div>
        </div>
      </div>

      <!-- Verification Status -->
      <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Verification Status</h3>
        <div class="flex items-center space-x-4">
          <div class="text-center">
            <div class="text-2xl font-bold text-green-600">{{ incident.verification_count }}</div>
            <div class="text-sm text-gray-600">Confirmations</div>
          </div>
          <div class="text-center">
            <div class="text-2xl font-bold text-red-600">{{ incident.dispute_count }}</div>
            <div class="text-sm text-gray-600">Disputes</div>
          </div>
          <div class="text-center">
            <div class="text-2xl font-bold text-blue-600">{{ getVerificationRatio() }}%</div>
            <div class="text-sm text-gray-600">Verified</div>
          </div>
        </div>
      </div>

      <!-- Comments -->
      <div v-if="incident.comments && incident.comments.length > 0" class="mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Comments ({{ incident.comments.length }})</h3>
        <div class="space-y-4">
          <div v-for="comment in incident.comments" :key="comment.id" 
               class="border-l-4 border-blue-500 pl-4 py-2">
            <div class="flex justify-between items-start">
              <div>
                <p class="font-medium text-gray-900">{{ comment.commenter_display_name }}</p>
                <p class="text-gray-700">{{ comment.content }}</p>
              </div>
              <span class="text-sm text-gray-500">{{ formatDate(comment.created_at) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="bg-white shadow-lg rounded-lg p-6">
      <div class="text-center text-gray-600">
        <h2 class="text-xl font-bold mb-2">Incident Not Found</h2>
        <p>The incident you're looking for doesn't exist or has been removed.</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* CSS Radio Button Slider Styles */
.media-slider {
  position: relative;
  width: 100%;
  height: 400px;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  background: #f8fafc;
}

.slider-radio {
  display: none;
}

.slides-container {
  position: relative;
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.slide {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  transform: translateX(100%);
  transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
}

.slide-content {
  position: relative;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.slide-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.slide:hover .slide-image {
  transform: scale(1.05);
}

.zoom-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  opacity: 0;
}

.slide:hover .zoom-overlay {
  background: rgba(0, 0, 0, 0.3);
  opacity: 1;
}

.zoom-icon {
  width: 48px;
  height: 48px;
  color: white;
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
}

.video-slide {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.video-placeholder {
  text-align: center;
  color: white;
  padding: 2rem;
}

.video-icon {
  font-size: 4rem;
  margin-bottom: 1rem;
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
}

.video-title {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.video-type {
  font-size: 0.875rem;
  opacity: 0.8;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

/* Radio button navigation - Show first slide by default */
.slide:first-child {
  opacity: 1;
  transform: translateX(0);
}

/* Radio button navigation - Show specific slide when radio is checked */
.slider-radio:nth-child(1):checked ~ .slides-container .slide:nth-child(1) {
  opacity: 1;
  transform: translateX(0);
}

.slider-radio:nth-child(2):checked ~ .slides-container .slide:nth-child(1) {
  opacity: 0;
  transform: translateX(-100%);
}

.slider-radio:nth-child(2):checked ~ .slides-container .slide:nth-child(2) {
  opacity: 1;
  transform: translateX(0);
}

.slider-radio:nth-child(3):checked ~ .slides-container .slide:nth-child(1),
.slider-radio:nth-child(3):checked ~ .slides-container .slide:nth-child(2) {
  opacity: 0;
  transform: translateX(-100%);
}

.slider-radio:nth-child(3):checked ~ .slides-container .slide:nth-child(3) {
  opacity: 1;
  transform: translateX(0);
}

.slider-radio:nth-child(4):checked ~ .slides-container .slide:nth-child(1),
.slider-radio:nth-child(4):checked ~ .slides-container .slide:nth-child(2),
.slider-radio:nth-child(4):checked ~ .slides-container .slide:nth-child(3) {
  opacity: 0;
  transform: translateX(-100%);
}

.slider-radio:nth-child(4):checked ~ .slides-container .slide:nth-child(4) {
  opacity: 1;
  transform: translateX(0);
}

.slider-radio:nth-child(5):checked ~ .slides-container .slide:nth-child(1),
.slider-radio:nth-child(5):checked ~ .slides-container .slide:nth-child(2),
.slider-radio:nth-child(5):checked ~ .slides-container .slide:nth-child(3),
.slider-radio:nth-child(5):checked ~ .slides-container .slide:nth-child(4) {
  opacity: 0;
  transform: translateX(-100%);
}

.slider-radio:nth-child(5):checked ~ .slides-container .slide:nth-child(5) {
  opacity: 1;
  transform: translateX(0);
}

/* Navigation Dots */
.navigation-dots {
  position: absolute;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 8px;
  z-index: 10;
}

.nav-dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.5);
  cursor: pointer;
  transition: all 0.3s ease;
  border: 2px solid transparent;
}

.nav-dot:hover {
  background: rgba(255, 255, 255, 0.8);
  transform: scale(1.2);
}

/* Navigation dots - Show first dot as active by default */
.nav-dot:first-child {
  background: white;
  box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
}

/* Navigation dots - Show specific dot as active when radio is checked */
.slider-radio:nth-child(1):checked ~ .navigation-dots .nav-dot:nth-child(1) {
  background: white;
  box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
}

.slider-radio:nth-child(2):checked ~ .navigation-dots .nav-dot:nth-child(1) {
  background: rgba(255, 255, 255, 0.5);
  box-shadow: none;
}

.slider-radio:nth-child(2):checked ~ .navigation-dots .nav-dot:nth-child(2) {
  background: white;
  box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
}

.slider-radio:nth-child(3):checked ~ .navigation-dots .nav-dot:nth-child(1),
.slider-radio:nth-child(3):checked ~ .navigation-dots .nav-dot:nth-child(2) {
  background: rgba(255, 255, 255, 0.5);
  box-shadow: none;
}

.slider-radio:nth-child(3):checked ~ .navigation-dots .nav-dot:nth-child(3) {
  background: white;
  box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
}

.slider-radio:nth-child(4):checked ~ .navigation-dots .nav-dot:nth-child(1),
.slider-radio:nth-child(4):checked ~ .navigation-dots .nav-dot:nth-child(2),
.slider-radio:nth-child(4):checked ~ .navigation-dots .nav-dot:nth-child(3) {
  background: rgba(255, 255, 255, 0.5);
  box-shadow: none;
}

.slider-radio:nth-child(4):checked ~ .navigation-dots .nav-dot:nth-child(4) {
  background: white;
  box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
}

.slider-radio:nth-child(5):checked ~ .navigation-dots .nav-dot:nth-child(1),
.slider-radio:nth-child(5):checked ~ .navigation-dots .nav-dot:nth-child(2),
.slider-radio:nth-child(5):checked ~ .navigation-dots .nav-dot:nth-child(3),
.slider-radio:nth-child(5):checked ~ .navigation-dots .nav-dot:nth-child(4) {
  background: rgba(255, 255, 255, 0.5);
  box-shadow: none;
}

.slider-radio:nth-child(5):checked ~ .navigation-dots .nav-dot:nth-child(5) {
  background: white;
  box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
}

/* Slide Counter */
.slide-counter {
  position: absolute;
  top: 20px;
  right: 20px;
  background: rgba(0, 0, 0, 0.7);
  color: white;
  padding: 8px 16px;
  border-radius: 20px;
  font-size: 0.875rem;
  font-weight: 500;
  backdrop-filter: blur(10px);
  z-index: 10;
}

.current-slide {
  font-weight: 600;
}

.slide-separator {
  margin: 0 4px;
  opacity: 0.7;
}

.total-slides {
  opacity: 0.8;
}

/* Responsive Design */
@media (max-width: 768px) {
  .media-slider {
    height: 300px;
  }
  
  .navigation-dots {
    bottom: 15px;
  }
  
  .nav-dot {
    width: 10px;
    height: 10px;
  }
  
  .slide-counter {
    top: 15px;
    right: 15px;
    padding: 6px 12px;
    font-size: 0.75rem;
  }
  
  .video-icon {
    font-size: 3rem;
  }
  
  .video-title {
    font-size: 1rem;
  }
}

@media (max-width: 480px) {
  .media-slider {
    height: 250px;
  }
  
  .zoom-icon {
    width: 36px;
    height: 36px;
  }
  
  .video-icon {
    font-size: 2.5rem;
  }
}

/* Animation for slide transitions */
@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateX(100%);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

@keyframes slideOut {
  from {
    opacity: 1;
    transform: translateX(0);
  }
  to {
    opacity: 0;
    transform: translateX(-100%);
  }
}

/* Smooth transitions for all slides */
.slide {
  animation: slideIn 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Focus styles for accessibility */
.slider-radio:focus + .slides-container .slide {
  outline: 2px solid #3b82f6;
  outline-offset: 2px;
}

.nav-dot:focus {
  outline: 2px solid #3b82f6;
  outline-offset: 2px;
}
</style>

<script setup>
import { ref, onMounted, onUnmounted, computed, watch } from 'vue'
import { useRoute } from 'vue-router'
import PageHeader from './PageHeader.vue'

const route = useRoute()
const incident = ref(null)
const loading = ref(true)
const error = ref(null)

// Gallery state
const showGallery = ref(false)
const currentImageIndex = ref(0)
const zoomLevel = ref(1)
const isDragging = ref(false)
const dragStart = ref({ x: 0, y: 0 })
const galleryImage = ref(null)

// Slider state
const currentSliderIndex = ref(0)

// Google Maps state
const map = ref(null)
const marker = ref(null)
const mapType = ref('roadmap')

// Computed property for image media only
const imageMedia = computed(() => {
  return incident.value?.media?.filter(media => media.file_type === 'image') || []
})

// Computed property for current slider media
const currentSliderMedia = computed(() => {
  return incident.value?.media?.[currentSliderIndex.value] || null
})

const fetchIncident = async () => {
  try {
    loading.value = true
    error.value = null
    
    const response = await fetch(`/api/incidents/${route.params.id}`)
    
    if (!response.ok) {
      if (response.status === 404) {
        error.value = 'Incident not found'
      } else {
        error.value = 'Failed to load incident'
      }
      return
    }
    
    const data = await response.json()
    incident.value = data
    
    // Debug: Log media data
    console.log('Incident media:', incident.value.media)
    console.log('Current slider index:', currentSliderIndex.value)
    console.log('First media item:', incident.value.media?.[0])
    
    // Reset slider to first image when incident loads
    currentSliderIndex.value = 0
  } catch (err) {
    error.value = 'Network error occurred'
    console.error('Error fetching incident:', err)
  } finally {
    loading.value = false
  }
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const getMediaUrl = (media) => {
  const url = `/storage/${media.file_path}`
  console.log('Generated media URL:', url, 'for file:', media.file_name)
  return url
}

const getVerificationRatio = () => {
  if (!incident.value) return '0.0'
  
  const total = incident.value.verification_count + incident.value.dispute_count
  if (total === 0) return '0.0'
  
  const ratio = (incident.value.verification_count / total) * 100
  return ratio.toFixed(1)
}

// Google Maps functions
const initializeMap = () => {
  if (!incident.value?.latitude || !incident.value?.longitude) return
  
  const mapElement = document.getElementById('incident-map')
  if (!mapElement) return
  
  const location = {
    lat: parseFloat(incident.value.latitude),
    lng: parseFloat(incident.value.longitude)
  }
  
  // Initialize map
  map.value = new google.maps.Map(mapElement, {
    zoom: 15,
    center: location,
    mapTypeId: mapType.value === 'roadmap' ? google.maps.MapTypeId.ROADMAP : google.maps.MapTypeId.SATELLITE,
    styles: [
      {
        featureType: 'poi',
        elementType: 'labels',
        stylers: [{ visibility: 'off' }]
      }
    ]
  })
  
  // Add marker
  marker.value = new google.maps.Marker({
    position: location,
    map: map.value,
    title: 'Incident Location',
    icon: {
      url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
        <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
          <circle cx="16" cy="16" r="12" fill="#ef4444" stroke="#ffffff" stroke-width="3"/>
          <circle cx="16" cy="16" r="6" fill="#ffffff"/>
        </svg>
      `),
      scaledSize: new google.maps.Size(32, 32),
      anchor: new google.maps.Point(16, 16)
    }
  })
  
  // Add info window
  const infoWindow = new google.maps.InfoWindow({
    content: `
      <div class="p-2">
        <h3 class="font-semibold text-gray-900 mb-1">Incident Location</h3>
        <p class="text-sm text-gray-600 mb-2">${incident.value.address || 'Location coordinates'}</p>
        <p class="text-xs text-gray-500">${incident.value.latitude}, ${incident.value.longitude}</p>
      </div>
    `
  })
  
  marker.value.addListener('click', () => {
    infoWindow.open(map.value, marker.value)
  })
}

const centerMap = () => {
  if (!map.value || !incident.value?.latitude || !incident.value?.longitude) return
  
  const location = {
    lat: parseFloat(incident.value.latitude),
    lng: parseFloat(incident.value.longitude)
  }
  
  map.value.setCenter(location)
  map.value.setZoom(15)
}

const toggleMapType = () => {
  if (!map.value) return
  
  mapType.value = mapType.value === 'roadmap' ? 'satellite' : 'roadmap'
  map.value.setMapTypeId(
    mapType.value === 'roadmap' 
      ? google.maps.MapTypeId.ROADMAP 
      : google.maps.MapTypeId.SATELLITE
  )
}

const getGoogleMapsUrl = () => {
  if (!incident.value?.latitude || !incident.value?.longitude) return '#'
  
  const lat = incident.value.latitude
  const lng = incident.value.longitude
  const address = incident.value.address ? encodeURIComponent(incident.value.address) : ''
  
  return `https://www.google.com/maps?q=${lat},${lng}${address ? `+(${address})` : ''}`
}

const copyCoordinates = async () => {
  if (!incident.value?.latitude || !incident.value?.longitude) return
  
  const coordinates = `${incident.value.latitude}, ${incident.value.longitude}`
  
  try {
    await navigator.clipboard.writeText(coordinates)
    // You could add a toast notification here
    console.log('Coordinates copied to clipboard:', coordinates)
  } catch (err) {
    console.error('Failed to copy coordinates:', err)
    // Fallback for older browsers
    const textArea = document.createElement('textarea')
    textArea.value = coordinates
    document.body.appendChild(textArea)
    textArea.select()
    document.execCommand('copy')
    document.body.removeChild(textArea)
  }
}

// Slider functions
const nextSliderImage = () => {
  if (currentSliderIndex.value < incident.value.media.length - 1) {
    currentSliderIndex.value++
    // Trigger radio button change
    const radioId = `slide-${incident.value.id}-${currentSliderIndex.value}`
    const radio = document.getElementById(radioId)
    if (radio) radio.checked = true
  }
}

const previousSliderImage = () => {
  if (currentSliderIndex.value > 0) {
    currentSliderIndex.value--
    // Trigger radio button change
    const radioId = `slide-${incident.value.id}-${currentSliderIndex.value}`
    const radio = document.getElementById(radioId)
    if (radio) radio.checked = true
  }
}

const goToSliderImage = (index) => {
  currentSliderIndex.value = index
  // Trigger radio button change
  const radioId = `slide-${incident.value.id}-${index}`
  const radio = document.getElementById(radioId)
  if (radio) radio.checked = true
}

// Update slider index when radio button changes
const updateSliderIndex = (index) => {
  currentSliderIndex.value = index
}

// Gallery functions
const openGallery = (sliderIndex) => {
  // Find the first image media item
  const imageMediaItems = incident.value.media.filter(media => media.file_type === 'image')
  if (imageMediaItems.length > 0) {
    // Find the image index that corresponds to the slider index
    const imageIndex = incident.value.media.findIndex((media, index) => 
      index === sliderIndex && media.file_type === 'image'
    )
    
    if (imageIndex !== -1) {
      // Find the position of this image in the imageMedia array
      const imagePosition = imageMediaItems.findIndex(img => 
        img.id === incident.value.media[imageIndex].id
      )
      currentImageIndex.value = imagePosition
    } else {
      // If the clicked item is not an image, open the first image
      currentImageIndex.value = 0
    }
    
    showGallery.value = true
    zoomLevel.value = 1
    document.body.style.overflow = 'hidden'
  }
}

const closeGallery = () => {
  showGallery.value = false
  document.body.style.overflow = 'auto'
}

const nextImage = () => {
  if (currentImageIndex.value < imageMedia.value.length - 1) {
    currentImageIndex.value++
    zoomLevel.value = 1
  }
}

const previousImage = () => {
  if (currentImageIndex.value > 0) {
    currentImageIndex.value--
    zoomLevel.value = 1
  }
}

const goToImage = (index) => {
  currentImageIndex.value = index
  zoomLevel.value = 1
}

const zoomIn = () => {
  zoomLevel.value = Math.min(zoomLevel.value + 0.25, 3)
}

const zoomOut = () => {
  zoomLevel.value = Math.max(zoomLevel.value - 0.25, 0.5)
}

const resetZoom = () => {
  zoomLevel.value = 1
}

const handleWheel = (event) => {
  event.preventDefault()
  if (event.deltaY < 0) {
    zoomIn()
  } else {
    zoomOut()
  }
}

const startDrag = (event) => {
  isDragging.value = true
  dragStart.value = { x: event.clientX, y: event.clientY }
  event.preventDefault()
}

const handleDrag = (event) => {
  if (!isDragging.value) return
  event.preventDefault()
  // Drag functionality can be enhanced here
}

const endDrag = () => {
  isDragging.value = false
}

// Keyboard navigation
const handleKeydown = (event) => {
  if (!showGallery.value) {
    // Slider navigation when gallery is closed
    if (incident.value?.media?.length > 1) {
      switch (event.key) {
        case 'ArrowLeft':
          event.preventDefault()
          previousSliderImage()
          break
        case 'ArrowRight':
          event.preventDefault()
          nextSliderImage()
          break
      }
    }
    return
  }
  
  // Gallery navigation when gallery is open
  switch (event.key) {
    case 'Escape':
      closeGallery()
      break
    case 'ArrowLeft':
      previousImage()
      break
    case 'ArrowRight':
      nextImage()
      break
    case '+':
    case '=':
      zoomIn()
      break
    case '-':
      zoomOut()
      break
    case '0':
      resetZoom()
      break
  }
}

// Watch for incident changes and reset slider
watch(() => incident.value, (newIncident) => {
  if (newIncident && newIncident.media && newIncident.media.length > 0) {
    currentSliderIndex.value = 0
    console.log('Incident loaded, reset slider to index 0')
  }
  
  // Initialize map when incident loads
  if (newIncident && newIncident.latitude && newIncident.longitude) {
    // Wait for Google Maps to load
    setTimeout(() => {
      if (window.google && window.google.maps) {
        initializeMap()
      } else {
        // Retry if Google Maps isn't loaded yet
        setTimeout(() => {
          if (window.google && window.google.maps) {
            initializeMap()
          }
        }, 1000)
      }
    }, 100)
  }
}, { immediate: true })

onMounted(() => {
  fetchIncident()
  document.addEventListener('keydown', handleKeydown)
})

// Cleanup
onUnmounted(() => {
  document.removeEventListener('keydown', handleKeydown)
  document.body.style.overflow = 'auto'
})
</script>

<style scoped>
/* Modern minimal gallery styles */
.gallery-image {
  cursor: grab;
  user-select: none;
}

.gallery-image:active {
  cursor: grabbing;
}

/* Smooth transitions */
.gallery-transition-enter-active,
.gallery-transition-leave-active {
  transition: opacity 0.2s ease;
}

.gallery-transition-enter-from,
.gallery-transition-leave-to {
  opacity: 0;
}

/* Minimal hover effects */
.thumbnail:hover {
  transform: scale(1.02);
}

/* Modern backdrop blur */
.backdrop-blur-sm {
  backdrop-filter: blur(8px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .gallery-modal {
    padding: 1rem;
  }
  
  .thumbnail-strip {
    bottom: 1rem;
  }
  
  .zoom-controls {
    bottom: 1rem;
  }
}

/* Clean, minimal animations */
.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Subtle opacity changes */
.group-hover\:opacity-80:hover {
  opacity: 0.8;
}

.group-hover\:opacity-75:hover {
  opacity: 0.75;
}

.group-hover\:opacity-50:hover {
  opacity: 0.5;
}
</style>
