<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
$name = $_SESSION['name'] ?? 'Administrator';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Smart Event Campus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* ========================================== */
        /* RESET & GLOBAL
        /* ========================================== */
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f0f4f8;
            padding: 24px;
            min-height: 100vh;
        }

        .main-content { max-width: 1100px; margin: 0 auto; }

        /* ========================================== */
        /* ANIMASI
        /* ========================================== */
        @keyframes fadeInUp {
            from { opacity:0; transform:translateY(30px); }
            to { opacity:1; transform:translateY(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .animate-fade { animation: fadeInUp 0.7s ease forwards; }
        .animate-float { animation: float 3s ease-in-out infinite; }

        /* ========================================== */
        /* HERO DENGAN GAMBAR
        /* ========================================== */
        .hero-about {
            background: linear-gradient(135deg, #5b7cff, #7c4dff);
            border-radius: 24px;
            padding: 50px 45px;
            color: #fff;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(91,124,255,0.25);
        }
        .hero-about::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -5%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }
        .hero-about .hero-content { position: relative; z-index: 1; }

        /* Gambar/Ilustrasi di Hero */
        .hero-illustration {
            position: absolute;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 140px;
            opacity: 0.10;
            z-index: 0;
            animation: float 4s ease-in-out infinite;
        }

        .hero-about .badge-hero {
            display: inline-block;
            padding: 4px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,0.15);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }
        .hero-about h1 {
            font-size: 34px;
            font-weight: 900;
            margin-bottom: 12px;
        }
        .hero-about p {
            font-size: 16px;
            opacity: 0.9;
            max-width: 600px;
            margin: 0;
            line-height: 1.7;
        }

        /* ========================================== */
        /* CARD DENGAN GAMBAR
        /* ========================================== */
        .card-about {
            background: #fff;
            border-radius: 18px;
            padding: 30px 32px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.03);
            margin-bottom: 24px;
            transition: 0.3s;
        }
        .card-about:hover {
            box-shadow: 0 12px 40px rgba(0,0,0,0.06);
            transform: translateY(-3px);
        }
        .card-about .icon-wrapper {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            background: linear-gradient(135deg, #5b7cff, #7c4dff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #fff;
            margin-bottom: 14px;
            box-shadow: 0 8px 20px rgba(91,124,255,0.25);
        }
        .card-about h4 {
            font-weight: 700;
            color: #1a1a2e;
            font-size: 20px;
            margin-bottom: 10px;
        }
        .card-about h4 i {
            color: #5b7cff;
            margin-right: 10px;
        }
        .card-about p {
            color: #555;
            line-height: 1.8;
            font-size: 15px;
            margin: 0;
        }
        .card-about ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .card-about ul li {
            padding: 7px 0;
            color: #555;
            font-size: 15px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            border-bottom: 1px solid #f8f9fa;
        }
        .card-about ul li:last-child { border-bottom: none; }
        .card-about ul li i {
            color: #5b7cff;
            font-size: 18px;
            margin-top: 2px;
        }

        /* ========================================== */
        /* FEATURE GRID DENGAN GAMBAR ICON
        /* ========================================== */
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-top: 6px;
        }
        .feature-item {
            background: #f8faff;
            border-radius: 16px;
            padding: 24px 20px;
            text-align: center;
            transition: 0.3s;
            border: 1px solid rgba(0,0,0,0.03);
        }
        .feature-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 35px rgba(91,124,255,0.10);
            background: #fff;
        }
        .feature-item .icon-box {
            width: 64px;
            height: 64px;
            margin: 0 auto 12px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #fff;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        .feature-item .icon-box.purple { background: linear-gradient(135deg, #5b7cff, #7c4dff); }
        .feature-item .icon-box.green { background: linear-gradient(135deg, #34c759, #16a34a); }
        .feature-item .icon-box.orange { background: linear-gradient(135deg, #ffb347, #ff7f50); }
        .feature-item .icon-box.blue { background: linear-gradient(135deg, #38bdf8, #2563eb); }
        .feature-item .icon-box i { font-size: 30px; }
        .feature-item h6 {
            font-weight: 700;
            color: #1a1a2e;
            font-size: 15px;
            margin-bottom: 3px;
        }
        .feature-item p {
            color: #888;
            font-size: 13px;
            margin: 0;
        }

        /* ========================================== */
        /* TEAM DENGAN AVATAR GAMBAR
        /* ========================================== */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-top: 4px;
        }
        .team-item {
            background: #f8faff;
            border-radius: 16px;
            padding: 24px 18px;
            text-align: center;
            border: 1px solid rgba(0,0,0,0.03);
            transition: 0.3s;
        }
        .team-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.06);
            background: #fff;
        }
        .team-item .avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, #5b7cff, #7c4dff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            font-weight: 700;
            color: #fff;
            margin: 0 auto 12px;
            box-shadow: 0 6px 20px rgba(91,124,255,0.2);
        }
        .team-item .avatar.orange { background: linear-gradient(135deg, #FF9800, #F57C00); box-shadow: 0 6px 20px rgba(255,152,0,0.2); }
        .team-item .avatar.green { background: linear-gradient(135deg, #4CAF50, #2E7D32); box-shadow: 0 6px 20px rgba(76,175,80,0.2); }
        .team-item .avatar.blue { background: linear-gradient(135deg, #2196F3, #0D47A1); box-shadow: 0 6px 20px rgba(33,150,243,0.2); }
        .team-item h6 {
            font-weight: 700;
            color: #1a1a2e;
            font-size: 15px;
            margin: 0;
        }
        .team-item .role {
            color: #888;
            font-size: 13px;
        }

        /* ========================================== */
        /* FOOTER
        /* ========================================== */
        .footer {
            text-align: center;
            padding: 18px 0 5px;
            color: #bbb;
            font-size: 13px;
            border-top: 1px solid #f0f0f0;
            margin-top: 25px;
        }
        .footer i { color: #5b7cff; }

        /* ========================================== */
        /* RESPONSIVE
        /* ========================================== */
        @media (max-width: 992px) {
            .feature-grid { grid-template-columns: repeat(2, 1fr); }
            .team-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            body { padding: 14px; }
            .hero-about { padding: 30px 24px; }
            .hero-about h1 { font-size: 26px; }
            .hero-illustration { display: none; }
            .card-about { padding: 22px 20px; }
            .feature-grid { grid-template-columns: repeat(2, 1fr); }
            .team-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 480px) {
            .feature-grid { grid-template-columns: 1fr; }
            .team-grid { grid-template-columns: 1fr; }
            .hero-about h1 { font-size: 22px; }
        }
    </style>
</head>
<body>

<!-- ========================================== -->
<!-- MAIN CONTENT
<!-- ========================================== -->
<div class="main-content">

    <!-- ===== HERO DENGAN GAMBAR ===== -->
    <div class="hero-about animate-fade">
        <div class="hero-content">
            <div class="badge-hero"><i class="bi bi-info-circle"></i> TENTANG KAMI</div>
            <h1>Tentang Smart Event Campus</h1>
            <p>Platform informasi kegiatan kampus yang membantu mahasiswa dan civitas akademika menemukan, mendaftar, dan mengelola berbagai event kampus dengan mudah dan terorganisir.</p>
        </div>
        <!-- ===== GAMBAR/ILUSTRASI DI HERO ===== -->
        <div class="hero-illustration animate-float">
            <i class="bi bi-calendar-event"></i>
        </div>
    </div>

    <!-- ===== TENTANG ===== -->
    <div class="card-about animate-slide delay-1">
        <div class="icon-wrapper"><i class="bi bi-calendar-event"></i></div>
        <h4>Tentang Smart Event Campus</h4>
        <p><strong>Smart Event Campus</strong> adalah platform digital yang dirancang untuk membantu mahasiswa dan civitas akademika dalam menemukan, mendaftar, dan mengelola berbagai kegiatan kampus seperti seminar, workshop, lomba, pelatihan, dan event lainnya secara mudah dan terorganisir.</p>
    </div>

    <!-- ===== VISI ===== -->
    <div class="card-about animate-slide delay-2">
        <h4><i class="bi bi-eye"></i> Visi Kami</h4>
        <ul>
            <li><i class="bi bi-dot"></i> Menjadi platform manajemen event kampus terkemuka yang terintegrasi, efisien, dan mudah digunakan oleh seluruh civitas akademika di Indonesia.</li>
        </ul>
    </div>

    <!-- ===== MISI ===== -->
    <div class="card-about animate-slide delay-3">
        <h4><i class="bi bi-bullseye"></i> Misi Kami</h4>
        <ul>
            <li><i class="bi bi-check-circle"></i> Menyediakan sistem manajemen event yang mudah dan efisien</li>
            <li><i class="bi bi-check-circle"></i> Membantu kampus dalam mengelola data event secara terpusat</li>
            <li><i class="bi bi-check-circle"></i> Meningkatkan partisipasi mahasiswa dalam kegiatan kampus</li>
            <li><i class="bi bi-check-circle"></i> Mendukung kegiatan akademik dan non-akademik di kampus</li>
        </ul>
    </div>

    <!-- ===== FITUR DENGAN GAMBAR ICON ===== -->
    <div class="card-about animate-slide delay-4">
        <h4><i class="bi bi-stars"></i> Apa yang Kami Lakukan?</h4>
        <div class="feature-grid">
            <div class="feature-item">
                <div class="icon-box purple"><i class="bi bi-clipboard"></i></div>
                <h6>Manajemen Event</h6>
                <p>Kelola semua event kampus dengan mudah.</p>
            </div>
            <div class="feature-item">
                <div class="icon-box green"><i class="bi bi-pencil-square"></i></div>
                <h6>Pendaftaran Online</h6>
                <p>Sistem pendaftaran event yang cepat dan aman.</p>
            </div>
            <div class="feature-item">
                <div class="icon-box orange"><i class="bi bi-database"></i></div>
                <h6>Informasi Terpusat</h6>
                <p>Informasi event lengkap dalam satu platform.</p>
            </div>
            <div class="feature-item">
                <div class="icon-box blue"><i class="bi bi-geo-alt"></i></div>
                <h6>Lokasi Event</h6>
                <p>Temukan lokasi kegiatan dengan mudah.</p>
            </div>
        </div>
    </div>

    <!-- ===== TEAM DENGAN AVATAR ===== -->
    <div class="card-about animate-fade">
        <h4><i class="bi bi-people"></i> Tim Pengembang</h4>
        <div class="team-grid">
            <div class="team-item">
                <div class="avatar">A</div>
                <h6>Admin Utama</h6>
                <div class="role">Administrator</div>
            </div>
            <div class="team-item">
                <div class="avatar orange">D</div>
                <h6>Developer</h6>
                <div class="role">Web Developer</div>
            </div>
            <div class="team-item">
                <div class="avatar green">M</div>
                <h6>Manager</h6>
                <div class="role">Project Manager</div>
            </div>
            <div class="team-item">
                <div class="avatar blue">S</div>
                <h6>Support</h6>
                <div class="role">Customer Support</div>
            </div>
        </div>
    </div>

    <!-- ===== FOOTER ===== -->
    <div class="footer">
        <i class="bi bi-c-circle"></i> 2026 Smart Event Campus - Universitas Potensi Utama
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>