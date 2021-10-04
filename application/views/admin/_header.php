<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<header class="main-header">
    <a href="/" class="logo">
<!--        <span class="logo-mini"><b>AD</b></span>-->
        <span class="logo-lg">
          <img src="<?php echo get_globalsettings('custom_logo', '/assets/imgs/adflex-logo.png')?>">
        </span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">


                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"><?php _e('Администратор'); ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:void(0)"><span class="fa fa-fw fa-check"></span> <?php _e('Администратор'); ?></a></li>
                        <li class="change-user-subrole" data-to-role="webmaster"><a href="javascript:void(0)"><span class="fa fa-fw"></span> <?php _e('Вебмастер (субаккаунт)'); ?></a></li>
                        <li class="change-user-subrole" data-to-role="advertiser"><a href="javascript:void(0)"><span class="fa fa-fw"></span> <?php _e('Рекламодатель (субаккаунт)'); ?></a></li>
                    </ul>
                </li>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/assets/imgs/avatar_admin.png" class="user-image">
                        <span class="hidden-xs"><?php echo $username; ?></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="/assets/imgs/avatar_admin.png" class="img-circle" alt="User Image">
                            <p>
                                <?php echo $username; ?>
                                <small><?php echo $email; ?></small>
                            </p>
                        </li>

                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="/administrator/settings/" class="btn btn-default btn-flat">
                                    <i class="fa fa-cog"></i>
                                    <?php _e('Настройки'); ?>
                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="/auth/logout/" class="btn btn-default btn-flat">
                                    <i class="fa fa-sign-out"></i>
                                    <?php _e('Выход'); ?>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>
