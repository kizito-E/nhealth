<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/assets/imgs/avatar_user.png" class="img-circle">
            </div>
            <div class="pull-left info">
                <p><?php echo $username; ?></p>
                <a href="/"><span class="label label bg-light-blue" style="font-size: 10px;"> <?php _e('Вебмастер'); ?></span></a>
            </div>
        </div>
        <ul class="sidebar-menu " data-widget="tree">
            <li class="header"><?php _e('НАВИГАЦИЯ'); ?></li>
            <li <?php menu_item('webmaster\/dashboard'); ?> >
                <a href="/webmaster/dashboard">
                    <i class="fa fa-dashboard"></i> <span><?php _e('Консоль'); ?></span>
                </a>
            </li>
            <li <?php menu_item(["webmaster\/sites", "webmaster\/units"]); ?> >
                <a href="/webmaster/sites/">
                    <i class="fa fa-globe"></i> <span><?php _e('Сайты'); ?></span>
                </a>
            </li>
            <li <?php menu_item('webmaster\/statistics'); ?> >
                <a href="/webmaster/statistics">
                    <i class="fa fa-pie-chart"></i>
                    <span><?php _e('Статистика'); ?></span>
                </a>
            </li>
            <li <?php menu_item('webmaster\/payouts'); ?> >
                <a href="/webmaster/payouts/">
                    <i class="fa fa-money"></i> <span><?php _e('Выплаты'); ?></span>
                </a>
            </li>

            <?php if (is_administrator() === false): ?>

                <li <?php menu_item('webmaster\/support'); ?> >
                    <a href="/webmaster/support">
                        <i class="fa fa-life-ring"></i> <span><?php _e('Поддержка'); ?></span>
                        <span class="pull-right-container">
                            <small class="label pull-right label-primary"><?php echo $count_unread_messages; ?></small>
                        </span>
                    </a>
                </li>

            <?php endif; ?>

            <li <?php menu_item('webmaster\/settings'); ?> >
                <a href="/webmaster/settings">
                    <i class="fa fa-cog"></i> <span><?php _e('Настройки'); ?></span>
                </a>
            </li>

        </ul>
    </section>
</aside>