<div class="notification-container">
    @if (session('success'))
    <div class="notification success show" id="successNotif">
        <div class="notification-content">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Succès !</strong>
                <div>{{ session('success') }}</div>
            </div>
        </div>
        <button class="notification-close" onclick="dismissNotification('successNotif')">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if ($errors->any())
    <div class="notification error show" id="errorNotif">
        <div class="notification-content">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Erreur !</strong>
                <div>{{ $errors->first() }}</div>
            </div>
        </div>
        <button class="notification-close" onclick="dismissNotification('errorNotif')">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif
</div>

<style>
    .notification-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 400px;
        width: 100%;
    }

    .notification {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 15px 20px;
        margin-bottom: 15px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.4s ease;
        animation: slideIn 0.5s forwards;
    }

    .notification.show {
        opacity: 1;
        transform: translateX(0);
    }

    .notification-content {
        display: flex;
        align-items: flex-start;
        flex-grow: 1;
    }

    .notification i {
        font-size: 22px;
        margin-right: 15px;
        margin-top: 2px;
    }

    .notification.success {
        background-color: #d4edda;
        border-left: 5px solid #28a745;
        color: #155724;
    }

    .notification.error {
        background-color: #f8d7da;
        border-left: 5px solid #dc3545;
        color: #721c24;
    }

    .notification-close {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        font-size: 16px;
        opacity: 0.7;
        padding: 5px;
        transition: opacity 0.2s;
        margin-left: 10px;
    }

    .notification-close:hover {
        opacity: 1;
    }

    @keyframes slideIn {
        0% {
            transform: translateX(100%);
            opacity: 0;
        }

        100% {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        0% {
            opacity: 1;
            transform: translateX(0);
        }

        100% {
            opacity: 0;
            transform: translateX(100%);
        }
    }

    @media (max-width: 768px) {
        .notification-container {
            left: 20px;
            right: 20px;
            max-width: none;
        }

        .notification {
            padding: 12px 15px;
        }

        .notification i {
            font-size: 18px;
            margin-right: 10px;
        }
    }
</style>

<script>
    function dismissNotification(id) {
        const notif = document.getElementById(id);
        if (notif) {
            notif.style.animation = 'fadeOut 0.5s forwards';
            setTimeout(() => {
                notif.remove();
            }, 500);
        }
    }

    // Fermeture automatique après 5 secondes
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notif => {
                notif.style.animation = 'fadeOut 0.5s forwards';
                setTimeout(() => {
                    notif.remove();
                }, 500);
            });
        }, 5000);
    });
</script>