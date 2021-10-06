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
                            <section id="authentication" class="doc-section">
                                <h2 class="section-title">Getting Started</h2>
                                <div class="section-block">
                                    <p>Welcome! The nHealth API is currently secured using <a href="https://en.wikipedia.org/wiki/Basic_access_authentication" target="_blank">basic</a> authentication. To access the api, simply pass an authorization header containing a base64 encoding of the provided username and password seperated by a single colon.</p>
                                    <p>All api requests should be made to the following URL</p>
                                    <p><code>https://api.nhealth.site/api_v1</code></p>

                                    <p>Sample authorization request</p>
                                    <pre class="language-html"><code>curl https://api.nhealth.site/api_v1/ping
-H "Authorization: Bearer BASE64_ENCODE(user:pass)"
-H "Content-Type: application/json"
-X POST</code></pre>
                        
                                </div><!--//section-block-->
                                
                            </section><!--//doc-section-->
                            
                            <section id="app-components" class="doc-section">
                                <h2 class="section-title">User</h2>
                                <div id="projects" class="section-block">
                                    <h3 class="block-title">Create</h3>
                                    <p>Create a new user account.<br>Endpoint: /user/create<br>Method: POST</p>
                                    <div class="row">
                                        <div class="col-md-6 col-12 code-block">
                                            <p>Sample request</p>
                                            <pre class="language-html"><code>curl https://api.nhealth.site/api_v1/user/create
-H "Authorization: Bearer BASE64_ENCODE(user:pass)"
-H "Content-Type: application/json"
-d "{
    "first_name": "David",
    "last_name": "Edijala",
    "email": "davided@gmail.com",
    "password": "Pass755003",
    "role": "admin"
    }"
-X POST</code></pre>
                                        </div>
                                        <div class="col-md-6 col-12 code-block">
                                        <p>Sample response</p>
                                            <pre class="language-json"><code>{
    "status": "success",
    "user_id": "2"
}</code></pre>
                                        </div>
                                    </div><!--//row-->
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <h6>Required parameters</h6>
                                            <ul class="list">
        										<li>first_name</li>
        										<li>last_name</li>
        										<li>email</li>
        										<li>password</li>
                                                <li>role (one of these: benefactor, hmo, sp, admnin)</li>
        									</ul>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <h6>Optional parameters</h6>
                                            <ul class="list">
        										<li>business_name</li>
        									</ul>
                                        </div>
                                    </div><!--//row-->
                                </div><!--//section-block-->
                                <div id="discussions" class="section-block">
                                    <h3 class="block-title">User account</h3>
                                    <p>Get the basic details of a user account.<br>Endpoint: /user/{user_id}<br>Method: GET</p>
                                    <div class="row">
                                        <div class="col-md-6 col-12 code-block">
                                            <p>Sample request</p>
                                            <pre class="language-html"><code>curl https://api.nhealth.site/api_v1/user/2
-H "Authorization: Bearer BASE64_ENCODE(user:pass)"
-H "Content-Type: application/json"
-X GET</code></pre>
                                        </div>
                                        <div class="col-md-6 col-12 code-block">
                                        <p>Sample response</p>
                                            <pre class="language-json"><code>{
    "status": "success",
    "user": {
        "id": "2",
        "first_name": "David",
        "last_name": "Edijala",
        "business_name": "",
        "email": "davided@gmail.com",
        "role": "admin",
        "hmo_id": "0",
        "plan_id": "0",
        "status": "1",
        "created": "2021-10-05 13:06:18"
    }
}</code></pre>
                                        </div>
                                    </div><!--//row-->
                                </div><!--//section-block-->
                                
                                <div id="members" class="section-block">
                                    <h3 class="block-title">Authenticate</h3>
                                    <p>Verify a users' login credentials.<br>Endpoint: /user/auth<br>Method: POST</p>
                                    <div class="row">
                                        <div class="col-md-6 col-12 code-block">
                                            <p>Sample request</p>
                                            <pre class="language-html"><code>curl https://api.nhealth.site/api_v1/user/auth
