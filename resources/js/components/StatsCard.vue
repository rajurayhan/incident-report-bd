<template>
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
      <div :class="['p-2 rounded-lg', iconBgClass]">
        <slot name="icon"></slot>
      </div>
      <div class="ml-4">
        <p class="text-sm font-medium text-gray-600">{{ label }}</p>
        <p class="text-2xl font-semibold text-gray-900">{{ value }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  label: {
    type: String,
    required: true
  },
  value: {
    type: [String, Number],
    required: true
  },
  iconBgClass: {
    type: String,
    default: 'bg-gray-100'
  }
})
</script>
