<?php

$xml = new SimpleXMLElement('dummy.xml', 0, TRUE);
print_r(json_encode($xml));