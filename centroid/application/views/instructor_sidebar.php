<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
        <div class="pull-left image">
            <img src="<?php echo ASSET_PATH;?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p><?php if(isset($_user_name['name']))echo $_user_name['name'];else echo $_user_name;?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
        </div>
		<?php //echo $selstudentdata[0]['idx'];?>
        <ul class="sidebar-menu" data-widget="tree">
            <?php
			if(isset($selstudentdata)){if(count($selstudentdata)){
			echo "<li class=\"treeview ".($content=="instructor/dailygame.php"?"active":"")." \">";
			}else{
			echo "<li ".($content=="instructor/dailygame.php"?"class=\"active\"":"").">";
			}}if(!isset($selstudentdata)){
			echo "<li ".($content=="instructor/dailygame.php"?"class=\"active\"":"").">";
			}?>
			  <a href="index" onclick="">
				<i class="fa fa-book"></i>
				<span><?php if(isset($sessiondata['studentx']))echo $sessiondata['studentx'];?> Daily game plan</span>
				<?php if(isset($selstudentdata))if(count($selstudentdata)){?>
				<span class="pull-right-container">
				  <i class="fa fa-angle-left pull-right"></i>
				</span>
				<?php }?>
			  </a>
			  <?php if(isset($selstudentdata)){?>
			  <ul class="treeview-menu" style="display: block;">
				<?php 
					if(!isset($sessiondata['idx']))$sessiondata['idx']="";
					$rcnt=0;$rn=count($selstudentdata);
					foreach($selstudentdata as $session){$datearr=explode("-",$session['datex']);$dates=$datearr[1]."-".$datearr[2];
						$rcnt++;
						$ssttrr="";$fff=0;
						for($i=1;$i<7;$i++)if($session["topic{$i}x"]!=""){$arr=explode("@",$session["topic{$i}x"]);
						if($fff>0)$ssttrr.= "<br>";
						$ssttrr.= "<small class=\"label pull-right bg-red\">".(strlen($arr[2])>4&&strlen($arr[1])>4?"...":substr($arr[2],0,5))."</small>";
						
						$ssttrr.= "<small class=\"label pull-right bg-green\">".(strlen($arr[2])>4&&strlen($arr[1])>4?substr($arr[1],0,7):substr($arr[1],0,5))."</small>";
						
						$ssttrr.= "<small class=\"label pull-right bg-yellow\">".substr($arr[0],0,3)."</small>";
						$fff++;
						//break;
					}
					if($fff==0)$fff=1;
					$het=$fff*20;
					if($rcnt==$rn)$het+=5;
					echo "<li ".($session['idx']==$sessiondata['idx']?" class=\"active\"":"")." style=\"height:".($het)."px;\"><a href=\"#\" onclick=\"goStudentAction('".$session['idx']."','".$session['studentidx']."','".$session['datex']."');\"><i class=\"fa fa-circle-o\"></i> {$dates}";
					echo "<span class=\"pull-right-container\">";
					echo $ssttrr;
					echo "</span>";
					echo "</a></li>";						
				}?>
			  </ul>
			  <?php }?>
			</li>
			<?php if($_user_sendable){?><li <?php if($content=="instructor/extrahomework.php") echo "class=\"active\"";?>><a href="<?php echo BASE_PATH?>/instructor/extrahomework"><i class="fa fa-meh-o"></i> <span>ExtraHomework</span></a></li><? }?>
			<?php
			$menu="<li class=\"treeview ".($content=="instructor/comment.php"||$content=="instructor/template_ex.php"||$content=="instructor/template_rm.php"||$content=="instructor/template_rs.php"||$content=="instructor/template_hm.php"||$content=="instructor/template_hs.php"||$content=="instructor/template_im.php"?"active":"")."\">".
					"<a href=\"index\">".
					"<i class=\"fa fa-share-alt\"></i>".
					"<span>Template</span>".
					"<span class=\"pull-right-container\">".
					"  <i class=\"fa fa-angle-left pull-right\"></i>".
					"</span>".
					"</a>".
					"<ul class=\"treeview-menu\" style=\"display: ".($content=="instructor/comment.php"||$content=="instructor/template_ex.php"||$content=="instructor/template_rm.php"||$content=="instructor/template_rs.php"||$content=="instructor/template_hm.php"||$content=="instructor/template_hs.php"||$content=="instructor/template_im.php"?"block":"").";\">".
					"	<li ".($content=="instructor/comment.php"?"class=\"active\"":"")."><a href=\"comment\" onclick=\"\"><i class=\"fa fa-circle-o\"></i>COMMENTS</a></li>".
					"	<li ".($content=="instructor/template_rm.php"?"class=\"active\"":"")."><a href=\"rmtemplate\" onclick=\"\"><i class=\"fa fa-circle-o\"></i>SESSION MESSAGE</a></li>".
					"	<li ".($content=="instructor/template_rs.php"?"class=\"active\"":"")."><a href=\"rstemplate\" onclick=\"\"><i class=\"fa fa-circle-o\"></i>SESSION SMS</a></li>".
					($_user_sendable?"	<li ".($content=="instructor/template_hm.php"?"class=\"active\"":"")."><a href=\"hmtemplate\" onclick=\"\"><i class=\"fa fa-circle-o\"></i>HOMEWORK MESSAGE</a></li>":"").
					($_user_sendable?"	<li ".($content=="instructor/template_hs.php"?"class=\"active\"":"")."><a href=\"hstemplate\" onclick=\"\"><i class=\"fa fa-circle-o\"></i>HOMEWORK SMS</a></li>":"").
					"	<li ".($content=="instructor/template_im.php"?"class=\"active\"":"")."><a href=\"imtemplate\" onclick=\"\"><i class=\"fa fa-circle-o\"></i>INTERNAL MESSAGE</a></li>".
					($_user_sendable?"	<li ".($content=="instructor/template_ex.php"?"class=\"active\"":"")."><a href=\"extemplate\" onclick=\"\"><i class=\"fa fa-circle-o\"></i>EXTRA MESSAGE</a></li>":"").
					//"	<li><a href=\"sessionsmstemplate\" onclick=\"\"><i class=\"fa fa-circle-o\"></i>LOCATION ADDRESS</a></li>".
					"</ul>".
			      "</li>";
			echo $menu;
			?>
			
            <li <?php if($content=="instructor/report.php")echo "class=\"active\"";?>><a href="reportexe"><i class="fa fa-twitter"></i> <span>Report</span></a></li>
            <!--li><a href="excelimport"><i class="fa fa-book"></i> <span>Admin Section</span></a></li-->
			<li><a href="controlpanel"><i class="fa fa-gear"></i> <span>Control Panel</span></a></li>
            <li><a href="<?php echo BASE_PATH?>/login/signout"><i class="fa fa-sign-out"></i> <span>Log Out</span></a></li>
        </ul>
    </section>
</aside>