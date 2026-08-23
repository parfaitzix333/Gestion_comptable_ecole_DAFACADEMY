<style>
    /* Shared styles extracted from les_annees_scolaires.blade.php */
    :root {
        --primary-gradient: linear-gradient(135deg, #020f4d 0%, #e20505 100%);
        --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        --info-gradient: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        --dark-gradient: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    }

    body {
        background: #f3f4f6;
    }

    .content-wrapper {
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.5s ease-out;
    }

    .page-header {
        background: var(--primary-gradient);
        border-radius: 1.5rem;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .page-header h2 {
        color: white;
        margin: 0;
        font-weight: 700;
        font-size: 1.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-header p {
        color: rgba(255, 255, 255, 0.8);
        margin: 0.5rem 0 0 0;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 1rem;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        animation: fadeInUp 0.5s ease-out;
    }

    .stat-card .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
    }

    .stat-total {
        border-left: 4px solid #667eea;
    }

    .stat-active {
        border-left: 4px solid #10b981;
    }

    .stat-inactive {
        border-left: 4px solid #ef4444;
    }

    .btn-modern {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        border-radius: 0.75rem;
        border: none;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary-modern {
        background: var(--primary-gradient);
        color: white;
    }

    .btn-submit {
        width: 100%;
        padding: 0.75rem;
        background: var(--success-gradient);
        color: white;
        border: none;
        border-radius: 0.75rem;
        font-weight: 600;
    }

    .table-container {
        background: white;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        animation: fadeInUp 0.5s ease-out;
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .modern-table thead tr {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    }

    .modern-table thead th {
        padding: 1rem 1.5rem;
        color: white;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    .modern-table tbody td {
        padding: 1rem 1.5rem;
        font-size: 0.875rem;
        color: #374151;
        vertical-align: middle;
    }

    .status-badge,
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.375rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-active i {
        color: #10b981;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-inactive i {
        color: #ef4444;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-icon {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 0.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .btn-edit {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }

    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .btn-toggle {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }

    .modal-modern .modal-content {
        border: none;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .modal-modern .modal-header {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 1.5rem;
    }

    .modal-modern .modal-body {
        padding: 1.5rem;
    }

    .modal-modern .modal-footer {
        border: none;
        padding: 1rem 1.5rem 1.5rem;
        gap: 0.75rem;
    }

    .form-control-modern {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        font-size: 0.875rem;
        background: white;
    }

    .empty-state {
        text-align: center;
        padding: 4rem;
    }

    .alert-modern {
        border-radius: 1rem;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .toast-notification {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        background: white;
        border-radius: 0.75rem;
        padding: 1rem 1.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        display: none;
        align-items: center;
        gap: 0.75rem;
        z-index: 9999;
    }

    @media (max-width: 992px) {
        .content-wrapper {
            padding: 1.5rem;
        }

        .modern-table thead th,
        .modern-table tbody td {
            padding: 0.875rem 1rem;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 768px) {
        .content-wrapper {
            padding: 1rem;
        }

        .modern-table thead {
            display: none;
        }

        .modern-table tbody tr {
            display: block;
            padding: 1rem;
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 0.5rem;
            background: white;
            border-radius: 0.75rem;
        }

        .modern-table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
        }

        .modern-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #6b7280;
        }
    }
</style>
