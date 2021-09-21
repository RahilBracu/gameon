<?php

Class AddGame extends Controller {
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
        
        if(isset($_POST['game_name']) && isset($_POST['name']) && isset($_POST['thumbnail']) && isset($_POST['cover']) && isset($_POST['about']) && isset($_POST['platform']) && isset($_POST['genre']) && isset($_POST['release_date'])) {
            $games->add_game($_POST);
        }

        $data['page_title'] = "Add Game";

        $this->view("gameon/addgame", $data);
    }
}