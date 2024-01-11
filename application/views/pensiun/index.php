<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage
        <small>Pensiun</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pensiun</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      <div class="col-md-12 col-xs-12">
          <?php
          
          if ($this->session->flashdata('success')) :
              echo '<div class="alert alert-success alert-dismissible" role="alert">';
              echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
              echo $this->session->flashdata('success');
              echo '</div>';
          endif;

          
          if ($this->session->flashdata('error')) :
              echo '<div class="alert alert-error alert-dismissible" role="alert">';
              echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
              echo $this->session->flashdata('error');
              echo '</div>';
          endif;?>
          <?php if (in_array('createPensiun', $user_permission)) : ?>
            <a href="<?php echo base_url('pensiun/create') ?>" class="btn btn-primary">Tambah Data Pensiun</a>
            <br /> <br />
          <?php endif; ?>


          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Pensiun</h3>
            </div>
            <!-- /.box-header -->
            <div class="responsive" style="overflow-y: auto; max-height: 440px;">
            <table id="pensiunTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                <th>No</th>
                  <th>Tahun Pensiun</th>
                  <th>Upload File</th>
                
                  <?php if(in_array('updatePensiun', $user_permission) || in_array('deletePensiun', $user_permission)): ?>
                  <th>Aksi</th>
                  <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                  <?php if($psn_data): ?>  
                   <?php $no = 1; ?>                
                    <?php foreach ($psn_data as $k => $v): ?>
                      <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $v['psn_info']['tahun_pensiun']; ?></td>           
                      <td>
                          <img style="width: 100px;" src="<?php echo base_url().$v['psn_info']['upload_file']; ?>" alt="">
                      </td>

        <?php if(in_array('updatePensiun', $user_permission) || in_array('deletePensiun', $user_permission)): ?>
            <td>
                <?php if(in_array('updatePensiun', $user_permission)): ?>
                    <a href="<?php echo base_url('pensiun/edit/'.$v['psn_info']['Id']) ?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
                <?php endif; ?>
                          <?php if (in_array('deletePensiun', $user_permission)): ?>
                            <a href="javascript:void(0);" class="btn btn-default" onclick="confirmDelete(<?php echo $v['psn_info']['Id']; ?>)">
                                <i class="fa fa-trash"></i>
                                <a href="<?php echo base_url().$v['psn_info']['upload_file']; ?>" target="_blank" class="btn btn-default"><i class="fa fa-image"></i></a>
                            </a>
                        <?php endif; ?>
                          </td>
                      <?php endif; ?>
                      </tr>
                      <?php $no++; 
                      endforeach ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <?php
          $this->session->mark_as_temp('success', 1);
          $this->session->mark_as_temp('error', 1);
          ?>
          <!-- /.box -->
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    $(document).ready(function() {
      $('#pensiunTable').DataTable({
        'order' : [],
        });

      $("#pensiunMainNav").addClass('active');
      $("#managePensiunSubNav").addClass('active');
    });
  </script>
  <script>
  function confirmDelete(itemId) {
      var confirmDelete = confirm("Apakah Anda yakin ingin menghapus?");

      if (confirmDelete) {
          var xhr = new XMLHttpRequest();
          var url = "<?php echo base_url('pensiun/delete/'); ?>" + itemId;

          xhr.open("POST", url, true);
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

          xhr.send("confirm=true");
          
          xhr.onreadystatechange = function () {
              if (xhr.readyState === 4) {
                  if (xhr.status === 200) {
                      
                      alert("Data berhasil dihapus!");

                      
                      window.location.reload();
                  } else {
                      
                      alert("Error occurred!");
                  }
              }
          };
      } else {
          
      }
  }
  </script>