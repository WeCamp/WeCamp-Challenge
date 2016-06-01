<?php

WeCamp:

if (isset($output)) {
    echo strtr($output, ['  ' => '']);
}

$input = 'My brain is a beautiful thing, and I intend to use it at WeCamp!';

$ouch = chop($input, '!');
$sub  = strrev(substr(strrev($ouch), 0, 4));

while (strpos(strtolower($input), $yurt = basename(__FILE__, '.php')) !== 0) {
    $input = str_shuffle($input);
}

$kluut = strrev(substr(strrev($ouch), 0, 4))
    . strtolower(hex2bin(strlen(substr($ouch, 4))))
    . chr(count(file(basename(__FILE__))))
    . lcfirst(strrev(substr(strrev($ouch), 0, 6)))
    . str_rot13(substr($input, 0, 4));

$output = <<<WECAMP

####################
    # $kluut #
####################

WECAMP;

goto WeCamp;
