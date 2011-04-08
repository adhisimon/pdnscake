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

    var $virtualFields = array(
        //non fqdn of Record.name
        'simple_name' => 'LEFT(Record.name, LENGTH(Record.name) - LENGTH(Domain.name) - 1)',
    );

    var $order = array(
        'Record.simple_name ASC',
    );

    function getSOA($domain_id, $return_array = false) {

        $conditions = array(
            'Record.domain_id' => $domain_id,
            'Record.type' => 'SOA',
        );

        $record = $this->find('first', array('conditions' => $conditions));
        $soa = $record['Record']['content'];

        if ($return_array) {

            list($primary_ns, $hostmaster, $serial) = split(" ", $soa, 3);
            $soa = array();

            if ($primary_ns) {
                $soa['primary_ns'] = $primary_ns;
            }

            if ($hostmaster) {
                $soa['hostmaster'] = $hostmaster;
            }

            if ($serial) {
                $soa['serial'] = $serial;
            }

            $soa['id'] = $record['Record']['id'];
        }

        return $soa;
    }

    function incrementSOA($domain_id = null) {
        $this->skipBeforeSave = true;

        if (!$domain_id) {
            $domain_id = $this->field('Record.domain_id', array('Record.id' => $this->id));
        }

        $soa_content = $this->getSOA($domain_id, true);
        $serial = $soa_content['serial'];
        $new_soa_content = $soa_content['primary_ns'] . ' ' . $soa_content['hostmaster'] . ' ' . ++$serial;

        $result = $this->updateAll(
            array(
                'Record.content' => "'$new_soa_content'",
            ),
            array(
                'Record.domain_id' => $domain_id,
                'Record.type' => 'SOA',
            )
        );
    }

    function beforeSave() {
        if (!isset($this->skipBeforeSave)) {
            //convert name to fqdn
            if (!isset($this->data['Record']['name'])) {

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
        }

        return true;
    }

    function afterSave($created) {
        if ($created and ($this->data['Record']['type'] != 'SOA')) {
            $this->incrementSOA($this->data['Record']['domain_id']);
        }
    }
}
