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

if (!empty($this->data)) {
    $after_simple_name =
        '.'
        . $html->link(
            $this->data['Record']['domain_name'],
            array(
                'action' => 'index',
                'domain_id' => $this->data['Record']['domain_id']
            )
        );
} else {
    $after_simple_name = '';
}

echo $this->Form->create('Record');
echo $this->Form->input(
    'simple_name',
    array(
        'style' => 'width: 30%',
        'div' => false,
        'after' => $after_simple_name,
    )
);

echo ".";

if (empty($this->data)) {
    echo $this->Form->input(
        'domain_id',
        array(
            'div' => false,
            'label' => false,
            'default' => $domain_id,
            'options' => $domains,
        )
    );
} else {
    echo $this->Form->hidden('domain_id');
}

echo $this->Form->input(
    'type',
    array(
        'options' => Configure::read('AvailableRecordTypes')
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

