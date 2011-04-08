<?php
/**
 * view of /records/index
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */
?>
<h2><?php echo $title_for_layout; ?></h2>

<table>
    <tr>
        <th><?php echo $this->Paginator->sort('No.', 'Record.id'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Name', true), 'Record.simple_name'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Type', true), 'Record.type'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Value', true), 'Record.content'); ?></th>
        <th><?php echo $this->Paginator->sort(__('TTL', true), 'Record.ttl'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Priority', true), 'Record.prio'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Modified', true), 'Record.change_date'); ?></th>
    </tr>

    <?php $i = 0; foreach ($data as $record): ?>

        <tr>
            <td><?php echo ++$i; ?>.</td>

            <td><?php echo $record['Record']['name']; ?></td>
            <td><?php echo $record['Record']['type']; ?></td>
            <td><?php echo $record['Record']['content']; ?></td>
            <td><?php echo $record['Record']['ttl']; ?></td>
            <td><?php echo $record['Record']['prio']; ?></td>
            <td><?php echo $record['Record']['change_date']; ?></td>

        </tr>

    <?php endforeach; ?>
</table>

