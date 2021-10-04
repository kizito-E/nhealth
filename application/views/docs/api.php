<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>nHealth | API Guide/Reference</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <!-- FontAwesome JS -->
    <script defer src="/assets/docs/fontawesome/js/all.js"></script>
    <!-- Global CSS -->
    <link rel="stylesheet" href="/assets/docs/plugins/bootstrap/css/bootstrap.min.css">   
    <!-- Plugins CSS -->    
    <link rel="stylesheet" href="/assets/docs/plugins/prism/prism.css">
    <link rel="stylesheet" href="/assets/docs/plugins/lightbox/dist/ekko-lightbox.css">
    <link rel="stylesheet" href="/assets/docs/plugins/elegant_font/css/style.css">

    <!-- Theme CSS -->
    <link id="theme-style" rel="stylesheet" href="/assets/docs/css/styles.css">
    
</head> 

<body class="body-blue">
    <div class="page-wrapper">
        <!-- ******Header****** -->
        <header id="header" class="header">
            <div class="container">
                <div class="branding">
                    <h1 class="logo">
                        <a href="/docs">
                            <span aria-hidden="true" class="icon_documents_alt icon"></span>
                            <span class="text-highlight">nHealth</span><span class="text-bold">Docs</span>
                        </a>
                    </h1>
                </div><!--//branding-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/docs">Home</a></li>
                    <li class="breadcrumb-item active">API Reference</li>
                </ol>
            </div><!--//container-->
        </header><!--//header-->
        <div class="doc-wrapper">
            <div class="container">
                <div id="doc-header" class="doc-header text-center">
                    <h1 class="doc-title"><span aria-hidden="true" class="icon icon_puzzle_alt"></span> API Reference</h1>
                    <div class="meta"><i class="far fa-clock"></i> Last updated: Oct 4th, 2020</div>
                </div><!--//doc-header-->
                <div class="doc-body row" >
                    <div class="doc-content col-md-9 col-12 order-1">
                        <div class="content-inner">
                            <section id="dashboards" class="doc-section">
                                <h2 class="section-title">Dashboards</h2>
                                <div class="section-block">
                                    <p>Welcome! The screenshots used in this page are taken from <a href="https://themes.3rdwavemedia.com/bootstrap-templates/product/appify-bootstrap-4-admin-template-for-app-developers/" target="_blank">Appify</a>. Appify is a Bootstrap 4 admin template made for app developers.</p>
                        
                                </div><!--//section-block-->
                                
                            </section><!--//doc-section-->
                            
                            <section id="app-components" class="doc-section">
                                <h2 class="section-title">App Components</h2>
                                <div id="projects" class="section-block">
                                    <h3 class="block-title">Projects</h3>
                                    <p>Intro goes here lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis</p>
                                    <div class="row">
                                    </div><!--//row-->
                                </div><!--//section-block-->
                                <div id="discussions" class="section-block">
                                    <h3 class="block-title">Discussions</h3>
                                    <div class="row">
                                    </div><!--//row-->  
                                </div><!--//section-block-->
                                
                                <div id="members" class="section-block">
                                    <h3 class="block-title">Members</h3>
                                    <div class="row">
                                    </div><!--//row-->  
                                </div><!--//section-block-->
                                
                                <div id="account" class="section-block">
                                    <h3 class="block-title">User Account</h3>
                                    <p>Intro goes here lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes.</p>
                                    <div class="row">
                                    </div><!--//row-->  
                                </div><!--//section-block-->
                                
                                 <div id="others" class="section-block">
                                    <h3 class="block-title">Others</h3>
                                    <div class="row">
                                    </div><!--//row-->  
                                </div><!--//section-block-->
                            </section><!--//doc-section-->
                            <section id="ui-components" class="doc-section">
                                <h2 class="section-title">UI Components</h2>
                                <div class="section-block">
                                    <p>appify is packed with building blocks. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. </p>
                                    <div class="row">
                                    </div><!--//row-->
                                </div><!--//section-block-->
                            </section><!--//doc-section-->
                            
                        </div><!--//content-inner-->
                    </div><!--//doc-content-->
                    <div class="doc-sidebar col-md-3 col-12 order-0 d-none d-md-flex">
                        <div id="doc-nav" class="doc-nav">
                            <nav id="doc-menu" class="nav doc-menu flex-column sticky">
                                <a class="nav-link scrollto" href="#dashboards">Dashboards</a>
                                <a class="nav-link scrollto" href="#app-components">App Components</a>
                                    <nav class="doc-sub-menu nav flex-column">
                                        <a class="nav-link scrollto" href="#projects">Projects</a>
                                        <a class="nav-link scrollto" href="#discussions">Discussions</a>
                                        <a class="nav-link scrollto" href="#members">Members</a>
                                        <a class="nav-link scrollto" href="#account">User Account</a>
                                        <a class="nav-link scrollto" href="#others">Others</a>
                                    </nav><!--//nav-->
                                <a class="nav-link scrollto" href="#ui-components">UI Components</a>
                            </nav><!--//doc-menu-->
                        </div><!--//doc-nav-->
                    </div><!--//doc-sidebar-->
                </div><!--//doc-body-->              
            </div><!--//container-->
        </div><!--//doc-wrapper-->
        
    </div><!--//page-wrapper-->
    
    <footer id="footer" class="footer text-center">
        <div class="container">
            <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
            <small class="copyright">Designed with <i class="fas fa-heart"></i> by <a href="https://themes.3rdwavemedia.com/" target="_blank">Xiaoying Riley</a> for developers</small>
            
        </div><!--//container-->
    </footer><!--//footer-->
    
     
    <!-- Main Javascript -->          
    <script type="text/javascript" src="/assets/docs/plugins/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="/assets/docs/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/assets/docs/plugins/prism/prism.js"></script>    
    <script type="text/javascript" src="/assets/docs/plugins/jquery-scrollTo/jquery.scrollTo.min.js"></script>  
    <script type="text/javascript" src="/assets/docs/plugins/lightbox/dist/ekko-lightbox.min.js"></script>      
    <script type="text/javascript" src="/assets/docs/plugins/stickyfill/dist/stickyfill.min.js"></script>                                                              
    <script type="text/javascript" src="/assets/docs/js/main.js"></script>
    
</body>
</html>