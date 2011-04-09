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

    var $hasMany = array(
        'Record' => array(
            'className' => 'Record',
            'dependent' => true,
            'exclusive' => true,
        )
    );

    var $order = array(
        'Domain.name',
    );

    function afterSave($created) {
        if ($created and ($this->data['Domain']['type'] != 'SLAVE')) {
            $this->createDefaultRecords($this->id);
        }
    }

    function createDefaultRecords($id = null) {
        if (!$id) {
            $id = $this->id;
        }

        $records = Configure::read('InitialRecords');
        foreach ($records as $record) {
            $data['Record'] = $record;

            $data['Record']['domain_id'] = $id;

            $data['Record']['name'] = str_replace('__DOMAINNAME__', $this->data['Domain']['name'], $data['Record']['name']);
            $data['Record']['content'] = str_replace('__DOMAINNAME__', $this->data['Domain']['name'], $data['Record']['content']);

            if (empty($data['Record']['ttl'])) {
                $data['Record']['ttl'] = Configure::read('DefaultTTL');
            }

            $data['Record']['change_date'] = time();

            $this->Record->create();
            $this->Record->skipAfterSave = true;
            $this->Record->save($data);
        }
    }
}
