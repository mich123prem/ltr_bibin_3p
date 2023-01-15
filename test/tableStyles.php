<?php
print_r($_GET);
print<<<FROM
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="../prog.css" />
<title>Relevance Assessment</title>
</head>

<body>
<form>
<input type="radio" name="test" value="shown"/>shown<br/>
<input class="skjul" type="radio" name="test" value="hidden" checked />hidden<br/>
<input type="submit"/>
</form>


</html>
FROM;
