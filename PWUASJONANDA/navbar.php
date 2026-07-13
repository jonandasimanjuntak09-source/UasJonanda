<?php if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); } ?>
<div class="sidebar">
    <div class="sidebar-brand">
        <a href="dashboard.php">
            <i class="bi bi-calendar-event"></i>
            Smart <span>Event</span>
        </a>
    </div>
    
    <div class="sidebar-menu">
        <div class="menu-label">MENU</div>
        <ul>
            <li><a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='dashboard.php'?'active':''; ?>"><i class="bi bi-grid-1x2"></i> Dashboard</a></li>
            <li><a href="event.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='event.php'?'active':''; ?>"><i class="bi bi-calendar2-week"></i> Event</a></li>
            <li><a href="kategori.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='kategori.php'?'active':''; ?>"><i class="bi bi-tags"></i> Kategori</a></li>
            <li><a href="pendaftaran.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='pendaftaran.php'?'active':''; ?>"><i class="bi bi-clipboard"></i> Pendaftaran</a></li>
            <li><a href="lokasi.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='lokasi.php'?'active':''; ?>"><i class="bi bi-geo-alt"></i> Lokasi</a></li>
            <li><a href="pengguna.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='pengguna.php'?'active':''; ?>"><i class="bi bi-people"></i> Pengguna</a></li>
        </ul>
        
        <div class="menu-label">LAINNYA</div>
        <ul>
            <li><a href="pengaturan.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='pengaturan.php'?'active':''; ?>"><i class="bi bi-gear"></i> Pengaturan</a></li>
            <li><a href="about.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='about.php'?'active':''; ?>"><i class="bi bi-info-circle"></i> Tentang Kami</a></li>
            <li><a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
    </div>
    
    <div class="sidebar-user">
        <i class="bi bi-person-circle"></i>
        <span><?php echo $_SESSION['name'] ?? 'Administrator'; ?></span>
    </div>
</div>

<style>
/* ========================================== */
/* SIDEBAR - LEBIH KECIL
/* ========================================== */
.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: 200px;
    height: 100vh;
    background: linear-gradient(180deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    color: #fff;
    padding: 15px 0;
    z-index: 1000;
    overflow-y: auto;
    box-shadow: 2px 0 20px rgba(0,0,0,0.2);
}

.sidebar-brand {
    padding: 0 16px 15px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    margin-bottom: 10px;
}
.sidebar-brand a {
    color: #fff;
    font-size: 17px;
    font-weight: 800;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
}
.sidebar-brand a i {
    font-size: 22px;
    color: #667eea;
}
.sidebar-brand a span {
    color: #667eea;
}

.menu-label {
    font-size: 10px;
    color: rgba(255,255,255,0.3);
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 8px 16px 4px;
    font-weight: 600;
}

.sidebar-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.sidebar-menu ul li a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 7px 16px;
    color: rgba(255,255,255,0.6);
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    transition: 0.3s;
}
.sidebar-menu ul li a:hover {
    color: #fff;
    background: rgba(255,255,255,0.05);
}
.sidebar-menu ul li a.active {
    color: #fff;
    background: rgba(102,126,234,0.2);
}
.sidebar-menu ul li a i {
    font-size: 16px;
    width: 20px;
}

.sidebar-user {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 12px 16px;
    border-top: 1px solid rgba(255,255,255,0.05);
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255,255,255,0.6);
    font-size: 13px;
}
.sidebar-user i {
    font-size: 18px;
    color: #667eea;
}

.main-content {
    margin-left: 200px;
    padding: 20px 25px;
    min-height: 100vh;
    background: #f0f4f8;
}

@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        width: 220px;
    }
    .sidebar.open {
        transform: translateX(0);
    }
    .main-content {
        margin-left: 0;
        padding: 15px;
    }
    .sidebar-toggle {
        display: flex !important;
    }
}

.sidebar-toggle {
    display: none;
    position: fixed;
    top: 12px;
    left: 12px;
    z-index: 1100;
    background: #1a1a2e;
    color: #fff;
    border: none;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 20px;
    cursor: pointer;
}

.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.4);
    z-index: 999;
}
.overlay.show {
    display: block;
}
</style>