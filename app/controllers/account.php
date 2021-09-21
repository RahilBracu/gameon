<?php

Class Account extends Controller {
    function index($user_name = '', $tab = '') {
        $user = $this->model("user");

        if(!$user->check_logged_in()) {
            header("Location:".ROOT."signin");
            die;
        }

        if($_SESSION['user_id'] == 0) {
            header("Location:".ROOT."home");
            die;
        }

        if($tab == "account-info" || $tab == '') {
            $data['page_title'] = "My account";

            $this->view("gameon/info", $data);
        }

        elseif($tab == "edit-account") {
            if(isset($_POST['fname']) && isset($_POST['dob']) && isset($_POST['email'])) {
                $user->edit_profile($_POST);
            }

            $data['page_title'] = "Edit account";
            
            $this->view("gameon/edit", $data);
        }

        elseif($tab == "change-password") {
            if(isset($_POST['old_password']) && isset($_POST['new_password']) && $_POST['confirm_password']) {
                $user->change_password($_POST);
            }

            $data['page_title'] = "Change password";

            $this->view("gameon/password", $data);
        }

        elseif($tab == "delete-account") {
            if(isset($_POST['password'])) {
                $user->delete_account($_POST);
            }

            $data['page_title'] = "Delete account";

            $this->view("gameon/delete", $data);
        }
    }
}