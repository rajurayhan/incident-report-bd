<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="text-center mb-8">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
          <div class="w-16 h-16 bg-red-600 rounded-lg flex items-center justify-center">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
          </div>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-900 mb-4">
          {{ $t('privacyPolicy.title') }}
        </h1>
        <p class="text-lg text-gray-600">
          {{ $t('privacyPolicy.lastUpdated') }}
        </p>
      </div>


      <!-- Content -->
      <div class="bg-white rounded-lg shadow-sm border p-8">
        <div class="prose prose-lg max-w-none">
          <!-- Introduction -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('privacyPolicy.introduction.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('privacyPolicy.introduction.content') }}
            </p>
          </section>

          <!-- Information We Collect -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('privacyPolicy.informationWeCollect.title') }}
            </h2>
            
            <h3 class="text-xl font-medium text-gray-800 mb-3">
              {{ $t('privacyPolicy.informationWeCollect.personalInfo.title') }}
            </h3>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('privacyPolicy.informationWeCollect.personalInfo.name') }}</li>
              <li>{{ $t('privacyPolicy.informationWeCollect.personalInfo.email') }}</li>
              <li>{{ $t('privacyPolicy.informationWeCollect.personalInfo.phone') }}</li>
              <li>{{ $t('privacyPolicy.informationWeCollect.personalInfo.username') }}</li>
              <li>{{ $t('privacyPolicy.informationWeCollect.personalInfo.location') }}</li>
            </ul>

            <h3 class="text-xl font-medium text-gray-800 mb-3">
              {{ $t('privacyPolicy.informationWeCollect.incidentInfo.title') }}
            </h3>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('privacyPolicy.informationWeCollect.incidentInfo.description') }}</li>
              <li>{{ $t('privacyPolicy.informationWeCollect.incidentInfo.location') }}</li>
              <li>{{ $t('privacyPolicy.informationWeCollect.incidentInfo.media') }}</li>
              <li>{{ $t('privacyPolicy.informationWeCollect.incidentInfo.timestamp') }}</li>
            </ul>

            <h3 class="text-xl font-medium text-gray-800 mb-3">
              {{ $t('privacyPolicy.informationWeCollect.technicalInfo.title') }}
            </h3>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('privacyPolicy.informationWeCollect.technicalInfo.ipAddress') }}</li>
              <li>{{ $t('privacyPolicy.informationWeCollect.technicalInfo.browser') }}</li>
              <li>{{ $t('privacyPolicy.informationWeCollect.technicalInfo.device') }}</li>
              <li>{{ $t('privacyPolicy.informationWeCollect.technicalInfo.cookies') }}</li>
            </ul>
          </section>

          <!-- How We Use Information -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('privacyPolicy.howWeUseInfo.title') }}
            </h2>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('privacyPolicy.howWeUseInfo.provideService') }}</li>
              <li>{{ $t('privacyPolicy.howWeUseInfo.communicate') }}</li>
              <li>{{ $t('privacyPolicy.howWeUseInfo.improve') }}</li>
              <li>{{ $t('privacyPolicy.howWeUseInfo.analytics') }}</li>
              <li>{{ $t('privacyPolicy.howWeUseInfo.security') }}</li>
              <li>{{ $t('privacyPolicy.howWeUseInfo.legal') }}</li>
            </ul>
          </section>

          <!-- Information Sharing -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('privacyPolicy.informationSharing.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('privacyPolicy.informationSharing.content') }}
            </p>
            
            <h3 class="text-xl font-medium text-gray-800 mb-3">
              {{ $t('privacyPolicy.informationSharing.whenWeShare.title') }}
            </h3>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('privacyPolicy.informationSharing.whenWeShare.consent') }}</li>
              <li>{{ $t('privacyPolicy.informationSharing.whenWeShare.legal') }}</li>
              <li>{{ $t('privacyPolicy.informationSharing.whenWeShare.emergency') }}</li>
              <li>{{ $t('privacyPolicy.informationSharing.whenWeShare.anonymized') }}</li>
            </ul>
          </section>

          <!-- Data Security -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('privacyPolicy.dataSecurity.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('privacyPolicy.dataSecurity.content') }}
            </p>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('privacyPolicy.dataSecurity.encryption') }}</li>
              <li>{{ $t('privacyPolicy.dataSecurity.access') }}</li>
              <li>{{ $t('privacyPolicy.dataSecurity.monitoring') }}</li>
              <li>{{ $t('privacyPolicy.dataSecurity.backup') }}</li>
            </ul>
          </section>

          <!-- Your Rights -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('privacyPolicy.yourRights.title') }}
            </h2>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('privacyPolicy.yourRights.access') }}</li>
              <li>{{ $t('privacyPolicy.yourRights.correction') }}</li>
              <li>{{ $t('privacyPolicy.yourRights.deletion') }}</li>
              <li>{{ $t('privacyPolicy.yourRights.portability') }}</li>
              <li>{{ $t('privacyPolicy.yourRights.objection') }}</li>
              <li>{{ $t('privacyPolicy.yourRights.withdraw') }}</li>
            </ul>
          </section>

          <!-- Cookies -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('privacyPolicy.cookies.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('privacyPolicy.cookies.content') }}
            </p>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('privacyPolicy.cookies.essential') }}</li>
              <li>{{ $t('privacyPolicy.cookies.analytics') }}</li>
              <li>{{ $t('privacyPolicy.cookies.preferences') }}</li>
              <li>{{ $t('privacyPolicy.cookies.marketing') }}</li>
            </ul>
          </section>

          <!-- Data Retention -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('privacyPolicy.dataRetention.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('privacyPolicy.dataRetention.content') }}
            </p>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('privacyPolicy.dataRetention.incidentData') }}</li>
              <li>{{ $t('privacyPolicy.dataRetention.userData') }}</li>
              <li>{{ $t('privacyPolicy.dataRetention.analytics') }}</li>
              <li>{{ $t('privacyPolicy.dataRetention.legal') }}</li>
            </ul>
          </section>

          <!-- Children's Privacy -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('privacyPolicy.childrensPrivacy.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('privacyPolicy.childrensPrivacy.content') }}
            </p>
          </section>

          <!-- International Transfers -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('privacyPolicy.internationalTransfers.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('privacyPolicy.internationalTransfers.content') }}
            </p>
          </section>

          <!-- Changes to Privacy Policy -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('privacyPolicy.changes.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('privacyPolicy.changes.content') }}
            </p>
          </section>

          <!-- Contact Information -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('privacyPolicy.contact.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('privacyPolicy.contact.content') }}
            </p>
            <div class="bg-gray-50 p-4 rounded-lg">
              <p class="text-gray-700 mb-2">
                <strong>{{ $t('privacyPolicy.contact.email') }}:</strong> privacy@incidentreport.bd
              </p>
              <p class="text-gray-700 mb-2">
                <strong>{{ $t('privacyPolicy.contact.address') }}:</strong>
                {{ $t('privacyPolicy.contact.addressValue') }}
              </p>
              <p class="text-gray-700">
                <strong>{{ $t('privacyPolicy.contact.phone') }}:</strong> +880-XXX-XXXXXXX
              </p>
            </div>
          </section>
        </div>
      </div>

      <!-- Back Button -->
      <div class="text-center mt-8">
        <button
          @click="goBack"
          class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          {{ $t('privacyPolicy.backButton') }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PrivacyPolicy',
  setup() {
    const goBack = () => {
      window.history.back()
    }
    
    return {
      goBack
    }
  }
}
</script>

<style scoped>
.prose h2 {
  border-bottom: 1px solid #d1d5db;
  padding-bottom: 0.5rem;
}

.prose h3 {
  color: #1f2937;
}

.prose ul {
  margin-top: 0.25rem;
  margin-bottom: 0.25rem;
}

.prose ul li + li {
  margin-top: 0.25rem;
}

.prose li {
  line-height: 1.625;
}
</style>
