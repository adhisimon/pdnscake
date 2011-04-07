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
    }

    function edit($id) {
    }

    function view($id) {
        $this->Domain->id = $id;
        $this->set('id', $id);

        $domain = $this->Domain->read();
        $this->set('domain', $domain);

        $this->set('title_for_layout', $domain['Domain']['name']);
    }

    function delete($id) {
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
