<?php

Class SignOut extends Controller {
    function index(){
        $user = $this->model("user");
        $user->logout();
    }
}