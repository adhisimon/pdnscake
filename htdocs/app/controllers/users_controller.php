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
        if(!$this->Auth->user('admin') && $this->params['action'] != 'login' && $this->params['action'] != 'logout') {
            echo $this->Session->setFlash(__('You are not authorized to access that location.', true));
            $this->redirect(array('controller' => 'domains', 'action' => 'index'));
        }
        parent::beforeFilter();
    }

    function editPassword($id = null) {
        if ((!$this->Auth->user('admin')) and ($id != $this->Auth->User('id'))) {
            $this->Session->setFlash($this->authError);
            $this->redirect('/');
        }

        if (empty($this->data)) {

            if (!$id) {
                $this->redirect(array($this->Auth->User('id')));
            }

            $this->User->id = $id;
            $user = $this->User->read();
            $this->set('user', $user);

        } else {

            if ($this->data['User']['new_password'] != $this->data['User']['retype_new_password']) {
                $this->Session->setFlash(__("Password didn't match", true));
                $this->redirect($this->referer());
            }

            if ((!$this->Auth->user('admin')) and ($this->data['User']['id'] != $this->Auth->User('id'))) {
                $this->Session->setFlash($this->Auth->authError);
                $this->redirect($this->referer());
            }

            $this->data['User']['password'] = $this->Auth->password($this->data['User']['new_password']);

            if ($this->User->save($this->data)) {
                $this->Session->setFlash(__('Password has been changed', true));
            } else {
                $this->Session->setFlash(__('Error changing password', true));
            }
            $this->redirect(array('action' => 'view', $this->data['User']['id']));
        }

    }

}
