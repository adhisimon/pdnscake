<?php
/**
 * view of /records/add
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */
?>
<h2><?php echo $title_for_layout; ?></h2>

<?php

echo $this->Form->create('Record');

echo $this->Form->input(
    'name',
    array(
        'style' => 'width: 30%',
        'div' => false,
    )
);

echo ".";

echo $this->Form->input(
    'domain',
    array(
        'div' => false,
        'label' => false,
        'default' => $domain_id,
    )
);

echo $this->Form->input(
    'type',
    array(
        'options' => array(
            'SOA' => __('SOA (Start of Authority)', true),
            'NS' => __('NS (Name Server)', true),
            'A' => __('A (IPv4 address)', true),
            'CNAME' => __('CNAME (Alias)', true),
            'MX' => __('MX (Mail Exchange)', true),
        )
    )
);

echo $this->Form->input('content', array('label' => __('Value', true)));

echo $this->Form->input(
    'ttl',
    array(
        'label' => __('TTL', true),
        'default' => 86400,
    )
);

echo $this->Form->input(
    'prio',
    array(
        'label' => __('Priority', true),
        'default' => 0,
    )
);

echo $this->Form->end(__('Save', true));

