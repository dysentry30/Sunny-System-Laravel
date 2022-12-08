<?php 
use Illuminate\Support\Facades\Auth;

// if(!function_exists("url_encode")) {
// }
function url_encode($url) {
    return urlencode(urlencode($url));
}

function url_decode($url) {
    return urldecode(urldecode($url));
}
?>