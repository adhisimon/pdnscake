<?php
/**
 * view of users/add
 */
?>
<fieldset>
    <legend><?php echo __('Add User', true); ?></legend>
    <?php echo $form->create('User'); ?>
    <?php echo $form->input('username'); ?>
    <?php echo $form->input('password'); ?>
    <?php echo $form->input('fullname'); ?>
    <?php echo $form->input('admin'); ?>
    <?php echo $form->end(__('Save', true)); ?>

</fieldset>
