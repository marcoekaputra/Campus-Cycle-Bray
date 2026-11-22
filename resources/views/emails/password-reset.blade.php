<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f8fafc; color: #1e293b; padding: 24px; }
        .card { max-width: 540px; margin: 0 auto; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .header { background-color: #641E28; color: #ffffff; padding: 24px; text-align: center; }
        .body { padding: 32px 24px; line-height: 1.6; font-size: 14px; }
        .btn { display: inline-block; background-color: #641E28; color: #ffffff !important; text-decoration: none; font-weight: bold; padding: 12px 28px; border-radius: 9999px; margin: 20px 0; }
        .footer { background-color: #f1f5f9; padding: 16px 24px; text-align: center; font-size: 11px; color: #64748b; }
        .info-box { background-color: #fff1f2; border: 1px solid #fecdd3; border-radius: 12px; padding: 14px; margin: 16px 0; font-size: 13px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h2 style="margin: 0; font-size: 20px; font-weight: 800; color: #ffffff;">CampusCycle Untirta</h2>
            <p style="margin: 4px 0 0; font-size: 12px; color: #EDAB0F; font-weight: 600;">Permintaan Atur Ulang Kata Sandi</p>
        </div>
        <div class="body">
            <p>Halo <strong>{{ $user->name }}</strong>,</p>
            <p>Kami menerima permintaan untuk mereset kata sandi akun CampusCycle Anda.</p>
            
            <div class="info-box">
                <table style="width: 100%; font-size: 13px;">
                    <tr>
                        <td style="color: #64748b; width: 120px;">NIM Akun:</td>
                        <td style="font-weight: bold; color: #1e293b;">{{ $user->nim ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b;">Nama Mahasiswa:</td>
                        <td style="font-weight: bold; color: #1e293b;">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b;">Gmail Penerima:</td>
                        <td style="font-weight: bold; color: #641E28;">{{ $targetEmail ?? $user->email }}</td>
                    </tr>
                </table>
            </div>

            <p>Silakan klik tombol di bawah ini untuk membuat kata sandi baru akun Anda:</p>
            <div style="text-align: center;">
                <a href="{{ $resetUrl }}" class="btn">Atur Ulang Kata Sandi</a>
            </div>
            <p style="font-size: 12px; color: #64748b;">Tautan ini berlaku selama 60 menit. Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini dan akun Anda akan tetap aman.</p>
            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 24px 0;" />
            <p style="font-size: 11px; color: #94a3b8; word-break: break-all;">
                Jika tombol di atas tidak dapat diklik, salin tautan berikut ke peramban browser Anda:<br>
                <a href="{{ $resetUrl }}" style="color: #641E28;">{{ $resetUrl }}</a>
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} CampusCycle - Universitas Sultan Ageng Tirtayasa. Semua hak dilindungi.
        </div>
    </div>
</body>
</html>
