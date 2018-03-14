<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NewsortopicImagens Controller
 *
 * @property \App\Model\Table\NewsortopicImagensTable $NewsortopicImagens
 */
class NewsortopicImagensController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Newsortopic']
        ];
        $newsortopicImagens = $this->paginate($this->NewsortopicImagens);

        $this->set(compact('newsortopicImagens'));
        $this->set('_serialize', ['newsortopicImagens']);
    }

    /**
     * View method
     *
     * @param string|null $id Newsortopic Imagen id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $newsortopicImagen = $this->NewsortopicImagens->get($id, [
            'contain' => ['Newsortopic']
        ]);

        $this->set('newsortopicImagen', $newsortopicImagen);
        $this->set('_serialize', ['newsortopicImagen']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $newsortopicImagen = $this->NewsortopicImagens->newEntity();
        if ($this->request->is('post')) {
            $newsortopicImagen = $this->NewsortopicImagens->patchEntity($newsortopicImagen, $this->request->getData());
            if ($this->NewsortopicImagens->save($newsortopicImagen)) {
                $this->Flash->success(__('The newsortopic imagen has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The newsortopic imagen could not be saved. Please, try again.'));
        }
        $newsortopic = $this->NewsortopicImagens->Newsortopic->find('list', ['limit' => 200]);
        $this->set(compact('newsortopicImagen', 'newsortopic'));
        $this->set('_serialize', ['newsortopicImagen']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Newsortopic Imagen id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $newsortopicImagen = $this->NewsortopicImagens->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $newsortopicImagen = $this->NewsortopicImagens->patchEntity($newsortopicImagen, $this->request->getData());
            if ($this->NewsortopicImagens->save($newsortopicImagen)) {
                $this->Flash->success(__('The newsortopic imagen has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The newsortopic imagen could not be saved. Please, try again.'));
        }
        $newsortopic = $this->NewsortopicImagens->Newsortopic->find('list', ['limit' => 200]);
        $this->set(compact('newsortopicImagen', 'newsortopic'));
        $this->set('_serialize', ['newsortopicImagen']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Newsortopic Imagen id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $newsortopicImagen = $this->NewsortopicImagens->get($id);
        if ($this->NewsortopicImagens->delete($newsortopicImagen)) {
            $this->Flash->success(__('The newsortopic imagen has been deleted.'));
        } else {
            $this->Flash->error(__('The newsortopic imagen could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
