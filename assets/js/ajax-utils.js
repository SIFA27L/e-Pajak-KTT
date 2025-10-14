/**
 * AJAX Utilities for e-Pajak KTT
 * Mempercepat koneksi dan loading data
 */

class AjaxUtils {
    constructor() {
        this.baseUrl = window.location.origin;
        this.loadingOverlay = null;
        this.initLoadingOverlay();
    }

    /**
     * Initialize loading overlay
     */
    initLoadingOverlay() {
        if (!document.getElementById('ajaxLoadingOverlay')) {
            const overlay = document.createElement('div');
            overlay.id = 'ajaxLoadingOverlay';
            overlay.className = 'ajax-loading-overlay';
            overlay.innerHTML = `
                <div class="ajax-spinner">
                    <div class="spinner-border"></div>
                    <p>Memuat data...</p>
                </div>
            `;
            document.body.appendChild(overlay);
            this.loadingOverlay = overlay;
        }
    }

    /**
     * Show loading indicator
     */
    showLoading(message = 'Memuat data...') {
        if (this.loadingOverlay) {
            this.loadingOverlay.querySelector('p').textContent = message;
            this.loadingOverlay.classList.add('active');
        }
    }

    /**
     * Hide loading indicator
     */
    hideLoading() {
        if (this.loadingOverlay) {
            this.loadingOverlay.classList.remove('active');
        }
    }

    /**
     * Generic AJAX request
     * @param {string} url - URL endpoint
     * @param {object} options - Request options
     * @returns {Promise}
     */
    async request(url, options = {}) {
        const defaultOptions = {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            showLoading: true,
            loadingMessage: 'Memuat data...'
        };

        const config = { ...defaultOptions, ...options };

        if (config.showLoading) {
            this.showLoading(config.loadingMessage);
        }

        try {
            const fetchOptions = {
                method: config.method,
                headers: config.headers,
                credentials: 'same-origin'
            };

            if (config.body) {
                if (config.headers['Content-Type'] === 'application/json') {
                    fetchOptions.body = JSON.stringify(config.body);
                } else {
                    fetchOptions.body = config.body;
                }
            }

            const response = await fetch(url, fetchOptions);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const contentType = response.headers.get('content-type');
            let data;

            if (contentType && contentType.includes('application/json')) {
                data = await response.json();
            } else {
                data = await response.text();
            }

            if (config.showLoading) {
                this.hideLoading();
            }

            return { success: true, data };

        } catch (error) {
            console.error('AJAX Error:', error);
            if (config.showLoading) {
                this.hideLoading();
            }
            return { success: false, error: error.message };
        }
    }

    /**
     * GET request
     */
    async get(url, options = {}) {
        return this.request(url, { ...options, method: 'GET' });
    }

    /**
     * POST request
     */
    async post(url, data, options = {}) {
        return this.request(url, { ...options, method: 'POST', body: data });
    }

    /**
     * PUT request
     */
    async put(url, data, options = {}) {
        return this.request(url, { ...options, method: 'PUT', body: data });
    }

    /**
     * DELETE request
     */
    async delete(url, options = {}) {
        return this.request(url, { ...options, method: 'DELETE' });
    }

    /**
     * Load content into element
     */
    async loadInto(url, elementId, options = {}) {
        const element = document.getElementById(elementId);
        if (!element) {
            console.error(`Element with id '${elementId}' not found`);
            return;
        }

        const result = await this.get(url, options);
        
        if (result.success) {
            element.innerHTML = result.data;
            // Trigger custom event
            element.dispatchEvent(new CustomEvent('contentLoaded', { detail: result.data }));
        } else {
            element.innerHTML = `<div class="alert alert-danger">Error: ${result.error}</div>`;
        }

        return result;
    }

    /**
     * Submit form via AJAX
     */
    async submitForm(formElement, options = {}) {
        const formData = new FormData(formElement);
        const url = formElement.action || window.location.href;
        
        const config = {
            loadingMessage: 'Mengirim data...',
            ...options
        };

        // Convert FormData to JSON if needed
        if (config.json) {
            const jsonData = {};
            formData.forEach((value, key) => {
                jsonData[key] = value;
            });
            return this.post(url, jsonData, config);
        } else {
            config.headers = {
                'X-Requested-With': 'XMLHttpRequest'
            };
            return this.post(url, formData, config);
        }
    }

    /**
     * Load table data with pagination
     */
    async loadTableData(url, tableId, options = {}) {
        const table = document.getElementById(tableId);
        if (!table) {
            console.error(`Table with id '${tableId}' not found`);
            return;
        }

        const tbody = table.querySelector('tbody');
        if (!tbody) {
            console.error('Table body not found');
            return;
        }

        const result = await this.get(url, options);

        if (result.success) {
            if (typeof result.data === 'string') {
                tbody.innerHTML = result.data;
            } else if (result.data.html) {
                tbody.innerHTML = result.data.html;
            }
        } else {
            tbody.innerHTML = `<tr><td colspan="100%" class="text-center text-danger">Error: ${result.error}</td></tr>`;
        }

        return result;
    }

    /**
     * Auto-refresh data at intervals
     */
    startAutoRefresh(callback, interval = 30000) {
        return setInterval(callback, interval);
    }

    /**
     * Stop auto-refresh
     */
    stopAutoRefresh(intervalId) {
        if (intervalId) {
            clearInterval(intervalId);
        }
    }

    /**
     * Debounce function for search inputs
     */
    debounce(func, wait = 300) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    /**
     * Show toast notification
     */
    showToast(message, type = 'info', duration = 3000) {
        const toast = document.createElement('div');
        toast.className = `ajax-toast ajax-toast-${type}`;
        toast.innerHTML = `
            <i class="fas fa-${this.getToastIcon(type)}"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => toast.classList.add('show'), 100);
        
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }

    /**
     * Get toast icon based on type
     */
    getToastIcon(type) {
        const icons = {
            success: 'check-circle',
            error: 'exclamation-circle',
            warning: 'exclamation-triangle',
            info: 'info-circle'
        };
        return icons[type] || icons.info;
    }

    /**
     * Cache management
     */
    cache = new Map();

    async getWithCache(url, ttl = 60000) {
        const cached = this.cache.get(url);
        const now = Date.now();

        if (cached && (now - cached.timestamp) < ttl) {
            return { success: true, data: cached.data, cached: true };
        }

        const result = await this.get(url);
        
        if (result.success) {
            this.cache.set(url, {
                data: result.data,
                timestamp: now
            });
        }

        return result;
    }

    clearCache(url = null) {
        if (url) {
            this.cache.delete(url);
        } else {
            this.cache.clear();
        }
    }
}

// Initialize global AJAX instance
const ajax = new AjaxUtils();

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AjaxUtils;
}
