<?php
function checkUser() {

}
?>


<html>
<head>
<style>
input{ border: 1px solid black; border-radius: 2px; margin-left: auto; margin-right:auto; padding 1%;}
H1 {font-family:Arial; font-size: 20px; margin-left: auto; margin-right:auto;}
</style>
</head>
<body>
<H1>Login</H1>
<HR>
<input name="username"  placeholder = "username" style width = 300px/>
<br>
<input name="email" type="email" placeholder = "email@domain.com"/>
<input name="emailconfirm" type="email"  placeholder = "email@domain.com"/>
<br>
<input name="password" type="password"  placeholder = "password"/>
<input name="passwordconfirm" type="password"  placeholder = "confirm password"/>
<br>
<input type="submit" value="Submit"/>
</body>
</html>
<?php checkUser();?>
