<?php 

    session_start();
    require "config.php";

    if (isset($_POST["login"])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
    }

    if (empty($username)) {
        $_SESSION['error'] = "Please enter your username";
        header("Location: login.php");
    } else if (empty($password)) {
        $_SESSION['error'] = "Please enter your password";
        header("Location: login.php");
    } else {
        try {

            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $userData = $stmt->fetch();

            if ($userData && password_verify($password, $userData['password'])) {
                $_SESSION['user_id'] = $userData['id'];
                header("Location: dashboard.php");
            } else {
                $_SESSION['error'] = "Invalid usrname or password";
                header("Location: login.php");
            }

        } catch(PODException $e) {
            $_SESSION['error'] = "Something went wrong, please try again.";
            header("Location: login.php");
        }
    }

?>