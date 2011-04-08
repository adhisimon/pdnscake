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
        Owner: <?php echo $domain['User']['username']; ?>
    </li>
    <li>
        Serial: <?php echo $this->requestAction("/domains/getSerial/$id"); ?>
    </li>
</ul>
