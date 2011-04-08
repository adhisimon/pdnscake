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
    <thead>
    <tr>
        <th><?php echo $this->Paginator->sort('No.', 'Domain.id'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Name', true), 'Domain.name'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Type', true), 'Domain.type'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Owner', true), 'User.username'); ?></th>
        <th colspan=2><?php echo $this->Paginator->sort(__('Created', true), 'Domain.created'); ?></th>
    </tr>
    </thead>

    <tbody>
    <?php $i = 0; foreach ($data as $domain): ?>

        <tr>
            <td><?php echo ++$i; ?>.</td>

            <td><?php

                echo $html->link(
                    $domain['Domain']['name'],
                    array(
                        'controller' => 'records',
                        'action' => 'index',
                        'domain_id' => $domain['Domain']['id']
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
            <td><?php echo $time->niceShort($domain['Domain']['created']); ?></td>
            <td class="actions"><?php
                echo $html->link(__('Delete', true),
                    array('action' => 'delete', $domain['Domain']['id']),
                    null,
                    sprintf(__("Are you sure want to delete domain name %s", true), $domain['Domain']['name'])
                );
            ?></td>
        </tr>

    <?php endforeach; ?>
        <tr>
            <td colspan="6" class="actions"><?php
                echo $html->link(__('Add Domain', true), array('action' => 'add'));
            ?></td>
        </tr>
    </tbody>
</table>
