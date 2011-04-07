<?php
/**
 * Implementation of Record model
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */

/**
 * Implementation of Record model
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */
class Record extends AppModel {
    var $belongsTo = array(
        'Domain'
    );
}
