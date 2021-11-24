<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/assets/imgs/avatar_user.png" class="img-circle">
            </div>
            <div class="pull-left info">
                <p><?php echo $first_name . ' ' . $last_name; ?></p>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li <?php menu_item('beneficiary\/dashboard'); ?> >
                <a href="/beneficiary/dashboard">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li <?php menu_item('beneficiary\/transactions'); ?> >
                <a href="/beneficiary/transactions">
                    <i class="fa fa-money"></i> <span>Transactions</span>
                </a>
            </li>
            
            <li <?php menu_item('beneficiary\/settings'); ?> >
                <a href="/beneficiary/settings">
                    <i class="fa fa-cog"></i> <span>Settings</span>
                </a>
            </li>
        </ul>
    </section>
</aside>