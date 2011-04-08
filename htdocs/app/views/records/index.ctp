<?php
/**
 * view of /records/index
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */
?>
<h2><?php echo $title_for_layout; ?></h2>

<?php
    if (!empty($this->params['named']['domain_id'])) {
        echo $this->requestAction("/domains/view/" . $this->params['named']['domain_id'], array('return'));
    }
?>

<table>
    <thead>
    <tr>
        <th><?php echo $this->Paginator->sort('No.', 'Record.id'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Name', true), 'Record.simple_name'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Type', true), 'Record.type'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Value', true), 'Record.content'); ?></th>
        <th><?php echo $this->Paginator->sort(__('TTL', true), 'Record.ttl'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Priority', true), 'Record.prio'); ?></th>
        <th colspan=2><?php echo $this->Paginator->sort(__('Modified', true), 'Record.change_date'); ?></th>
    </tr>
    </thead>

    <tbody>
    <?php $i = 0; foreach ($data as $record): ?>

        <tr>
            <td><?php echo ++$i; ?>.</td>

            <td><?php echo $record['Record']['name']; ?></td>
            <td><?php echo $record['Record']['type']; ?></td>
            <td><?php echo $record['Record']['content']; ?></td>
            <td><?php echo $record['Record']['ttl']; ?></td>
            <td><?php echo $record['Record']['prio']; ?></td>
            <td><?php echo $record['Record']['change_date']; ?></td>

            <td class="actions">

                <?php
                    echo $html->link(__('Delete', true), array('action' => 'delete', $record['Record']['id']), null, __('Are you sure you want to delete this record?', true));
                ?>

            </td>

        </tr>

    <?php endforeach; ?>

        <tr>
            <td colspan=8 class="actions">

                <?php
                    $addUrl = array('action' => 'add');
                    if (!empty($this->params['named']['domain_id'])) {
                        $addUrl += array('domain_id' => $this->params['named']['domain_id']);
                    }
                    echo $html->link(__('Add a record', true), $addUrl);
                ?>

            </td>
        </tr>

    </tbody>
</table>
