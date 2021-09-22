<?php

require 'app/core/app.php';
require 'app/core/config.php';
require 'app/core/controller.php';
require 'app/core/database.php';
require 'app/models/user.php';

class UserTest extends \PHPUnit\Framework\TestCase {
    public function testLogin(){
        $user = new user();
        $POST = [
            'username' => "demo",
            'password' => "asd",
        ];

        $user->login($POST);

        $this->assertEquals(7, $_SESSION['user_id']);
        $this->assertEquals("Demo Account", $_SESSION['fname']);
        $this->assertEquals("April 23, 1999", $_SESSION['dob']);
        $this->assertEquals("demo", $_SESSION['username']);
        $this->assertEquals("asd", $_SESSION['password']);
    }

    public function testCheckloggedIn(){
        $user = new user();
        $POST = [
            'username' => "demo",
            'password' => "asd",
        ];

        $user->login($POST);

        $this->assertEquals(true, $user->check_logged_in());
    }

    public function testLogout(){
        $user = new user();
        $POST = [
            'username' => "demo",
            'password' => "asd",
        ];

        $user->login($POST);

        $user->logout();

        $this->assertEquals(false, isset($_SESSION['user_id']));
        $this->assertEquals(false, isset($_SESSION['fname']));
        $this->assertEquals(false, isset($_SESSION['dob']));
        $this->assertEquals(false, isset($_SESSION['email']));
        $this->assertEquals(false, isset($_SESSION['username']));
        $this->assertEquals(false, isset($_SESSION['password']));
    }

    public function testSingup(){
        $user = new user();

        $POST = [
            'fname' => "Demo2 Account",
            'dob' => '2000-10-10',
            'email' => "demo2.account@gmail.com",
            'username' => "demo2",
            'password' => "123",
        ];

        $_POST = [
            'fname' => "Demo2 Account",
            'dob' => '2000-10-10',
            'email' => "demo2.account@gmail.com",
            'username' => "demo2",
            'password' => "123",
        ];

        $user->signup($POST);

        // Checking if a user with an username "demo2" exists AFTER signing up
        $DB = new Database();
        $query = "SELECT * FROM users WHERE username = 'demo2' LIMIT 1";
        $new_user = $DB->read($query);

        $this->assertEquals(true, is_array($new_user));
    }

    public function testEditProfile(){
        $user = new user();
        $data = [
            'username' => "demo2",
            'password' => "123",
        ];

        $user->login($data);

        $POST = [
            'fname' => "Demo2 Acc",
            'dob' => '2000-10-10',
            'email' => "demo2.account@yahoo.com",
        ];

        $_POST = [
            'fname' => "Demo2 Acc",
            'dob' => '2000-10-10',
            'email' => "demo2.account@yahoo.com",
        ];

        $user->edit_profile($POST);

        $DB = new Database();
        $query = "SELECT * FROM users WHERE username = 'demo2' LIMIT 1";
        $user_edited = $DB->read($query);

        $this->assertEquals("Demo2 Acc", $user_edited[0]->fname);
        $this->assertEquals("demo2.account@yahoo.com", $user_edited[0]->email);
    }

    public function testChangePassword(){
        $user = new user();
        $data = [
            'username' => "demo2",
            'password' => "123",
        ];

        $user->login($data);

        $POST = [
            'old_password' => "123",
            'new_password' => '12345',
            'confirm_password' => "12345",
        ];

        $_POST = [
            'old_password' => "123",
            'new_password' => '12345',
            'confirm_password' => "12345",
        ];

        $user->change_password($POST);

        $DB = new Database();
        $query = "SELECT * FROM users WHERE username = 'demo2' LIMIT 1";
        $user_edited = $DB->read($query);

        $this->assertEquals("12345", $user_edited[0]->password);
    }

    public function testDeleteAccount(){
        $user = new user();
        $data = [
            'username' => "demo2",
            'password' => "12345",
        ];

        $user->login($data);

        $POST = [
            'password' => "12345",
        ];

        $_POST = [
            'password' => "12345",
        ];

        $user->delete_account($POST);

        $DB = new Database();
        $query = "SELECT * FROM users WHERE username = 'demo2' LIMIT 1";
        $user_exists = $DB->read($query);

        $this->assertEquals(false, is_array($user_exists));
    }
}