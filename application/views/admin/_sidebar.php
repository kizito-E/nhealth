<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<aside class="main-sidebar">

    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/assets/imgs/avatar_admin.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $username; ?></p>
                <a href="/">
                    <span class="label label bg-red" style="font-size: 10px;"> 
                        <?php _e('Администратор'); ?>
                    </span>
                </a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
            <li class="header"><?php _e('НАВИГАЦИЯ'); ?></li>

            <li <?php menu_item('administrator\/dashboard'); ?> >
                <a href="/administrator/dashboard">
                    <i class="fa fa-dashboard"></i> <span><?php _e('Консоль'); ?></span>
                </a>
            </li>

            <li <?php menu_item('administrator\/users'); ?> >
                <a href="/administrator/users">
                    <i class="fa fa-users"></i> <span><?php _e('Пользователи'); ?></span>
                </a>
            </li>

            <li <?php menu_item('administrator\/sites(.*)'); ?> >
                <a href="/administrator/sites">
                    <i class="fa fa-globe"></i> <span><?php _e('Сайты'); ?></span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-red"><?php echo $count_sites_moderation; ?></small>
                    </span>
                </a>
            </li>            

            <li <?php menu_item('administrator\/campaigns(.*)'); ?> >
                <a href="/administrator/campaigns">
                    <i class="fa fa-shopping-basket"></i> <span><?php _e('Кампании'); ?></span>
                </a>
            </li>   

            <li <?php menu_item('administrator\/ads'); ?> >
                <a href="/administrator/ads">
                    <i class="fa fa-bullhorn"></i> <span><?php _e('Обьявления'); ?></span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-red"><?php echo $count_ads_moderation; ?></small>
                    </span>
                </a>
            </li>           

            <li <?php menu_item('administrator\/statistics'); ?> >
                <a href="/administrator/statistics">
                    <i class="fa fa-pie-chart"></i> <span><?php _e('Статистика'); ?></span>
                </a>
            </li> 

            <li <?php menu_item('administrator\/payments'); ?> >
                <a href="/administrator/payments">
                    <i class="fa fa-plus"></i> <span><?php _e('Платежи'); ?></span>
                </a>
            </li> 

            <li <?php menu_item('administrator\/payouts'); ?> >
                <a href="/administrator/payouts">
                    <i class="fa fa-minus"></i> <span><?php _e('Выплаты'); ?></span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-red"><?= $count_payouts; ?></small>
                    </span>
                </a>
            </li> 

            <li <?php menu_item('administrator\/support'); ?> >
                <a href="/administrator/support">
                    <i class="fa fa-life-ring"></i> <span><?php _e('Поддержка'); ?></span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-red"><?= $count_unread_messages; ?></small>
                    </span>
                </a>
            </li>         

            <li <?php menu_item("administrator\/settings"); ?> >
                <a href="/administrator/settings">
                    <i class="fa fa-cog"></i> <span><?php _e('Настройки'); ?></span>
                </a>
            </li>


<!--           <li --><?php //menu_item("administrator\/eventlog"); ?><!-- >-->
<!--                <a href="/administrator/eventlog">-->
<!--                    <i class="fa fa-history"></i> <span>--><?php //_e('Журнал событий'); ?><!--</span>-->
<!--                </a>-->
<!--            </li>-->


<!--            <li --><?php //menu_item("administrator\/faq"); ?><!-- >-->
<!--                <a href="/administrator/faq">-->
<!--                    <i class="fa fa fa-book"></i>-->
<!--                    <span>--><?php //_e('ЧаВо'); ?><!--</span>-->
<!--                </a>-->
<!--            </li>-->

        </ul>
    </section>

</aside>
