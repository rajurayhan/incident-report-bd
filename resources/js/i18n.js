import { createI18n } from 'vue-i18n'
import en from './locales/en'
import bn from './locales/bn'

const messages = {
  en,
  bn
}

const i18n = createI18n({
  legacy: false,
  locale: localStorage.getItem('locale') || 'en',
  fallbackLocale: 'en',
  messages
})

export default i18n

