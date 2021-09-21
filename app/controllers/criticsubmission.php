<?php

Class CriticSubmission extends Controller {
    function index($game_name = '', $tab = '') {
        $data['game_name'] = $game_name;

        if($game_name == '') {
            header("Location:".ROOT."search");
            die;
        }

        if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == 0) {
            header("Location:".ROOT."home");
            die;
        }

        $games = $this->model("games");
        $data['game_info'] = $games->get_game_info($game_name);

        if(isset($_POST['critic']) && isset($_POST['critic']) && isset($_POST['email']) && isset($_POST['score']) && isset($_POST['comment']) && isset($_POST['link'])) {
            $games->submit_critic_review($_POST);
        }

        $data['page_title'] = $data['game_info'][0]->name." | Critics' Review Submission";

        if($tab == '') {
            $this->view("gameon/criticsubmission", $data);
        } elseif($tab == 'pending') {
            $this->view("gameon/pendingmessage", $data);
        }
    }
}