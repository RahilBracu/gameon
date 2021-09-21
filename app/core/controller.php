<?php

Class Controller{
    protected function view($view, $data = []){
        if(file_exists("../app/views/".$view.".php")){
            include "../app/views/".$view.".php";
        }else{
            echo "Error 404: Page not found!";
        }
    }

    protected function model($model){
        if(file_exists("../app/models/".$model.".php")){
            include "../app/models/".$model.".php";
            return $model = new $model();
        }

        return false;
    }
}