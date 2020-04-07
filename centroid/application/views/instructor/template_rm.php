<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?php echo "<font stype='font-weight:bold;'>".$_user_location."</font>";?> Session Message Template
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
	 <div class="row">
        <div class="col-md-6">
			<div class="alert alert-info alert-dismissible ">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4>_STUDENTNAME_</h4>
					&nbsp;&nbsp;&nbsp;&nbsp;Student name on top of GamePlan page.
					<h4>_PARENTNAME_</h4>
					&nbsp;&nbsp;&nbsp;&nbsp;Main account parent's first name based on student name on top of GamePlan page.
				  </div>
		</div>
	    <div class="col-md-6">
			<div class="alert alert-info alert-dismissible ">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4>_FIXEDBODY_</h4>
					&nbsp;&nbsp;&nbsp;&nbsp;Fixed message body picked from database of GamePlan page.
					<?php if($_now_user['role']>0){?>
					&nbsp;COMMENTS:<select onchange="dropimtempaction(0)" class="form-control select2" style="width:280px;" name="dropimtemp" id="dropimtemp">
						<?php foreach($templatedata[0] as $r){
								echo "<option>{$r['textx']}</option>";
						}?>
						<option></option>
					</select>
					<? }?>
					<h4>_CHECKOUTNAME_</h4>
					&nbsp;&nbsp;&nbsp;&nbsp;Check Out Instructor Name from GamePlan Page.
				  </div>
		</div>
	</div>
	
        <div class="box box-info">
            <div class="row">
				<div class="col-sm-6">
					<div class="box">
						<div class="box-header">
						  <h3 class="box-title">SESSION MESSAGE TEMPLATE
							<!--small>Simple and fast</small-->
						  </h3>
						  <!-- tools box -->
						  <div class="pull-right box-tools">
							<!--button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
							  <i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
									title="Remove">
							  <i class="fa fa-times"></i></button-->
							<button type="button" onclick="saveAction(4);" data-toggle="modal" class="btn btn-block btn-primary " data-target="#modal-success">SAVE</button>
							</div>
						</div>
						<!-- /.box-header -->
						
						<div class="box-body pad"  style="min-height:400px;">
						  <form>
							<textarea id="body" class="textarea" placeholder="Place some text here" style="width: 100%; height:400px;  font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php
								if(!isset($templatedata[4]['textx'])){if(!isset($stemplatedata[4]['textx']))echo "There is no data.";else echo $stemplatedata[4]['textx'];}
								else echo $templatedata[4]['textx'];
							?>
							</textarea>
						  </form>
						</div>
					</div>
				</div>
                <div class="col-sm-6" style="border-left: 1px dashed #d6d8d8;" id="previewpanel">
					  <!-- small box -->
					  <div class="small-box bg-primary">
						<div class="inner">
						  <h3>TODAY'S SESSION REPORT MESSAGE</h3>
						  <!--p>SESSION REPORT TO arupkuma86@gmail.com ON 06/03/2019</p-->
						  
						</div>
						<div class="icon">
						  <i class="ion ion-email"></i>
						</div>
						<div id="preview" style="min-height:420px;">
							<p><?php if(!isset($templatedata[4]['textx']))echo "There is no data.";
								else echo str_replace("\n","<br>",$templatedata[4]['textx']);?></p>
						</div>
						<a href="#" class="small-box-footer">
						  
						</a>
					  </div>
				</div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo ASSET_PATH;?>pages/instructor/template.js"></script>