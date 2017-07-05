
  <?php
    include('../header.php');
    include('../sidebar.php');
    include('../dbconfig.php');
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Despatch Request - List
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <table id="grn_table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>S. No.</th>
                <th>PDR ID</th>
                <th>SAC/PAR</th>
                <th>Client Web</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $select_query = "SELECT * FROM despatch_request";
                $result = mysqli_query($dbc,$select_query);
                $row_counter = 0;
                if(mysqli_num_rows($result) > 0) {
                  $dataTableFlag = true;
                  while($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>".++$row_counter."</td>";
                    echo "<td>".$row['pdr_id']."</td>";
                    echo "<td>".strtoupper($row['sac_par_table']).": ".$row['sac_par_id']."</td>";
                    echo "<td>".$row['client_web']."</td>";
                    echo "<td><a href='pdr-edit.php?pdr_id=".$row['pdr_id']."'>View</a></td>";
                    echo "</tr>";
                  }
                } else {
                  $dataTableFlag = false;
                  echo "<tr><td colspan=\"6\">No Job Orders available. <a href=\"job-order-unloading-create.php\">Create one</a> now</td></tr>";
                }
              ?>
            </tbody>
          </table>
        </div>
        </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
    include('../footer_imports.php');
    include('../footer.php');
  ?>
  
  <script>
    $(function () {
      <?php if($dataTableFlag) { ?>
        $("#grn_table").DataTable();
      <?php } ?>
    });
  </script>
