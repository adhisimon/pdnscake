<?php
/**
 * app controller
 *
 * @package pdnscake
 * @version 1.0.0-20110408.111259
 * @since 1.0.0-20110408.111259
 * @author adi surya <adi@mondial.co.id>
 */

/**
 * app controller
 *
 * @package pdnscake
 * @version 1.0.0-20110408.111259
 * @since 1.0.0-20110408.111259
 * @author adi surya <adi@mondial.co.id>
 */
class AppController extends Controller {
    var $components = array('Auth', 'Session', 'RequestHandler');
    var $helpers = array('Html', 'Form', 'Session', 'Time');
    

    function beforeFilter() {
        $loggedIn = 0;

        $this->Auth->userScope = array('User.active' => 1);
        
        if($this->Auth->user('id')) {
            $loggedIn = 1;
        }
        $this->set(compact('loggedIn'));
    }
}
