<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Aktivasi Akun SIM BMN</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #4f46e5;
            padding: 20px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
            color: #333333;
            line-height: 1.6;
        }
        .credentials {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        .credentials p {
            margin: 5px 0;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            background-color: #4f46e5;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: bold;
        }
        .button:hover {
            background-color: #4338ca;
        }
        .footer {
            background-color: #f1f5f9;
            padding: 20px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Aktivasi Akun SIM BMN</h1>
        </div>
        
        <div class="content">
            <p>Halo, <strong>{{ $user->name }}</strong>,</p>
            <p>Akun Anda untuk sistem <strong>SIM BMN</strong> telah berhasil dibuat oleh Administrator. Namun, sebelum Anda dapat menggunakan akun tersebut, Anda perlu mengaktifkannya terlebih dahulu.</p>
            
            <p>Berikut adalah detail login Anda:</p>
            <div class="credentials">
                <p><strong>Email / Username:</strong> {{ $user->email }}</p>
                <p><strong>Password:</strong> {{ $passwordRaw }}</p>
            </div>
            
            <div class="button-container text-white">
                <a href="{{ $activationUrl }}" class="button text-white">Aktifkan Akun Saya</a>
            </div>
            
            <p>Jika Anda tidak merasa mendaftar atau didaftarkan untuk akun ini, Anda dapat mengabaikan email ini.</p>
            
            <p>Salam,<br>Tim Administrator SIM BMN</p>
        </div>
        
        <div class="footer">
            &copy; {{ date('Y') }} SIM BMN. All rights reserved.
        </div>
    </div>
</body>
</html>
