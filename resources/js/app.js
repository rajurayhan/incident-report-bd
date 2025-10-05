import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { createRouter, createWebHistory } from 'vue-router';
import { createHead } from '@vueuse/head';

// Import components
import App from './components/App.vue';
import Home from './components/Home.vue';
import ReportIncident from './components/ReportIncident.vue';
import IncidentDetails from './components/IncidentDetails.vue';
import IncidentMap from './components/IncidentMap.vue';
import AdminDashboard from './components/AdminDashboard.vue';
import Analytics from './components/Analytics.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import ForgotPassword from './components/ForgotPassword.vue';
import ResetPassword from './components/ResetPassword.vue';
import Profile from './components/Profile.vue';
import MyReports from './components/MyReports.vue';
import MyActivity from './components/MyActivity.vue';

// Create router
const routes = [
    { path: '/', name: 'home', component: Home },
    { path: '/report', name: 'report', component: ReportIncident },
    { path: '/incident/:id', name: 'incident', component: IncidentDetails },
    { path: '/map', name: 'map', component: IncidentMap },
    { path: '/admin', name: 'admin', component: AdminDashboard },
    { path: '/analytics', name: 'analytics', component: Analytics },
    { path: '/login', name: 'login', component: Login },
    { path: '/register', name: 'register', component: Register },
    { path: '/forgot-password', name: 'forgot-password', component: ForgotPassword },
    { path: '/reset-password', name: 'reset-password', component: ResetPassword },
    { path: '/profile', name: 'profile', component: Profile },
    { path: '/my-reports', name: 'my-reports', component: MyReports },
    { path: '/my-activity', name: 'my-activity', component: MyActivity },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Create Pinia store
const pinia = createPinia();

// Create head management
const head = createHead();

// Create Vue app
const app = createApp(App);

app.use(pinia);
app.use(router);
app.use(head);

app.mount('#app');
