<?php
session_start();
if(isset($_SESSION['login_user']))
{
header("location: pages/index.php"); 
}

?>

<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Geniey - login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->
    <!-- Ionicons -->
<!--     <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
 -->    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="index.php"><b>Geniey</b>-IoT </a>
      </div><!-- /.login-logo -->
      <div class="login-box-body" id="login_form">
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="etc/Login.php" method="post" onsubmit="return checkProfile1()">
          <div class="form-group has-feedback">
            <input type="text" id="email" name="email" class="form-control" placeholder="Email" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter PIN" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" name="submit"  id="LoginBtn" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

        <a href="#" onclick="new_to_geniey()">I forgot my password</a><br>
        <a href="#" class="text-center" onclick="new_to_geniey()">New to Geniey</a>
        <p style="text-align:center;color:Red">

         <?php
         if(isset($_SESSION['error']))
         {
          echo "Login Failure.";
          session_destroy();
         }

        ?><p>
      </div><!-- /.login-box-body -->
      <div class="login-box-body" id="signup_form" style="display:none">
        <p class="login-box-msg">Email is your basic identification</p>
        <form action="#" method="post" onsubmit="return doRegister()">
          <div class="form-group has-feedback">
            <input type="text" id="email1" name="email1" class="form-control" placeholder="Enter your Email" required>
            <input type="hidden" id="profileCheck" value="0" />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4" style="width:60%;float:right">
              <button type="submit" name="submit"onclick=""  id="regBtn" class="btn btn-primary btn-block btn-flat">Create/Reset password</button>
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.login-box-body -->
      <div class="login-box-body" id="signup_form1" style="display:none">
        <p class="login-box-msg">We have sent PIN to your Email</p>
        <form action="#" method="post" onsubmit="return doReset()">
          <div class="form-group has-feedback">
            <input type="password" id="old_pin" name="old_pin" class="form-control" placeholder="Received PIN" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" id="new_pin" name="password" class="form-control" placeholder="Enter NEW PIN" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" id="new_pin2" name="password" class="form-control" placeholder="Confirm NEW PIN"required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4" >
              <button type="submit" name="submit"  id="resetBtn" class="btn btn-primary btn-block btn-flat">Save PIN</button>
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.login-box-body -->
      <div class="login-box-body" id="profile_form1" style="display:none">
        <p class="login-box-msg">Complete profile</p>
        <form action="#" method="post" onsubmit="return updateProfile()">
          <div class="form-group has-feedback">
            <input type="text" id="name" name="name" class="form-control" placeholder="Fullname" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Mobile Number" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" id="address1" name="address1" class="form-control" placeholder="Enter Address Line1" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" id="address2" name="address2" class="form-control" placeholder="Enter Address Line2" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4" style="windth:40%;float:right">
              <button type="submit" name="submit"  id="profileupdate" class="btn btn-primary btn-block btn-flat">Update Profile</button>
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.login-box-body -->
      
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
  </body>
</html>
<script src="dist/js/pages/index.js"></script>
<script type="text/javascript">
function new_to_geniey()
{
  $("#login_form").css("display","none");
  $("#signup_form").css("display","inherit");
  $("#signup_form1").css("display","none");
  $("#profile_form1").css("display","none");
  resetForm();
}
function doRegister()
{
  $.ajax({
  type: "GET",
  url: site_url+"/etc/updateDB.php?route=registeruser&table=ok",
  data:{vars:$("#email1").val()},
  success: function(data) {
    console.log(data);
    if(data=="1")
    {
      $("#login_form").css("display","none");
      $("#signup_form").css("display","none");
      $("#signup_form1").css("display","inherit");
      $("#profile_form1").css("display","none");
    }
  }
  });
  
  return false;
}
function doReset()
{
  var email=$("#email1").val();
  var old_pin=$("#old_pin").val();
  var new_pin=$("#new_pin").val();
  var new_pin2=$("#new_pin2").val();
  if(new_pin==new_pin2)
  {
    var queryVal={};
    queryVal['old_Password']=old_pin;
    queryVal['Password']=new_pin;
    queryVal['Email']=email;
     $.ajax({
    type: "GET",
    url: site_url+"/etc/updateDB.php?route=updatePIN&table=ok",
    data:{vars:queryVal},
    success: function(data) {
      console.log(data);
    if(data=="1")
    {
      alert("PIN Successfully changed");
      $("#login_form").css("display","inherit");
      $("#signup_form").css("display","none");
      $("#signup_form1").css("display","none");
      $("#profile_form1").css("display","none");
      resetForm();
      checkProfile($("#email1").val());
    }
    else if(data=="0")
    {
      alert("Invalid PIN entered");
    }
  }
  });
  }
  else
  {
    alert("New PIN and confirm PIN mismatch");
  }
  return false;
}
function resetForm()
{
  $(".password").val("");
  $("#old_pin").val("");
  $("#new_pin").val("");
  $("#new_pin2").val("");
}
function checkProfile(email)
{
  resetpage();
  $.ajax({
  type: "GET",
  url: site_url+"/etc/updateDB.php?route=checkProfile&table=ok",
  data:{vars:email},
  success: function(data) {
    console.log(data);
    if(data=="1")
    {
      $("#login_form").css("display","none");
      $("#signup_form").css("display","none");
      $("#signup_form1").css("display","none");
      $("#profile_form1").css("display","inherit");
      alert("profile not completed");
      return false;
    }
    else
    {
      $("#login_form").css("display","inherit");
      $("#signup_form").css("display","none");
      $("#signup_form1").css("display","none");
      $("#profile_form1").css("display","none");
      resetpage();
      return true;
    }
  }
  });
}
function checkProfile1()
{
  if($("#profileCheck").val()=="1")
  {
    return true;
  }
  $( "#email1" ).val($( "#email" ).val());
  var queryVal={};
  queryVal['Email']=$( "#email" ).val();
  queryVal['Password']=$( "#password" ).val();
  $.ajax({
  type: "GET",
  url: site_url+"/etc/updateDB.php?route=checkProfile1&table=ok",
  data:{vars:queryVal},
  success: function(data) {
    console.log(data);
    if(data=="1")
    {
      $("#login_form").css("display","none");
      $("#signup_form").css("display","none");
      $("#signup_form1").css("display","none");
      $("#profile_form1").css("display","inherit");
      alert("profile not completed");
    }
    else
    {
      $("#login_form").css("display","inherit");
      $("#signup_form").css("display","none");
      $("#signup_form1").css("display","none");
      $("#profile_form1").css("display","none");
      $("#profileCheck").val("1");
      $("#LoginBtn").click();
    }
  }
  });
  return false;
}
function updateProfile()
{
  var queryVal={};
  queryVal['Name']=$( "#name" ).val();
  queryVal['Phone']=$( "#phone" ).val();
  queryVal['Address']=$( "#address1" ).val();
  queryVal['city']=$( "#address2" ).val();
  queryVal['Email']=$( "#email1" ).val();
 $.ajax({
  type: "GET",
  url: site_url+"/etc/updateDB.php?route=Updateprofile&table=ok",
  data:{vars:queryVal},
  success: function(data) {
    console.log(data);
    if(data=="1")
    {
      $("#login_form").css("display","inherit");
      $("#signup_form").css("display","none");
      $("#signup_form1").css("display","none");
      $("#profile_form1").css("display","none");
      alert("profile Updated Successfully");
      resetpage();
    }
  }
  });
  return false;
}
function resetpage()
{
   $(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
    $(':checkbox, :radio').prop('checked', false);
}
</script>
