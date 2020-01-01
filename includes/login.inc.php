<?php

    function validLogin($user) {
        header("Location: ../app.php");
        exit();
    }

    function invalidLogin() {
        header("Location: ../index.php?error=invalidLogin");
        exit();
    }

    if (isset($_POST['login-submit'])) {

        try {
            require 'dbconfig.inc.php';
        } catch(Exception $e) {
            header("Location: ../index.php?error=dbConnIssue");
            exit();
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "select * from users where username = '$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password'];
            if(password_verify($password, $hashed_password)) {
                validLogin($row);
            } else {
                invalidLogin();
            }
         } else {
            invalidLogin();
         }

         mysqli_close($conn);


    }
?>