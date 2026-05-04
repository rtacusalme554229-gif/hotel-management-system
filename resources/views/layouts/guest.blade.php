<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>STAYEASE HOTEL</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }

        .auth-page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .auth-left {
            position: relative;
            min-height: 100vh;
            padding: 48px;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background:
                linear-gradient(90deg, rgba(2, 6, 23, 0.94), rgba(15, 23, 42, 0.75)),
                url('https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1600&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }

        .auth-left.register-bg {
            background:
                linear-gradient(90deg, rgba(2, 6, 23, 0.95), rgba(15, 23, 42, 0.78)),
                url('https://images.unsplash.com/photo-1571896349842-33c89424de2d?q=80&w=1600&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }

        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: linear-gradient(135deg, #f7d76a, #c89211);
            color: #031229;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 26px;
            position: relative;
        }

        .brand-icon::before {
            content: "♛";
            position: absolute;
            top: -17px;
            font-size: 20px;
            color: #f7d76a;
        }

        .brand-text h3 {
            margin: 0;
            font-size: 24px;
            font-weight: 900;
            letter-spacing: 0.5px;
        }

        .brand-text p {
            margin: 2px 0 0;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.78);
        }

        .auth-title {
            max-width: 620px;
        }

        .auth-title h1 {
            font-size: 52px;
            font-weight: 900;
            line-height: 1.05;
            margin-bottom: 18px;
        }

        .auth-title p {
            max-width: 520px;
            color: rgba(255,255,255,0.84);
            font-size: 18px;
            line-height: 1.7;
            margin: 0;
        }

        .auth-features {
            margin-top: 36px;
        }

        .feature-item {
            display: flex;
            gap: 18px;
            align-items: flex-start;
            margin-bottom: 26px;
        }

        .feature-icon {
            width: 54px;
            height: 54px;
            min-width: 54px;
            border-radius: 50%;
            border: 1px solid rgba(245, 196, 64, 0.65);
            color: #f4c542;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            background: rgba(15, 23, 42, 0.45);
        }

        .feature-item h5 {
            margin: 0 0 4px;
            font-size: 18px;
            font-weight: 800;
        }

        .feature-item p {
            margin: 0;
            color: rgba(255,255,255,0.78);
            font-size: 15px;
        }

        .security-note {
            border-top: 1px solid rgba(255,255,255,0.20);
            padding-top: 22px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255,255,255,0.82);
            font-size: 15px;
        }

        .auth-right {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px;
            background: #ffffff;
        }

        .auth-card {
            width: 100%;
            max-width: 560px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 28px;
            padding: 52px;
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.12);
        }

        .auth-card-logo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #06224a;
            color: #f4c542;
            margin: 0 auto 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 26px;
            position: relative;
        }

        .auth-card-logo::before {
            content: "♛";
            position: absolute;
            top: -16px;
            color: #f4c542;
            font-size: 18px;
        }

        .auth-heading {
            text-align: center;
            margin-bottom: 34px;
        }

        .auth-heading h2 {
            margin: 0 0 10px;
            font-size: 34px;
            font-weight: 900;
            color: #0f172a;
        }

        .auth-heading p {
            margin: 0;
            color: #64748b;
            font-size: 16px;
        }

        .form-label {
            font-weight: 800;
            color: #0f172a;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 18px;
            pointer-events: none;
            z-index: 2;
        }

        .auth-input {
            width: 100%;
            height: 56px;
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            padding-left: 52px;
            padding-right: 52px;
            font-size: 15px;
            outline: none;
            transition: 0.2s ease;
            background: #ffffff;
        }

        .auth-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.14);
        }

        .toggle-password {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 18px;
            cursor: pointer;
            z-index: 3;
        }

        .toggle-password:hover {
            color: #0f172a;
        }

        .auth-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin: 18px 0 24px;
            font-size: 15px;
        }

        .auth-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 800;
        }

        .auth-link:hover {
            color: #1d4ed8;
        }

        .auth-btn {
            width: 100%;
            height: 58px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #071c3f, #082b63);
            color: #ffffff;
            font-size: 17px;
            font-weight: 900;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .auth-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(8, 43, 99, 0.25);
        }

        .auth-bottom {
            text-align: center;
            margin-top: 28px;
            color: #64748b;
        }

        .two-cols {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .terms {
            margin: 18px 0 24px;
            font-size: 14px;
            color: #64748b;
        }

        @media (max-width: 992px) {
            .auth-page {
                grid-template-columns: 1fr;
            }

            .auth-left {
                display: none;
            }

            .auth-right {
                min-height: 100vh;
                padding: 24px;
            }

            .auth-card {
                padding: 32px;
            }

            .two-cols {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

@yield('content')

<script>
    function togglePassword(inputId, element) {
        const input = document.getElementById(inputId);
        const icon = element.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>

</body>
</html>