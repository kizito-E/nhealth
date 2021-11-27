<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script id="status" type="text/html">
    {% if (o.status == 1) { %}
    <span class="label label-success">Active</span>
    {% } else { %}
    <span class="label label-danger">Inactive</span>
    {% } %}
</script>