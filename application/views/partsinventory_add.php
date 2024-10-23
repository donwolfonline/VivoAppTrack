  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Parts Management
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Parts Management</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
<section class="content">
  <div class="container-fluid">
  
<div class="card">
              
           <div class="row">
              <div class="col-sm-3"></div> 
                <div class="col-sm-6 col-md-offset-2 ">
              <form id="addnewcategory" class="basicvalidation" role="form" action="<?php echo base_url();?>partsinventory/<?php echo (isset($partsdetails))?'updatepartsinventory':'insertpartsinventory'; ?>" method="post"  enctype='multipart/form-data'>
                <div class="card-body">
                  
                <?php if(isset($partsdetails)) { ?>
                                 <input type="hidden" name="p_id" id="p_id" value="<?php echo (isset($partsdetails)) ? $partsdetails[0]['p_id']:'' ?>" >
                                 <?php } ?>
                
                  <div class="row">
               
                   <div class="col-sm-12 col-md-offset-2 ">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="p_name" value="<?php echo (isset($partsdetails)) ? $partsdetails[0]['p_name']:'' ?>" autocomplete="off" required="true" placeholder="Enter name of parts" class="form-control">
                  </div>
                  </div>
                  </div>
                   <div class="form-group">
                    <label>Parts Description</label>
                    <textarea class="form-control" id="p_desc" autocomplete="off" required="true" placeholder="Part description"  name="p_desc"><?php echo (isset($partsdetails)) ? $partsdetails[0]['p_desc']:'' ?></textarea>
                  </div>
                  <div class="row">
                  <div class="col-sm-12 col-md-offset-2 ">
                  <div class="form-group">
                    <label>Stock</label>
                    <input type="number" required="true" autocomplete="off" value="<?php echo (isset($partsdetails)) ? $partsdetails[0]['p_stock']:'' ?>" name="p_stock" placeholder="Total stocks available" class="form-control number">
                  </div>
                  </div>
                  </div>
                  <div class="form-group">
                    <label>Parts Status</label>
                    <select name="p_status" id="p_status" class="form-control" required="true">
                                 <option value="">Choose Status</option>
                                 <option <?php echo (isset($partsdetails[0]['p_status']) && $partsdetails[0]['p_status']=='1') ? 'selected':'' ?> value="1">Active</option>
                                <option <?php echo (isset($partsdetails[0]['p_status']) && $partsdetails[0]['p_status']=='0') ? 'selected':'' ?> value="0">InActive</option>
                               </select>
                  </div>
                    <div class="float-left">
                    <button type="submit" class="btn btn-primary"><?php echo (isset($partsdetails))?'Update':'Add' ?></button>
                  </div>
                </div>
              </form>
            </div>
            </div>
          </div>
</section>


<div class="modal fade show" id="modal-default" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Test SMTP Configuration</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
       <form   action="<?php echo base_url(); ?>settings/smtpconfigtestemail" method="post" >
      <div class="modal-body">
        <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
              <input type="email" required="true" class="form-control" id="testemailto" name="testemailto" placeholder="Enter email">
              </div>
            </div>            
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send Email</button>
      </div>
          </form>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>