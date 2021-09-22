<?php

require 'app/models/games.php';

class GamesTest extends \PHPUnit\Framework\TestCase {
    public function testSearchGames(){
        $games = new games();
        $POST = [
            'search' => "fifa",
        ];

        $result = $games->search_games($POST);

        $this->assertEquals(true, is_array($result));
        $this->assertEquals("FIFA 20", $result[0]->name);
        $this->assertEquals("FIFA 21", $result[1]->name);
    }

    public function testSearchCriteria(){
        $games = new games();
        $query = "SELECT * FROM games WHERE YEAR(release_date) >= 2020";

        $result = $games->search_criteria($query);

        $this->assertEquals(true, is_array($result));
        $this->assertEquals("FIFA 21", $result[0]->name);
    }

    public function testGetGameInfo(){
        $games = new games();
        $game_name = "ghost-of-tsushima";

        $info = $games->get_game_info($game_name);

        $this->assertEquals(true, is_array($info));
        $this->assertEquals("Ghost of Tsushima", $info[0]->name);
        $this->assertEquals(5, $info[0]->avg_rating);
        $this->assertEquals(49, $info[0]->avg_score);
    }

    public function testGetCriticComments(){
        $games = new games();
        $game_name = "minecraft";

        $comments = $games->get_critic_comments($game_name);

        $this->assertEquals(true, is_array($comments));
    }

    public function testGetUserComments(){
        $games = new games();
        $game_name = "fifa-20";

        $comments = $games->get_user_comments($game_name);

        $this->assertEquals(true, is_array($comments));
    }

    public function testGetSystemRequirements(){
        $games = new games();
        $game_name = "grand-theft-auto-v";

        $sys_req = $games->get_system_req($game_name);

        $this->assertEquals(true, is_array($sys_req));
    }

    public function testUpdateAVGRating(){
        $games = new games();

        $ratings_updated = $games->update_avg_rating();

        $this->assertEquals(true, $ratings_updated);
    }

    public function testUpdateAVGScore(){
        $games = new games();

        $scores_updated = $games->update_avg_score();

        $this->assertEquals(true, $scores_updated);
    }

    public function testSubmitUserComment(){
        $user = new user();
        $games = new games();
        
        $_SESSION['game_name'] = "fifa-21";
        $_SESSION['fname'] = "Demo Account";
        $_SESSION['username'] = "demo";

        $POST = [
            'rating1' => 5,
            'comment' => "Test comment.",
        ];

        $_POST = [
            'rating1' => 5,
            'comment' => "Test comment.",
        ];

        $games->submit_user_comment($POST);

        $DB = new Database();
        $query = "SELECT * FROM user_comments WHERE game_name = 'fifa-21' AND username = 'demo' AND comment = 'Test comment.' LIMIT 1";
        $comment_exists = $DB->read($query);

        $this->assertEquals(true, is_array($comment_exists));
        $this->assertEquals(5, $comment_exists[0]->rating);
        $this->assertEquals("Test comment.", $comment_exists[0]->comment);
    }

    public function testSubmitCriticReview(){
        $games = new games();

        $_SESSION['game_name'] = "grand-theft-auto-san-andreas";
        
        $POST = [
            'game_name' => "grand-theft-auto-san-andreas",
            'critic' => "DemoCritic",
            'email' => "demo.critic@gmail.com",
            'score' => 30,
            'comment' => "Just a test review.",
            'link' => "www.demoreview.com",
        ];

        $_POST = [
            'game_name' => "grand-theft-auto-san-andreas",
            'critic' => "DemoCritic",
            'email' => "demo.critic@gmail.com",
            'score' => 30,
            'comment' => "Just a test review.",
            'link' => "www.demoreview.com",
        ];

        $games->submit_critic_review($POST);

        $DB = new Database();
        $query = "SELECT * FROM critic_comments WHERE game_name = 'grand-theft-auto-san-andreas' AND critic = 'DemoCritic' AND comment = 'Just a test review.' AND status = 'pending' LIMIT 1";
        $review_exists = $DB->read($query);

        $this->assertEquals(true, is_array($review_exists));
        $this->assertEquals("DemoCritic", $review_exists[0]->critic);
        $this->assertEquals("demo.critic@gmail.com", $review_exists[0]->email);
        $this->assertEquals(30, $review_exists[0]->score);
        $this->assertEquals("Just a test review.", $review_exists[0]->comment);
        $this->assertEquals("www.demoreview.com", $review_exists[0]->link);
    }
}