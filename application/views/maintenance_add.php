<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Vehicle Maintenance
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Vehicle Maintenance</li>
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
              <form id="addnewcategory" class="basicvalidation" role="form" action="<?php echo base_url();?>maintenance/<?php echo (isset($maintenancedetails))?'updatemaintenance':'insertmaintenance'; ?>" method="post"  enctype='multipart/form-data'>
                <div class="card-body">
                  
                <?php if(isset($maintenancedetails)) { ?>
                                 <input type="hidden" name="r_id" id="r_id" value="<?php echo (isset($maintenancedetails)) ? $maintenancedetails[0]['r_id']:'' ?>" >
                                 <?php } ?>
                  <div class="form-group">
                     <label>Select Vehicle</label>
                     <select id="m_v_id"  class="form-control " required=""  name="m_v_id" >
                                          <option value="">Select Vehicle</option>
                                          <?php  foreach ($vechiclelist as $key => $vechiclelists) { ?>
                                          <option <?php if((isset($maintenancedetails)) && $maintenancedetails[0]['m_v_id'] == $vechiclelists['v_id']){ echo 'selected';} ?> value="<?php echo output($vechiclelists['v_id']) ?>"><?php echo output($vechiclelists['v_name']).' ['. output($vechiclelists['v_registration_no']).']'; ?></option>
                                          <?php  } ?>
                                       </select>

                  </div>
                  <div class="row">
                  <div class="col-sm-6 col-md-offset-2 ">
                  <div class="form-group">
                    <label>Maintenance Start Date</label>
                    <input type="text" autocomplete="off" placeholder="Choose start date" name="m_start_date" required="true" class="form-control datepicker">
                  </div>
                   </div>
                   <div class="col-sm-6 col-md-offset-2 ">
                  <div class="form-group">
                    <label>Maintenance End Date</label>
                    <input type="text" name="m_end_date" autocomplete="off" required="true" placeholder="Choose end date" class="form-control datepicker">
                  </div>
                  </div>
                  </div>
                   <div class="form-group">
                    <label>Service Details</label>
                    <textarea class="form-control" id="m_service_info" autocomplete="off" required="true" placeholder="Details"  name="m_service_info"><?php echo (isset($maintenancedetails)) ? $maintenancedetails[0]['r_message']:'' ?></textarea>
                  </div>
                  <div class="row">
                  <div class="col-sm-6 col-md-offset-2 ">
                  <div class="form-group">
                    <label>Total Cost</label>
                    <input type="text" autocomplete="off" name="m_cost" placeholder="Total Cost" class="form-control number">
                  </div>
                  </div>
                  <div class="col-sm-6 col-md-offset-2 ">
                  <div class="form-group">
                    <label>Vendor Name</label>
                    <input type="text" class="form-control" name="m_vendor" placeholder="Vendor Name">
                  </div>
                  </div>
                  </div>

                  <div class="row tr_clone">
                  <div class="col-sm-7 col-md-offset-2 ">
                  <div class="form-group">
                    <label>Parts Name</label>
                    <select class="selectemployee form-control" name="pu_p_id[]"  id="pu_p_id" >
                    <option value="">Select Parts</option>
                      <?php  if(!empty($partsinventory)){  foreach($partsinventory as $pi){  ?>
                      <option value="<?= $pi['p_id']; ?>"><?= $pi['p_name']; ?></option>
                      <?php } } ?>
                    </select>
                  </div>
                  </div>
                  <div class="col-sm-3 col-md-offset-2 ">
                  <div class="form-group">
                    <label>Qty</label>
                    <select class="selectemployee form-control" name="pu_qty[]"  id="pu_qty" >
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>   
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    </select>
                  </div>
                  </div>   
                  <div class="col-sm-2 col-md-offset-2 ">
                  <div class="form-group adddelbtn"> 
                  <button type="button" name="add" class="btn btn-success btn-xs rm tr_clone_add"><span class="fa fa-plus"></span></button>
                </div>
                  </div>                        
                </div>   

                  <div class="form-group">
                    <label>Maintenance Status</label>
                    <select name="m_status" id="m_status" class="form-control" required="true">
                                 <option value="">Choose Maintenance Status</option>
                                 <option value="planned">Planned</option>
                                <option value="inprogress">InProgress</option>
                                <option value="completed">Completed</option>
                               </select>
                  </div>

                
                   
               
                    <div class="float-left">
                    
                    <button type="submit" class="btn btn-primary">Save</button>
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

