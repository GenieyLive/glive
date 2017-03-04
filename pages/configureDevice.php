<?php require("../etc/header.php"); 
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Configure Devices
            <small>Geniey-IoT ptoduct</small>
          </h1>
        <!--   <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
            <li class="active">Here</li>
          </ol> -->
        </section>

        <!-- Main content -->
        <section class="content">

           <div class="row" id="step1">
            <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Device Details</h3>
                </div><!-- /.box-header -->
                <div class="box-body" id="box-body">
                  <form role="form" id="deviceRegister">
                    <!-- text input -->
                      <div class="alert alert-success alert-dismissable" id="success-msg" style="display:none">
                      <i class="icon fa fa-check"></i>
                      </div>
                    <div class="form-group">
                      <label>Device Id</label>
                      <input type="text" class="form-control" id="deviceid" placeholder="Enter ..." required autocomplete=off disabled />
                      <input type="hidden" id="User_id" value="0" />
                    </div>
                    <div class="form-group">
                      <label>Security key</label>
                      <input type="text" class="form-control" id="devicekey" placeholder="Enter ..." disabled  required />
                    </div>                
                    <!-- input states -->
                    <div class="form-group">
                      <label class="control-label" for="inputSuccess" >Name</label>
                      <input type="text" class="form-control" id="username" placeholder="Enter Name..." required autocomplete=off />
                    </div>
                    <div class="form-group">
                      <label class="control-label" for="inputWarning">Email</label>
                      <input type="text" class="form-control" id="useremail" placeholder="Enter Valid Email Id ..." required autocomplete=off />
                    </div>
                    <div class="form-group">
                      <label class="control-label" for="inputError" >Phone</label>
                      <input type="number" class="form-control" id="userphone" placeholder="Enter Valid phone ..." required autocomplete=off />
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
                      <input type="submit" class="btn btn-success btn-flat margin" id="deviceRegisterBtn" value="Next" />
                      <div class="text-red"><b><i class="icon fa fa-check" style="display:none" id="deviceRegister-error1"></i><span id="deviceRegister-error"></span></b></div>
                      <div class="text-green"><b><i class="icon fa fa-check" style="display:none" id="deviceRegister-success1"></i><span id="deviceRegister-success"></span></b></div>
                    </div>


                  </form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!--/.col (right) -->
          </div>   <!-- /.row -->
          <div class="row" id="step2" style="display:none">
            <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Product Details</h3>
                </div><!-- /.box-header -->
                <div class="box-body" id="box-body1">
                  <form role="form" id="productRegister">
                    <!-- text input -->
                      <div class="alert alert-success alert-dismissable" id="success-msg" style="display:none">
                      <i class="icon fa fa-check"></i>
                      </div>
                    <div class="form-group">
                      <label>Enter product Id</label>
                      <!-- <input type="text" class="form-control" id="productURL"  placeholder="PASTE PRODUCT URL ..." required autocomplete=off  /> -->
                      <input type="text" class="form-control" id="product" placeholder="" required  autocomplete=off  />
                      <span class="text-green" id="product_status"></span>
                    </div>
                    <div class="form-group">
                      <label>No of products</label>
                      <input type="Number" class="form-control" id="noofproduct" placeholder="Enter ..." required autocomplete=off  />
                    </div>
                     <div class="form-group">
                      <input type="submit" class="btn btn-success btn-flat margin" id="productRegisterBtn" value="Complete" />
                      <div class="text-red"><b><i class="icon fa fa-check" style="display:none" id="deviceRegister-error2"></i><span id="productRegister-error"></span></b></div>
                      <div class="text-green"><b><i class="icon fa fa-check" style="display:none" id="deviceRegister-success2"></i><span id="productRegister-success"></span></b></div>
                    </div>
                  </form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!--/.col (right) -->
          </div>   <!-- /.row -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require("../etc/footer.php"); ?>
<script src="../dist/js/pages/configureDevice.js"></script>
<script type="text/javascript">
<?php if(!isset($_GET['id']))
{
?>
$("#box-body").html("Invalid Access..Please Selet device to configure from \"view Devices\" ");
</script>
<?php
exit;
}?>
get_deviceDetails('<?php echo $_GET['id'] ?>');

</script>