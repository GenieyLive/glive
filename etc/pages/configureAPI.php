<?php require("../etc/header.php"); 
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Configure API
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
                  <h3 class="box-title">API Details</h3>
                </div><!-- /.box-header -->
                <div class="form-group">
                   <form role="form" id="deviceRegister">
                      <label class="control-label" for="inputError" >Vendor</label>
                      <select required class="form-control" onchange="changeVendor()" id="vendor_id">
                          <option value="">--Select vendor--</option>
                          <option value="1">shopyco</option>
                          <option value="2">snapdeal</option>
                      </select>
                    </div>
                    <div class="alert alert-success alert-dismissable" id="success-msg" style="display:none">
                      <i class="icon fa fa-check"></i>
                      </div>
                  <div class="box-body"  style="display:none" id="dummey2">
                       <div class="form-group">
                      <label>1.API URL</label>
                      <input type="text" class="form-control" id="api" placeholder="Enter ..." required autocomplete=off  />
                    </div>
                  </div>
                <div class="box-body"  style="display:none" id="dummey1">
                 
                    <!-- text input -->
                      
                    <div class="form-group">
                      <label>1.Session URL</label>
                      <input type="text" class="form-control" id="Session" placeholder="Enter ..." required autocomplete=off  />
                    </div>
                    <div class="form-group">
                      <label>2.Login URL</label>
                      <input type="text" class="form-control" id="login" placeholder="Enter ..." required autocomplete=off  />
                    </div>
                    <div class="form-group">
                      <label>3.Empty Cart URL</label>
                      <input type="text" class="form-control" id="empty_cart" placeholder="Enter ..." required autocomplete=off  />
                    </div>
                    <div class="form-group">
                      <label>4.Cart URL</label>
                      <input type="text" class="form-control" id="cart" placeholder="Enter ..." required autocomplete=off  />
                    </div>
                    <div class="form-group">
                      <label>5.Payment address Url</label>
                      <input type="text" class="form-control" id="payaddress" placeholder="Enter ..." required autocomplete=off  />
                    </div>
                    <div class="form-group">
                      <label>6.Shipping address Url</label>
                      <input type="text" class="form-control" id="shipaddress" placeholder="Enter ..." required autocomplete=off  />
                    </div>
                    <div class="form-group">
                      <label>7.payment Methods Url</label>
                      <input type="text" class="form-control" id="paymethods" placeholder="Enter ..." required autocomplete=off  />
                    </div>
                    <div class="form-group">
                      <label>8.Shipping Methods Url</label>
                      <input type="text" class="form-control" id="shipmethds" placeholder="Enter ..." required autocomplete=off  />
                    </div>
                    <div class="form-group">
                      <label>9.payment confirm Url</label>
                      <input type="text" class="form-control" id="payconfirm" placeholder="Enter ..." required autocomplete=off  />
                    </div>
                    <div class="form-group">
                      <label>10.Logout Url</label>
                      <input type="text" class="form-control" id="logout" placeholder="Enter ..." required autocomplete=off  />
                    </div>

                    
                </div><!-- /.box-body -->
                <div class="form-group">
                      <input type="submit" class="btn btn-success btn-flat margin" id="deviceRegisterBtn" value="UPDATE" />
                      <div class="text-red"><b><i class="icon fa fa-check" style="display:none" id="deviceRegister-error1"></i><span id="deviceRegister-error"></span></b></div>
                      <div class="text-green"><b><i class="icon fa fa-check" style="display:none" id="deviceRegister-success1"></i><span id="deviceRegister-success"></span></b></div>
                    </div>


                  </form>
              </div><!-- /.box -->
            </div><!--/.col (right) -->
          </div>   <!-- /.row -->
          

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require("../etc/footer.php"); ?>
<script src="../dist/js/pages/configureAPI.js"></script>
<script type="text/javascript">
get_APIDetails();
</script>