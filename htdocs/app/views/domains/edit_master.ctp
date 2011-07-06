<?php
/**
 * view of /domains/edit_master
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */
?>

<h2><?php echo $domain['Domain']['name']; ?></h2>

<?php
    echo $form->create('Domain', array('url' => array('action' => 'editMaster', $domain['Domain']['id'])));
    echo $form->input(
        'id',
        array(
            'type' => 'hidden',
            'value' => $domain['Domain']['id'],
        )
    );
    echo $form->input('master');
    echo $form->end(__('Save', true));
?>
