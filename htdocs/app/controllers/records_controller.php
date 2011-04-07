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

        $data = $this->paginate('Record');
        $this->set('data', $data);

    }

    function add($domain_id = null) {
        $this->set('title_for_layout', __('Add a record', true));

        $this->set('domain_id', $domain_id);
        $this->set('domains', $this->Record->Domain->find('list'));

        if (!empty($this->data)) {

            $domain_name = $this->Record->Domain->field('name', array('Domain.id' => $this->data['Record']['domain']));

            $this->data['Record']['name'] = trim($this->data['Record']['name']);

            if ($this->data['Record']['name']) {
                $this->data['Record']['name'] .= ".$domain_name";
            } else {
                $this->data['Record']['name'] = $domain_name;
            }

            $this->data['Record']['change_date'] = time();

            #debug($this->data); die;

            if ($this->Record->save($this->data)) {
                $this->Session->setFlash(__('Record has been saved', true));
                $this->redirect(array('action' => 'index'));
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
