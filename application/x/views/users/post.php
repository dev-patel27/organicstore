<!-- INCLUDE HEADER -->
<?php $this->load->view('includes/header'); ?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
<!-- BEGIN SIDEBAR -->
<?php $this->load->view('includes/sidebar'); ?>
<!-- END SIDEBAR -->
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">

<div class="page-content" >
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<span><?= ucfirst($this->router->fetch_class()); ?></span>
				<i class="fa fa-circle"></i>
			</li>
			<li>
				<span>Add</span>
			</li>
		   
		</ul>
		
	</div>
                
	<div class="row">
        <div class="portlet light">
                   
            <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                <form action="<?= current_url(); ?>" id="form_sample_3" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button> You have some form errors. Please check below.
                    </div>					
					<div class="form-body">						
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3">Department
										 <span class="required"> * </span>
									</label>
									<div class="col-md-9">
										<div class="input-icon right">
											<i class="fa"></i>
											<select class="table-group-action-input form-control" name="role_id" width="100%" id="role_id" class="required">
                                            <option value="">Select Department</option>
                                             <?php
                                            $user = $this->admin_model->get_users();
                                           	foreach($user as $row)
                                            {
                                            	echo '<option value="'.$row['id'].'">'.$row['type_name'].'</option>';
                                            }
                                            ?>                                           
                                            </select>
										</div>
									</div>
								</div>
							</div>
						</div>						
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3">Manager Name
										 <span class="required"> * </span>
									</label>
									<div class="col-md-9">
										<div class="input-icon right">
											<i class="fa"></i>
											<input type="text" class="required form-control " placeholder="Name" name="name" id="name"  />
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3">Email
										 <span class="required"> * </span>
									</label>
									<div class="col-md-9">
										<div class="input-icon right">
											<i class="fa"></i>
											<input type="email" class="required form-control " placeholder="Email Id" name="email" id="email"  />
										</div>
									</div>
								</div>
							</div>
						</div>	
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3">Password
										 <span class="required"> * </span>
									</label>
									<div class="col-md-9">
										<div class="input-icon right">
											<i class="fa"></i>
											<input type="password" class="required form-control " placeholder="Password" name="password" id="password"  />
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3">Mobile Number
										 <span class="required"> * </span>
									</label>
									<div class="col-md-9">
										<div class="input-icon right">
											<i class="fa"></i>
											<input type="text" class="required form-control " placeholder="Mobile Numbers" name="mobile_number" id="mobile_number"  />
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3">Address
										 <span class="required"> * </span>
									</label>
									<div class="col-md-9">
										<div class="input-icon right">
											<i class="fa"></i>
											<textarea class="required form-control " name="address" id="address"></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3">Alternate Mobile no.
										 <span class="required"> * </span>
									</label>
									<div class="col-md-9">
										<div class="input-icon right">
											<i class="fa"></i>
											<input type="text" class="required form-control " placeholder="Alternate Mobile Numbers" name="alternate_mobile_number" id="alternate_mobile_number"  />
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="control-label col-md-3">Manager Image
                                 <span class="required"> * </span>
                                 </label>
                                 <div class="col-md-9">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input type="file" class="required form-control" placeholder="" name="manager_image" id="file" />
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
	
					</div>
					<div class="form-actions">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<button class="btn green" type="submit">Submit</button>
										<button class="btn default" type="button">Cancel</button>
									</div>
								</div>
							</div>
							<div class="col-md-6"> </div>
						</div>
					</div>
                </form>
                        <!-- END FORM-->
            </div>
        </div>
    </div>
                </div>
            </div>
        </div>



<!-- INCLUDE FOOTER -->
<?php $this->load->view('includes/inner_footer'); ?>
<?php $this->load->view('includes/form_js'); ?>
<?php
$jsArray = array(
    'ckeditor/ckeditor.js',

);
echo $this->headerlib->put_js( $jsArray );
?>
<script>
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace( 'summernote_1' );
    CKEDITOR.replace( 'summernote_2' );
  
</script>
<?php $this->load->view('includes/footer'); ?>


