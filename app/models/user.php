<?php

Class User {
    function login($POST) {
        $DB = new Database();

        $_SESSION['error'] = "";

        if(isset($POST['username']) && isset($POST['password'])) {
            $array['username'] = $POST['username'];
            $array['password'] = $POST['password'];
            $query = "SELECT * FROM users WHERE username = :username && password = :password LIMIT 1";
            
            $data = $DB->read($query, $array);

            if(is_array($data)) {
                $_SESSION['user_id'] = $data[0]->user_id;
                $_SESSION['fname'] = $data[0]->fname;
                $_SESSION['dob'] = date('F j, Y', strtotime($data[0]->dob));
                $_SESSION['email'] = $data[0]->email;
                $_SESSION['username'] = $data[0]->username;
                $_SESSION['password'] = $data[0]->password;

                header("Location:".ROOT."home");
            } else {
                $_SESSION['error'] = "Wrong username or password.";
            }
        } else {
            $_SESSION['error'] = "Please enter valid username and password.";
        }
    }

    function signup($POST) {
        $DB = new Database();

        $_SESSION['error'] = "";

        if(isset($_POST['fname']) && isset($_POST['dob']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {
            $array['fname'] = $POST['fname'];
            $array['dob'] = $POST['dob'];
            $array['email'] = $POST['email'];
            $array['username'] = $POST['username'];
            $array['password'] = $POST['password'];

            $query = "INSERT INTO users (fname, dob, email, username, password) VALUES (:fname, :dob, :email, :username, :password)";
            
            $data = $DB->write($query, $array);

            if($data) {
                header("Location:".ROOT."signin");
            }
        } else {
            $_SESSION['error'] = "Please enter valid information.";
        }
    }

    function check_logged_in() {
        $DB = new Database();

        if(isset($_SESSION['user_id'])) {
            $array['user_id'] = $_SESSION['user_id'];

            $query = "SELECT * FROM users WHERE user_id = :user_id LIMIT 1";
            
            $data = $DB->read($query, $array);

            if(is_array($data)) {
                $_SESSION['user_id'] = $data[0]->user_id;
                $_SESSION['fname'] = $data[0]->fname;
                $_SESSION['dob'] = date('F j, Y', strtotime($data[0]->dob));
                $_SESSION['email'] = $data[0]->email;
                $_SESSION['user_name'] = $data[0]->username;
                $_SESSION['password'] = $data[0]->password;

                return true;
            }
        }

        return false;
    }

    function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['fname']);
        unset($_SESSION['dob']);
        unset($_SESSION['email']);
        unset($_SESSION['username']);
        unset($_SESSION['password']);

        header("Location:".ROOT."signin");
    }

    function edit_profile($POST) {
        $DB = new Database();

        $_SESSION['error'] = "";

        if(isset($_POST['fname']) && isset($_POST['dob']) && isset($_POST['email'])) {
            $array['user_id'] = $_SESSION['user_id'];
            $array['fname'] = $POST['fname'];
            $array['dob'] = $POST['dob'];
            $array['email'] = $POST['email'];

            $query = "UPDATE users SET fname = :fname, dob = :dob, email = :email WHERE user_id = :user_id LIMIT 1";
            
            $data = $DB->write($query, $array);

            if($data) {
                header("Location:".ROOT."account/".$_SESSION['user_id']."/account-info");
            }
        } else {
            $_SESSION['error'] = "Please enter valid information.";
        }
    }

    function change_password($POST) {
        $DB = new Database();

        $_SESSION['error'] = "";

        if(isset($_POST['old_password']) && isset($_POST['new_password']) && $_POST['confirm_password']) {
            if($POST['old_password'] == $_SESSION['password']) {
                if($_POST['new_password'] == $_POST['confirm_password']) {
                    $array['user_id'] = $_SESSION['user_id'];
                    $array['new_password'] = $POST['new_password'];

                    $query = "UPDATE users SET password = :new_password WHERE user_id = :user_id LIMIT 1";
                    
                    $data = $DB->write($query, $array);
    
                    if($data) {
                        header("Location:".ROOT."account/".$_SESSION['user_id']."/account-info");
                    }
                } else {
                    $_SESSION['error'] = "New and confirmed passwords do not match.";
                }
            } else {
                $_SESSION['error'] = "You've entered wrong existing password.";
            }
        } else {
            $_SESSION['error'] = "Please enter valid information.";
        }
    }

    function delete_account($POST) {
        $DB = new Database();

        $_SESSION['error'] = "";

        if(isset($_POST['password'])) {
            if($POST['password'] == $_SESSION['password']) {
                $array['user_id'] = $_SESSION['user_id'];
                $query = "DELETE FROM users WHERE user_id = :user_id LIMIT 1";
                
                $data = $DB->write($query, $array);
                
                if($data) {
                    header("Location:".ROOT."signout");
                }
            } else {
                $_SESSION['error'] = "You've entered wrong password.";
            }
        } else {
            $_SESSION['error'] = "Please enter valid information.";
        }
    }
}