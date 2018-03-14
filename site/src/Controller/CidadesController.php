<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Cidades Controller
 *
 * @property \App\Model\Table\CidadesTable $Cidades
 */
class CidadesController extends AppController
{

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['getCidades']);
    }

    public function getCidades()
    {

        if($this->request->is("post")) {

            $estado_id = $this->request->data['estado_id'];

            $cidades = $this->Cidades->find("all", [
                        "conditions" => [
                            "Cidades.estado_id" => $estado_id
                        ],
                        "order" => [
                            "Cidades.nome" => "ASC"
                        ]
                    ])->toArray();


            $this->set("cidades", $cidades);
        }
    }

}
