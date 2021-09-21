<?php

Class CriticRequest extends Controller {
    function index() {
        $user = $this->model("user");

        if(!$user->check_logged_in()) {
            header("Location:".ROOT."signin");
            die;
        } elseif($_SESSION['user_id'] != 0) {
            header("Location:".ROOT."home");
            die;
        }

        $games = $this->model("games");
        $data['requests'] = $games->load_requests();
        
        if(isset($_POST['decision'])) {
            $games->approval($_POST);
        }

        $data['page_title'] = "Pending Requests";

        $this->view("gameon/criticrequest", $data);
    }
}