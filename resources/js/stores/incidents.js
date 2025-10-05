import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';

export const useIncidentStore = defineStore('incidents', () => {
  const incidents = ref([]);
  const currentIncident = ref(null);
  const loading = ref(false);
  const filters = ref({
    category: null,
    status: null,
    verified: null,
    location: null,
    radius: 5,
  });

  const filteredIncidents = computed(() => {
    let filtered = incidents.value;

    if (filters.value.category) {
      filtered = filtered.filter(incident => incident.category === filters.value.category);
    }

    if (filters.value.status) {
      filtered = filtered.filter(incident => incident.status === filters.value.status);
    }

    if (filters.value.verified !== null) {
      filtered = filtered.filter(incident => incident.is_verified === filters.value.verified);
    }

    return filtered;
  });

  const categories = ref([
    { value: 'theft_robbery', label: 'Theft / Robbery', color: 'red' },
    { value: 'sexual_harassment', label: 'Sexual Harassment / Abuse', color: 'pink' },
    { value: 'domestic_violence', label: 'Domestic Violence', color: 'purple' },
    { value: 'suspicious_activities', label: 'Suspicious Activities', color: 'yellow' },
    { value: 'traffic_accidents', label: 'Traffic Accidents / Public Hazards', color: 'orange' },
    { value: 'drugs', label: 'Drugs', color: 'green' },
    { value: 'cybercrime', label: 'Cybercrime', color: 'blue' },
  ]);

  const statuses = ref([
    { value: 'pending', label: 'Pending', color: 'yellow' },
    { value: 'in_progress', label: 'In Progress', color: 'blue' },
    { value: 'resolved', label: 'Resolved', color: 'green' },
  ]);

  const fetchIncidents = async (params = {}) => {
    loading.value = true;
    try {
      const response = await axios.get('/api/incidents', { params });
      incidents.value = response.data.data;
      return response.data;
    } catch (error) {
      throw error.response?.data || error;
    } finally {
      loading.value = false;
    }
  };

  const fetchIncident = async (id) => {
    loading.value = true;
    try {
      const response = await axios.get(`/api/incidents/${id}`);
      currentIncident.value = response.data;
      return response.data;
    } catch (error) {
      throw error.response?.data || error;
    } finally {
      loading.value = false;
    }
  };

  const createIncident = async (incidentData) => {
    loading.value = true;
    try {
      const response = await axios.post('/api/incidents', incidentData);
      incidents.value.unshift(response.data);
      return response.data;
    } catch (error) {
      throw error.response?.data || error;
    } finally {
      loading.value = false;
    }
  };

  const updateIncident = async (id, data) => {
    loading.value = true;
    try {
      const response = await axios.put(`/api/incidents/${id}`, data);
      const index = incidents.value.findIndex(incident => incident.id === id);
      if (index !== -1) {
        incidents.value[index] = response.data;
      }
      if (currentIncident.value?.id === id) {
        currentIncident.value = response.data;
      }
      return response.data;
    } catch (error) {
      throw error.response?.data || error;
    } finally {
      loading.value = false;
    }
  };

  const deleteIncident = async (id) => {
    loading.value = true;
    try {
      await axios.delete(`/api/incidents/${id}`);
      incidents.value = incidents.value.filter(incident => incident.id !== id);
      if (currentIncident.value?.id === id) {
        currentIncident.value = null;
      }
    } catch (error) {
      throw error.response?.data || error;
    } finally {
      loading.value = false;
    }
  };

  const addComment = async (incidentId, commentData) => {
    try {
      const response = await axios.post(`/api/incidents/${incidentId}/comments`, commentData);
      if (currentIncident.value?.id === incidentId) {
        currentIncident.value.comments.push(response.data);
      }
      return response.data;
    } catch (error) {
      throw error.response?.data || error;
    }
  };

  const addVerification = async (incidentId, verificationData) => {
    try {
      const response = await axios.post(`/api/incidents/${incidentId}/verifications`, verificationData);
      if (currentIncident.value?.id === incidentId) {
        currentIncident.value.verifications.push(response.data);
        // Update verification counts
        if (verificationData.verification_type === 'confirm') {
          currentIncident.value.verification_count++;
        } else {
          currentIncident.value.dispute_count++;
        }
      }
      return response.data;
    } catch (error) {
      throw error.response?.data || error;
    }
  };

  const uploadMedia = async (incidentId, mediaData) => {
    try {
      const response = await axios.post(`/api/incidents/${incidentId}/media`, mediaData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });
      if (currentIncident.value?.id === incidentId) {
        currentIncident.value.media.push(response.data);
      }
      return response.data;
    } catch (error) {
      throw error.response?.data || error;
    }
  };

  const setFilters = (newFilters) => {
    filters.value = { ...filters.value, ...newFilters };
  };

  const clearFilters = () => {
    filters.value = {
      category: null,
      status: null,
      verified: null,
      location: null,
      radius: 5,
    };
  };

  return {
    incidents,
    currentIncident,
    loading,
    filters,
    filteredIncidents,
    categories,
    statuses,
    fetchIncidents,
    fetchIncident,
    createIncident,
    updateIncident,
    deleteIncident,
    addComment,
    addVerification,
    uploadMedia,
    setFilters,
    clearFilters,
  };
});
