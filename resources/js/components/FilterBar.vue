<template>
  <div class="flex items-center space-x-2">
    <select 
      v-model="localFilters.category" 
      @change="$emit('filter-change', localFilters)"
      class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
    >
      <option value="">All Categories</option>
      <option value="theft_robbery">Theft / Robbery</option>
      <option value="sexual_harassment">Sexual Harassment</option>
      <option value="domestic_violence">Domestic Violence</option>
      <option value="suspicious_activities">Suspicious Activities</option>
      <option value="traffic_accidents">Traffic Accidents</option>
      <option value="drugs">Drugs</option>
      <option value="cybercrime">Cybercrime</option>
    </select>
    
    <select 
      v-model="localFilters.status" 
      @change="$emit('filter-change', localFilters)"
      class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
    >
      <option value="">All Status</option>
      <option value="pending">Pending</option>
      <option value="in_progress">In Progress</option>
      <option value="resolved">Resolved</option>
    </select>
    
    <label class="flex items-center">
      <input 
        type="checkbox" 
        v-model="localFilters.verified" 
        @change="$emit('filter-change', localFilters)"
        class="mr-2"
      >
      Verified Only
    </label>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  filters: {
    type: Object,
    default: () => ({
      category: '',
      status: '',
      verified: false
    })
  }
})

const emit = defineEmits(['filter-change'])

const localFilters = ref({ ...props.filters })

// Watch for external changes to filters
watch(() => props.filters, (newFilters) => {
  localFilters.value = { ...newFilters }
}, { deep: true })
</script>
