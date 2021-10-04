<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="/assets/imgs/avatar_moderator.png" class="img-circle">
            </div>
            <div class="pull-left info">
                <p><?php echo $username; ?></p>
                <a href="/">
                    <span class="label label bg-purple" style="font-size: 10px;"> <?php _e('Модератор'); ?></span>
                </a>
            </div>
        </div>

        <ul class="sidebar-menu " data-widget="tree">
            <li class="header"><?php _e('НАВИГАЦИЯ'); ?></li>

            <li <?php menu_item('moderator\/sites'); ?> >
                <a href="/moderator/sites">
                    <i class="fa fa-globe"></i> <span><?php _e('Сайты'); ?></span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-purple"><?php echo $count_sites_moderation ?></small>
                    </span>
                </a>
            </li>

            <li <?php menu_item('moderator\/campaigns(.*)'); ?> >
                <a href="/moderator/campaigns">
                    <i class="fa fa-shopping-basket"></i> <span><?php _e('Кампании'); ?></span>
                </a>
            </li>

            <li <?php menu_item('moderator\/ads'); ?> >
                <a href="/moderator/ads">
                    <i class="fa fa-bullhorn"></i> <span><?php _e('Обьявления'); ?></span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-purple"><?php echo $count_ads_moderation; ?></small>
                    </span>
                </a>
            </li>


            <li <?php menu_item('moderator\/support'); ?> >
                <a href="/moderator/support">
                    <i class="fa fa-life-ring"></i> <span><?php _e('Поддержка'); ?></span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-purple"><?php echo $count_unread_messages; ?></small>
                    </span>
                </a>
            </li>

            <li <?php menu_item('moderator\/settings'); ?> >
                <a href="/moderator/settings">
                    <i class="fa fa-cog"></i> <span><?php _e('Настройки'); ?></span>
                </a>
            </li>

        </ul>
    </section>
</aside>
