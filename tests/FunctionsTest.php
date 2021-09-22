<?php

require 'app/core/functions.php';

class FunctionsTest extends \PHPUnit\Framework\TestCase {
    public function testCheckMessageWhenNoErrorFound(){
        $_SESSION['error'] = ""; // Default message is empty for all functions

        $this->setOutputCallback(function() {});
        $message = check_message();

        $this->assertEquals("", $message);
    }

    public function testCheckMessageWhenErrorFound(){
        $_SESSION['error'] = "Error found."; // Sample error

        $this->setOutputCallback(function() {});
        $message = check_message();

        $this->assertEquals("Error found.", $message);
    }
}