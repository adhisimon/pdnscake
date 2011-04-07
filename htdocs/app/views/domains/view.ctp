<?php
/**
 * view of /domains/view
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */
?>
<h2><?php echo $title_for_layout; ?></h2>

<ul>
    <li>
        Owner: <?php echo $domain['User']['username']; ?>
    </li>
    <li>
        Number of records: -
    </li>
    <li>
        Serial: <?php echo $this->requestAction("/domains/getSerial/$id"); ?>
    </li>
</ul>
