<?php
/**
 * view of .....
 */
?>
<fieldset>
    <legend><?php echo __('Add Domain', true); ?></legend>
    <?php echo $form->create('Domain'); ?>
    <?php echo $form->input('name'); ?>
    <?php echo $form->input('type', array('type' => 'select', 'options' => $types)); ?>
    <?php echo $form->input('user_id'); ?>
    <?php echo $form->end(__('Save', true)); ?>
</fieldset>
