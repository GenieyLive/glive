<?php
if(!isset($_GET['id']))
{
header("location: viewLogs.php"); 
}
?>
<?php require("../etc/header.php"); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Logs
            <small> Everything in Geniey-IoT</small>
          </h1>
        <!--   <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
            <li class="active">Here</li>
          </ol> -->
        </section>

        <!-- Main content -->
        <section class="content">

           <div class="row">
             <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Loading Table Content</th>
                      </tr>
                    </thead>
                    <tbody id="">
                      <tr>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require("../etc/footer.php"); ?>
<script src="../dist/js/pages/viewDLogs.js"></script>
<script type="text/javascript">
getDLogs(<?php echo $_GET['id'];   ?>);
</script>