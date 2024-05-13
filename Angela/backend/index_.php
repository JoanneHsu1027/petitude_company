    <?php
    if (!isset($_SESSION)) {
    session_start();
    }

    ?>
    <?php include __DIR__ . './../parts/html_head.php' ?>
    <?php include __DIR__ . './../parts/navbar.php' ?>

    <div class="container border border-3">
        <div class="row">
            <h1>Home Page</h1>
            <table>
                
            </table>
        </div>
    </div>

    <?php include __DIR__ . './../parts/script.php' ?>
    <?php include __DIR__ . './../parts/html_foot.php' ?>