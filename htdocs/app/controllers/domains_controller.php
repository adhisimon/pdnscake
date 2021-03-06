<?php
/**
 * Implementation of DomainsController
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */

/**
 * Implementation of DomainsController
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */
class DomainsController extends AppController {

    function index() {
        $this->set('title_for_layout', __('Available Domains', true));

        if (!$this->Auth->user('admin')) {
            $this->paginate['conditions']['Domain.user_id'] = $this->Auth->user('id');
        }

        $data = $this->paginate('Domain');
        $this->set('data', $data);
    }

    function add() {

        if(!empty($this->data)) {
            if(!$this->Auth->user('admin')) {
                $this->data['Domain']['user_id'] = $this->Auth->user('id');
            }

            if ($this->Domain->save($this->data)) {

                $this->Session->setFlash(__('Domain created', true));
                $this->redirect(array(
                    'controller' => 'records', 'action' => 'index', 'domain_id' => $this->Domain->id
                ));

            } else {

                $this->Session->setFlash(__('Failed to create a new domain', true));
                $this->redirect(array('action' => 'index'));

            }
        }
        if($this->Auth->user('admin')) {
            $users = $this->Domain->User->find('list');
        }

        /**
         * mengambil pilihan type domain dari information schema
         */
        /*
        $db = new DATABASE_CONFIG();
        $enum = $this->Domain->query(
            "SELECT COLUMN_TYPE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = '{$db->default['database']}'
            AND TABLE_NAME = 'domains'
            AND COLUMN_NAME = 'type'"
        );
        $types = $enum[0]['COLUMNS']['COLUMN_TYPE'];
        $types = preg_replace('/^enum\(|\)$|\'/', '', $types);
        $types = explode(',', $types);
        */

        $types = array('MASTER' => 'MASTER', 'SLAVE' => 'SLAVE');
    ;
        $this->set(compact('users', 'types'));
    }

    function view($id) {
        $this->Domain->id = $id;
        $this->set('id', $id);

        unset($this->Domain->hasMany['Record']);
        $domain = $this->Domain->read();
        $this->set('domain', $domain);

        $this->set('title_for_layout', $domain['Domain']['name']);
    }

    function delete($id) {
        if (!$this->Auth->user('admin')) {
            $owner_id = $this->Domain->field('Domain.user_id', array('Domain.id' => $id));
            if ($this->Auth->user('id') != $owner_id) {
                $this->Session->setFlash($this->Auth->authError);
                $this->redirect($this->referer());
            }
        }

        if($this->Domain->delete($id)) {
            echo $this->Session->setFlash(__('Domain Deleted', true));
            $this->redirect(array('action' => 'index'));
        } else {
            echo $this->Session->setFlash(__('Invalid Id', true));
            $this->redirect(array('action' => 'index'));
        }
    }

    function getSOA($id, $return_array = false) {
        return $this->Domain->Record->getSOA($id, $return_array);
    }

    function getSerial($id) {
        $soa = $this->getSOA($id, true);

        return $soa['serial'];
    }

    function getLastModified($id) {
        $conditions = array(
            'Record.domain_id' => $id
        );

        $last_modified = $this->Domain->Record->field(
            'Record.change_date',
            $conditions,
            'Record.change_date DESC'
        );
        return $last_modified;
    }

    function editMaster($id) {
        $this->Domain->id = $id;
        $domain = $this->Domain->read();
        $this->set('domain', $domain);

        # check authorization
        if (!$this->Auth->User('admin') and ($domain['Domain']['user_id'] != $this->Auth->User('id'))) {
            $this->Session->setFlash($this->Auth->authError);
            $this->redirect('/');
        }

        # there's a data
        if (!empty($this->data)) {

            # check authorization
            if (!$this->Auth->User('admin') and ($this->data['Domain']['id'] != $id)) {
                $this->Session->setFlash($this->Auth->authError);
                $this->redirect('/');
            }

            # try to save
            if ($this->Domain->save($this->data)) {
                $this->Session->setFlash(sprintf(__('Master for %s has been saved', true), $domain_name));
            } else {
                $this->Session->setFlash(sprintf(__('Failed to save master for %s', true), $domain_name));
            }

            # redirect
            $this->redirect(array(
                'controller' => 'records', 'action' => 'index', 'domain_id' => $this->data['Domain']['id']
            ));
        }
    }
}
