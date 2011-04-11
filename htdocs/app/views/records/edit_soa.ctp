<?php
/**
 * view of /records/edit
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */
?>
<h2><?php echo $title_for_layout; ?></h2>

<?php

echo $this->Form->create('Record');

echo $this->Form->hidden('simple_name');
echo $this->Form->hidden('domain_name');
echo $this->Form->hidden('domain_id');
echo $this->Form->hidden('type');

echo $this->Form->input('soa_primary_ns', array('label' => __('Primary NS', true), 'default' => $soa_content['primary_ns']));
echo $this->Form->input('soa_hostmaster', array('label' => __('Hostmaster', true), 'default' => $soa_content['hostmaster']));
echo $this->Form->input('soa_serial', array('label' => __('Serial', true), 'default' => $soa_content['serial']));

echo $this->Form->input(
    'ttl',
    array(
        'label' => __('TTL', true),
        'default' => Configure::read('DefaultTTL'),
    )
);

echo $this->Form->end(__('Save', true));

