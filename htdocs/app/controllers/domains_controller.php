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
    }

    function delete($id) {
    }

}
