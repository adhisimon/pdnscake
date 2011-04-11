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

echo $this->Form->input(
    'simple_name',
    array(
        'style' => 'width: 30%',
        'div' => false,
    )
);

echo "." . $this->data['Record']['domain_name'];
echo $this->Form->hidden('domain_id');

echo $this->Form->input(
    'type',
    array(
        'options' => array(
            'NS' => __('NS (Name Server)', true),
            'A' => __('A (IPv4 address)', true),
            'AAAA' => __('AAAA (IPv6 address)', true),
            'CNAME' => __('CNAME (Alias)', true),
            'MX' => __('MX (Mail Exchange)', true),
            'TXT' => __('TXT (Textual Data)', true),
        )
    )
);

echo $this->Form->input('content', array('label' => __('Value', true)));

echo $this->Form->input(
    'ttl',
    array(
        'label' => __('TTL', true),
        'default' => Configure::read('DefaultTTL'),
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

