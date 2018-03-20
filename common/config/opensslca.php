<?php
// @app/config/opensslca.php
return [
    'class'    => 'maxnegro\opensslca\Opensslca',
    'password' => 'secret',
    'ca_dir'   => '@app/../ca',
    'dn_base'   => [
	               'countryName'  => 'IT',
	               'stateOrProvinceName' => 'FC',
	               'localityName' => 'Cesena',
	               'organizationName' => 'El-Tek',
	               'organizationalUnitName' => 'VPN',
                ],
    'ca_cn'     => 'El-Tek Panel VPN CA',
    'crlWhenRevoke' => true,
    'crlValidDays'  => 30,
];
