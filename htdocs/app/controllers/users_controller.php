<?php
/**
 * kontroller user
 *
 * @package pdnscake
 * @version 1.0.0-20110408.112855
 * @since 1.0.0-20110408.112855
 * @author adi surya <adi@mondial.co.id>
 */

/**
 * kontroller user
 *
 * @package pdnscake
 * @version 1.0.0-20110408.112855
 * @since 1.0.0-20110408.112855
 * @author adi surya <adi@mondial.co.id>
 */
class UsersController extends AppController {
    var $helpers = array('Time');

    function login() {

    }

    function logout() {
        $this->redirect($this->Auth->logout());
    }

    function add() {
        if(!empty($this->data)) {
            $this->User->save($this->data);
            $this->Session->setFlash(__('User Saved', true));
            $this->redirect(array('action' => 'index'));
        }

    }

    function index() {
        $users = $this->paginate('User');
        $this->set(compact('users'));
    }

    function edit($id = null) {
        $user = $this->User->read(null, $id);
        if(empty($user)) {
            echo $this->Session->setFlash(__('Invalid Id', true));
            $this->redirect(array('action' => 'index'));
        }

        if(!empty($this->data)) {
            $this->User->save($this->data);
            echo $this->Session->setFlash(__('User Saved', true));
            $this->redirect(array('action' => 'index'));
        }

        $this->data = $user;

    }

    function delete($id = null) {
        if(!$id) {
            echo $this->Session->setFlash(__('Invalid Id', true));
            $this->redirect(array('action' => 'index'));
        }
        if($this->User->delete($id)) {
            echo $this->Session->setFlash(__('User Deleted', true));
            $this->redirect(array('action' => 'index'));
        } else {
            echo $this->Session->setFlash(__('Invalid Id', true));
            $this->redirect(array('action' => 'index'));
        }

        
    }

    function view($id = null) {
        $user = $this->User->read(null, $id);
        if(!$user) {
            echo $this->Session->setFlash(__('Invalid Id', true));
            $this->redirect(array('action' => 'index'));            
        }

        $this->set(compact('user'));
    }

    function beforeFilter() {
        parent::beforeFilter();
    }

}
