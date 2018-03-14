<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Newsortopic Controller
 *
 * @property \App\Model\Table\NewsortopicTable $Newsortopic
 */
class NewsortopicController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Poll', 'Dominus']
        ];
        $newsortopic = $this->paginate($this->Newsortopic);

        $this->set(compact('newsortopic'));
        $this->set('_serialize', ['newsortopic']);
    }

    /**
     * View method
     *
     * @param string|null $id Newsortopic id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $newsortopic = $this->Newsortopic->get($id, [
            'contain' => ['Poll', 'Dominus', 'NewsortopicComments', 'NewsortopicImagens', 'NewsortopicTags']
        ]);

        $this->set('newsortopic', $newsortopic);
        $this->set('_serialize', ['newsortopic']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $newsortopic = $this->Newsortopic->newEntity();
        if ($this->request->is('post')) {
            $newsortopic = $this->Newsortopic->patchEntity($newsortopic, $this->request->getData());
            if ($this->Newsortopic->save($newsortopic)) {
                $this->Flash->success(__('The newsortopic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The newsortopic could not be saved. Please, try again.'));
        }
        $poll = $this->Newsortopic->Poll->find('list', ['limit' => 200]);
        $dominus = $this->Newsortopic->Dominus->find('list', ['limit' => 200]);
        $this->set(compact('newsortopic', 'poll', 'dominus'));
        $this->set('_serialize', ['newsortopic']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Newsortopic id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $newsortopic = $this->Newsortopic->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $newsortopic = $this->Newsortopic->patchEntity($newsortopic, $this->request->getData());
            if ($this->Newsortopic->save($newsortopic)) {
                $this->Flash->success(__('The newsortopic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The newsortopic could not be saved. Please, try again.'));
        }
        $poll = $this->Newsortopic->Poll->find('list', ['limit' => 200]);
        $dominus = $this->Newsortopic->Dominus->find('list', ['limit' => 200]);
        $this->set(compact('newsortopic', 'poll', 'dominus'));
        $this->set('_serialize', ['newsortopic']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Newsortopic id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $newsortopic = $this->Newsortopic->get($id);
        if ($this->Newsortopic->delete($newsortopic)) {
            $this->Flash->success(__('The newsortopic has been deleted.'));
        } else {
            $this->Flash->error(__('The newsortopic could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
