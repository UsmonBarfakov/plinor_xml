<?php

namespace App\configs;

define('BASE_URL', 'http://plinor_xml/');
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . 'upload');
define('XPATH_QUERY', "//Component[
    @Id='030-032-000-000'  
    and count(*)=3
    and string(*[translate(name(),'VALUE', 'value')]/text())!=''  
    and string(*[translate(name(),'LIMIT', 'limit')]/text())!=''  
    and string(*[translate(name(),'ERROR', 'error')]/text())='ERROR'] 
    /.."); // '/..' selected parent - it's means that Node Component is not root element;
