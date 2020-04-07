
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="ninodezign.com, ninodezign@gmail.com">
  <meta name="copyright" content="ninodezign.com"> 
  <title>Sample</title>
  
  <!-- favicon -->
    <link rel="shortcut icon" href="<?php echo base_url();?>/assets/images/ico/favicon.jpg">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url();?>/assets/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url();?>/assets/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/<?php echo base_url();?>/assets/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url();?>/assets/images/ico/apple-touch-icon-57-precomposed.png">
  
  <!-- css -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/css/materialdesignicons.min.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/css/jquery.mCustomScrollbar.min.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/css/prettyPhoto.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/css/unslider.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/css/template.css" />
  
</head>

<body data-target="#nino-navbar" data-spy="scroll">

  <!-- Header
    ================================================== -->
  <header id="nino-header">
    <div id="nino-headerInner">         
      <nav id="nino-navbar" class="navbar navbar-default" role="navigation">
        <div class="container">

          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nino-navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url();?>/assets/homepage.html">PDW Develop</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="nino-menuItem pull-right">
            <div class="collapse navbar-collapse pull-left" id="nino-navbar-collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="<?php echo base_url();?>/assets/#nino-header"><i class="fa fa-home"></i>HOME <span class="sr-only">(current)</span></a></li>
                <li><a href="<?php echo base_url();?>/assets/#nino-story">ARTICLES</a></li>
                <li><a href="<?php echo base_url();?>/assets/#nino-services">VIDEOS</a></li>
                <li><a href="<?php echo base_url();?>/assets/#nino-ourTeam">COMMUNITY</a></li>
                <li><a href="<?php echo base_url();?>/assets/#nino-portfolio">SERIES</a></li>
                <li><a href="<?php echo base_url();?>/assets/#nino-latestBlog">SNIPPETS</a></li>
                <li><a href="<?php echo base_url();?>/assets/#nino-latestBlog">SPONSOR</a></li>
                <li><a href="<?php echo base_url();?>/assets/#nino-latestBlog">RSS</a></li>
              </ul>
            </div><!-- /.navbar-collapse -->
            <ul class="nino-iconsGroup nav navbar-nav">
              <li><a href="<?php echo base_url();?>/assets/#" class="nino-search"><i class="mdi mdi-magnify nino-icon"></i></a></li>
            </ul>
          </div>
        </div><!-- /.container-fluid -->
      </nav>

      <section id="nino-slider" class="carousel slide container" data-ride="carousel">
        
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <div class="item active">
            <h2 class="nino-sectionHeading">
              Welcome <br>to Tutorial
            </h2>
            <a href="<?php echo base_url();?>/assets/#" class="nino-btn">Learn more</a>
          </div>
          <div class="item">
            <h2 class="nino-sectionHeading">
              Welcome <br>to Tutorial
            </h2>
            <a href="<?php echo base_url();?>/assets/#" class="nino-btn">Learn more</a>
          </div>
          <div class="item">
            <h2 class="nino-sectionHeading">
              Welcome <br>to Tutorial
            </h2>
            <a href="<?php echo base_url();?>/assets/#" class="nino-btn">Learn more</a>
          </div>
          <div class="item">
            <h2 class="nino-sectionHeading">
              Welcome <br>to Tutorial
            </h2>
            <a href="<?php echo base_url();?>/assets/#" class="nino-btn">Learn more</a>
          </div>
        </div>

        <!-- Indicators -->
        <ol class="carousel-indicators clearfix">
          <li data-target="#nino-slider" data-slide-to="0" class="active">
            <div class="inner">
              <span class="number">01</span> intro  
            </div>
          </li>
          <li data-target="#nino-slider" data-slide-to="1">
            <div class="inner">
              <span class="number">02</span> tutorial
            </div>
          </li>
          <li data-target="#nino-slider" data-slide-to="2">
            <div class="inner">
              <span class="number">03</span> about
            </div>
          </li>
          <li data-target="#nino-slider" data-slide-to="3">
            <div class="inner">
              <span class="number">04</span> contacts
            </div>
          </li>
        </ol>
      </section>
    </div>
  </header><!--/#header-->

  