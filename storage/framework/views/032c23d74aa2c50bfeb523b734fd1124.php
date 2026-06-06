<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body {
            background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
            display: flex; justify-content: center; align-items: center; min-height: 100vh; color: #334155; padding: 30px 20px;
        }
        .dashboard-card {
            width: 100%; max-width: 900px; background: rgba(255, 255, 255, 0.96); border-radius: 24px; padding: 40px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        .header-content {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #e2e8f0; padding-bottom: 20px;
        }
        .user-welcome h2 { font-size: 24px; font-weight: 600; color: #1e293b; }
        .user-welcome p { font-size: 14px; color: #64748b; }
        
        /* Avatar & Upload Form Styling */
        .profile-section {
            display: flex; flex-direction: column; align-items: center; gap: 10px; background: #f1f5f9; padding: 15px 25px; border-radius: 20px; text-align: center;
        }
        .avatar-container {
            width: 70px; height: 70px; border-radius: 50%; overflow: hidden; display: flex; justify-content: center; align-items: center; background: #4f46e5; color: white; font-weight: 600; font-size: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .avatar-container img { width: 100%; height: 100%; object-fit: cover; }
        .upload-btn-wrapper { position: relative; overflow: hidden; display: inline-block; cursor: pointer; }
        .btn-upload { border: 1px solid #cbd5e1; color: #475569; background-color: white; padding: 4px 12px; border-radius: 50px; font-size: 11px; font-weight: 500; cursor: pointer; }
        .upload-btn-wrapper input[type=file] { font-size: 100px; position: absolute; left: 0; top: 0; opacity: 0; cursor: pointer; }

        /* Alerts */
        .alert { padding: 10px 15px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; font-weight: 500; text-align: center; }
        .alert-success { background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger { background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        /* Grid Layout */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: #f8fafc; padding: 20px; border-radius: 16px; border: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 5px; position: relative; overflow: hidden; }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: #4f46e5; }
        .stat-card.orange::before { background: #f97316; }
        .stat-card.green::before { background: #10b981; }
        .stat-label { font-size: 13px; color: #64748b; font-weight: 500; }
        .stat-value { font-size: 24px; font-weight: 700; color: #1e293b; }
        .dashboard-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 30px; }
        @media (max-width: 768px) {
            .dashboard-grid { grid-template-columns: 1fr; }
            .header-content { flex-direction: column; gap: 15px; align-items: center; }
        }
        .panel-box { background: #fff; padding: 22px; border-radius: 16px; border: 1px solid #e2e8f0; }
        .panel-title { font-size: 15px; font-weight: 600; color: #1e293b; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; }
        .badge-status { background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .info-list { display: flex; flex-direction: column; gap: 12px; }
        .info-item { display: flex; justify-content: space-between; padding-bottom: 10px; border-bottom: 1px solid #f1f5f9; font-size: 13px; }
        .info-item span:first-child { color: #64748b; }
        .info-item span:last-child { font-weight: 500; color: #334155; }
        .activity-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .activity-table th { text-align: left; padding: 8px; color: #64748b; font-weight: 500; border-bottom: 2px solid #f1f5f9; }
        .activity-table td { padding: 10px 8px; border-bottom: 1px solid #f1f5f9; }
        .footer-action { display: flex; justify-content: flex-end; }
        .btn-logout { padding: 12px 30px; background: #ef4444; color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; }
        .btn-logout:hover { background: #dc2626; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.25); }
    </style>
</head>
<body>

    <div class="dashboard-card">
        
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="alert alert-danger"><?php echo e($errors->first()); ?></div>
        <?php endif; ?>

        <div class="header-content">
            <div class="user-welcome">
                <h2>Ringkasan Panel Utama 👋</h2>
                <p>Selamat datang kembali di pusat data akun Anda.</p>
            </div>
            
            <div class="profile-section">
                <div class="avatar-container">
                    <?php if(Auth::user()->avatar): ?>
                        <img src="<?php echo e(asset('storage/' . Auth::user()->avatar)); ?>" alt="Foto Profil">
                    <?php else: ?>
                        <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                    <?php endif; ?>
                </div>
                
                <form action="<?php echo e(route('avatar.update')); ?>" method="POST" enctype="multipart/form-data" id="avatarForm">
                    <?php echo csrf_field(); ?>
                    <div class="upload-btn-wrapper">
                        <button class="btn-upload">Ganti Foto</button>
                        <input type="file" name="avatar" accept="image/*" onchange="document.getElementById('avatarForm').submit();">
                    </div>
                </form>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-label">Total Kehadiran Sesi</span>
                <span class="stat-value">12 Kali</span>
            </div>
            <div class="stat-card orange">
                <span class="stat-label">Keamanan Akun</span>
                <span class="stat-value" style="color: #f97316;">Tinggi</span>
            </div>
            <div class="stat-card green">
                <span class="stat-label">Status Server</span>
                <span class="stat-value" style="color: #10b981;">Online</span>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="panel-box">
                <div class="panel-title">
                    <span>Identitas Pengguna</span>
                    <span class="badge-status">Sesi Aktif</span>
                </div>
                <div class="info-list">
                    <div class="info-item">
                        <span>Nama Lengkap</span>
                        <span><?php echo e(Auth::user()->name); ?></span>
                    </div>
                    <div class="info-item">
                        <span>Email Terdaftar</span>
                        <span><?php echo e(Auth::user()->email); ?></span>
                    </div>
                    <div class="info-item">
                        <span>Waktu Login</span>
                        <span><?php echo e(date('d M Y - H:i')); ?> WIB</span>
                    </div>
                </div>
            </div>

            <div class="panel-box">
                <div class="panel-title">Riwayat Aktivitas Terakhir</div>
                <table class="activity-table">
                    <thead>
                        <tr>
                            <th>Aktivitas</th>
                            <th>Status</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mengakses Dashboard</td>
                            <td style="color: #10b981; font-weight:500;">Berhasil</td>
                            <td>Baru saja</td>
                        </tr>
                        <tr>
                            <td>Proses Autentikasi Sistem</td>
                            <td style="color: #10b981; font-weight:500;">Berhasil</td>
                            <td>2 menit lalu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="footer-action">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-logout">Keluar Aplikasi (Logout)</button>
            </form>
        </div>

    </div>

</body>
</html><?php /**PATH C:\laragon\www\latihandatabase2\resources\views/auth/dashboard.blade.php ENDPATH**/ ?>