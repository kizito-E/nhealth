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

        <?php if (isset($_SESSION["is_admin"]) && $_SESSION["role"] != "administrator"): ?>
            <button go-to-admin-account style="position:relative; top: 8px;" class="btn btn-danger">
                <i class="fa fa-fw fa-sign-in"></i>
                <?php _e("В аккаунт администратора")?>
            </button>
        <?php endif; ?>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <?php if (is_administrator() === true): ?>

                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"><?php _e('Рекламодатель (субаккаунт)'); ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="change-user-subrole" data-to-role="administrator"><a href="javascript:void(0)"><span class="fa fa-fw"></span> <?php _e('Администратор'); ?></a></li>
                            <li class="change-user-subrole" data-to-role="webmaster"><a href="javascript:void(0)"><span class="fa fa-fw"></span> <?php _e('Вебмастер (субаккаунт)'); ?></a></li>
                            <li><a href="javascript:void(0)"><span class="fa fa-fw fa-check"></span> <?php _e('Рекламодатель (субаккаунт)'); ?> </a></li>
                        </ul>
                    </li>

                <?php else: ?>

                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"><?php _e('Рекламодатель'); ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="change-user-subrole" data-to-role="webmaster"><a href="javascript:void(0)"><span class="fa fa-fw"></span> <?php _e('Вебмастер'); ?></a></li>
                            <li><a href="javascript:void(0)"><span class="fa fa-fw fa-check"></span> <?php _e('Рекламодатель'); ?> </a></li>
                        </ul>
                    </li>

                <?php endif; ?>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span>
                            <?php echo $balance; ?>
                            <?php echo get_globalsettings('current_currency', 'USD')?>
                        </span>
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <div class="container" style="max-width: 300px; padding:10px;">

                                <div class="form-group text-center">
                                    <span><?php _e('Баланс рекламодателя:'); ?></span>
                                    <h1>
                                        <b><?php echo $balance; ?></b>
                                        <?php echo get_globalsettings('current_currency', 'USD')?>
                                    </h1>
                                </div>

                                <div style="padding-top: 10px;">
                                    <a href="/advertiser/payments/" class="btn btn-flat btn-default btn-block">
                                        <i class="fa fa-plus"></i>
                                        <?php _e('Пополнить баланс'); ?>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>

                </li>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/assets/imgs/avatar_user.png" class="user-image">
                        <span class="hidden-xs"><?php echo $username; ?></span>
                    </a>


                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="/assets/imgs/avatar_user.png" class="img-circle">

                            <p>
                                <?php echo $username; ?>
                                <small><?php echo $email; ?></small>
                            </p>
                        </li>

                        <li class="user-footer">
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
