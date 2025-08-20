<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Popup SPPD - Sistem SPPD DPRD</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: #f8f9fa;
            padding: 20px;
        }
        
        .test-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .test-title {
            text-align: center;
            color: #1e3a8a;
            margin-bottom: 30px;
            font-size: 2rem;
            font-weight: 700;
        }
        
        .test-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }
        
        .test-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
        }
        
        .test-btn-success {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: white;
        }
        
        .test-btn-error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        
        .test-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        
        .test-info {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .test-info h4 {
            color: #1976d2;
            margin-bottom: 10px;
        }
        
        .test-info p {
            color: #424242;
            margin-bottom: 8px;
        }
        
        /* Popup Styles - Copy dari supervisor/show.blade.php */
        .success-notification {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            animation: fadeIn 0.3s ease-out;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideInUp {
            from {
                transform: translateY(50px) scale(0.8);
                opacity: 0;
            }
            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }
        
        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% {
                transform: translate3d(0,0,0);
            }
            40%, 43% {
                transform: translate3d(0, -8px, 0);
            }
            70% {
                transform: translate3d(0, -4px, 0);
            }
            90% {
                transform: translate3d(0, -2px, 0);
            }
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
        
        @keyframes checkmark {
            0% {
                stroke-dasharray: 0 100;
                stroke-dashoffset: 100;
                opacity: 0;
            }
            50% {
                opacity: 0.5;
            }
            100% {
                stroke-dasharray: 100 100;
                stroke-dashoffset: 0;
                opacity: 1;
            }
        }
        
        @keyframes circlePulse {
            0% {
                transform: scale(1);
                opacity: 0.3;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.5;
            }
            100% {
                transform: scale(1);
                opacity: 0.3;
            }
        }
        
        .success-modal {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
            color: white;
            padding: 40px 30px;
            border-radius: 8px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 450px;
            max-width: 85vw;
            margin: 0 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: slideInUp 0.5s ease-out;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            border: 1px solid transparent;
            background-clip: padding-box;
        }
        
        .success-modal::before {
            content: '';
            position: absolute;
            top: -1px;
            left: -1px;
            right: -1px;
            bottom: -1px;
            background: linear-gradient(45deg, #8b5cf6, #a855f7, #c084fc, #8b5cf6);
            background-size: 400% 400%;
            border-radius: 8px;
            z-index: -1;
            animation: borderRotate 3s ease-in-out infinite;
            filter: blur(0.5px);
            opacity: 0.9;
        }
        
        .success-modal::after {
            content: '';
            position: absolute;
            top: -0.5px;
            left: -0.5px;
            right: -0.5px;
            bottom: -0.5px;
            background: linear-gradient(45deg, #8b5cf6, #a855f7, #c084fc, #8b5cf6);
            background-size: 400% 400%;
            border-radius: 8px;
            z-index: -2;
            animation: borderRotate 2s ease-in-out infinite reverse;
            filter: blur(1.5px);
            opacity: 0.3;
        }
        
        @keyframes borderRotate {
            0% {
                background-position: 0% 50%;
                transform: rotate(0deg);
            }
            25% {
                background-position: 100% 50%;
            }
            50% {
                background-position: 100% 100%;
                transform: rotate(180deg);
            }
            75% {
                background-position: 0% 100%;
            }
            100% {
                background-position: 0% 50%;
                transform: rotate(360deg);
            }
        }
        
        .error-modal {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
            color: white;
            padding: 40px 30px;
            border-radius: 8px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 450px;
            max-width: 85vw;
            margin: 0 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: slideInUp 0.5s ease-out;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            border: 1px solid transparent;
            background-clip: padding-box;
        }
        
        .error-modal::before {
            content: '';
            position: absolute;
            top: -1px;
            left: -1px;
            right: -1px;
            bottom: -1px;
            background: linear-gradient(45deg, #dc2626, #ef4444, #f87171, #dc2626);
            background-size: 400% 400%;
            border-radius: 8px;
            z-index: -1;
            animation: borderRotate 3s ease-in-out infinite;
            filter: blur(0.5px);
            opacity: 0.9;
        }
        
        .error-modal::after {
            content: '';
            position: absolute;
            top: -0.5px;
            left: -0.5px;
            right: -0.5px;
            bottom: -0.5px;
            background: linear-gradient(45deg, #dc2626, #ef4444, #f87171, #dc2626);
            background-size: 400% 400%;
            border-radius: 8px;
            z-index: -2;
            animation: borderRotate 2s ease-in-out infinite reverse;
            filter: blur(1.5px);
            opacity: 0.3;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            position: relative;
            animation: bounce 1s ease-in-out;
        }
        
        .success-icon svg {
            width: 100%;
            height: 100%;
            stroke: #fff;
            stroke-width: 3;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        
        .success-icon svg path {
            animation: checkmark 1.5s ease-in-out 0.3s both;
        }
        
        .success-icon svg circle:last-child {
            animation: circlePulse 2s ease-in-out infinite;
        }
        
        .error-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            position: relative;
            animation: pulse 1s ease-in-out;
        }
        
        .error-icon svg {
            width: 100%;
            height: 100%;
            stroke: #fff;
            stroke-width: 3;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        
        .success-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 12px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            animation: slideInUp 0.6s ease-out 0.2s both;
            color: #90EE90;
        }
        
        .success-message {
            font-size: 16px;
            margin-bottom: 25px;
            line-height: 1.6;
            opacity: 1;
            animation: slideInUp 0.6s ease-out 0.3s both;
            color: #90EE90;
            font-weight: 500;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
            display: block;
            visibility: visible;
        }
        
        .close-button {
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
            animation: slideInUp 0.6s ease-out 0.4s both;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }
        
        .close-button:hover {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.4);
        }
        
        .close-button:active {
            transform: translateY(0) scale(0.98);
        }
        
        .close-button-error {
            background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
            animation: slideInUp 0.6s ease-out 0.4s both;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }
        
        .close-button-error:hover {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }
        
        .close-button-error:active {
            transform: translateY(0) scale(0.98);
        }
        
        .modal-content {
            position: relative;
            z-index: 2;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .success-modal, .error-modal {
                width: 90vw;
                padding: 35px 20px;
                margin: 0 10px;
            }
            
            .success-title {
                font-size: 24px;
            }
            
            .success-message {
                font-size: 14px;
            }
            
            .close-button, .close-button-error {
                padding: 10px 28px;
                font-size: 14px;
            }
            
            .success-icon, .error-icon {
                width: 70px;
                height: 70px;
            }
        }
        
        @media (max-width: 480px) {
            .success-modal, .error-modal {
                width: 95vw;
                padding: 30px 15px;
                margin: 0 5px;
            }
            
            .success-title {
                font-size: 22px;
            }
            
            .success-message {
                font-size: 13px;
            }
            
            .close-button, .close-button-error {
                padding: 8px 25px;
                font-size: 13px;
            }
            
            .success-icon, .error-icon {
                width: 60px;
                height: 60px;
            }
        }
    </style>
</head>
<body>
    <div class="test-container">
        <h1 class="test-title">🧪 Test Popup SPPD</h1>
        
        <div class="test-info">
            <h4><i class="fas fa-info-circle"></i> Informasi Testing</h4>
            <p><strong>File:</strong> resources/views/test-popup.blade.php</p>
            <p><strong>URL:</strong> /test-popup</p>
            <p><strong>Fitur:</strong> Test popup sukses dan error tanpa perlu membuat SPPD</p>
            <p><strong>Klik tombol di bawah untuk melihat popup!</strong></p>
        </div>
        
        <div class="test-buttons">
            <button class="test-btn test-btn-success" onclick="showSuccessPopup()">
                <i class="fas fa-check-circle"></i> Test Popup Sukses
            </button>
            <button class="test-btn test-btn-error" onclick="showErrorPopup()">
                <i class="fas fa-times-circle"></i> Test Popup Error
            </button>
        </div>
        
        <div class="text-center">
            <p class="text-muted">
                <i class="fas fa-lightbulb"></i> 
                Gunakan file ini untuk testing popup tanpa perlu bolak-balik membuat SPPD di admin!
            </p>
        </div>
    </div>

    <!-- Success Popup -->
    <div class="success-notification" id="successPopup" style="display: none;">
        <div class="success-modal">
            <div class="modal-content">
                <div class="success-icon">
                    <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="50" r="45" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.3)" stroke-width="4"/>
                        <circle cx="50" cy="50" r="35" fill="rgba(255,255,255,0.05)" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                        <path d="M30 50 L45 65 L70 35" stroke="#90EE90" stroke-width="8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="50" cy="50" r="40" fill="none" stroke="#90EE90" stroke-width="3" opacity="0.3"/>
                    </svg>
                </div>
                <h3 class="success-title">SPPD Berhasil Disetujui!</h3>
                <p class="success-message">Silahkan Cek Form Admin untuk Melihat Detail</p>
                <button onclick="closePopup('successPopup')" class="close-button">✨ Tutup</button>
            </div>
        </div>
    </div>

    <!-- Error Popup -->
    <div class="success-notification" id="errorPopup" style="display: none;">
        <div class="error-modal">
            <div class="modal-content">
                <div class="error-icon">
                    <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="50" r="45" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.3)" stroke-width="4"/>
                        <circle cx="50" cy="50" r="35" fill="rgba(255,255,255,0.05)" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                        <path d="M30 30 L70 70 M70 30 L30 70" stroke="#ff6b6b" stroke-width="8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="50" cy="50" r="40" fill="none" stroke="#ff6b6b" stroke-width="3" opacity="0.3"/>
                    </svg>
                </div>
                <h3 class="success-title">⚠️ Oops!</h3>
                <p class="success-message">Terjadi kesalahan dalam memproses SPPD</p>
                <button onclick="closePopup('errorPopup')" class="close-button-error">🔄 Coba Lagi</button>
            </div>
        </div>
    </div>

    <script>
        function showSuccessPopup() {
            const popup = document.getElementById('successPopup');
            popup.style.display = 'flex';
            
            // Auto close after 4 seconds
            setTimeout(() => {
                closePopup('successPopup');
            }, 4000);
        }
        
        function showErrorPopup() {
            const popup = document.getElementById('errorPopup');
            popup.style.display = 'flex';
            
            // Auto close after 4 seconds
            setTimeout(() => {
                closePopup('errorPopup');
            }, 4000);
        }
        
        function closePopup(popupId) {
            const popup = document.getElementById(popupId);
            popup.style.animation = 'fadeIn 0.3s ease-out reverse';
            setTimeout(() => {
                popup.style.display = 'none';
                popup.style.animation = 'fadeIn 0.3s ease-out';
            }, 300);
        }
        
        // Close popup when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('success-notification')) {
                const popupId = e.target.id;
                if (popupId) {
                    closePopup(popupId);
                }
            }
        });
    </script>
</body>
</html> 