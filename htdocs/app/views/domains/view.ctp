<?php
/**
 * view of /domains/view
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */
?>
<?php if (empty($this->params['requested'])) { ?>
    <h2><?php echo $title_for_layout; ?></h2>
<?php } ?>

<ul>
    <li>
        Owner:
        <?php
            echo $html->link($domain['User']['username'], array('controller' => 'users', 'action' => 'view', $domain['User']['id']));
        ?>
    </li>

    <li>
        Domain Type: <?php echo $domain['Domain']['type']; ?>
    </li>

    <?php if ($domain['Domain']['type'] == 'SLAVE'): ?>
    <li>
        Master:
        <?php
            $domain_master =  $domain['Domain']['master'];
            echo empty($domain_master) ? __('no master has specified', true) : $domain_master;


            echo ' [';
            echo $html->link(__('Edit Master', true), array('action' => 'editMaster', $domain['Domain']['id']));
            echo ']';
        ?>
    </li>
    <?php endif; ?>

    <li>
        Serial: <?php echo $this->requestAction("/domains/getSerial/$id"); ?>
    </li>

    <?php if ($domain['Domain']['type'] == 'MASTER'): ?>
    <li>
        Notified Serial: <?php echo $domain['Domain']['notified_serial']; ?>
    </li>

    <li>
        Last Modified:

        <?php echo date("Y-m-d H-i-s", $this->requestAction("/domains/getLastModified/$id")); ?>
    </li>
    <?php endif; ?>

</ul>
