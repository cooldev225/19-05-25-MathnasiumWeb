<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
        <div class="pull-left image">
            <img src="<?php echo ASSET_PATH;?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p><?php echo $_user_name['name'];?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
        </div>
		
        <ul class="sidebar-menu" data-widget="tree">
            <li><a href="index"><i class="fa fa-book"></i> <span>Studen Report</span></a></li>
			<li><a href="controlpanel"><i class="fa fa-gear"></i> <span>Control Panel</span></a></li>
            <li><a href="<?php echo BASE_PATH?>/login/signout"><i class="fa fa-sign-out"></i> <span>Log Out</span></a></li>
        </ul>
    </section>
</aside>