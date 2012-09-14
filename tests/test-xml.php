<?php
$navigation_parser=xml_parser_create();
$handle = fopen('C:\Program Files (x86)\Zend\Apache2\htdocs\zf-tutorial\application/configs/navigation.xml', "r");
$navigation_data=fread($handle,4096);
xml_parse_into_struct($navigation_parser, $navigation_data, $vals, $index);
xml_parser_free($navigation_parser);
echo "Index <br>";
print_r($index);
echo "<br> Vals <br>";
print_r($vals);
