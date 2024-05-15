<?php
require __DIR__ . '/../config/pdo-connect.php';

$title = '生前契約 - 線上下單';
$pageName = 'booking';
?>
<?php include __DIR__ . '/parts/html_head.php' ?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #fff;
        color: #fff;
        margin: 0;
        padding: 0;
    }

    #sidebar {
        width: 250px;
        background-color: #c8dbdf;
        padding: 20px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: -250px;
        transition: left 0.3s ease;
    }

    #sidebar.show {
        left: 0;
    }

    #content {
        margin-left: 250px;
        padding: 20px;
    }

    h1 {
        color: #0c5a67;
    }

    .menu-item {
        margin-bottom: 10px;
        transition: transform 0.3s ease;
    }

    .menu-item a {
        color: #0c5a67;
        text-decoration: none;
        display: block;
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .menu-item a:hover {
        background-color: #81b6be;
        color: #fff;
    }

    .menu-item:hover {
        transform: translateX(5px);
        color: #fff;
    }
</style>


<div id="sidebar" class="show">
    <h1>Petitude</h1>
    <div class="menu-item">
        <a href="#">首頁</a>
    </div>
    <div class="menu-item">
        <a href="#">使用者管理</a>
    </div>
    <div class="menu-item">
        <a href="#">設置</a>

    </div>
    <div class="menu-item">
        <a href="#">登出</a>
    </div>
</div>
<div id="content">
    <h1>Good Morning</h1>
    <p>這裡是您的後台管理面板。請在左側選擇您想要執行的操作。</p>
    <button onclick="toggleSidebar()">Toggle Sidebar</button>
</div>。請在左側選擇您想要執行的操作。</p>




<?php include __DIR__ . '/parts/script.php' ?>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('show');
    }
</script>





<?php include __DIR__ . '/parts/html_foot.php' ?>