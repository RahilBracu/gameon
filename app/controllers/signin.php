<?php

Class SignIn extends Controller {
    function index(){
        $data['page_title'] = "Sign in";

        if(isset($_POST['username']) && isset($_POST['password'])) {
            $user = $this->model("user");
            $user->login($_POST);
        }

        $this->view("gameon/signin", $data);
    }
}