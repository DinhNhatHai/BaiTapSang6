<?php

require_once 'app/model/UserModel.php';

class AccountController {
    private $db;
    private $userModel;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->userModel = new UserModel($this->db);
    }

    public function login() {
        include_once 'app/views/account/login.php';
    }

    public function checkLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $err = [];

            // Validate email
            if (empty($email)) {
                $err['email'] = "Email is required";
            }

            if (empty($password)) {
                $err['password'] = "Password is required";
            }

            if (!empty($err)) {
                include_once 'app/views/account/login.php';
                return; 
            }

            $user = $this->userModel->getUserByEmail($email);
            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_email'] = $user->email;
                $_SESSION['user_role'] = $user->role;
                header('Location: /BaiTapSang6');
            } else {
                $err['login'] = "Incorrect email or password";
                include_once 'app/views/account/login.php';
            }
        }
    }

    public function register() {
        include_once 'app/views/account/register.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirmpassword = $_POST['Confirmpassword'];

            $err = [];

            // Validate email
            if (empty($email)) {
                $err['email'] = "Email is required";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $err['email'] = "Invalid email format";
            } elseif ($this->userModel->getUserByEmail($email)) {
                $err['email'] = "Email already exists";
            }

            // Validate username
            if (empty($username)) {
                $err['username'] = "Username is required";
            }

            // Validate password
            if (empty($password)) {
                $err['password'] = "Password is required";
            } elseif (strlen($password) < 8) {
                $err['password'] = "Password must be at least 8 characters long";
            }

            // Validate confirm password
            if (empty($confirmpassword)) {
                $err['confirmpassword'] = "Confirm Password is required";
            } elseif ($password !== $confirmpassword) {
                $err['confirmpassword'] = "Passwords do not match";
            }


            if (!empty($err)) {
                include_once 'app/views/account/register.php';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

                $registered = $this->userModel->registerUser($email, $username, $hashedPassword);
                
                if ($registered) {
                    header('Location: /BaiTapSang6/account/login');
                    exit();
                } else {
                    include_once 'app/views/account/register.php';
                }
            }
        }
    }
}


