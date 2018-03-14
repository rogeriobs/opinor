<?php

namespace App\Traits;

trait Auth
{

    public function isLogged()
    {
        return $this->request->session()->check("Auth.Ipsum");

    }

    public function getUserData($assoc = '')
    {
        if($assoc){

            $Ipsum = $this->request->session()->read("Auth.Ipsum");

            if(isset($Ipsum[$assoc])){
                return $Ipsum[$assoc];
            }
        }
        
        return false;
    }

}