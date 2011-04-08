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

        $data = $this->paginate('Domain');
        $this->set('data', $data);
    }

    function add() {

        if(!empty($this->data)) {
            // serial berdasarkan tanggal
            $serial = date('Ymd'). '00';
            $this->data['Domain']['notified_serial'] = $serial;

            // ++ karena index untuk type enum di mulai dari satu sedangkan array dari 0
            $this->data['Domain']['type']++;

            $this->Domain->save($this->data);
            $this->redirect(array('action' => 'index'));
        }
        $users = $this->Domain->User->find('list');

        /**
         * mengambil pilihan type domain dari information schema
         */
        $db = new DATABASE_CONFIG();
        $enum = $this->Domain->query(
            "SELECT COLUMN_TYPE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = '{$db->default['database']}'
            AND TABLE_NAME = 'domains'
            AND COLUMN_NAME = 'type'"
        );
        $types = $enum[0]['COLUMNS']['COLUMN_TYPE'];
    ;
        $this->set(compact('users', 'types'));
    }

    function view($id) {
        $this->Domain->id = $id;
        $this->set('id', $id);

        $domain = $this->Domain->read();
        $this->set('domain', $domain);

        $this->set('title_for_layout', $domain['Domain']['name']);
    }

    function delete($id = null) {
        if(!$id) {
            echo $this->Session->setFlash(__('Invalid Id', true));
            $this->redirect(array('action' => 'index'));
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
        $this->loadModel('Record');
        return $this->Record->getSOA($id, $return_array);
    }

    function getSerial($id) {
        $soa = $this->getSOA($id, true);

        return $soa['serial'];
    }



}
