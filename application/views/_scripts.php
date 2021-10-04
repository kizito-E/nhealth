<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
print_js_var('translations', call_user_func(function () {

    $locales = include(APPPATH . "language" . DIRECTORY_SEPARATOR . "locales" . DIRECTORY_SEPARATOR . "en.php");
    $out     = [];

    foreach (array_shift($locales["messages"]) as $key => $val) {
        if ($key) {
            $out[$key] = array_shift($val);
        }
    }

    return $out;
}), JSON_UNESCAPED_UNICODE);

?>

<script src="/assets/js/vendor.js"></script>
<script src="/assets/js/app.js"></script>

