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
    var $ajax = null;
    var $user_id = null;
    

    function beforeFilter() {
        $loggedIn = 0;
        
        if($this->Auth->user('id')) {
            $loggedIn = 1;
            $this->user_id = $this->Auth->user('id');
        }
        $this->ajax = $this->RequestHandler->isAjax();
        $this->set(compact('loggedIn'));
        $this->set('ajax', $this->ajax);
        $this->set('user_id', $this->user_id);
    }
}
