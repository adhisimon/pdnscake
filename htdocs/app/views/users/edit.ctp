<?php
/**
 * view of users/edit
 */
?>
<fieldset>
    <legend><?php echo __('Edit User', true); ?></legend>
    <?php echo $form->create('User'); ?>
    <?php echo $form->input('username'); ?>
    <?php echo $form->input('fullname'); ?>
    <?php echo $form->input('admin'); ?>
    <?php echo $form->input('active'); ?>
    <?php echo $form->end(__('Save', true)); ?>

</fieldset>
