    <?php

    session_start();

    $_SESSION['admin'] = [
        'id' => 1,
        'email' => 'angela@gmail.com',
        'nickname' => 'Angela',
    ];

    header('Location: list.php');