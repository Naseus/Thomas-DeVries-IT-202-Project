<html>
<head>
<script>
function validateUser(user) {
	let name = user.value;
	let vid = "validation." + user.name;
	let vele = document.getElementById(vid);
	console.log(name);
	if(name.length > 0) {
		if(vele) {
			vele.remove();
			}
	} else{
		if(!vele) {
			vele = document.createElement("span");
			vele.id = vid;
			document.body.appendChild(vele);
		}
		vele.innerText = " Username is empty, ";
	}
}

function validate(original, confirmation) {
        let orig = original.value;
        let conf = confirmation.value;
        let vid = "validation." + original.name;
        let vele = document.getElementById(vid);
        console.log(orig);
        console.log(conf);
         if(!vele) {
                vele = document.createElement("span");
                vele.id = vid;
                document.body.appendChild(vele);
                }


        if(orig.length <=  0) {
                vele.innerText = original.name + " is empty, ";
        } else if(conf.length <= 0){
                vele.innerText = confirmation.name + "  is empty, ";
        }  else if(orig != conf ) {
                vele.innerText = original.name  + "s don't match, ";
        } else {
                if(vele) {
                        vele.remove();
                }
         }
}


</script>
</head>

<body>
<form onsubmit="return false;">

<input name="email" type="email" placeholder = "email@domain.com" onchange = "validate(this, emailconfirm);"/>
<input name="emailconfirm" type="email"  placeholder = "email@domain.com" onchange = "validate(email, this);"/>
<input name="password" type="password"  placeholder = "password" onchange = "validate(this, passwordconfirm);"/>
<input name="passwordconfirm" type="password"  placeholder = "confirm password" onchange = "validate(password, this);"/>
<input name="username"  placeholder = "username" onchange = "validateUser(this);"/>

<input type="submit" value="Submit"/>

</form>
</body>
</html>
