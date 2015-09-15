<script type="text/javascript">
window.fbAsyncInit = function() {
	//Initiallize the facebook using the facebook javascript sdk
	FB.init({
		appId:'160123597528115',
		cookie:true, // enable cookies to allow the server to access the session
		status:false, // check login status
		//xfbml:true, // parse XFBML
		oauth : true //enable Oauth
	});
	};
	//Read the baseurl from the config.php file
	(function(d){
	var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "//connect.facebook.net/es_LA/all.js";
	ref.parentNode.insertBefore(js, ref);
	}(document));
	//Onclick for fb login
	
		
</script>

<div id='login-box' class="navbar-form navbar-right"> <!-- div de carga -->
 <? 
if(isset($this->session->userdata['username'])){ //existe session iniciada correctamente

	switch ($this->session->userdata['usuarioTipo']){ //Seleccion tipo usuario
	case 1: break;
	case 2: break;
	//... case n
	default: break;

	}
//mensaje de bienvenida
	echo "Bienvenido ".$this->session->userdata['username']." <br><a href='/mipanel'>Mi panel</a> <a href='login/logout'>Logout</a>";
}else{ //no existe session iniciada      
?>
 <div id="login" > 
  <?php echo form_open(array('method' => 'POST'));?>
    <div class="form-group">
	<?= form_error('username'); ?>
    <input placeholder="Nombre usuario" type="text" id="username" name="username">
    </div>
    <div class="form-group">
    <?php echo form_error('password'); ?>
    <input placeholder="Contraseña" type="password" id="password" name="password">
    </div>
    
    <div id="btnLogin" class="form-group">Login</div>
    <?= form_close();?>
  </div>
  <div id="facebook-login" class="hide-text">Facebook Login</div>
  <? if (isset($error)){ ?>
  <div id="errorLogin">
    <?=$error?>
  </div>
  <? }
} 
?>
</div>
