<?php
/**
 * view of users/index
 */
?>
<h2><?php echo __('Users', true); ?></h2>

<table cellspacing="0">
    <thead>
        <th>No</th>
        <th><?php echo $paginator->sort(__('Username', true), 'User.username'); ?></th>
        <th><?php echo $paginator->sort(__('Fullname', true), 'User.fullname'); ?></th>
        <th><?php echo $paginator->sort(__('Admin', true), 'User.admin'); ?></th>
        <th><?php echo $paginator->sort(__('Active', true), 'User.active'); ?></th>

        <th><?php echo $paginator->sort(__('Created', true), 'User.created'); ?></th>
        <th><?php echo $paginator->sort(__('Modified', true), 'User.modified'); ?></th>
        <th>&nbsp;</th>

    </thead>
    <tbody>
    <?php
        $i = $paginator->counter(array('format' => '%start%'));
        foreach($users as $user) {
    ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td>
                <?php
                    echo $html->link($user['User']['username'], array('action' => 'view', $user['User']['id']));
                ?>
            </td>
            <td><?php echo $user['User']['fullname']; ?></td>
            <td><?php echo $user['User']['admin']; ?></td>
            <td><?php echo $user['User']['active']; ?></td>
            <td><?php echo $user['User']['created']; ?></td>
            <td><?php echo $user['User']['modified']; ?></td>
            <td class="actions">
                <?php
                    echo $html->link(__('Edit', true), array('action' => 'edit', $user['User']['id']));
                    echo $html->link(
                        __('delete', true),
                        array(
                            'action' => 'delete',
                            $user['User']['id']
                        ),
                        null,
                        sprintf(__("Are you sure you want to delete user #%s?", true), $user['User']['username'])
                    );
                ?>

            </td>
        </tr>
    <?php
        }
    ?>
    <tr>
        <td class="actions" colspan="10">
            <?php echo $html->link(__('Add User', true), array('action' => 'add')); ?>
        </td>
    </tr>

    </tbody>
</table>
<p>
<?php
    echo $this->Paginator->counter(array('format' => __('Page %page% of %pages% Pages', true)));
?>
</p>
<div class="paging">
    <?php echo $paginator->first('<< '. __('First', true)); ?>&nbsp;
    <?php echo $paginator->prev(__('Previous', true), null, null, array('class' => 'disable')); ?>
    <?php echo $paginator->numbers(); ?>
    <?php echo $paginator->next(__('Next', true), null, null, array('class' => 'disable')); ?>&nbsp;
    <?php echo $paginator->last(__('Last', true). ' >>'); ?>
</div>

