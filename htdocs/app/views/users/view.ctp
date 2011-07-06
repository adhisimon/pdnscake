<?php
/**
 * view of .....
 */
?>
<h2><?php echo __('User', true); ?></h2>

<div style="text-align: right;">
    [

    <?php
        echo $html->link(
            __('Edit', true),
            array(
                'action' => 'edit',
                $user['User']['id']
            )
        );
    ?>

    ]

    [

    <?php
        echo $html->link(
            __('Change Password', true),
            array(
                'action' => 'editPassword',
                $user['User']['id']
            )
        );
    ?>

    ]


</div>

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
                echo __('Normal User', true);
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

<br/>
<?php
    if ($this->Session->read('Auth.User.admin')) {
        echo $html->link(
            __('List of  users', true),
            array(
                'controller' => 'users',
                'action' => 'index',
            )
        );

        echo '<br/>';
        echo $html->link(
            __('Create a user', true),
            array(
                'controller' => 'users',
                'action' => 'add',
            )
        );
    }
?>

<br/>
<?php
    echo $html->link(
        __('List of domains', true),
        array(
            'controller' => 'domains',
            'action' => 'index',
        )
    );
?>
