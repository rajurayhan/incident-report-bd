<template>
  <div class="flex items-center space-x-2">
    <label v-if="label" class="text-sm font-medium text-gray-700">{{ label }}:</label>
    <div class="flex bg-gray-100 rounded-lg p-1">
      <button 
        v-for="option in options"
        :key="option.value"
        @click="updateValue(option.value)"
        :class="[
          'px-3 py-1 text-sm rounded-md transition-colors',
          modelValue === option.value 
            ? 'bg-white text-blue-600 shadow-sm' 
            : 'text-gray-600 hover:text-gray-900'
        ]"
      >
        {{ option.label }}
      </button>
    </div>
  </div>
</template>

<script setup>
defineProps({
  modelValue: {
    type: String,
    required: true
  },
  options: {
    type: Array,
    required: true,
    validator: (options) => {
      return options.every(option => 
        typeof option === 'object' && 
        'value' in option && 
        'label' in option
      )
    }
  },
  label: {
    type: String,
    default: ''
  }
})

const emit = defineEmits(['update:modelValue'])

const updateValue = (value) => {
  console.log('ViewToggle: updating value to:', value)
  emit('update:modelValue', value)
}
</script>
