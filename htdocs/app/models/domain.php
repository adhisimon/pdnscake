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
            $this->createDefaultSOA($this->id);
        }
    }

    function createDefaultSOA($id = null) {
        if (!$id) {
            $id = $this->id;
        }

        $data['Record']['domain_id'] = $id;
        $data['Record']['name'] = $this->data['Domain']['name'];
        $data['Record']['type'] = 'SOA';
        $data['Record']['content'] =
            Configure::read('DefaultPrimaryNS')
            . ' '
            . 'hostmaster@' . $this->data['Domain']['name']
            . ' 0';
        $data['Record']['ttl'] = 86400;
        $data['Record']['change_date'] = time();
        $this->Record->save($data);
    }
}
