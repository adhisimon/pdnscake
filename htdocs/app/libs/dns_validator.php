<?php
/**
 * dns entry validator
 *
 * many codes are from poweradmin (https://www.poweradmin.org/) library
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */

/**
 * ipv4 validator
 *
 * @params string $ipv4 entry to validate
 * @return boolean true if valid
 */
function is_valid_ipv4($ipv4) {
    $quads = explode('.', $ipv4);
    $numquads = count($quads);

    if ($numquads != 4) {
        return false;
    }

    if ($quads[0] == 0) {
        return false;
    }

    foreach($quads as $quad) {
        if (!is_numeric($quad) or $quad > 255 or $quad < 0) {
            return false;
        }
    }

    return true;
}

function is_valid_dns_record($record, $type) {
    if ($type == 'A') {
        return is_valid_ipv4($record);
    } else {
        return true;
    }
}
