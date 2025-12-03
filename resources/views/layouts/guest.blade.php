<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Đăng nhập hệ thống')</title>
    {{-- Font chữ --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg: #f0f2f5;
            --accent: #48a6a7;
            --accent-hover: #2f7f80;
            --text: #1f2937;
            --muted: #6b7280;
            --border: #e5e7eb;
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        * { box-sizing: border-box; }
        
        body {
            margin: 0;
            font-family: 'Nunito', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: grid;
            place-items: center;
        }

        .login-shell {
            width: 100%;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 40px 30px;
            border-top: 5px solid var(--accent);
        }

        h1 { margin: 0 0 5px; font-size: 24px; color: var(--text); text-align: center; font-weight: 800; }
        .subtitle { margin: 0 0 30px; color: var(--muted); text-align: center; font-size: 14px; }

        label { display: block; font-weight: 600; font-size: 14px; margin-bottom: 6px; color: #374151; }
        
        .input-group { position: relative; margin-bottom: 20px; }
        
        .input-group input {
            width: 100%;
            padding: 12px 16px 12px 42px; /* Chừa chỗ cho icon */
            border: 2px solid var(--border);
            border-radius: 10px;
            outline: none;
            font-size: 15px;
            transition: all 0.2s;
            color: var(--text);
        }

        .input-group input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(72, 166, 167, 0.1);
        }

        .input-group svg, .input-group i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            pointer-events: none;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background-color: var(--accent);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn:hover { background-color: var(--accent-hover); }

        .options { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; font-size: 14px; }
        .options a { color: var(--accent); text-decoration: none; font-weight: 600; }
        .options input { accent-color: var(--accent); cursor: pointer; }

        .divider { display: flex; align-items: center; margin: 25px 0; color: var(--muted); font-size: 13px; }
        .divider::before, .divider::after { content: ""; flex: 1; height: 1px; background: var(--border); }
        .divider span { padding: 0 10px; }

        .social-btns { display: grid; gap: 10px; }
        .btn-social {
            width: 100%; padding: 10px; border-radius: 8px; border: 1px solid var(--border);
            background: #fff; font-weight: 600; color: #4b5563; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            font-size: 14px; transition: 0.2s;
        }
        .btn-social:hover { background: #f9fafb; }

        .text-danger { color: #e11d48; font-size: 13px; margin-top: 4px; display: block; }
        
        .footer-text { text-align: center; margin-top: 25px; font-size: 14px; color: var(--muted); }
        .footer-text a { color: var(--accent); text-decoration: none; font-weight: 700; }
    </style>
</head>
<body>
    <div class="login-shell">
        @yield('content')
    </div>
</body>
</html>