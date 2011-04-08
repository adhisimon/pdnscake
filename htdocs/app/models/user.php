<?php
/**
 * model untuk berhubungan dengan tabel user
 *
 * @package pdnscake
 * @version 1.0.0-20110408.100936
 * @since 1.0.0-20110408.100936
 * @author adi surya <adi@mondial.co.id>
 */

/**
 * model untuk berhubungan dengan tabel user
 *
 * @package pdnscake
 * @version 1.0.0-20110408.100936
 * @since 1.0.0-20110408.100936
 * @author adi surya <adi@mondial.co.id>
 */
class User extends AppModel {
    var $hasMany = array('Domain');
    var $displayField = 'fullname';
}
