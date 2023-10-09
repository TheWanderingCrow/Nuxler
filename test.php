<?php

require __DIR__ . '/src/classes/autoload.php';

$res = NuxBackend::directoryMap();

print_r($res['aliases']['Nuxler']);
foreach ($res['aliases']['Nuxler'] as $thing) {
    print($thing);
}