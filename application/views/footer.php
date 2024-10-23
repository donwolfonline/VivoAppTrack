<footer class="main-footer">
   <strong>Developed By <a href="http://frederickdineen.com" target="_blank">Frederick Dineen</a>.</strong>
   <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 6.0
   </div>
</footer>
</div>
</div>
<script src="<?= base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/dist/js/adminlte.js"></script>
<script src="<?= base_url(); ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<?php $CI = get_instance(); $last = $CI->uri->total_segments();  $seg = $CI->uri->segment($last);  if(is_numeric($seg)) { $seg = $CI->uri->segment($last-1); } ?>
<script src="<?= base_url(); ?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<script src="<?= base_url(); ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/jscolor.js"></script>
<script src="<?= base_url(); ?>assets/plugins/selectize.min.js"></script>

<script src="<?= base_url(); ?>assets/plugins/datetimepicker/datetimepicker.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/datetimepicker/datetimepicker.css">



<script type="text/javascript">
   <?php if ($this->session->flashdata('successmessage')) { ?>
      const Toast = Swal.mixin({toast: true,position: 'top',showConfirmButton: false,timer: 5000});
      Toast.fire({
       type: 'success',
       title: '<?= $this->session->flashdata('successmessage'); ?>'
       });
   <?php if(isset($_SESSION['successmessage'])){
            unset($_SESSION['successmessage']);
        } } else if ($this->session->flashdata('warningmessage')) { ?>
       const Toast = Swal.mixin({toast: true,position: 'top',showConfirmButton: false,timer: 5000});
       Toast.fire({
       type: 'error',
       title: '<?= $this->session->flashdata('warningmessage'); ?>'
       });
   <?php if(isset($_SESSION['warningmessage'])){
            unset($_SESSION['warningmessage']);
        } } ?>
</script>
<?php 
   if($seg=='booking' || $seg=='incomeexpense' || $seg=='fuels' || $seg=='partsinventory' || $seg=='driversreport') {
   ?>
<script src="<?= base_url(); ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables/jszip.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables/vfs_fonts.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables/buttons.html5.min.js"></script>
<?php } 
   if($seg=='addgeofence' || $seg=='addtrips' || $seg=='geofence' || $seg == 'livestatus' || $seg == 'tracking') {
      $data = sitedata();
    ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript"
   src="https://maps.google.com/maps/api/js?key=<?php echo output($data['s_googel_api_key']); ?>&sensor=false&v=3.21.5a&libraries=drawing&signed_in=true&libraries=places,drawing"></script>
<script src="<?php echo base_url(); ?>assets/distance_calculator.js"></script>
<?php } ?>
<script src="<?= base_url(); ?>assets/custom.js?v=<?= mt_rand(); ?>"></script>
<?php 
   if($seg=='addgeofence') { ?>
<script src="<?php echo base_url(); ?>assets/geofence.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/css/select2-bootstrap4.min.css">
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.full.min.js"></script>
<script>$('.select2').select2()</script>
<?php } ?>
<?php 
   if($seg=='vehicleavailablity') { ?>
<script src="<?php echo base_url(); ?>assets/plugins/fullcalendar/fullcalendar.js"></script>
<?php } ?>
<script>
   $('#file').change(function(){
      var ext = $('#file').val().split('.').pop().toLowerCase();
      if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
         alert('Invalid file, only accepts gif,png,jpg,jpeg');
         this.value = '';
      }
   });
   $('#file1').change(function(){
      var ext = $('#file1').val().split('.').pop().toLowerCase();
      if($.inArray(ext, ['pdf','docx']) == -1) {
         alert('Invalid file, only accepts pdf,docx');
         this.value = '';
      }
   });

   $('.tr_clone_add').click(function(){
      var $tr    = $(this).closest('.tr_clone');
      var $clone = $tr.clone();
      $clone.find(':text').val('');
      $clone.find('.rm').remove();
      $clone.find('.adddelbtn').html('<button type="button" name="add" class="btn btn-danger btn-xs tr_clone_remove"><span class="fa fa-trash"></span></button>');
      $tr.after($clone);
      $('.tr_clone_remove').click(function(){
         $(this).closest('.tr_clone').remove();
      });
   });

   function addAddress() {
      $("#new").on("click", function() {
         var inc = $(".row_address").length + 1,
         $newAddressRow = `
               <div id="${inc}" class="row row_address col-sm-6" >
                     <input type="text" name="address" class="form-control" placeholder="Address...">
               <button class="remove">X</button>
            </div>
            `;

         $($newAddressRow).insertBefore($(this));
            var $newAddressInput = $("input[name='address']:last");
            $newAddressInput.focus();
            applySearchAddress($newAddressInput);
      });
   };

   function delAddress() {
      $(document).on("click", ".remove", function() {
         $(this).closest(".row_address").remove();
         $("#predictions_" + $(this).closest("div").attr("id")).remove();
      });
   };

   function applySearchAddress($input) {
      if (google.maps.places.PlacesServiceStatus.OK != "OK") {
      console.warn(google.maps.places.PlacesServiceStatus)
      return false;
      }
      var autocomplete = new google.maps.places.Autocomplete($input.get(0));
      
      setTimeout(function() {
      var rowId = $input.closest("div").attr("id");
      $(".pac-container:last").attr("id", "predictions_" + rowId);
      }, 100);
   };
   $(document).ready(function() {
      addAddress();
      delAddress();
   });



</script>
</body>
</html>