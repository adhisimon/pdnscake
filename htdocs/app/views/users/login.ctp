<?php
/**
 * view of users/login
 */
?>
<fieldset>
    <?php echo $form->create('User'); ?>
    <?php echo $form->input('username'); ?>
    <?php echo $form->input('password'); ?>
    <?php echo $form->end(__('Login', true)); ?>
</fieldset>
