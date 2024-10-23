    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Maintenance
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Maintenance</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
    <div class="card">

        <div class="card-body p-0">
          

         <div class="table-responsive">
                    <table id="incomexpensetbl" class="table card-table">
                      <thead>
                      <tr>
                          <th class="w-1">S.No</th>
                          <th>Vehicle</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Service Info</th>
                          <th>Vendor</th>
                          <th>Cost</th>
                          <th>Status</th>
                          <th>#</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php if(!empty($maintenancelist)){  $count=1;
                           foreach($maintenancelist as $maintenancelists){
                           ?>
                        <tr>
                           <td> <?php echo output($count); $count++; ?></td>
                           <td> <?php echo output($maintenancelists['v_name']); ?></td>
                           <td> <?php echo output(date(dateformat(), strtotime($maintenancelists['m_start_date']))); ?></td>
                           <td><?php echo output(date(dateformat(), strtotime($maintenancelists['m_end_date']))); ?> </td>
                           <td><?php echo output($maintenancelists['m_service_info']); ?>
                           <?php
                           if(!empty($maintenancelists['partsused'])){
                            echo '<br>';
                            foreach($maintenancelists['partsused'] as $partsused){
                                echo $partsused['p_name'].' - '.$partsused['pu_qty'];
                                echo '<br>';
                            }
                           }
                           ?>
                          </td>
                           <td><?php echo output($maintenancelists['m_vendor']); ?></td>
                           <td><?php echo sitedata()['s_price_prefix'].output($maintenancelists['m_cost']); ?></td>
                           
                          
                           <td>
                           <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" style="height: 29px;font-size: 11px;width: 100px;" name="m_status" id="m_status" class="input-sm form-control" required="true">
                                 <option value="maintenance/updatemaintenance/<?= $maintenancelists['m_id'] ?>/planned" <?= ($maintenancelists['m_status']=='planned')?'selected':''; ?> value="planned">Planned</option>
                                <option value="maintenance/updatemaintenance/<?= $maintenancelists['m_id'] ?>/inprogress" <?= ($maintenancelists['m_status']=='inprogress')?'selected':''; ?> value="inprogress">InProgress</option>
                                <option value="maintenance/updatemaintenance/<?= $maintenancelists['m_id'] ?>/completed" <?= ($maintenancelists['m_status']=='completed')?'selected':''; ?> value="completed">Completed</option>
                               </select>
                           </td>
                           <td>
                             <a data-toggle="modal" onclick="confirmation('<?php echo base_url(); ?>maintenance/deletemaintenance','<?= output($maintenancelists['m_id']); ?>')" data-target="#deleteconfirm" class="cursor px-3 text-danger" data-toggle="tooltip" data-placement="top"><i class="fas fa-trash-restore arrow"></i></a>
                          </td>
                        </tr>
                        <?php } } ?>
                      </tbody>
                    </table>
                   
        </div>         
        </div>
        <!-- /.card-body -->
      </div>
      
             </div>
    </section>
    <!-- /.content -->



