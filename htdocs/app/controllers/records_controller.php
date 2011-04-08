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

    function add($domain_id = null) {
        $this->set('title_for_layout', __('Add a record', true));

        $this->set('domain_id', $domain_id);
        $this->set('domains', $this->Record->Domain->find('list'));

        if (!empty($this->data)) {

            $this->data['Record']['domain_name'] = $this->Record->Domain->field('name', array('Domain.id' => $this->data['Record']['domain']));
            #debug($this->data); die;

            if ($this->Record->save($this->data)) {
                $this->Session->setFlash(__('Record has been saved', true));
                $this->redirect(array('action' => 'index'));
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

    function delete($id) {
    }
    */

}
