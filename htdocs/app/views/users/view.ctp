<?php
/**
 * view of .....
 */
?>
<h2><?php echo __('User', true); ?></h2>
<table cellspacing="0">
    <tr>
        <td><?php echo __('Username', true); ?></td>
        <td width="10">:</td>
        <td width="100%"><?php echo $user['User']['username']; ?></td>

    </tr>
    <tr>
        <td><?php echo __('Fullname', true); ?></td>
        <td width="10">:</td>
        <td width="100%"><?php echo $user['User']['fullname']; ?></td>

    </tr>
    <tr>
        <td><?php echo __('Admin', true); ?></td>
        <td width="10">:</td>
        <td width="100%"><?php
            if($user['User']['admin']) {
                echo __('Admin', true);
            } else {
                echo __('Not Admin', true);
            }
        ?></td>

    </tr>
    <tr>
        <td><?php echo __('Active', true); ?></td>
        <td width="10">:</td>
        <td width="100%"><?php
            if($user['User']['active']) {
                echo __('Active', true);
            } else {
                echo __('Not Active', true);
            }
        ?></td>

    </tr>
    <tr>
        <td><?php echo __('Created', true); ?></td>
        <td width="10">:</td>
        <td width="100%"><?php echo $time->niceShort($user['User']['created']); ?></td>

    </tr>
    <tr>
        <td><?php echo __('Modified', true); ?></td>
        <td width="10">:</td>
        <td width="100%"><?php echo $time->niceShort($user['User']['modified']); ?></td>

    </tr>

</table>
