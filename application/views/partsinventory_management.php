    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Parts Inventory
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Parts Inventory</li>
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
                    <table class="table card-table datatable">
                      <thead>
                      <tr>
                          <th class="w-1">S.No</th>
                          <th>Name</th>
                          <th>Description</th>
                          <th>Stock</th>
                          <th>Status</th>
                          <th>#</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php if(!empty($partsinventorylist)){  $count=1;
                           foreach($partsinventorylist as $pi){
                           ?>
                        <tr>
                           <td><?php echo output($count); $count++; ?></td>
                           <td><?php echo output($pi['p_name']); ?></td>
                           <td><?php echo output($pi['p_desc']); ?></td>
                           <td><?php echo output($pi['p_stock']); ?></td>
                           <td><span class="badge <?php echo ($pi['p_status']==1) ? 'badge-success' : 'badge-danger'; 
                            ?>"><?php echo ($pi['p_status']==1) ? 'Active' : 'Inactive'; ?></span></td>  
                            <td>
                            <a class="icon" href="<?php echo base_url(); ?>partsinventory/editparts/<?php echo output($pi['p_id']); ?>">
                           <i class="fa fa-edit"></i>
                           </a>
                           |
                                <a data-toggle="modal" href="" onclick="confirmation('<?php echo base_url(); ?>partsinventory/deletepartsinventory/','<?php echo 
                                  output($pi['p_id']); ?>')" data-target="#deleteconfirm" class="icon" ><i class="fa fa-trash text-danger"></i> </a>    
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



