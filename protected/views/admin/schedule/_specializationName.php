<?php

$specializationName = SpecializationViewConst::getSpecializationTextView($s->name, $s->additional);
if ($specializationName === $lastSpecializationName) {
    echo '&nbsp;';
} else {
    echo $specializationName;
}
$lastSpecializationName = $specializationName;