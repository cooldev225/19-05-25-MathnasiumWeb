  <div class="content-wrapper">
    <section class="content-header">
      <h1>
    <?php //if(isset($error))if($error!="")echo $error;echo "sdfs";?>
        <?php if($_user_name['role']>0) echo "<font stype='font-weight:bold;'>".$_user_name['center']."</font>";else echo "Super Admin";?> Import Excel
    
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <h3 class="box-title">Select student Excel file</h3>
                    </div>
                    <form role="form" class="form-horizontal" action="<?php echo BASE_PATH;?>/administrator/sendsmsaction" method="post">
                        <input type="text" id="sid" value="<?php echo $sid111;?>" name="sid" placeholder="sid"/>
                        <input type="text" id="token" value="<?php echo $token;?>" name="token" placeholder="token"/>
                        <input type="text" id="fromnumber" value="<?php echo $fromnumber;?>" name="fromnumber" placeholder="fromnumber"/>
                        <input type="text" id="tonumber" name="tonumber" placeholder="tonumber"/>
                        <textarea id="smsbody" name="smsbody" style="    width: 691px;height: 100px;"></textarea>
                        <input type="submit"/>
                    </form>
                </div>
            </div>
        </div>
    </section>

  </div>
  

