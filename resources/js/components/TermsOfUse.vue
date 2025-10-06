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
          {{ $t('termsOfUse.title') }}
        </h1>
        <p class="text-lg text-gray-600">
          {{ $t('termsOfUse.lastUpdated') }}
        </p>
      </div>


      <!-- Content -->
      <div class="bg-white rounded-lg shadow-sm border p-8">
        <div class="prose prose-lg max-w-none">
          <!-- Introduction -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('termsOfUse.introduction.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('termsOfUse.introduction.content') }}
            </p>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('termsOfUse.introduction.agreement') }}
            </p>
          </section>

          <!-- Acceptance of Terms -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('termsOfUse.acceptance.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('termsOfUse.acceptance.content') }}
            </p>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('termsOfUse.acceptance.conditions') }}</li>
              <li>{{ $t('termsOfUse.acceptance.legalAge') }}</li>
              <li>{{ $t('termsOfUse.acceptance.authority') }}</li>
              <li>{{ $t('termsOfUse.acceptance.compliance') }}</li>
            </ul>
          </section>

          <!-- Description of Service -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('termsOfUse.serviceDescription.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('termsOfUse.serviceDescription.content') }}
            </p>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('termsOfUse.serviceDescription.reporting') }}</li>
              <li>{{ $t('termsOfUse.serviceDescription.tracking') }}</li>
              <li>{{ $t('termsOfUse.serviceDescription.verification') }}</li>
              <li>{{ $t('termsOfUse.serviceDescription.community') }}</li>
              <li>{{ $t('termsOfUse.serviceDescription.analytics') }}</li>
            </ul>
          </section>

          <!-- User Accounts -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('termsOfUse.userAccounts.title') }}
            </h2>
            <h3 class="text-xl font-medium text-gray-800 mb-3">
              {{ $t('termsOfUse.userAccounts.registration.title') }}
            </h3>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('termsOfUse.userAccounts.registration.accuracy') }}</li>
              <li>{{ $t('termsOfUse.userAccounts.registration.security') }}</li>
              <li>{{ $t('termsOfUse.userAccounts.registration.responsibility') }}</li>
              <li>{{ $t('termsOfUse.userAccounts.registration.notification') }}</li>
            </ul>

            <h3 class="text-xl font-medium text-gray-800 mb-3">
              {{ $t('termsOfUse.userAccounts.accountSecurity.title') }}
            </h3>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('termsOfUse.userAccounts.accountSecurity.password') }}</li>
              <li>{{ $t('termsOfUse.userAccounts.accountSecurity.unauthorized') }}</li>
              <li>{{ $t('termsOfUse.userAccounts.accountSecurity.reporting') }}</li>
            </ul>
          </section>

          <!-- Acceptable Use -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('termsOfUse.acceptableUse.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('termsOfUse.acceptableUse.content') }}
            </p>

            <h3 class="text-xl font-medium text-gray-800 mb-3">
              {{ $t('termsOfUse.acceptableUse.permitted.title') }}
            </h3>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('termsOfUse.acceptableUse.permitted.reporting') }}</li>
              <li>{{ $t('termsOfUse.acceptableUse.permitted.verification') }}</li>
              <li>{{ $t('termsOfUse.acceptableUse.permitted.communication') }}</li>
              <li>{{ $t('termsOfUse.acceptableUse.permitted.legal') }}</li>
            </ul>

            <h3 class="text-xl font-medium text-gray-800 mb-3">
              {{ $t('termsOfUse.acceptableUse.prohibited.title') }}
            </h3>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('termsOfUse.acceptableUse.prohibited.false') }}</li>
              <li>{{ $t('termsOfUse.acceptableUse.prohibited.harassment') }}</li>
              <li>{{ $t('termsOfUse.acceptableUse.prohibited.illegal') }}</li>
              <li>{{ $t('termsOfUse.acceptableUse.prohibited.spam') }}</li>
              <li>{{ $t('termsOfUse.acceptableUse.prohibited.impersonation') }}</li>
              <li>{{ $t('termsOfUse.acceptableUse.prohibited.technical') }}</li>
            </ul>
          </section>

          <!-- Content Guidelines -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('termsOfUse.contentGuidelines.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('termsOfUse.contentGuidelines.content') }}
            </p>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('termsOfUse.contentGuidelines.accuracy') }}</li>
              <li>{{ $t('termsOfUse.contentGuidelines.relevance') }}</li>
              <li>{{ $t('termsOfUse.contentGuidelines.respectful') }}</li>
              <li>{{ $t('termsOfUse.contentGuidelines.legal') }}</li>
              <li>{{ $t('termsOfUse.contentGuidelines.media') }}</li>
            </ul>
          </section>

          <!-- Privacy and Data Protection -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('termsOfUse.privacy.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('termsOfUse.privacy.content') }}
            </p>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('termsOfUse.privacy.collection') }}</li>
              <li>{{ $t('termsOfUse.privacy.usage') }}</li>
              <li>{{ $t('termsOfUse.privacy.sharing') }}</li>
              <li>{{ $t('termsOfUse.privacy.security') }}</li>
            </ul>
          </section>

          <!-- Intellectual Property -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('termsOfUse.intellectualProperty.title') }}
            </h2>
            <h3 class="text-xl font-medium text-gray-800 mb-3">
              {{ $t('termsOfUse.intellectualProperty.ourContent.title') }}
            </h3>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('termsOfUse.intellectualProperty.ourContent.content') }}
            </p>

            <h3 class="text-xl font-medium text-gray-800 mb-3">
              {{ $t('termsOfUse.intellectualProperty.userContent.title') }}
            </h3>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('termsOfUse.intellectualProperty.userContent.content') }}
            </p>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('termsOfUse.intellectualProperty.userContent.license') }}</li>
              <li>{{ $t('termsOfUse.intellectualProperty.userContent.warranty') }}</li>
              <li>{{ $t('termsOfUse.intellectualProperty.userContent.removal') }}</li>
            </ul>
          </section>

          <!-- Disclaimers -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('termsOfUse.disclaimers.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('termsOfUse.disclaimers.content') }}
            </p>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('termsOfUse.disclaimers.accuracy') }}</li>
              <li>{{ $t('termsOfUse.disclaimers.availability') }}</li>
              <li>{{ $t('termsOfUse.disclaimers.liability') }}</li>
              <li>{{ $t('termsOfUse.disclaimers.thirdParty') }}</li>
            </ul>
          </section>

          <!-- Limitation of Liability -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('termsOfUse.limitationLiability.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('termsOfUse.limitationLiability.content') }}
            </p>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('termsOfUse.limitationLiability.damages') }}</li>
              <li>{{ $t('termsOfUse.limitationLiability.incidents') }}</li>
              <li>{{ $t('termsOfUse.limitationLiability.thirdParty') }}</li>
              <li>{{ $t('termsOfUse.limitationLiability.maximum') }}</li>
            </ul>
          </section>

          <!-- Termination -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('termsOfUse.termination.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('termsOfUse.termination.content') }}
            </p>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('termsOfUse.termination.userTermination') }}</li>
              <li>{{ $t('termsOfUse.termination.platformTermination') }}</li>
              <li>{{ $t('termsOfUse.termination.effect') }}</li>
              <li>{{ $t('termsOfUse.termination.survival') }}</li>
            </ul>
          </section>

          <!-- Governing Law -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('termsOfUse.governingLaw.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('termsOfUse.governingLaw.content') }}
            </p>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('termsOfUse.governingLaw.jurisdiction') }}</li>
              <li>{{ $t('termsOfUse.governingLaw.disputes') }}</li>
              <li>{{ $t('termsOfUse.governingLaw.arbitration') }}</li>
            </ul>
          </section>

          <!-- Changes to Terms -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('termsOfUse.changes.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('termsOfUse.changes.content') }}
            </p>
            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2">
              <li>{{ $t('termsOfUse.changes.notification') }}</li>
              <li>{{ $t('termsOfUse.changes.acceptance') }}</li>
              <li>{{ $t('termsOfUse.changes.continued') }}</li>
            </ul>
          </section>

          <!-- Contact Information -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('termsOfUse.contact.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('termsOfUse.contact.content') }}
            </p>
            <div class="bg-gray-50 p-4 rounded-lg">
              <p class="text-gray-700 mb-2">
                <strong>{{ $t('termsOfUse.contact.email') }}:</strong> legal@incidentreport.bd
              </p>
              <p class="text-gray-700 mb-2">
                <strong>{{ $t('termsOfUse.contact.address') }}:</strong>
                {{ $t('termsOfUse.contact.addressValue') }}
              </p>
              <p class="text-gray-700">
                <strong>{{ $t('termsOfUse.contact.phone') }}:</strong> +880-XXX-XXXXXXX
              </p>
            </div>
          </section>

          <!-- Severability -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('termsOfUse.severability.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('termsOfUse.severability.content') }}
            </p>
          </section>

          <!-- Entire Agreement -->
          <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
              {{ $t('termsOfUse.entireAgreement.title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
              {{ $t('termsOfUse.entireAgreement.content') }}
            </p>
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
          {{ $t('termsOfUse.backButton') }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TermsOfUse',
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
