<?php
/**
 * view of /domains/index
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */
?>
<h2><?php echo $title_for_layout; ?></h2>

<table>
    <tr>
        <th><?php echo $this->Paginator->sort('No.', 'Domain.id'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Name', true), 'Domain.name'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Type', true), 'Domain.type'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Owner', true), 'User.username'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Created', true), 'Domain.created'); ?></th>
    </tr>

    <?php $i = 0; foreach ($data as $domain): ?>

        <tr>
            <td><?php echo ++$i; ?>.</td>

            <td><?php

                echo $html->link(
                    $domain['Domain']['name'],
                    array(
                        'action' => 'view',
                        $domain['Domain']['id']
                    )
                );

            ?></td>

            <td><?php echo $domain['Domain']['type']; ?></td>

            <td><?php

                echo $html->link(
                    $domain['User']['username'],
                    array(
                        'controller' => 'users',
                        'action' => 'view',
                        $domain['User']['id']
                    )
                );

            ?></td>
            <td><?php echo $domain['Domain']['created']; ?></td>
        </tr>

    <?php endforeach; ?>
</table>
