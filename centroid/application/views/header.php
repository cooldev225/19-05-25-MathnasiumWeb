<?php 
$name="";
if(isset($_user_name['name']))$name=$_user_name['name'];
?>
<header class="main-header">
    <a href="index2.html" class="logo">
      <span class="logo-lg"><img src="<?php echo IMAGE_PATH?>logo.png" style="width: 105px;"></span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <?php if($centerpermission!=""){?>
          <select id="headercenter" onchange="location.href='chgcenter?c='+$('#headercenter').val()+'&p=<?php echo $content;?>';" style="font-size: 27px;background-color: #3c8dbc;color: white;margin-top: 7px;">
          <?php 
            foreach(explode("###",$centerpermission) as $c){
                echo "<option ".($_now_user['center']==$c?"selected":"").">{$c}</option>";
            }
          ?>    
          </select>
      <?php }?>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
    
    <script>
        function loginAction(f,email,role,pass,center,name){
            if(f!='')return;
            $('#name').val(name);
            $('#email').val(email);
            $('#role').val(role);
            $('#password').val(pass);
            $('#center').val(center);
            $('#loginfrm').submit();
        }
    </script>      
    <form action="<?php echo BASE_PATH?>/login/signin" method="post" id="loginfrm">
        <input type="hidden" name="name" id="name"/>
        <input type="hidden" name="email" id="email"/>
        <input type="hidden" name="iflag" id="iflag" value="internal_login"/>
        <input type="hidden" name="password" id="password"/>
        <input type="hidden" id="role" name="role"/>
        <input type="hidden" id="center" name="center"/>
    </form>
    <?php //echo count($_cross_user);
        $rolestr=explode(",","SA,LA,Instructor,Parent");
        if(count($_cross_user)){
      $html="<li class=\"dropdown messages-menu\">";
      $html.="  <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">";
      $html.="     <i class=\"fa fa-cubes\"></i>";
      $html.="     <span class=\"label label-success\">".count($_cross_user)."</span>";
      $html.="  </a>";
      $html.="  <ul class=\"dropdown-menu\">";
      $html.="      <li class=\"header\" style=\"font-weight: bold;\">You can access with ".count($_cross_user)." each other users.</li>";
        foreach($_cross_user as $cuser){if($_now_user['name']==$cuser['name']&&$_now_user['email']==$cuser['email']&&$_now_user['role']==$cuser['role']&&$_now_user['center']==$cuser['center'])$nowf="background-color: #d2d6de;";else $nowf="";
      $html.="      <li style=\"{$nowf}\">";
      $html.="        <ul class=\"menu\">";
      $html.="          <li>";
      $html.="            <a href=\"#\" onclick=\"loginAction('{$nowf}','{$cuser['email']}','{$cuser['role']}','{$cuser['password']}','{$cuser['center']}','{$cuser['name']}');\">";
      $html.="              <div class=\"pull-left\"><i class=\"fa fa-database\"></i>";//    
      //$html.="          <!--img src=" //echo ASSET_PATH;dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"-->fa-database   fa-binoculars   cubes
      $html.="              </div>";
      $html.="              <h4>";
      $html.="{$cuser['center']} {$rolestr[$cuser['role']]}";
      $html.="                <small style=\"top: -10px;\"><i class=\"fa fa-clock-o\"></i>{$cuser['last_visited_time']}</small>";
      $html.="              </h4>";
      $html.="              <p>".($nowf==""?"Do you want to log in again now?":"loged in now.")."</p>";
      $html.="             </a>";
      $html.="          </li>";
      $html.="        </ul>";
        }
      $html.="      </li>";
      $html.="  </ul>";
      $html.="</li>";
      
      if(count($_cross_user)>1)echo $html;
        }
     ?> 
            
          
          <!--li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <ul class="menu">
                  <li>
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li-->
          <!--li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo ASSET_PATH;?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $name;?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="<?php echo ASSET_PATH;?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo $name;?>
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li-->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  
  
  
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
          
      </div>
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <!--div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div-->
        </form>
      </div>
    </div>
  </aside>