-H "Authorization: Bearer BASE64_ENCODE(user:pass)"
-H "Content-Type: application/json"
-d "{
    "email": "davided@gmail.com",
    "password": "Pass755003"
    }"
-X POST</code></pre>
                                        </div>
                                        <div class="col-md-6 col-12 code-block">
                                        <p>Sample response</p>
                                            <pre class="language-json"><code>{
    "status": "success"
}</code></pre>
                                        </div>
                                    </div><!--//row-->
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <h6>Required parameters</h6>
                                            <ul class="list">
        										<li>email</li>
        										<li>password</li>
        									</ul>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <h6>Optional parameters</h6>
                                            <ul class="list">
                                                <li>none</li>
        									</ul>
                                        </div>
                                    </div><!--//row-->
                                </div><!--//section-block-->
                                
                                 <div id="others" class="section-block">
                                    <h3 class="block-title">List</h3>
                                    <p>List all user accounts in the system.<br>Endpoint: /user/list<br>Method: GET</p>
                                    <div class="row">
                                        <div class="col-md-6 col-12 code-block">
                                            <p>Sample request</p>
                                            <pre class="language-html"><code>curl https://api.nhealth.site/api_v1/user/list
-H "Authorization: Bearer BASE64_ENCODE(user:pass)"
-H "Content-Type: application/json"
-X GET</code></pre>
                                        </div>
                                        <div class="col-md-6 col-12 code-block">
                                        <p>Sample response</p>
                                            <pre class="language-json"><code>{
    "status": "success",
    "users": [
        {
            "id": "1",
            "first_name": "Elvis",
            "last_name": "Obioha",
            "business_name": "",
            "email": "elvis@elviskizito.com",
            "role": "benefactor",
            "hmo_id": "0",
            "plan_id": "0",
            "status": "1",
            "created": "2021-09-26 20:15:32"
        },
        {
            "id": "2",
            "first_name": "David",
            "last_name": "Edijala",
            "business_name": "",
            "email": "davided@gmail.com",
            "role": "admin",
            "hmo_id": "0",
            "plan_id": "0",
            "status": "1",
            "created": "2021-10-05 13:06:18"
        }
    ]
}</code></pre>
                                        </div>
                                    </div><!--//row--> 
                                </div><!--//section-block-->
                            </section><!--//doc-section-->

                            <section id="plan" class="doc-section">
                                <h2 class="section-title">Plan</h2>
                                <div id="get-plan" class="section-block">
                                    <h3 class="block-title">Get a plan</h3>
                                    <p>Get the basic details of a plan.<br>Endpoint: /plan/{plan_id}<br>Method: GET</p>
                                    <div class="row">
                                        <div class="col-md-6 col-12 code-block">
                                            <p>Sample request</p>
                                            <pre class="language-html"><code>curl https://api.nhealth.site/api_v1/plan/2
-H "Authorization: Bearer BASE64_ENCODE(user:pass)"
-H "Content-Type: application/json"
-X GET</code></pre>
                                        </div>
                                        <div class="col-md-6 col-12 code-block">
                                        <p>Sample response</p>
                                            <pre class="language-json"><code>{
    "status": "success",
    "plan": {
        "id": "2",
        "name": "gold",
        "amount": "25000.00"
    }
}</code></pre>
                                        </div>
                                    </div><!--//row-->
                                </div><!--//section-block-->

                                <div id="list-plans" class="section-block">
                                    <h3 class="block-title">List plans</h3>
                                    <p>Get details of all available plans.<br>Endpoint: /plan/list<br>Method: GET</p>
                                    <div class="row">
                                        <div class="col-md-6 col-12 code-block">
                                            <p>Sample request</p>
                                            <pre class="language-html"><code>curl https://api.nhealth.site/api_v1/plan/list
