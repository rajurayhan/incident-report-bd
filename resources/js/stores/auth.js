import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null);
  const token = ref(localStorage.getItem('token'));
  const loading = ref(false);

  const isAuthenticated = computed(() => !!token.value);

  const login = async (credentials) => {
    loading.value = true;
    try {
      const response = await axios.post('/api/login', credentials);
      token.value = response.data.token;
      user.value = response.data.user;
      localStorage.setItem('token', token.value);
      axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;
      return response.data;
    } catch (error) {
      throw error.response?.data || error;
    } finally {
      loading.value = false;
    }
  };

  const register = async (userData) => {
    loading.value = true;
    try {
      const response = await axios.post('/api/register', userData);
      token.value = response.data.token;
      user.value = response.data.user;
      localStorage.setItem('token', token.value);
      axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;
      return response.data;
    } catch (error) {
      throw error.response?.data || error;
    } finally {
      loading.value = false;
    }
  };

  const logout = () => {
    token.value = null;
    user.value = null;
    localStorage.removeItem('token');
    delete axios.defaults.headers.common['Authorization'];
  };

  const fetchUser = async () => {
    if (!token.value) return;
    
    try {
      axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;
      const response = await axios.get('/api/user');
      user.value = response.data;
    } catch (error) {
      logout();
    }
  };

  const updateUser = (userData) => {
    user.value = { ...user.value, ...userData };
  };

  // Initialize auth state
  if (token.value) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;
    fetchUser();
  }

  return {
    user,
    token,
    loading,
    isAuthenticated,
    login,
    register,
    logout,
    fetchUser,
    updateUser,
  };
});
