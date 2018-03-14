<?php

namespace App\Traits;

trait AccessLog
{

    public function register_page_access($__cnx, $data)
    {
        if(!is_numeric($data['ipsum_id'])){
            return false;
        }

        $artigo_id = $data['newsortopic_id'];
        $ipsum_id  = $data['ipsum_id'];

        $AccessLogView = $this->request->session()->read("AccessLogView.{$ipsum_id}.{$artigo_id}");

        if($AccessLogView){
            return false;
        }

        $this->request->session()->write("AccessLogView.{$ipsum_id}.{$artigo_id}", true);

        $__cnx->insert('ipsum_activity_access_logs', [
            'ipsum_id'       => $data['ipsum_id'],
            'newsortopic_id' => $data['newsortopic_id'],
            'ip'             => $data['ip'],
            'created'        => date("Y-m-d H:i:s")
        ]);

    }

    public function register_search_term($__cnx, $termo)
    {
        if($this->isLogged()){
            $ipsum_id = $this->getUserData('id');
        }else{
            $ipsum_id = NULL;
        }

        $__cnx->insert('ipsum_activity_search_logs', [
            'ipsum_id' => $ipsum_id,
            'ip'       => getIP(),
            'termo'    => $termo,
            'created'  => date("Y-m-d H:i:s")
        ]);

    }

}
