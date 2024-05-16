<?php
if (!isset($_SESSION)) {
  session_start();
}

?>
<?php include __DIR__ . '/../parts/head.php' ?>
<style>
  body {
    background-image: url('https://images.unsplash.com/photo-1547480786-6552fae2dd51?q=80&w=1740&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
    background-size: cover;
    background-position-x: left 20px;
    background-position-y: bottom 100px;
  }

  h1 {
    color: whitesmoke;
    font-size: 180px;
  }

  .eb-garamond {
    font-family: "EB Garamond", serif;
    font-optical-sizing: auto;
    font-weight: <weight>;
    font-style: normal;
    position: fixed;
    top: 30px;
    left: 100px;
    line-height: 250px;
  }

  .eb-garamond span {
    display: inline-block;
    position: relative;
  }

  .eb-garamond span:nth-child(1) {
    top: 60px;
    left: 10px;
  }

  .eb-garamond span:nth-child(2) {
    top: 60px;
    left: 40px;
    opacity: 0.7;
  }

  .eb-garamond span:nth-child(4) {
    left: 0px;
    bottom: -300px;
    opacity: 0.7;
    font-size: 250px;
  }

  .eb-garamond span:nth-child(5) {
    left: 1100px;
    bottom: -300px;

  }
</style>

<h1 class="eb-garamond">
  <span>P</span>
  <span>etitude</span><br>
  <span><a href="login.php" style="color:whitesmoke;">C</a></span>
  <span>ompany</span>
</h1>

<?php include __DIR__ . '/../parts/scripts.php' ?>
<?php include __DIR__ . '/../parts/foot.php' ?>