<?php
/**
 * Implementation of Domain model
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */

/**
 * Implementation of Domain model
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */
class Domain extends AppModel {
    var $belongsTo = array(
        'User',
    );

    var $order = array(
        'Domain.name',
    );

    /**
     * get SOA of a domain
     *
     * @params int $domain_id id of requested domain
     * @return string SOA of requested domain
     */
    function getSOA($domain_id) {

    }
}
