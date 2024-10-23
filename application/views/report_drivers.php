<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Drivers Report
            </h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>reports">Report</a></li>
               <li class="breadcrumb-item active">Drivers Report</li>
            </ol>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <form method="post" id="fuel_report" class="card basicvalidation" action="<?php echo base_url();?>reports/driversreport">
         <div class="card-body">
            <div class="row">
               <div class="col-md-3">
                  <div class="form-group row">
                     <label for="r_from" class="col-sm-5 col-form-label">Report From</label>
                     <div class="col-sm-6 form-group">
                        <input type="text" required="true" class="form-control form-control-sm datepicker" value="<?php echo isset($_POST['r_from']) ? $_POST['r_from'] : ''; ?>" id="r_from" name="r_from" placeholder="Date From">
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group row">
                     <label for="r_to" class="col-sm-5 col-form-label">Report To</label>
                     <div class="col-sm-6 form-group">
                        <input type="text" required="true" class="form-control form-control-sm datepicker" value="<?php echo isset($_POST['r_to']) ? $_POST['r_to'] : ''; ?>" id="r_to" name="r_to" placeholder="Date To">
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group row">
                     <label for="booking_to" class="col-sm-3 col-form-label">Drivers</label>
                     <div class="col-sm-8 form-group">
                        <select required="true" id="d_id"  class="form-control selectized"  name="d_id">
                           <option value="all">All Drivers</option>
                           <?php foreach ($dlist as $key => $driver) { ?>
                           <option <?php echo (isset($_POST['driverreport']) && ($_POST['d_id'] == $driver['d_id'])) ? 'selected':'' ?> value="<?php echo output($driver['d_id']) ?>"><?php echo output($driver['d_name']).' - '. output($driver['d_id']); ?></option>
                           <?php  } ?>
                        </select>
                     </div>
                  </div>
               </div>
               <input type="hidden" id="driverreport" name="driverreport" value="1">
               <div class="col-md-2">
                  <button type="submit" class="btn btn-block btn-outline-info btn-sm"> Generate Report</button>
               </div>
            </div>
         </div>
   </div>
   </form>
    <div class="card">
        <div class="card-body p-0">
            <?php if(!empty($drivers)){ 
             ?>
                   <table  class="datatableexport table card-table">
                      <thead>
                        <tr>
                          <th class="w-1">S.No</th>
                           <th>Booking Date</th>
                          <th>From</th>
                          <th>To</th>
                          <th>Distance</th>
                          <th>Vehicle</th>
                           <th>Driver Name</th>
                          <th>Created Date</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php if(!empty($drivers)){  $count=1;
                           foreach($drivers as $dridata){
                           ?>
                        <tr>
                           <td> <?php echo output($count); $count++; ?></td>
                            <td> <?php echo output($dridata['t_start_date']); ?></td>
                           <td> <?php echo output($dridata['t_trip_fromlocation']); ?></td>
                           <td> <?php echo output($dridata['t_trip_tolocation']); ?></td>
                           <td><?php echo output($dridata['t_totaldistance']); ?></td>
                           <td><?php echo output($dridata['t_vechicle_details']->v_registration_no); ?></td>
                           <td><?php echo output($dridata['t_driver_details']->d_name); ?></td>
                           <td><?php echo output($dridata ['t_created_date']); ?></td>
                        </tr>
                        <?php } } ?>
                      </tbody>
                    </table>
                     <?php }  ?>
        </div>
      </div>
   </div>
</section>
