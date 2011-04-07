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

    /*
    function add() {
    }

    function edit($id) {
    }

    function view($id) {
    }

    function delete($id) {
    }
    */

}
