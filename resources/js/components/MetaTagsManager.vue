<template>
  <div></div>
</template>

<script>
import { ref, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'

export default {
  name: 'MetaTagsManager',
  setup() {
    const route = useRoute()
    
    const updateMetaTags = async () => {
      try {
        const response = await fetch(`/api/meta-tags?path=${encodeURIComponent(route.path)}`)
        
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`)
        }
        
        const contentType = response.headers.get('content-type')
        if (!contentType || !contentType.includes('application/json')) {
          throw new Error('Response is not JSON')
        }
        
        const metaTags = await response.json()
        
        // Update document title
        document.title = metaTags['og:title'] || 'Incident Report'
        
        // Update meta tags
        updateMetaTag('description', metaTags['og:description'])
        updateMetaTag('og:title', metaTags['og:title'])
        updateMetaTag('og:description', metaTags['og:description'])
        updateMetaTag('og:image', metaTags['og:image'])
        updateMetaTag('og:url', metaTags['og:url'])
        updateMetaTag('og:type', metaTags['og:type'])
        updateMetaTag('og:site_name', metaTags['og:site_name'])
        updateMetaTag('twitter:title', metaTags['twitter:title'])
        updateMetaTag('twitter:description', metaTags['twitter:description'])
        updateMetaTag('twitter:image', metaTags['twitter:image'])
        
        // Update canonical URL
        updateCanonicalUrl(metaTags['og:url'])
        
      } catch (error) {
        console.error('Failed to update meta tags:', error)
        // Fallback to default meta tags
        document.title = 'Incident Report - Community Safety Platform'
      }
    }
    
    const updateMetaTag = (property, content) => {
      if (!content) return
      
      // Handle different meta tag types
      if (property.startsWith('og:')) {
        updateOrCreateMetaTag('property', property, content)
      } else if (property.startsWith('twitter:')) {
        updateOrCreateMetaTag('name', property, content)
      } else {
        updateOrCreateMetaTag('name', property, content)
      }
    }
    
    const updateOrCreateMetaTag = (attribute, value, content) => {
      let metaTag = document.querySelector(`meta[${attribute}="${value}"]`)
      
      if (!metaTag) {
        metaTag = document.createElement('meta')
        metaTag.setAttribute(attribute, value)
        document.head.appendChild(metaTag)
      }
      
      metaTag.setAttribute('content', content)
    }
    
    const updateCanonicalUrl = (url) => {
      if (!url) return
      
      let canonical = document.querySelector('link[rel="canonical"]')
      
      if (!canonical) {
        canonical = document.createElement('link')
        canonical.setAttribute('rel', 'canonical')
        document.head.appendChild(canonical)
      }
      
      canonical.setAttribute('href', url)
    }
    
    // Watch for route changes
    watch(route, () => {
      updateMetaTags()
    }, { immediate: true })
    
    onMounted(() => {
      updateMetaTags()
    })
    
    return {}
  }
}
</script>
