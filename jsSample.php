<html>
<!--comment-->
<head>
<!--css and js here-->
<script>
function pageLoaded() {
	//this is inside the script
	// comment format changes
	var myVariable;
	let myNum = 0;
	for(let i = 0; i < 10; i++) {
		myNum += 0.1;
	}
	console.log("My num is 1: " + (myNum == 1) + "\nMy Num " + myNum);
	let myParagraph = document.getElementById("myParagraph");
	console.log(myParagraph);
	myParagraph.innerText = "It was updated";
}
</script>
</head>

<body onload = "pageLoaded();">
<!--html content-->
<p id = "myParagraph"> It loaded yay!</p>

<div>
<p id ="newElement"> Added New Element </p>
</div>
</body>
</html>
