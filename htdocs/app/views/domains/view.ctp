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
        Serial: <?php echo $this->requestAction("/domains/getSerial/$id"); ?>
    </li>

    <?php if ($domain['Domain']['type'] == 'MASTER'): ?>
    <li>
        Notified Serial: <?php echo $domain['Domain']['notified_serial']; ?>
    </li>
    <?php endif; ?>

    <li>
        Last Modified:

        <?php echo date("Y-m-d H-i-s", $this->requestAction("/domains/getLastModified/$id")); ?>
    </li>

</ul>
