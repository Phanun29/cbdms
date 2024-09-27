<?php
session_start();
require "admin/config.php";

$errors = array();

// If user click login button
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $check_email = "SELECT * FROM tbl_users WHERE username = '$email'";
    $res = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($res) > 0) {
        $fetch = mysqli_fetch_assoc($res);
        $fetch_pass = $fetch['password'];
        if (password_verify($password, $fetch_pass)) {
            $_SESSION['username'] = $email;
            $status = $fetch['status'];
            if ($status == 'active') {
                $_SESSION['username'] = $email;
                $_SESSION['password'] = $password;
                header('location: admin');
            } else {
                // echo "your account is inactive";
                $errors['username'] = "your account is inactive";
                // $info = "It looks like you haven't verified your email - $email";

            }
        } else {
            $errors['username'] = "Incorrect username or password!";
        }
    } else {
        $errors['username'] = "It looks like you're not yet a member! ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CBDMS | Corn Breeding Data Management System</title>
    <link rel="icon" href="assets/img/logo_ksit.PNG">

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body style="background: rgb(0, 80, 0);" class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <img src="assets/img/logo_ksit.png" alt="" style="width: 100%;">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome</h1>
                                    </div>
                                    <form class="" method="POST">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user" value="" id="InputUsername" placeholder="Enter User name..." required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="InputPassword" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="ShowPassword">
                                                <label class="custom-control-label" for="ShowPassword">
                                                    Show Password

                                                </label>
                                            </div>
                                        </div>
                                        <?php
                                        if (count($errors) > 0) {
                                        ?>
                                            <div class="alert alert-danger text-center">
                                                <?php
                                                foreach ($errors as $showerror) {
                                                    echo $showerror;
                                                }
                                                ?>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <button name="login" class="btn btn-primary btn-user btn-block">Login</button>

                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <!-- show password -->
    <script>
        const Password = document.getElementById("InputPassword");
        const Check = document.getElementById("ShowPassword");

        Check.onchange = function(e) {
            Password.type = Check.checked ? "text" : "password";
        };
    </script>
</body>

</html>