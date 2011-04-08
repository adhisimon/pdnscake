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

    function beforeSave() {
        //convert name to fqdn
        if (!$this->data['Record']['name']) {

            $this->data['Record']['simple_name'] = trim($this->data['Record']['simple_name']);

            if ($this->data['Record']['simple_name']) {
                $this->data['Record']['name'] = $this->data['Record']['simple_name'] . "." . $this->data['Record']['domain_name'];
            } else {
                $this->data['Record']['name'] = $this->data['Record']['domain_name'];
            }

        }

        //update change_date
        $this->data['Record']['change_date'] = time();

        //strip prio
        if ($this->data['Record']['type'] != 'MX') {
            unset($this->data['Record']['prio']);
        }

        return true;
    }
}