-H "Authorization: Bearer BASE64_ENCODE(user:pass)"
-H "Content-Type: application/json"
-X GET</code></pre>
                                        </div>
                                        <div class="col-md-6 col-12 code-block">
                                        <p>Sample response</p>
                                            <pre class="language-json"><code>{
    "status": "success",
    "plans": [
        {
            "id": "1",
            "name": "basic",
            "amount": "5000.00"
        },
        {
            "id": "2",
            "name": "gold",
            "amount": "25000.00"
        },
        {
            "id": "3",
            "name": "platinum",
            "amount": "50000.00"
        }
    ]
}</code></pre>
                                        </div>
                                    </div><!--//row-->
                                </div><!--//section-block-->

                            </section>

                            <section id="sub" class="doc-section">
                                <h2 class="section-title">Subscription</h2>
                                <div id="create-sub" class="section-block">
                                    <h3 class="block-title">Create</h3>
                                    <p>Create a new subscription.<br>Endpoint: /subscription/create<br>Method: POST</p>
                                    <div class="row">
                                        <div class="col-md-6 col-12 code-block">
                                            <p>Sample request</p>
                                            <pre class="language-html"><code>curl https://api.nhealth.site/api_v1/subscription/create
-H "Authorization: Bearer BASE64_ENCODE(user:pass)"
-H "Content-Type: application/json"
-d "{
    "user_id": 1,
    "plan_id": 3,
    "hmo_id": 4
    }"
-X POST</code></pre>
                                        </div>
                                        <div class="col-md-6 col-12 code-block">
                                        <p>Sample response</p>
                                            <pre class="language-json"><code>{
    "status": "success",
    "subscription_id": "2"
}</code></pre>
                                        </div>
                                    </div><!--//row-->
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <h6>Required parameters</h6>
                                            <ul class="list">
        										<li>user_id</li>
        										<li>plan_id</li>
        									</ul>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <h6>Optional parameters</h6>
                                            <ul class="list">
        										<li>hmo_id (Optionally assign user a new HMO)</li>
        									</ul>
                                        </div>
                                    </div><!--//row-->
                                </div><!--//section-block-->

                                <div id="update-sub" class="section-block">
                                    <h3 class="block-title">Update</h3>
                                    <p>Update an existing subscription with a new plan.<br>Endpoint: /subscription/update<br>Method: POST</p>
                                    <div class="row">
                                        <div class="col-md-6 col-12 code-block">
                                            <p>Sample request</p>
                                            <pre class="language-html"><code>curl https://api.nhealth.site/api_v1/subscription/update
-H "Authorization: Bearer BASE64_ENCODE(user:pass)"
-H "Content-Type: application/json"
-d "{
    "subscription_id": 4,
    "user_id": 1,
    "new_plan_id": 2
    }"
-X POST</code></pre>
                                        </div>
                                        <div class="col-md-6 col-12 code-block">
                                        <p>Sample response</p>
                                            <pre class="language-json"><code>{
    "status": "success",
    "subscription": {
        "id": "4",
        "plan_id": "2",
        "user_id": "1",
        "created": "2021-10-06 12:42:01"
    }
}</code></pre>
                                        </div>
                                    </div><!--//row-->
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <h6>Required parameters</h6>
                                            <ul class="list">
        										<li>subscription_id</li>
        										<li>user_id</li>
        										<li>new_plan_id</li>
        									</ul>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <h6>Optional parameters</h6>
                                            <ul class="list">
        										<li>none</li>
        									</ul>
                                        </div>
                                    </div><!--//row-->
                                </div><!--//section-block-->

                                <div id="get-sub" class="section-block">
                                    <h3 class="block-title">Get Subscription</h3>
                                    <p>Get the basic details of a subscription.<br>Endpoint: /subscription/{subscription_id}<br>Method: GET</p>
                                    <div class="row">
                                        <div class="col-md-6 col-12 code-block">
                                            <p>Sample request</p>
                                            <pre class="language-html"><code>curl https://api.nhealth.site/api_v1/subscription/2
