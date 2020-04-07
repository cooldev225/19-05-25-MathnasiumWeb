
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?php echo "<font stype='font-weight:bold;'>".$_user_center."</font>";?>  Comments
      </h1>
    <section class="content">
        <form method="post" id="refreshfrm" action="comment"><input type="hidden" id="_sel_tab" name="_sel_tab" value="<?php echo $_sel_tab;?>"></form>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
			  <li<?php if($_sel_tab==0)echo " class=\"active\"";?>><a href="#tab_1" data-toggle="tab" aria-expanded="false">GPP</a></li>
			  <li<?php if($_sel_tab==7)echo " class=\"active\"";?>><a href="#tab_2" data-toggle="tab" aria-expanded="false">Internal</a></li>
			</ul>
            <div class="tab-content">
                <div class="tab-pane <?php if($_sel_tab==0)echo " active";?>" id="tab_1">
                    <div class="box box-info">
                        <form class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">username</label>
                                    <div class="col-sm-8">
                                        <input type="mail" value="" class="form-control" id="gpp_add_0" placeholder="comment">
                                    </div>
                                    <div class="col-sm-1">
        							    <button type="button" onclick="addAction(0);" class="btn btn-info pull-right">Add</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <table id="example1" width="100%" class="table table-bordered table">
                                <thead>
                                    <tr>
                                        <th>Comment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
										foreach($commentdata as $r)if($r['typex']==0){
											echo "<tr>";
											echo "<td>{$r['textx']}</td>";
											echo "<td><button onclick=\"deleteAction(0,'{$r['idx']}');\" type=\"button\" class=\"btn bg-orange btn-xs\">delete</button></td>";
											echo "</tr>";
										}
                                    ?>
                                </tbody>
                            </table>
                                </div>
                            </div>
                            <div class="box-footer">
							<div class="col-sm-7"></div>
							<div class="col-sm-2">
							
							</div>
							
							</div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane <?php if($_sel_tab==7)echo " active";?>" id="tab_2">
                    <div class="box box-info">
                        <form class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">username</label>
                                    <div class="col-sm-8">
                                        <input type="mail" value="" class="form-control" id="gpp_add_7" placeholder="comment">
                                    </div>
                                    <div class="col-sm-1">
        							    <button type="button" onclick="addAction(7);" class="btn btn-info pull-right">Add</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <table id="example1" width="100%" class="table table-bordered table">
                                <thead>
                                    <tr>
                                        <th>Comment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
										foreach($commentdata as $r)if($r['typex']==7){
											echo "<tr>";
											echo "<td>{$r['textx']}</td>";
											echo "<td><button onclick=\"deleteAction(7,'{$r['idx']}');\" type=\"button\" class=\"btn bg-orange btn-xs\">delete</button></td>";
											echo "</tr>";
										}
                                    ?>
                                </tbody>
                            </table>
                                </div>
                            </div>
                            <div class="box-footer">
							<div class="col-sm-7"></div>
							<div class="col-sm-2">
							
							</div>
							
							</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
</div>

<script>
  $(function () {
    
  });
  function addAction(f){
      var res = $.ajax({
		url: "saveIMTemp",
		type: 'post',
		data: {
			body:$("#gpp_add_"+f).val(),
			type:f
		},
		dataType: "json",
		success: function( data ) {
		    $("#_sel_tab").val(f);
			$("#refreshfrm").submit();
		},
		error: function(e) {
			//alert(e);
		}
	});
	
  }
  function deleteAction(f,id){
      var res = $.ajax({
		url: "deleteIMTemp",
		type: 'post',
		data: {
			idx:id
		},
		dataType: "json",
		success: function( data ) {
		    $("#_sel_tab").val(f);
			$("#refreshfrm").submit();
		},
		error: function(e) {
			//alert(e);
		}
	});
}
</script>