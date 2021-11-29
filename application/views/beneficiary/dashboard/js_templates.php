<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script id="service-actions" type="text/html">
    <div class="tet-center">
    {% if (o.status == 'pending approval') { %}
        <button class="item-action btn btn-sm btn-success" data-id="{%=o.id%}" data-action="approve">
            <i class="fa fa-check"></i> Approve
        </button>
        <button class="item-action btn btn-sm btn-danger" data-id="{%=o.id%}" data-action="cancelled">
            <i class="fa fa-times"></i> Cancel
        </button>
    {% } else if(o.status == 'pending fulfillment') { %}
        <button class="item-action btn btn-sm btn-primary" data-id="{%=o.id%}" data-action="completed">
            <i class="fa fa-check"></i> Delivered
        </button>
        <button class="item-action btn btn-sm btn-danger" data-id="{%=o.id%}" data-action="cancelled">
            <i class="fa fa-times"></i> Cancel
        </button>
    {% } else { %}
        <p>---</p>
    {% } %}
    </div>
</script>