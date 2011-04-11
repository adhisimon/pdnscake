<?php
/**
 * Sample of core.local.php
 *
 * Copy this file to "core.local.php" to make your local configuration.
 * You can override any entry in "core.php" here.
 */

/**
 * Salt for password (hexadecimal value)
 */
#Configure::write('Security.salt', '043d5a9570939e5bc9a34add2f3c25ce57a42394');

/**
 * Chiperseed (number value)
 */
#Configure::write('Security.cipherSeed', '12367812922');

/**
 * Default TTL for a record (in seconds)
 */
#Configure::write('DefaultTTL', 86400);

/**
 * Available record types
 */
/*
Configure::write(
    'AvailableRecordTypes',
    array(
        'A' => __('A (IPv4 address)', true),
        'AAAA' => __('AAAA (IPv6 address)', true),
        'CNAME' => __('CNAME (Alias)', true),
        'DNSKEY' => 'DNSKEY',
        'DS' => 'DS',
        'HINFO' => __('HINFO (Hardware Info)', true),
        'KEY' => 'KEY',
        'LOC' => __('LOC (Location)', true),
        'MX' => __('MX (Mail Exchange)', true),
        'NAPTR' => __('NAPTR (Naming Authority Pointer)', true),
        'NS' => __('NS (Name Server)', true),
        'NSEC' => __('NSEC', true),
        'PTR' => __('PTR (Reverse Pointer)', true),
        'RP' => __('RP (Responsible Person)', true),
        'RRSIG' => 'RRSIG',
        'SPF' => __('SPF (Sender Permitted From)', true),
        'SSHFP' => __('SSHFP (SSH Fingerprint)', true),
        'SRV' => 'SRV',
        'TXT' => __('TXT (Textual Data)', true),
    )
);
*/

/**
 * Initial record when creating a new domain
 *
 * __DOMAINNAME__ will be replaced by domain name at runtime
 * __DOMANSERIAL__ will be replaced by domain serial at runtime
 */
/*
Configure::write(
    'InitialRecords',
    array(
        array(
            'name' => '__DOMAINNAME__',
            'type' => 'SOA',
            'content' => 'localhost.localdomain hostmaster@__DOMAINNAME__ __DOMAINSERIAL__',
        ),
        array(
            'name' => '__DOMAINNAME__',
            'type' => 'NS',
            'content' => 'localhost.localdomain',
        ),
        array(
            'name' => '__DOMAINNAME__',
            'type' => 'A',
            'content' => '127.0.0.1',
        ),
        array(
            'name' => 'www.__DOMAINNAME__',
            'type' => 'CNAME',
            'content' => '__DOMAINNAME__',
        ),
        array(
            'name' => 'mail.__DOMAINNAME__',
            'type' => 'A',
            'content' => '127.0.0.1',
        ),
        array(
            'name' => '__DOMAINNAME__',
            'type' => 'MX',
            'prio' => 10,
            'content' => 'mail.__DOMAINNAME__',
        )
    )
);
*/
