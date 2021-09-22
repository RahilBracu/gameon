<?php

Class Games {
    function search_games($search) {
        $DB = new Database();

        $_SESSION['error'] = "";

        if(isset($_POST['search'])) {
            $query = "SELECT * FROM games WHERE name LIKE '%$search%' ORDER BY name";
            $data = $DB->read($query);

            if(is_array($data)) {
                return $data;
            } else {
                $_SESSION['error'] = "No results found.";
                return false;
            }
        } else {
            $query = "SELECT * FROM games ORDER BY name";
            $data = $DB->read($query);

            if(is_array($data)) {
                return $data;
            } else {
                $_SESSION['error'] = "No games are available at the moment.";
                return false;
            }
        }
    }

    function search_criteria($query) {
        $DB = new Database();

        $_SESSION['error'] = "";

        $data = $DB->read($query);

        if(is_array($data)) {
            return $data;
        } else {
            $_SESSION['error'] = "No results found.";
            return false;
        }
    }

    function get_game_info($game_name) {
        $DB = new Database();
    
        $_SESSION['error'] = "";
        $_SESSION['game_name'] = $game_name;
    
        if(isset($game_name)) {
            $array['game_name'] = $game_name;
    
            $query = "SELECT * FROM games WHERE game_name = :game_name LIMIT 1";
            
            $data = $DB->read($query, $array);
    
            if(is_array($data)) {
                return $data;
            }
        }
    
        return false;
    }

    function get_critic_comments($game_name) {
        $DB = new Database();
    
        $_SESSION['error'] = "";
    
        if(isset($game_name)) {
            $array['game_name'] = $game_name;
    
            $query = "SELECT * FROM critic_comments WHERE game_name = :game_name AND status = 'accepted'";
            
            $data = $DB->read($query, $array);
    
            if(is_array($data)) {
                return $data;
            } else {
                $_SESSION['error'] = "No reviews available.";
                return false;
            }
        }
    
        return false;
    }

    function get_user_comments($game_name) {
        $DB = new Database();
    
        $_SESSION['error'] = "";
    
        if(isset($game_name)) {
            $array['game_name'] = $game_name;
    
            $query = "SELECT * FROM user_comments WHERE game_name = :game_name";
            
            $data = $DB->read($query, $array);
    
            if(is_array($data)) {
                return $data;
            } else {
                $_SESSION['error'] = "No comments found.";
                return false;
            }
        }
    
        return false;
    }

    function submit_user_comment($POST) {
        $DB = new Database();
        
        $_SESSION['error'] = "";
        
        if(isset($_POST['rating1']) && isset($_POST['comment'])) {
            $array['game_name'] = $_SESSION['game_name'];
            $array['name'] = $_SESSION['fname'];
            $array['username'] = $_SESSION['username'];
            $array['rating'] = $POST['rating1'];
            $array['comment'] = $POST['comment'];
            
            $query = "INSERT INTO user_comments (game_name, name, username, rating, comment) VALUES (:game_name, :name, :username, :rating, :comment)";
            
            $data = $DB->write($query, $array);
            
            if($data) {
                header("Location:".ROOT."game/".$_SESSION['game_name']."/user-reviews");
            }
        } else {
            $_SESSION['error'] = "Please enter valid information.";
        }
    }

    function get_system_req($game_name) {
        $DB = new Database();
    
        $_SESSION['error'] = "";
    
        if(isset($game_name)) {
            $array['game_name'] = $game_name;
    
            $query = "SELECT * FROM system_req WHERE game_name = :game_name";
            
            $data = $DB->read($query, $array);
    
            if(is_array($data)) {
                return $data;
            } else {
                $_SESSION['error'] = "The game is not available on PC.";
                return false;
            }
        }
    
        return false;
    }

    function update_avg_rating() {
        $data = $this->search_games('');

        $DB = new Database();
        
        $_SESSION['error'] = "";

        foreach($data as $data) {
            $arr['game_name'] = $data->game_name;
            $query = "SELECT rating FROM user_comments WHERE game_name = :game_name AND rating > 0";
            
            $ratings = $DB->read($query, $arr);
            
            $rating_sum = 0;
            $avg = 0;
            $avg_per = 0;

            if(is_array($ratings)) {
                foreach($ratings as $row) {
                    $rating_sum = $rating_sum + $row->rating;
                }
                
                $avg = $rating_sum / count($ratings);
                $avg_per = $avg * 20;
            }
            
            $a['game_name'] = $data->game_name;
            $query = "UPDATE games SET avg_rating = $avg, avg_rating_per = $avg_per WHERE game_name = :game_name";
            
            return $DB->write($query, $a);
        }
    }

    function update_avg_score() {
        $data = $this->search_games('');

        $DB = new Database();
        
        $_SESSION['error'] = "";

        foreach($data as $data) {
            $arr['game_name'] = $data->game_name;
            $query = "SELECT score FROM critic_comments WHERE game_name = :game_name AND status = 'accepted'";
            
            $scores = $DB->read($query, $arr);
            
            $score_sum = 0;
            $avg = 0;

            if(is_array($scores)) {
                foreach($scores as $row) {
                    $score_sum = $score_sum + $row->score;
                }

                $avg = $score_sum / count($scores);
            }
            
            $a['game_name'] = $data->game_name;
            $query = "UPDATE games SET avg_score = $avg WHERE game_name = :game_name";
            
            return $DB->write($query, $a);
        }
    }

    function submit_critic_review($info) {
        $DB = new Database();
        
        $_SESSION['error'] = "";
        
        if(isset($_POST['critic']) && isset($_POST['critic']) && isset($_POST['email']) && isset($_POST['score']) && isset($_POST['comment']) && isset($_POST['link'])) {
            $array['game_name'] = $info['game_name'];
            $array['critic'] = $info['critic'];
            $array['email'] = $info['email'];
            $array['score'] = $info['score'];
            $array['comment'] = $info['comment'];
            $array['link'] = $info['link'];
            $array['status'] = 'pending';
            
            $query = "INSERT INTO critic_comments (game_name, critic, email, score, comment, link, status) VALUES (:game_name, :critic, :email, :score, :comment, :link, :status)";
            
            $data = $DB->write($query, $array);
            
            if($data) {
                header("Location:".ROOT."criticsubmission/".$_SESSION['game_name']."/pending");
            }
        } else {
            $_SESSION['error'] = "Please enter valid information.";
        }
    }

    function load_requests() {
        $DB = new Database();

        $_SESSION['error'] = "";

        $query = "SELECT * FROM critic_comments WHERE status = 'pending'";
        $data = $DB->read($query);

        if(is_array($data)) {
            return $data;
        } else {
            $_SESSION['error'] = "No pending requests.";
            return false;
        }
    }

    function approval($info) {
        $DB = new Database();
        
        $_SESSION['error'] = "";

        $array['comment_id'] = $info['comment_id'];
        $array['decision'] = $info['decision']."ed";

        $query = "UPDATE critic_comments SET status = :decision WHERE comment_id = :comment_id";
            
        $data = $DB->write($query, $array);

        if($data) {
            header("Location:".ROOT."criticrequest");
        }
    }

    function add_game($POST) {
        $DB = new Database();
        
        $_SESSION['error'] = "";
        
        if(isset($_POST['game_name']) && isset($_POST['name']) && isset($_POST['thumbnail']) && isset($_POST['cover']) && isset($_POST['about']) && isset($_POST['platform']) && isset($_POST['genre']) && isset($_POST['release_date'])) {
            $array['game_name'] = $POST['game_name'];
            $array['name'] = $POST['name'];
            $array['thumbnail'] = $POST['thumbnail'];
            $array['avg_rating'] = 0;
            $array['avg_rating_per'] = 0;
            $array['avg_score'] = 0;
            $array['cover'] = $POST['cover'];
            $array['about'] = $POST['about'];
            $array['platform'] = $POST['platform'];
            $array['genre'] = $POST['genre'];
            $array['release_date'] = $POST['release_date'];
            
            $query = "INSERT INTO games (game_name, name, thumbnail, avg_rating, avg_rating_per, avg_score, cover, about, platform, genre, release_date) VALUES (:game_name, :name, :thumbnail, :avg_rating, :avg_rating_per, :avg_score, :cover, :about, :platform, :genre, :release_date)";
            
            $data = $DB->write($query, $array);

            if(!empty($_POST['p1_m']) && !empty($_POST['p2_m']) && !empty($_POST['g1_m']) && !empty($_POST['g2_m']) && !empty($_POST['vr_m']) && !empty($_POST['v_m']) && !empty($_POST['os_m']) && !empty($_POST['dx_m']) && !empty($_POST['hdd_m']) && !empty($_POST['p1_r']) && !empty($_POST['p2_r']) && !empty($_POST['g1_r']) && !empty($_POST['g2_r']) && !empty($_POST['vr_r']) && !empty($_POST['v_r']) && !empty($_POST['os_r']) && !empty($_POST['dx_r']) && !empty($_POST['hdd_r'])) {
                $arr['game_name'] = $POST['game_name'];
                $arr['p1_m'] = $POST['p1_m'];
                $arr['p2_m'] = $POST['p2_m'];
                $arr['g1_m'] = $POST['g1_m'];
                $arr['g2_m'] = $POST['g2_m'];
                $arr['vr_m'] = $POST['vr_m'];
                $arr['v_m'] = $POST['v_m'];
                $arr['os_m'] = $POST['os_m'];
                $arr['dx_m'] = $POST['dx_m'];
                $arr['hdd_m'] = $POST['hdd_m'];

                $arr['p1_r'] = $POST['p1_r'];
                $arr['p2_r'] = $POST['p2_r'];
                $arr['g1_r'] = $POST['g1_r'];
                $arr['g2_r'] = $POST['g2_r'];
                $arr['vr_r'] = $POST['vr_r'];
                $arr['v_r'] = $POST['v_r'];
                $arr['os_r'] = $POST['os_r'];
                $arr['dx_r'] = $POST['dx_r'];
                $arr['hdd_r'] = $POST['hdd_r'];
                
                $query = "INSERT INTO system_req (game_name, p1_m, p2_m, g1_m, g2_m, vr_m, v_m, os_m, dx_m, hdd_m, p1_r, p2_r, g1_r, g2_r, vr_r, v_r, os_r, dx_r, hdd_r) VALUES (:game_name, :p1_m, :p2_m, :g1_m, :g2_m, :vr_m, :v_m, :os_m, :dx_m, :hdd_m, :p1_r, :p2_r, :g1_r, :g2_r, :vr_r, :v_r, :os_r, :dx_r, :hdd_r)";
                
                $DB->write($query, $arr);
            }
            
            if($data) {
                header("Location:".ROOT."search");
            } else {
                $_SESSION['error'] = "Something went wrong.";
            }
        } else {
            $_SESSION['error'] = "Enter valid information.";
        }
    }

    function modify_game($POST) {
        $DB = new Database();

        $_SESSION['error'] = "";

        if(isset($_POST['game_name']) && isset($_POST['name']) && isset($_POST['thumbnail']) && isset($_POST['cover']) && isset($_POST['about']) && isset($_POST['platform']) && isset($_POST['genre']) && isset($_POST['release_date'])) {
            $array['game_name'] = $POST['game_name'];
            $array['name'] = $POST['name'];
            $array['thumbnail'] = $POST['thumbnail'];
            $array['avg_rating'] = 0;
            $array['avg_rating_per'] = 0;
            $array['avg_score'] = 0;
            $array['cover'] = $POST['cover'];
            $array['about'] = $POST['about'];
            $array['platform'] = $POST['platform'];
            $array['genre'] = $POST['genre'];
            $array['release_date'] = $POST['release_date'];

            $query = "UPDATE games SET game_name =:game_name, name =:name, thumbnail =:thumbnail, avg_rating =:avg_rating, avg_rating_per =:avg_rating_per, avg_score =:avg_score, cover =:cover, about =:about, platform =:platform, genre =:genre, release_date =:release_date WHERE game_name = :game_name LIMIT 1";
            
            $data = $DB->write($query, $array);

            if(!empty($_POST['p1_m']) && !empty($_POST['p2_m']) && !empty($_POST['g1_m']) && !empty($_POST['g2_m']) && !empty($_POST['vr_m']) && !empty($_POST['v_m']) && !empty($_POST['os_m']) && !empty($_POST['dx_m']) && !empty($_POST['hdd_m']) && !empty($_POST['p1_r']) && !empty($_POST['p2_r']) && !empty($_POST['g1_r']) && !empty($_POST['g2_r']) && !empty($_POST['vr_r']) && !empty($_POST['v_r']) && !empty($_POST['os_r']) && !empty($_POST['dx_r']) && !empty($_POST['hdd_r'])) {
                $arr['game_name'] = $POST['game_name'];
                $arr['p1_m'] = $POST['p1_m'];
                $arr['p2_m'] = $POST['p2_m'];
                $arr['g1_m'] = $POST['g1_m'];
                $arr['g2_m'] = $POST['g2_m'];
                $arr['vr_m'] = $POST['vr_m'];
                $arr['v_m'] = $POST['v_m'];
                $arr['os_m'] = $POST['os_m'];
                $arr['dx_m'] = $POST['dx_m'];
                $arr['hdd_m'] = $POST['hdd_m'];

                $arr['p1_r'] = $POST['p1_r'];
                $arr['p2_r'] = $POST['p2_r'];
                $arr['g1_r'] = $POST['g1_r'];
                $arr['g2_r'] = $POST['g2_r'];
                $arr['vr_r'] = $POST['vr_r'];
                $arr['v_r'] = $POST['v_r'];
                $arr['os_r'] = $POST['os_r'];
                $arr['dx_r'] = $POST['dx_r'];
                $arr['hdd_r'] = $POST['hdd_r'];

                $query = "UPDATE system_req SET p1_m =:p1_m, p2_m =:p2_m, g1_m =:g1_m, g2_m =:g2_m, vr_m =:vr_m, v_m =:v_m, os_m =:os_m, dx_m =:dx_m, hdd_m =:hdd_m, p1_r =:p1_r, p2_r =:p2_r, g1_r =:g1_r, g2_r =:g2_r, vr_r =:vr_r, v_r =:v_r, os_r =:os_r, dx_r =:dx_r, hdd_r =:hdd_r WHERE game_name = :game_name LIMIT 1";
                
                $sys_req = $DB->write($query, $arr);

                if(!is_array($sys_req)) {
                    $query = "INSERT INTO system_req (game_name, p1_m, p2_m, g1_m, g2_m, vr_m, v_m, os_m, dx_m, hdd_m, p1_r, p2_r, g1_r, g2_r, vr_r, v_r, os_r, dx_r, hdd_r) VALUES (:game_name, :p1_m, :p2_m, :g1_m, :g2_m, :vr_m, :v_m, :os_m, :dx_m, :hdd_m, :p1_r, :p2_r, :g1_r, :g2_r, :vr_r, :v_r, :os_r, :dx_r, :hdd_r)";
                
                    $DB->write($query, $arr);
                }
            } else {
                $arr['game_name'] = $POST['game_name'];
                
                $query = "DELETE FROM system_req WHERE game_name = :game_name";
                $DB->write($query, $arr);
            }
            
            if($data) {
                header("Location:".ROOT."game/".$game_name."/summary");
            } else {
                $_SESSION['error'] = "Something went wrong.";
            }
        } else {
            $_SESSION['error'] = "Enter valid information.";
        }
    }

    function delete_game($game_name) {
        $DB = new Database();

        $_SESSION['error'] = "";

        if(isset($game_name)) {
            $array['game_name'] = $game_name;
            
            $query = "DELETE FROM games WHERE game_name = :game_name LIMIT 1";
            $data = $DB->write($query, $array);

            $query = "DELETE FROM system_req WHERE game_name = :game_name LIMIT 1";
            $DB->write($query, $array);
                
            if($data) {
                header("Location:".ROOT."search");
            }
        }
    }
}