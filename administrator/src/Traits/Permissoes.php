<?php

namespace App\Traits;

Trait Permissoes
{

    public function isPermitted($dcmsFerramentaId, $perm)
    {
        if($this->isUserRoot()) {
            return true;
        }
        
        $grupos = $this->request->session()->read("Auth.User.grupos");
        
        foreach($grupos as $grupo):

            $permissao = json_decode($grupo['permissoes'], true);
                    
            foreach($permissao as $menuId => $controllers):
                
                if(isset($controllers['controller'][$dcmsFerramentaId]['actions'][$perm])){

                    return true;
                }
                                
            endforeach;
            
        endforeach;
        
        return false;
    }

    public function allowAction($permissao_id, $perm){
        
        if(!$this->isPermitted($permissao_id, $perm)){
                        
            throw new \Cake\Network\Exception\ForbiddenException(__("Permissão Negada"));

            return false;
            
        }
        
    }
    
    public function isUserRoot()
    {
        
        if($this->request->session()->check("Auth.User.regra")) {

            return $this->request->session()->read("Auth.User.regra") === "root";
        }

        return false;
    }

    public function isUserMaster()
    {

        //var_dump($this->request->session()->read("Auth.User.regra"));
        
        if($this->request->session()->check("Auth.User.regra")) {
            return $this->request->session()->read("Auth.User.regra") === "master";
        }

        return false;
    }

}