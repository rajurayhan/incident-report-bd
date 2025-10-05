<template>
  <div class="text-sm text-gray-600">
    <span class="font-semibold">{{ value }}</span> {{ label }}
  </div>
</template>

<script setup>
defineProps({
  value: {
    type: [String, Number],
    required: true
  },
  label: {
    type: String,
    required: true
  }
})
</script>
