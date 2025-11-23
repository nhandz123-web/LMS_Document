<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','DMS CNTT')</title>
  <style>
    :root{
      --bg:#f6f7fb;
      --card:#fffdf7;
      --accent:#48a6a7;      /* xanh ngọc dịu */
      --accent-2:#2f7f80;
      --ink:#0f172a;
      --muted:#6b7280;
      --ring:#b4e3e4;
      --input:#e9e9e9;
      --danger:#e11d48;
      --fb:#1877f2;
      --gg:#ea4335;
      --radius:16px;
      --shadow:0 10px 30px rgba(0,0,0,.07);
    }
    *{box-sizing:border-box}
    body{margin:0;font-family:system-ui,Segoe UI,Roboto,Helvetica,Arial,sans-serif;background:var(--bg);color:var(--ink)}
    .shell{min-height:100svh;display:grid;place-items:center;padding:24px}
    .card{
      width:min(480px, 92vw);
      background:linear-gradient(180deg,#fcfff8 0%, var(--card) 100%);
      border:3px solid var(--ring);
      border-radius:var(--radius);
      box-shadow:var(--shadow);
      padding:28px 26px;
    }
    h1{margin:6px 0 4px;font-size:28px;letter-spacing:.3px;color:var(--accent-2)}
    .subtitle{margin:0 0 18px;color:var(--muted);font-size:14px}
    .row{display:flex;gap:12px}
    label{display:block;font-weight:600;margin:12px 2px 6px}
    .inp{
      width:100%; border:2px solid var(--input); background:#fff; border-radius:12px;
      padding:12px 14px 12px 42px; outline:none; transition:.2s; position:relative;
    }
    .inp:focus{border-color:var(--accent); box-shadow:0 0 0 4px rgba(72,166,167,.15)}
    .icon{
      position:relative;
    }
    .icon svg{
      position:absolute; left:12px; top:50%; transform:translateY(-50%); opacity:.7;
    }
    .btn{
      width:100%; border:none; outline:none; cursor:pointer;
      background:var(--accent); color:#fff; padding:12px 16px; font-weight:700; border-radius:12px;
      transition:.2s; letter-spacing:.3px;
    }
    .btn:hover{background:var(--accent-2)}
    .muted{color:var(--muted); font-size:13px}
    .hr{
      display:flex; align-items:center; gap:10px; margin:18px 0 10px;
    }
    .hr:before,.hr:after{content:""; height:1px; flex:1; background:#ddd}
    .links{display:grid; grid-template-columns:1fr 1fr; gap:12px}
    .btn-fb,.btn-gg{
      display:flex; align-items:center; justify-content:center; gap:10px;
      color:#fff; border-radius:10px; padding:10px 12px; font-weight:600; border:0; cursor:pointer;
    }
    .btn-fb{background:var(--fb)}
    .btn-gg{background:var(--gg)}
    .alt{display:flex; justify-content:space-between; align-items:center; margin-top:10px}
    .small-link{color:var(--accent-2); text-decoration:none; font-weight:600}
    .danger{color:var(--danger); font-size:13px; margin:6px 2px 0}
    .footer{margin-top:14px; text-align:center}
  </style>
</head>
<body>
  <div class="shell">
    @yield('content')
  </div>
</body>
</html>
