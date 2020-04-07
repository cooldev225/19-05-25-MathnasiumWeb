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
             <?php if($_user_name['role']){?>
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <h3 class="box-title">Select student Excel file</h3>
                    </div>
                    <form role="form" class="form-horizontal" action="<?php echo BASE_PATH;?>/administrator/importStudent/0" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="col-sm-2 control-label">Select File</label>
                                <div class="col-sm-10">
                                    <input type="file" id="studentfile" name="studentfile" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <h3 class="box-title">Account Excel file</h3>
                    </div>
                    <form role="form" class="form-horizontal" action="<?php echo BASE_PATH;?>/administrator/importStudent/1" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="col-sm-2 control-label">Select File</label>
                                <div class="col-sm-10">
                                    <input type="file" id="accountfile" name="accountfile" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <h3 class="box-title">Guardian Excel file</h3>
                    </div>
                    <form role="form" class="form-horizontal" action="<?php echo BASE_PATH;?>/administrator/importStudent/2" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="col-sm-2 control-label">Select File</label>
                                <div class="col-sm-10">
                                    <input type="file" id="guardianfile" name="guardianfile" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
			<?php }else if($_user_name['role']==0){?>
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <h3 class="box-title">IXL URL Excel file</h3>
                    </div>
                    <form role="form" class="form-horizontal" action="<?php echo BASE_PATH;?>/administrator/importStudent/3" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="col-sm-2 control-label">Select File</label>
                                <div class="col-sm-10">
                                    <input type="file" id="ixlfile" name="ixlfile" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
			<?php }?>
        </div>
    </section>

  </div>
  

