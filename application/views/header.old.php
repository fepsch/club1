<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>RadarIgniter</title>

<link href="css/style.css" rel="stylesheet" media="screen">
</head>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="//code.jquery.com/jquery.js"></script>

<!-- DEBEN CAMBIARSE A UN JS ANTES DE PRODUCCION-->
<script type="text/javascript" language="javascript">
	  $(document).ready(function() {
			$("#btnLogin").click(function() {
                    username_js = $('#username').val();
					password_js = $('#password').val();
					$("#loader").addClass("loading"); 
                    $.post("login", {
                        username : username_js,
						password : password_js
                    }, function(data) {
                        $("#login-box").html(data);
						$("#loader").removeClass("loading"); 
                    });
               
            });
			
			$('#facebook-login').click(function(e) {
		 
				FB.login(function(response) {
				if(response.authResponse) {
				parent.location ='login/fblogin'; //redirect uri after closing the facebook popup
				}
				},{scope: 'email,read_stream,publish_stream,user_birthday,user_location,user_work_history,user_hometown,user_photos'}); //permissions for facebook
			});
			
        });
	</script>
<body>


<div id="wrapper-header">
  <div id="header"> 
  <div id="main-logo">
  <a href="#" class="brand ">
    <div class="hide-text"> Logo </div>
    </a>
    </div>
    <div div="menu-superior">
      <ul class="nav">
        <? $this->load->view('menu'); ?>
      </ul>
      <div id='login-box'> <!-- div de carga -->
        <? 
        $this->load->view('login');
        ?>
      </div>
    </div>
  </div>
</div>


<div id="wrapper-content">

<div id="content">
