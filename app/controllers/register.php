<?php

Class Register extends Controller {
    function index(){
        $data['page_title'] = "Register";

        if(isset($_POST['fname']) && isset($_POST['dob']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {
            $user = $this->model("user");
            $user->signup($_POST);
        }

        $this->view("gameon/register", $data);
    }
}