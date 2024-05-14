<?php
if (!isset($_SESSION)) {
    session_start();
}

?>
<?php include __DIR__ . './parts/head.php' ?>
<?php include __DIR__ . './parts/navbar.php' ?>

<div class="container">
    <h1>Home</h1>
</div>

<?php include __DIR__ . './parts/footer.php' ?>
<?php include __DIR__ . './parts/scripts.php' ?>
<?php include __DIR__ . './parts/foot.php' ?>