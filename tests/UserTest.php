<?php

require_once 'app/core/app.php';
require_once 'app/core/config.php';
require_once 'app/core/controller.php';
require_once 'app/core/database.php';
require_once 'app/models/user.php';

class UserTest extends \PHPUnit\Framework\TestCase {
    public function testLogin(){
        $user = new user();
        $POST = [
            'username' => "demo",
            'password' => "asd",
        ];

        $user->login($POST);

        $this->assertEquals(7, $_SESSION['user_id']);
    }
}