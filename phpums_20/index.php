<?php
/*  UMS DEMO:                                                                                  *\
 *	In this page you can find all basic features of UMS.                                       *
 *	Please fill free to change any of the source code according to the GNU license.            *
\*	Any feedback is wellcome: as [at] aslabs [dot] com                                         */

	include("lib/ums.php");


/*  UMS DEMO:                                                                                  *\
\*	Here we call a specific UMS function accordign to form submition.                          */

	if(isset($_POST['act']) && $_POST['act']=='login' && !$ums->logged){
		$ums->login($_POST['user'],$_POST['pass'],isset($_POST['remember']));
	}
	if(isset($_POST['act']) && $_POST['act']=='logout' && $ums->logged){
		$ums->logout();
	}
	if(isset($_POST['act']) && $_POST['act']=='register' && !$ums->logged){
		$ums->register($_POST['uname'],$_POST['pass'],$_POST['email']);
	}
	if(isset($_POST['act']) && $_POST['act']=='update' && $ums->logged){
		$ums->update($_POST['up_uname'],$_POST['up_pass'],$_POST['up_email']);
	}
	if(isset($_POST['act']) && $_POST['act']=='recover' && !$ums->logged){
		$ums->recover($_POST['rec_user']);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHPums.com</title>
<script type="text/javascript" language="javascript" src="jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="jquery.tools.min.js"></script>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php 
/*  UMS DEMO:                                                                                  *\
\*	Printing all errors.                                                                       */
echo $err->get();
?>
<div class="center">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center"><a href="http://www.phpums.com"><img src="UMS.png" width="98" height="89" alt="UMS"></a></td>
      <td rowspan="2"><div class="tabs">
          <div class="tabcont">
            <div class="tab" id="login"> <br /><br /><br /><br /><br />
              <h1>Login</h1>
              <br />
              <?php if($ums->logged){ ?>
              Welcome <strong><?php echo $ums->uname; ?></strong> <a href="javascript:document.getElementById('logoutF').submit();" >Logout</a>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="logoutF">
                <input name="act" type="hidden" value="logout" />
              </form>
              <?php }else{ ?>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input name="act" type="hidden" value="login" />
                <em>Try admin/admin.</em>
                <table width="400" border="0" align="center" cellpadding="4" cellspacing="0">
                  <tr>
                    <td align="right"><label>Username OR Email:</label></td>
                    <td align="left"><input name="user" type="text" /></td>
                  </tr>
                  <tr>
                    <td align="right"><label>Password:</label></td>
                    <td align="left"><input name="pass" type="password" /></td>
                  </tr>
                  <tr>
                    <td align="right"><input name="remember" type="checkbox" /></td>
                    <td align="left">Remember me.</td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center"><input name="login_btn" type="submit" value="  Login  " /></td>
                  </tr>
                </table>
              </form>
              <?php } ?>
            </div>
            <div class="tab" id="register"><br /><br /><br /><br /><br />
              <h1>Register</h1>
              <br />
              <?php if($ums->logged){ ?>
              Welcome <strong><?php echo $ums->uname; ?></strong><br />
              To see this page you should first <a href="javascript:document.getElementById('logoutF').submit();" >Logout</a>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="logoutF">
                <input name="act" type="hidden" value="logout" />
              </form>
              <?php }else{ ?>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="reg_form">
                <input name="act" type="hidden" value="register" />
                <table width="400" border="0" align="center" cellpadding="4" cellspacing="0">
                  <tr>
                    <td align="right"><label>Username:</label></td>
                    <td align="left"><input name="uname" type="text" id="uname" /></td>
                  </tr>
                  <tr>
                    <td align="right"><label>Email:</label></td>
                    <td align="left"><input name="email" type="text" id="email" /></td>
                  </tr>
                  <tr>
                    <td align="right"><label>Password:</label></td>
                    <td align="left"><input name="pass" type="password" id="pass" /></td>
                  </tr>
                  <tr>
                    <td align="right"><label>Password again:</label></td>
                    <td align="left"><input name="pass2" type="password" id="pass2" /></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center"><input id="reg_btn" name="login_btn" type="button" value="  Register  " /></td>
                  </tr>
                </table>
                <script type="text/javascript">
  $(document).ready(function(){
	 $('#reg_btn').click(function(){
		 $('.error').remove();
		 var errs = 0;
		 var err_str = ''; 
	   if($('#uname').val()==''){ errs++; err_str+='Username is mandatory.<br />'; }
	   if($('#email').val()==''){ errs++; err_str+='Email is mandatory.<br />'; }
	   if($('#pass').val()==''){ errs++; err_str+='Password is mandatory.<br />'; }
	   if($('#pass2').val()==''){ errs++; err_str+='Please enter the password again.<br />'; }
	   if($('#pass').val()!=$('#pass2').val()){ errs++; err_str+='Passwords must be the same.<br />'; }
	   
	   if(errs>=1){
		   $('.center').before('<div class="error">'+err_str+'</div>');
	   }else{
		   $('#reg_form').submit();
	   }
	 });
  });
  </script>
              </form>
              <?php } ?>
            </div>
            <div class="tab" id="user"><br /><br /><br /><br /><br />
              <h1>User's page</h1>
              <br />
              <?php if(!$ums->logged){ ?>
              Welcome <strong>Guest</strong><br />
              To see this page you should first <a href="javascript:gotoTab(0)">Login</a>
              <?php }else{ $info = $ums->getUser();
			  ?>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="update">
                <input name="act" type="hidden" value="update" />
                <table width="400" border="0" align="center" cellpadding="4" cellspacing="0">
                  <tr>
                    <td align="right"><label>Username:</label></td>
                    <td align="left"><input name="up_uname" type="text" id="uname" value="<?php echo $info['uname']; ?>" /></td>
                  </tr>
                  <tr>
                    <td align="right"><label>Email:</label></td>
                    <td align="left"><input name="up_email" type="text" id="email" value="<?php echo $info['email']; ?>" /></td>
                  </tr>
                  <tr>
                    <td align="right"><label>New Password:</label></td>
                    <td align="left"><input name="up_pass" type="password" id="pass" /></td>
                  </tr>
                  <tr>
                    <td align="right"><label>New Password again:</label></td>
                    <td align="left"><input name="up_pass2" type="password" id="pass2" /></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center"><input name="update_btn" type="button" value="  Update  " id="update_btn" /></td>
                  </tr>
                </table>
                <script type="text/javascript">
  $(document).ready(function(){
	 $('#update_btn').click(function(){
		 $('.error').remove();
		 var errs = 0;
		 var err_str = ''; 
	   if($('#up_pass').val()!=$('#up_pass2').val()){ errs++; err_str+='Passwords must be the same.<br />'; }
	   /*if( ($('#uname').val()=='' || $('#uname').val()=='<?php echo $info['uname']; ?>') &&
	       ($('#email').val()=='' || $('#email').val()=='<?php echo $info['email']; ?>') &&
	       ($('#pass').val()=='') &&
	       ($('#pass2').val()=='') ) {
			   
			   
		}else{
		
	   }*/
	   
	   if(errs>=1){
		   $('.center').before('<div class="error">'+err_str+'</div>');
	   }else{
		   $('#update').submit();
	   }
	 });
  });
  </script>
              </form>
              <?php } ?>
            </div>
            <div class="tab" id="recover"><br /><br /><br /><br /><br />
              <h1>Recover password</h1>
              <br />
              <?php if($ums->logged){ ?>
              Welcome <strong><?php echo $ums->uname; ?></strong><br />
              To see this page you should first <a href="javascript:document.getElementById('logoutF').submit();" >Logout</a>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="logoutF">
                <input name="act" type="hidden" value="logout" />
              </form>
              <?php }else{ $info = $ums->getUser();
			  ?>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="recover">
                <input name="act" type="hidden" value="recover" />
                We will send you a new email to your email.
                <table width="400" border="0" align="center" cellpadding="4" cellspacing="0">
                  <tr>
                    <td align="right"><label>Username OR email:</label></td>
                    <td align="left"><input name="rec_user" type="text" id="rec_user" /></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center"><input name="rec_btn" type="submit" value="  Send  " id="update_btn" /></td>
                  </tr>
                </table>
              </form>
              <?php } ?>
            </div>
            <div class="tab" id="other">
              <h1>How it works</h1>
              UMS is made from public and private functions. Here is a list of the public functions.<br />
              <br />
              Before you start plase make sure you include the main class (ums.php):
              <div class="code"> <span class="functions">include</span>(<span class="string">"lib/ums.php"</span>);</div>
              <h2>LOGIN/LOGOUT</h2>
              <div class="code"><span class="tag_form">//You should use the login function this way:</span><br />
                <span class="pars">$ums</span>-><span class="cfunctions">login</span>(<span class="pars">$user</span>,<span class="pars">$pass</span>,<span class="pars">$remember</span>);<br />
                <br />
                <span class="tag_form">//And the logout function this way:</span><br />
                <span class="pars">$ums</span>-><span class="cfunctions">logout</span>();<br />
                <br />
                <span class="tag_form">//You can also call some special vars from the class. For example you can check if the user is logged in or not, you can get the username of the current user.</span><br />
                <span class="pars">$ums</span>-><span class="cfunctions">logged</span>; <span class="tag_form">//Boolean: user login status.</span><br />
                <br />
                <span class="pars">$ums</span>-&gt;<span class="cfunctions">uname</span>; <span class="tag_form">//String: user Username.</span><br />
              </div>
              <h2>Register</h2>
              The register function uses by default very basic info. You can edit this function to insert more user's info (like gender, address, tel, etc). The very basi syntax is:
              <div class="code"><span class="pars">$ums</span>-><span class="cfunctions">register</span>(<span class="pars">$uname</span>,<span class="pars">$pass</span>,<span class="pars">$email</span>);<br />
              </div>
              <br />
              <!--<div class="code">
	<span class="functions">include</span>(<span class="string">"lib/ums.php"</span>);<br />
	<br />
		<span class="pars">$ums</span>-><span class="cfunctions">login</span>(<span class="pars">$user</span>,<span class="pars">$pass</span>,<span class="pars">$remember</span>);<br />
		<br />
		<span class="pars">$ums</span>-><span class="cfunctions">logout</span>();<br />
		<br />
	    <span class="pars">$ums</span>-><span class="cfunctions">logged</span>;<br />
    <br />
		<span class="pars">$ums</span>-><span class="cfunctions">register</span>(<span class="pars">$uname</span>,<span class="pars">$pass</span>,<span class="pars">$email</span>);<br />
    </div>--> 
            </div>
            <div class="tab" id="about"><h1>About</h1>
<h2>What is UMS?</h2>
UMS stands for User Management System. When I first created UMS, it was intended to be a "base" from which I could start any project. During years I used this tool to build any kind of sites.
Today UMS can help you too. Releasing it under a GNU license, brought many members of the Open Source community to get involved in the project. Since then UMS have evolved to be a very powerful tool for PHP programmers.
<h2>What does it include?</h2>
Following the Philosophy of the project, UMS include the very basic feature common in every site.<br />
<br />
<strong>Those are the very basic features:</strong>
<br />
<ul>
<li>Login/Logout</li>
<li>User Groups/levels</li>
<li>Register (by Group)</li>
<li>Password recovery *</li>
<li>Account update *</li>
<li>Error are smartly managed.</li>
</ul>

<h2>Is this Secure?</h2>
Security has been a major point of interest while we built UMS. We have added a security class that filter any $_POST/$_GET variable looking for injections. You are certainly asking your self how passwords are stored. Well, we are storing passwords in MD5 php algorithms.<br />
<br /><br /><br />
<a href="http://www.phpums.com"><img src="download.png" width="447" height="74" /></a>

             </div>
          </div>
        </div></td>
    </tr>
    <tr>
      <td valign="top"><ul class="tabber" id="options">
          <li><a href="#login" class="vert navi">Login/Logout</a></li>
          <li><a href="#register" class="vert navi">Register</a></li>
          <li><a href="#user" class="vert navi">User</a></li>
          <li><a href="#recover" class="vert navi">Recover</a></li>
          <li><a href="#other" class="vert navi">How it works</a></li>
          <li><a href="#about" class="vert navi">About</a></li>
          <li><a href="http://www.phpums.com" class="vert">Download</a></li>
        </ul></td>
    </tr>
  </table>
</div>
<script>
$(function() {		
	$(".tabs").scrollable({ vertical: true, mousewheel: false }).navigator({
		navi: "body",
		naviItem: 'a.navi',
		activeClass: 'current'
	});
});
	function gotoTab(where){
	var api = $(".tabs").data("scrollable");
	api.seekTo(where)
	}
</script>
</body>
</html>