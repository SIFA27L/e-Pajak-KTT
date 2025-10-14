/**
 * Session Timeout Manager
 * Handles auto-logout and session timeout warnings
 */

class SessionManager {
    constructor(options = {}) {
        // Configuration (in seconds)
        this.timeout = options.timeout || 300; 
        this.warningTime = options.warningTime || 250; 
        this.checkInterval = options.checkInterval || 60; 
        
        // State
        this.lastActivity = Date.now();
        this.warningShown = false;
        this.checkTimer = null;
        this.warningModal = null;
        
        // Initialize
        this.init();
    }

    init() {
        // Track user activity
        this.trackActivity();
        
        // Start checking session
        this.startChecking();
        
        // Create warning modal
        this.createWarningModal();
    }

    trackActivity() {
        const events = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'];
        
        events.forEach(event => {
            document.addEventListener(event, () => {
                this.updateActivity();
            }, true);
        });
    }

    updateActivity() {
        this.lastActivity = Date.now();
        
        // Hide warning if shown
        if (this.warningShown) {
            this.hideWarning();
        }
        
        // Update server-side session
        this.pingServer();
    }

    pingServer() {
        // Send ping to server to keep session alive
        if (navigator.sendBeacon) {
            navigator.sendBeacon('ping_session.php');
        } else {
            fetch('ping_session.php', {
                method: 'POST',
                keepalive: true
            }).catch(() => {
                // Ignore errors
            });
        }
    }

    startChecking() {
        this.checkTimer = setInterval(() => {
            this.checkSession();
        }, this.checkInterval);
    }

    checkSession() {
        const now = Date.now();
        const inactiveTime = Math.floor((now - this.lastActivity) / 1000);
        const remainingTime = this.timeout - inactiveTime;

        // Show warning
        if (remainingTime <= this.warningTime && !this.warningShown) {
            this.showWarning(remainingTime);
        }

        // Auto logout
        if (remainingTime <= 0) {
            this.logout();
        }
    }

    createWarningModal() {
        const modal = document.createElement('div');
        modal.id = 'sessionWarningModal';
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10000;
        `;

        modal.innerHTML = `
            <div style="
                background: white;
                padding: 30px;
                border-radius: 15px;
                max-width: 500px;
                width: 90%;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
                text-align: center;
            ">
                <div style="
                    width: 80px;
                    height: 80px;
                    margin: 0 auto 20px;
                    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 2.5rem;
                    color: white;
                ">
                    <i class="fas fa-clock"></i>
                </div>
                <h2 style="color: #1f2937; margin-bottom: 15px; font-size: 1.5rem;">
                    Sesi Akan Berakhir
                </h2>
                <p style="color: #6b7280; margin-bottom: 20px; font-size: 1rem;">
                    Sesi Anda akan berakhir dalam <strong id="sessionCountdown" style="color: #f59e0b;">5:00</strong> menit karena tidak ada aktivitas.
                </p>
                <p style="color: #6b7280; margin-bottom: 30px; font-size: 0.9rem;">
                    Klik tombol di bawah untuk melanjutkan sesi Anda.
                </p>
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button id="continueSession" style="
                        padding: 12px 30px;
                        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                        color: white;
                        border: none;
                        border-radius: 8px;
                        font-size: 1rem;
                        font-weight: 600;
                        cursor: pointer;
                        transition: transform 0.3s ease;
                    ">
                        <i class="fas fa-check-circle"></i> Lanjutkan Sesi
                    </button>
                    <button id="logoutNow" style="
                        padding: 12px 30px;
                        background: #6b7280;
                        color: white;
                        border: none;
                        border-radius: 8px;
                        font-size: 1rem;
                        font-weight: 600;
                        cursor: pointer;
                        transition: transform 0.3s ease;
                    ">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(modal);
        this.warningModal = modal;

        // Event listeners
        document.getElementById('continueSession').addEventListener('click', () => {
            this.updateActivity();
        });

        document.getElementById('logoutNow').addEventListener('click', () => {
            this.logout();
        });
    }

    showWarning(remainingTime) {
        this.warningShown = true;
        this.warningModal.style.display = 'flex';
        
        // Update countdown
        this.updateCountdown(remainingTime);
        
        // Start countdown timer
        this.countdownTimer = setInterval(() => {
            const now = Date.now();
            const inactiveTime = Math.floor((now - this.lastActivity) / 1000);
            const remaining = this.timeout - inactiveTime;
            
            if (remaining > 0) {
                this.updateCountdown(remaining);
            } else {
                clearInterval(this.countdownTimer);
                this.logout();
            }
        }, 1000);
    }

    hideWarning() {
        this.warningShown = false;
        this.warningModal.style.display = 'none';
        
        if (this.countdownTimer) {
            clearInterval(this.countdownTimer);
        }
    }

    updateCountdown(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = seconds % 60;
        const timeString = `${minutes}:${String(secs).padStart(2, '0')}`;
        
        const countdownEl = document.getElementById('sessionCountdown');
        if (countdownEl) {
            countdownEl.textContent = timeString;
        }
    }

    logout() {
        // Clear timers
        if (this.checkTimer) {
            clearInterval(this.checkTimer);
        }
        if (this.countdownTimer) {
            clearInterval(this.countdownTimer);
        }
        
        // Redirect to logout
        window.location.href = 'logout.php?reason=timeout';
    }

    destroy() {
        // Cleanup
        if (this.checkTimer) {
            clearInterval(this.checkTimer);
        }
        if (this.countdownTimer) {
            clearInterval(this.countdownTimer);
        }
        if (this.warningModal) {
            this.warningModal.remove();
        }
    }
}

// Initialize session manager on protected pages
if (typeof isProtectedPage !== 'undefined' && isProtectedPage) {
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            window.sessionManager = new SessionManager({
                timeout: 1800,      // 30 minutes
                warningTime: 300,   // 5 minutes warning
                checkInterval: 60000 // Check every 1 minute
            });
        });
    } else {
        window.sessionManager = new SessionManager({
            timeout: 1800,
            warningTime: 300,
            checkInterval: 60000
        });
    }
}
