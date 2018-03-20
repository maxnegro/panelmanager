<?php
// @app/config/opensslca.php
return [
    'class'    => 'ssimpson\opensslca\Opensslca',
    'password' => 'secret',
    'ca_dir'   => '@app/ca',
    'dn_base'   => [
	               'countryName'  => 'US',
	               'stateOrProvinceName' => 'Some State',
	               'localityName' => 'My City',
	               'organizationName' => 'Snake Oil Development Company',
	               'organizationalUnitName' => 'Demo',
                ],
    'ca_cn'     => 'Snake Oil CA',
    'crlWhenRevoke' => true,
    'crlValidDays'  => 30,
];
