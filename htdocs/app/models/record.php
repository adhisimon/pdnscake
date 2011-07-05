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

    function splitSOA($soa_content) {
        list($primary_ns, $hostmaster, $serial) = split(" ", $soa_content, 3);
        $soa = array();

        $soa['primary_ns'] = $primary_ns;
        $soa['hostmaster'] = $hostmaster;
        $soa['serial'] = $serial;

        return $soa;
    }

    function getSOA($domain_id, $return_array = false) {

        $conditions = array(
            'Record.domain_id' => $domain_id,
            'Record.type' => 'SOA',
        );

        $record = $this->find('first', array('conditions' => $conditions));
        $soa = $record['Record']['content'];

        if ($return_array) {
            $soa = $this->splitSOA($soa);
            $soa['id'] = $record['Record']['id'];
        }

        return $soa;
    }

    function incrementSerial($domain_id = null) {
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
                'Record.change_date' => time(),
                //'Domain.notified_serial' => $serial,
            ),
            array(
                'Record.domain_id' => $domain_id,
                'Record.type' => 'SOA',
            )
        );
    }

    function beforeValidate() {
        $this->createNameFromSimpleName();

        if ($this->data['Record']['type'] == 'CNAME') {

            $this->validate['simple_name'] = array(
                'rule' => 'noConflictFromCNAME',
                'message' => __('CNAME record can not be conflicted with other records', true),
            );

        } elseif ($this->data['Record']['type'] == 'A') {

            $this->validate['content'] = array(
                'rule' => array('ip', 'IPV4'),
                'message' => __('Please supply a valid IPv4 address', true),
            );

            $this->validate['simple_name'] = array(
                'rule' => 'noConflictWithCNAME',
                'message' => __('Record conflicted with CNAME', true),
            );
        } elseif ($this->data['Record']['type'] == 'AAAA') {

            $this->validate['content'] = array(
                'rule' => array('ip', 'IPV6'),
                'message' => __('Please supply a valid IPv6 address', true),
            );

            $this->validate['simple_name'] = array(
                'rule' => 'noConflictWithCNAME',
                'message' => __('Record conflicted with CNAME', true),
            );
        } elseif ($this->data['Record']['type'] == 'PTR') {
            $this->validate['simple_name'] = array(
                'valid' => array(
                    'rule' => 'validPTR',
                    'message' => __('PTR record must be numeric and not begin with 0', true),
                ),
            );
        } else {
            $this->validate['simple_name'] = array(
                'rule' => 'noConflictWithCNAME',
                'message' => __('Record conflicted with CNAME', true),
            );
        }

        return true;
    }

    function uniquePTR($check) {
        $conditions['Record.name'] = $this->data['Record']['name'];
        $conditions['Record.type'] = 'PTR';

        if (!empty($this->id)) {
            $conditions['Record.id <>'] = $this->id;
        }

        $count = $this->find('count', array('conditions' => $conditions));
        return !$count;
    }

    function validPTR($check) {
        $allowed_chars =
            !preg_match('/^0/', $this->data['Record']['simple_name'])
            and !preg_match("/[^0-9\.]/", $this->data['Record']['simple_name']);

        if ($allowed_chars) {
            return $this->uniquePTR($check);
        } else {
            return false;
        }
    }

    function noConflictFromCNAME($check) {
        $conditions['Record.name'] = $this->data['Record']['name'];

        if (!empty($this->id)) {
            $conditions['Record.id <>'] = $this->id;
        }

        $count = $this->find('count', array('conditions' => $conditions));
        return !$count;
    }

    function noConflictWithCNAME($check) {
        $conditions['Record.name'] = $this->data['Record']['name'];
        $conditions['Record.type'] = 'CNAME';

        if (!empty($this->id)) {
            $conditions['Record.id <>'] = $this->id;
        }

        $count = $this->find('count', array('conditions' => $conditions));
        return !$count;
    }

    function createNameFromSimpleName() {
        if (!isset($this->data['Record']['name'])) {

            $this->data['Record']['simple_name'] = trim($this->data['Record']['simple_name']);

            if ($this->data['Record']['simple_name']) {
                $this->data['Record']['name'] = $this->data['Record']['simple_name'] . "." . $this->data['Record']['domain_name'];
            } else {
                $this->data['Record']['name'] = $this->data['Record']['domain_name'];
            }
        }
    }

    function beforeSave() {
        if (!isset($this->skipBeforeSave)) {

            //convert name to fqdn
            $this->createNameFromSimpleName();

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
        if (!isset($this->skipAfterSave) and $this->data['Record']['type'] != 'SOA') {
            $this->incrementSerial($this->data['Record']['domain_id']);
        }

        if ($this->data['Record']['type'] == 'SOA') {
            $soa = $this->splitSOA($this->data['Record']['content']);
            $this->Domain->updateAll(
                /*
                array(
                    'Domain.notified_serial' => $soa['serial'],
                ),
                */
                array(
                    'Domain.id' => $this->data['Record']['domain_id']
                )
            );
        }
    }

    function beforeDelete($cascade) {
        $data = $this->read();

        if (!$data or $data['Record']['type'] == 'SOA') {
            return false;
        }

        $this->incrementSerial($data['Record']['domain_id']);
        return true;
    }
}
