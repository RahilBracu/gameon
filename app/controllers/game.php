<?php

Class Game extends Controller {
    function index($game_name = '', $tab = '') {
        $games = $this->model("games");
        $games->update_avg_rating();
        $game_info = $games->get_game_info($game_name);

        if(!$game_info){
            header("Location:".ROOT."search");
            die;
        }
        
        $data['game_info'] = $game_info;
        $data['page_title'] = $game_info[0]->name;

        if($tab == "summary" || $tab == '') {
            $this->view("gameon/summary", $data);
        }

        elseif($tab == "critic-reviews") {
            $critic_comments = $games->get_critic_comments($game_name);
        
            $data['critic_comments'] = $critic_comments;
            $this->view("gameon/criticreview", $data);
        }

        elseif($tab == "user-reviews") {
            $user_comments = $games->get_user_comments($game_name);

            if(isset($_POST['rating1']) && isset($_POST['comment'])) {
                $user = $this->model("user");

                if(!$user->check_logged_in()) {
                    header("Location:".ROOT."signin");
                    die;
                }
                
                $games->submit_user_comment($_POST);
            }
        
            $data['user_comments'] = $user_comments;
            $this->view("gameon/userreview", $data);
        }

        elseif($tab == "system-requirements") {
            $system_req = $games->get_system_req($game_name);
        
            $data['system_req'] = $system_req;
            $this->view("gameon/systemrequirements", $data);
        }

        elseif($tab == "modify-game") {
            $user = $this->model("user");

            if(!$user->check_logged_in()) {
                header("Location:".ROOT."signin");
                die;
            } elseif($_SESSION['user_id'] != 0) {
                header("Location:".ROOT."home");
                die;
            }

            $system_req = $games->get_system_req($game_name);
        
            $data['system_req'] = $system_req;

            if(isset($_POST['game_name']) && isset($_POST['name']) && isset($_POST['thumbnail']) && isset($_POST['cover']) && isset($_POST['about']) && isset($_POST['platform']) && isset($_POST['genre']) && isset($_POST['release_date'])) {
                $games->modify_game($_POST);
            }

            $this->view("gameon/modifygame", $data);
        }
        
        elseif($tab == "delete-game") {
            $user = $this->model("user");

            if(!$user->check_logged_in()) {
                header("Location:".ROOT."signin");
                die;
            } elseif($_SESSION['user_id'] != 0) {
                header("Location:".ROOT."home");
                die;
            }

            $games->delete_game($game_name);
        }
    }
}