<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>RadarIgniter</title>

<meta name="viewport" content="width=device-width" />
   
	<link href="css/style.css" rel="stylesheet" media="screen">
    
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/foundation.css" />
	<script src="js/vendor/custom.modernizr.js"></script>
    <script src="//code.jquery.com/jquery.js"></script>
</head>
	
    
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

<script>
  document.write('<script src=' +
  ('__proto__' in {} ? 'js/vendor/zepto' : 'js/vendor/jquery') +
  '.js><\/script>')
  </script>
  <script src="js/foundation/foundation.js"></script>
  <script src="js/foundation/foundation.alerts.js"></script>
  <script src="js/foundation/foundation.clearing.js"></script>
  <script src="js/foundation/foundation.cookie.js"></script>
  <script src="js/foundation/foundation.dropdown.js"></script>
  <script src="js/foundation/foundation.forms.js"></script>
  <script src="js/foundation/foundation.joyride.js"></script>
  <script src="js/foundation/foundation.magellan.js"></script>
  <script src="js/foundation/foundation.orbit.js"></script>
  <script src="js/foundation/foundation.placeholder.js"></script>
  <script src="js/foundation/foundation.reveal.js"></script>
  <script src="js/foundation/foundation.section.js"></script>
  <script src="js/foundation/foundation.tooltips.js"></script>
  <script src="js/foundation/foundation.topbar.js"></script>
  <script src="js/foundation/foundation.interchange.js"></script>
  <script>
    $(document).foundation();
  </script>

<div id="wrapper-header">
<div id="header">

    <a href="#">
        <div id="logo" class="hide-text">
            Logo
        </div>
    </a>
			<div id="login-status">
				<? 
				
					$this->load->view('login');
              
				?>
			</div>
</div>
</div>
<div id="wrapper-content">
<div id="content">