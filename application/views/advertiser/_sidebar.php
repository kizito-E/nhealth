<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/assets/imgs/avatar_user.png" class="img-circle">
            </div>
            <div class="pull-left info">
                <p><?php echo $username; ?></p>
                <a href="/">
                    <span class="label label bg-green" style="font-size: 10px;">
                        <?php _e('Рекламодатель'); ?>
                    </span>
                </a>
            </div>
        </div>

        <ul class="sidebar-menu " data-widget="tree">
            <li class="header"><?php _e('НАВИГАЦИЯ'); ?></li>

            <li <?php menu_item('advertiser\/dashboard'); ?> >
                <a href="/advertiser/dashboard">
                    <i class="fa fa-dashboard"></i> <span><?php _e('Консоль'); ?></span>
                </a>
            </li>

            <li <?php menu_item(['advertiser\/(campaigns|dsalist|bannerlist)']); ?> >
                <a href="/advertiser/campaigns">
                    <i class="fa fa-shopping-basket"></i> <span><?php _e('Кампании'); ?></span>
                </a>
            </li>

            <li <?php menu_item('advertiser\/statistics'); ?> >
                <a href="/advertiser/statistics/">
                    <i class="fa fa-pie-chart"></i>
                    <span><?php _e('Статистика'); ?></span>
                </a>
            </li>

            <li <?php menu_item('advertiser\/payments'); ?> >
                <a href="/advertiser/payments">
                    <i class="fa fa-money"></i> <span><?php _e('Платежи'); ?></span>
                </a>
            </li>

        </ul>
    </section>
</aside>
