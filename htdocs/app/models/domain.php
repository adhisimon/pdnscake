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
}
