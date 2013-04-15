<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script language=JavaScript src='scripts/innovaeditor.js'></script>

<form method="post" action="" id="Form1">

  <textarea id="txtContent" name="txtContent" rows=4 cols=30></textarea>

  <script> //STEP 2: Replace the textarea (txtContent)
		var oEdit1 = new InnovaEditor("oEdit1");
		oEdit1.width="600";
		oEdit1.height="300";
		oEdit1.REPLACE("txtContent");//Specify the id of the textarea here
	</script>
  <label>
    <input type="submit" name="button" id="button" value="Submit">
  </label>
</form>

<?
if(isset($_POST["txtContent"])) 
	{
	$sContent=stripslashes($_POST['txtContent']); /*** remove (/) slashes ***/		
	echo $sContent;
	}
?>
</body>
</html>