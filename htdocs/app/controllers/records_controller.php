<?php
/**
 * Implementation of RecordsController
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */

/**
 * Implementation of RecordsController
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */
class RecordsController extends AppController {
    var $scaffold;


    function index() {
        $this->set('title_for_layout', __('Available Records', true));

        $this->Record->virtualFields = array(
        //non fqdn of Record.name
            'simple_name' => 'LEFT(Record.name, LENGTH(Record.name) - LENGTH(Domain.name) - 1)',
        );

        $this->paginate['joins'] = array(
            array(
                'alias' => 'RecordTypeOrder',
                'table' => 'record_type_orders',
                'type' => 'LEFT',
                'conditions' => array(
                    'Record.type = RecordTypeOrder.name',
                ),
            )
        );

        $this->paginate['order'] = array(
            'Record.simple_name',
            'RecordTypeOrder.order DESC',
            'Record.type',
            'Record.prio',
            'Record.content',
        );

        $this->paginate['conditions'] = array();

        if (!$this->Auth->user('admin')) {
            $this->paginate['conditions']['Domain.user_id'] = $this->Auth->user('id');
        }

        if (!empty($this->params['named']['domain_id'])) {
            $this->paginate['conditions']['Record.domain_id'] = $this->params['named']['domain_id'];
        }

        $data = $this->paginate('Record');
        $this->set('data', $data);

    }

    function add() {
        $this->set('title_for_layout', __('Add a record', true));

        if (!empty($this->params['named']['domain_id'])) {
            $domain_id = $this->params['named']['domain_id'];
        } else {
            $domain_id = 0;
        }

        $this->set('domain_id', $domain_id);
        $this->set('domains', $this->Record->Domain->find('list'));

        if (!empty($this->data)) {

            $user_id = $this->Record->Domain->field('Domain.user_id', array('Domain.id' => $this->data['Record']['domain_id']));
            if (!$this->Auth->user('admin') and ($this->Auth->user('id') != $user_id)) {
                $this->redirect($this->referer());
            }

            $this->data['Record']['domain_name'] = $this->Record->Domain->field('name', array('Domain.id' => $this->data['Record']['domain']));
            $this->data['Record']['domain_id'] = $this->data['Record']['domain'];

            if ($this->Record->save($this->data)) {
                $this->Session->setFlash(__('Record has been saved', true));
                $this->redirect(array('action' => 'index', 'domain_id' => $this->data['Record']['domain_id']));
            } else {
                $this->Session->setFlash(__('Failed to save record', true));
            }
        }
    }

    /*
    function edit($id) {
    }

    function view($id) {
    }
    */

    function delete($id) {
        $record = $this->Record->read(null, $id);
        if (!$this->Auth->user('admin') and ($this->Auth->user('id') != $record['Domain']['user_id'])) {
            $this->flash($this->Auth->authError, $this->referer());
        }

        $this->Record->delete($id);
        $this->redirect($this->referer());
    }

}
