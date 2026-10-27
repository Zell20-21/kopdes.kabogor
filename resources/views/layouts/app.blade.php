<!DOCTYPE html>
<html lang="id" class="scroll-smooth w-full max-w-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard KMP Kabupaten Bogor | Koperasi Desa & Kelurahan Merah Putih')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Tailwind CSS (CDN for guaranteed styling) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            300: '#fca5a5',
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                            950: '#450a0a',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        html, body {
            max-width: 100%;
            overflow-x: clip;
            width: 100%;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        /* Custom Leaflet Map styling */
        .leaflet-popup-content-wrapper {
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            padding: 4px;
            border: 1px solid #fee2e2;
        }

        .leaflet-popup-content {
            margin: 10px 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Ensure popup action buttons have crisp white text */
        .leaflet-popup-content a,
        .leaflet-popup-content a span,
        .leaflet-popup-content a i {
            color: #ffffff !important;
            text-decoration: none !important;
        }

        /* User requested cooperative marker: red vertical pill with white store icon and soft red circular halo */
        .kmp-store-div-icon {
            background: transparent !important;
            border: none !important;
        }
        .kmp-store-marker {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            width: 40px;
            height: 40px;
            transition: transform 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .kmp-store-marker:hover, .kmp-store-marker.active-pin {
            transform: scale(1.25);
            z-index: 9999 !important;
        }
        .kmp-store-halo {
            position: absolute;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: rgba(225, 29, 72, 0.38);
            box-shadow: 0 0 12px rgba(225, 29, 72, 0.45);
            pointer-events: none;
        }
        .kmp-store-pill {
            position: relative;
            width: 20px;
            height: 36px;
            border-radius: 9999px;
            background: linear-gradient(180deg, #dc2626 0%, #b91c1c 100%);
            border: 2px solid #ffffff;
            box-shadow: 0 4px 10px rgba(185, 28, 28, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            z-index: 2;
        }
        .kmp-store-pill i {
            color: #ffffff !important;
            font-size: 11px;
            filter: drop-shadow(0 1px 1px rgba(0, 0, 0, 0.3));
        }

        .custom-kmp-pin {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            cursor: pointer;
            transition: transform 0.2s ease, filter 0.2s ease;
        }

        .custom-kmp-pin:hover {
            transform: scale(1.18);
            z-index: 9999 !important;
        }

        .pin-body {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #b91c1c, #991b1b);
            border-radius: 50%;
            border: 2px solid #ffffff;
            box-shadow: 0 4px 10px rgba(185, 28, 28, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 13px;
        }

        .pin-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background-color: #ffffff;
            color: #b91c1c;
            border: 1.5px solid #b91c1c;
            font-size: 10px;
            font-weight: 800;
            border-radius: 9999px;
            padding: 1px 5px;
            line-height: 1.1;
            box-shadow: 0 2px 4px rgba(0,0,0,0.15);
        }

        /* Facility Pin for Filtered Map Points */
        .custom-facility-pin {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            cursor: pointer;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .custom-facility-pin:hover {
            transform: scale(1.25);
            z-index: 9999 !important;
        }

        .pin-facility-core {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, #ef4444, #991b1b);
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            border: 2px solid #ffffff;
            box-shadow: 0 6px 14px rgba(220, 38, 38, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
        }

        .pin-facility-core i {
            transform: rotate(45deg);
            font-size: 14px;
            filter: drop-shadow(0 1px 2px rgba(0,0,0,0.3));
        }

        .pin-facility-pulse {
            position: absolute;
            width: 14px;
            height: 14px;
            bottom: -6px;
            left: 10px;
            background: rgba(239, 68, 68, 0.6);
            border-radius: 50%;
            animation: pinPulse 1.8s infinite ease-out;
            pointer-events: none;
        }

        @keyframes pinPulse {
            0% { transform: scale(0.6); opacity: 1; }
            100% { transform: scale(3.2); opacity: 0; }
        }

        /* Custom scrollbars */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased selection:bg-red-500 selection:text-white min-h-screen flex flex-col justify-between overflow-x-hidden w-full max-w-full">

    @yield('content')

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    @stack('scripts')
</body>
</html>
