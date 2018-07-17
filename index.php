<?php
session_start();

if(isset($_SESSION["file_opened"]))
{
	unset($_SESSION['file_opened']);
}

?>
<html>
<head>
	<title>VIEW FILES</title>
</head>
<body>
	<h3>VIEW FILES:</h3>  
  <p>Send Feedbacks to <i style='color:blue'><u>brguru90@gmail.com</u></i></p>
	<script>
		iframe.contentWindow.location.reload();
	</script>
	<iframe src="view0.php" id="aaaa" width="100%" height="80%"></iframe><br />
</body>
</html>