-H "Authorization: Bearer BASE64_ENCODE(user:pass)"
-H "Content-Type: application/json"
-X GET</code></pre>
                                        </div>
                                        <div class="col-md-6 col-12 code-block">
                                        <p>Sample response</p>
                                            <pre class="language-json"><code>{
    "status": "success",
    "subscription": {
        "id": "1",
        "plan_id": "2",
        "user_id": "1",
        "created": "2021-10-06 11:59:17"
    },
    "plan": {
        "id": "2",
        "name": "gold",
        "amount": "25000.00"
    },
    "user": {
        "id": "1",
        "first_name": "Elvis",
        "last_name": "Obioha",
        "business_name": "",
        "email": "elvis@elviskizito.com",
        "role": "benefactor",
        "hmo_id": "0",
        "plan_id": "0",
        "subscription_id": "0",
        "status": "1",
        "created": "2021-09-26 21:08:51"
    }
}</code></pre>
                                        </div>
                                    </div><!--//row-->
                                </div><!--//section-block-->
                                
                                 <div id="list-subs" class="section-block">
                                    <h3 class="block-title">List</h3>
                                    <p>List all subscriptions.<br>Endpoint: /subscription/list<br>Method: GET</p>
                                    <div class="row">
                                        <div class="col-md-6 col-12 code-block">
                                            <p>Sample request</p>
                                            <pre class="language-html"><code>curl https://api.nhealth.site/api_v1/subscription/list
-H "Authorization: Bearer BASE64_ENCODE(user:pass)"
-H "Content-Type: application/json"
-X GET</code></pre>
                                        </div>
                                        <div class="col-md-6 col-12 code-block">
                                        <p>Sample response</p>
                                            <pre class="language-json"><code>
{
    "status": "success",
    "subscriptions": [
        {
            "id": "1",
            "plan_id": "2",
            "user_id": "1",
            "created": "2021-10-06 11:59:17"
        },
	{
            "id": "2",
            "plan_id": "3",
            "user_id": "2",
            "created": "2021-10-06 8:59:17"
        }
    ]
}</code></pre>
                                        </div>
                                    </div><!--//row--> 
                                </div><!--//section-block-->
                            </section><!--//doc-section-->

                            <section id="ui-components" class="doc-section">
                                <h2 class="section-title">Miscellenous</h2>
                                <div class="section-block">
                                    <div class="row">
                                    </div><!--//row-->
                                </div><!--//section-block-->
                            </section><!--//doc-section-->
                            
                        </div><!--//content-inner-->
                    </div><!--//doc-content-->
                    <div class="doc-sidebar col-md-3 col-12 order-0 d-none d-md-flex">
                        <div id="doc-nav" class="doc-nav">
                            <nav id="doc-menu" class="nav doc-menu flex-column sticky">
                                <a class="nav-link scrollto" href="#authentication">Getting Started</a>
                                <a class="nav-link scrollto" href="#app-components">User</a>
                                    <nav class="doc-sub-menu nav flex-column">
                                        <a class="nav-link scrollto" href="#projects">Create</a>
                                        <a class="nav-link scrollto" href="#discussions">User account</a>
                                        <a class="nav-link scrollto" href="#members">Authenticate</a>
                                        <a class="nav-link scrollto" href="#others">List</a>
                                    </nav><!--//nav-->
                                <a class="nav-link scrollto" href="#plan">Plan</a>
                                    <nav class="doc-sub-menu nav flex-column">
                                        <a class="nav-link scrollto" href="#get-plan">Get plan</a>
                                        <a class="nav-link scrollto" href="#list-plans">List</a>
                                    </nav><!--//nav-->
                                <a class="nav-link scrollto" href="#sub">Subscription</a>
                                    <nav class="doc-sub-menu nav flex-column">
                                        <a class="nav-link scrollto" href="#create-sub">Create</a>
                                        <a class="nav-link scrollto" href="#update-sub">Update</a>
                                        <a class="nav-link scrollto" href="#get-sub">Get Subscription</a>
                                        <a class="nav-link scrollto" href="#list-subs">List</a>
                                    </nav><!--//nav-->
                                <a class="nav-link scrollto" href="#ui-components">Miscellenous</a>
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