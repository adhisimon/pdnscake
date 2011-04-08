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

    function getSOA($domain_id, $return_array = false) {

        $conditions = array(
            'domain_id' => $domain_id,
            'type' => 'SOA',
        );

        $record = $this->find('first', $conditions);
        $soa = $record['Record']['content'];

        if ($return_array) {

            list($primary_ns, $hostmaster, $serial) = split(" ", $soa, 3);
            $soa = array();

            if ($primary_ns) {
                $soa['primary_ns'] = $primary_ns;
            }

            if ($hostmaster) {
                $soa['hostmasteer'] = $hostmaster;
            }

            if ($serial) {
                $soa['serial'] = $serial;
            }

            $soa['id'] = $record['Record']['id'];
        }

        return $soa;
    }
}
