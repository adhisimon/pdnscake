<?php
/**
 * kontroller user
 *
 * @package pdnscake
 * @version 1.0.0-20110408.112855
 * @since 1.0.0-20110408.112855
 * @author adi surya <adi@mondial.co.id>
 */

/**
 * kontroller user
 *
 * @package pdnscake
 * @version 1.0.0-20110408.112855
 * @since 1.0.0-20110408.112855
 * @author adi surya <adi@mondial.co.id>
 */
class UsersController extends AppController {

    function login() {

    }

    function logout() {
        $this->redirect($this->Auth->logout());
    }

}
