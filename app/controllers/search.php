<?php

Class Search extends Controller {
    function index() {
        $games = $this->model("games");
        $games->update_avg_rating();
        $games->update_avg_score();
        
        if(isset($_POST['search'])) {
            $data['search'] = $_POST['search'];
            $result = $games->search_games($data['search']);
        } elseif(isset($_POST['criteria'])) {
            $data['search'] = '';
            $result = $games->search_criteria($_POST['criteria']);
        } else {
            $data['search'] = '';
            $result = $games->search_games($data['search']);
        }

        $data['result'] = $result;
        $data['page_title'] = "Search Games";

        $this->view("gameon/search", $data);
    }
}