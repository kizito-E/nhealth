<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/assets/imgs/avatar_user.png" class="img-circle">
            </div>
            <div class="pull-left info">
                <p><?php echo $name; ?></p>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li <?php menu_item('serviceprovider\/dashboard'); ?> >
                <a href="/serviceprovider/dashboard">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li <?php menu_item('serviceprovider\/settings'); ?> >
                <a href="/serviceprovider/settings">
                    <i class="fa fa-cog"></i> <span>Settings</span>
                </a>
            </li>
        </ul>
    </section>
</aside>