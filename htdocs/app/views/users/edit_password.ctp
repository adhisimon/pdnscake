<?php
/**
 * view of /users/editPassword
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */
?>

<h2><?php echo sprintf(__('Edit %s Password', true), $user['User']['username']); ?></h2>

<?php
    echo $form->create('User');
    echo $form->input('id', array('type' => 'hidden', 'value' => $user['User']['id']));
    echo $form->input('new_password', array('type' => 'password'));
    echo $form->input('retype_new_password', array('type' => 'password'));
    echo $form->end(__('Change Password', true));
?>
