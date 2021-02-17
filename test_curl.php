<?php
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);


function _iscurlsupported() {
    if  (in_array  ('curl', get_loaded_extensions())) return true;
    else return false;
}

if (_iscurlsupported()) echo “cURL is supported”; else echo "cURL is NOT supported";

    ?>