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

        <?php if (isset($_SESSION["is_admin"])): ?>
            <button go-to-admin-account style="position:relative; top: 8px;" class="btn btn-danger">
                <i class="fa fa-fw fa-sign-in"></i>
                <?php _e("В аккаунт администратора")?>
            </button>
        <?php endif; ?>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/assets/imgs/avatar_moderator.png" class="user-image">
                        <span class="hidden-xs"><?php echo $username; ?></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="/assets/imgs/avatar_moderator.png" class="img-circle" alt="User Image">
                            <p>
                                <?php echo $username; ?>
                                <small><?php echo $email; ?></small>
                            </p>
                        </li>

                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="/moderator/settings/" class="btn btn-default btn-flat">
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
