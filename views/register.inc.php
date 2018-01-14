<h2>Register</h2>
<div class='container-fluid'>

	<form action="register-process.php" method='post'>
	  <div class='form-group'>
	    <label for='email'>Email address</label>
	    <input type='email' class='form-control' name='email' id='email' aria-describedby='emailHelp' placeholder='Email'>
	  </div>
	  <div class='form-group'>
	    <label for='pass1'>Password</label>
	    <input type='password' class='form-control' name='pass' id='pass1' placeholder='Password'>
	  </div>
	  <div class='form-group'>
	    <label for='pass2'>Repeat Password</label>
	    <input type='password' class='form-control' id='pass2' placeholder='Repeat password'>
	  </div>
	  <button type='submit' class='btn btn-primary'>Register</button>
	</form>

</div>