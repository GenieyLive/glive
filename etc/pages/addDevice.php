<?php require("../etc/header.php"); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add New Devices
            <small>Geniey-IoT ptoduct</small>
          </h1>
        <!--   <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
            <li class="active">Here</li>
          </ol> -->
        </section>

        <!-- Main content -->
        <section class="content">

           <div class="row">
            <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Device Details</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <form role="form" id="deviceRegister">
                    <!-- text input -->
                      <div class="alert alert-success alert-dismissable" id="success-msg" style="display:none">
                      <i class="icon fa fa-check"></i>
                      </div>
                    <div class="form-group">
                      <label>Device Id</label>
                      <input type="text" class="form-control" id="deviceid" placeholder="Enter ..." required autocomplete=off />
                    </div>
                    <div class="form-group">
                      <label>Security key</label>
                      <input type="text" class="form-control" id="devicekey" placeholder="Enter ..." disabled  required />
                      <input type="button" class="btn bg-orange btn-flat margin" id="generateKey" value="Generate new Key" />
                    </div>                
                    <!-- input states -->
                    <div class="form-group">
                      <label class="control-label" for="inputSuccess" >Name</label>
                      <input type="text" class="form-control" id="username" placeholder="Enter Name..." autocomplete=off />
                    </div>
                    <div class="form-group">
                      <label class="control-label" for="inputWarning">Email</label>
                      <input type="text" class="form-control" id="useremail" placeholder="Enter Valid Email Id ..." autocomplete=off  />
                    </div>
                    <div class="form-group">
                      <label class="control-label" for="inputError" >Phone</label>
                      <input type="number" class="form-control" id="userphone" placeholder="Enter Valid phone ..." autocomplete=off />
                    </div>
                    <div class="form-group">
                      <label class="control-label" for="inputError" >Vendor</label>
                      <select required class="form-control" onchange="changeVendor()" id="vendor_id">
                          <option value="">--Select vendor--</option>
                          <option value="1">shopyco</option>
                          <option value="2">snapdeal</option>
                      </select>
                    </div>
                     <div class="form-group" style="display:none" id="dummey1">
                      <label class="control-label" for="inputError" >Passsword</label>
                      <input type="password" class="form-control" id="userpassword1" placeholder="Enter Password ..." autocomplete=off   />
                    </div>
                     <div class="form-group" style="display:none" id="dummey2">
                      <label class="control-label" for="inputError" >Login token</label>
                      <input type="text" class="form-control" id="userpassword2" placeholder="Enter Login Token ..." autocomplete=off   />
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-success btn-flat margin" id="deviceRegisterBtn" value="Register Device" />
                      <div class="text-red"><b><i class="icon fa fa-check" style="display:none" id="deviceRegister-error1"></i><span id="deviceRegister-error"></span></b></div>
                      <div class="text-green"><b><i class="icon fa fa-check" style="display:none" id="deviceRegister-success1"></i><span id="deviceRegister-success"></span></b></div>
                    </div>


                  </form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!--/.col (right) -->
          </div>   <!-- /.row -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require("../etc/footer.php"); ?>
<script src="../dist/js/pages/addDevice.js"></script>