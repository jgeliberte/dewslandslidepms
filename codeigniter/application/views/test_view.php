<?php 
	echo BASEPATH;
?>

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous">
</script>

<script 
	type="text/javascript"
	src="/js/modal.js">
</script>

<script 
    type="text/javascript"
    src="/js/jquery.validate.min.js">
</script>

<script 
	type="text/javascript"
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
</script>

<link 
	rel="stylesheet" 
	type="text/css" 
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!DOCTYPE html>
<html>
<head>
	<title>TEST</title>
</head>
<body>

</body>
</html>

<script type="text/javascript">
    // PMS_MODAL.attach("body", "xxx");
    // PMS_MODAL.show();
    
    const instance = PMS_MODAL.create("xxx", "bulletin_accuracy");
    // instance.attach("body", "xxx");
    instance.show();
    // instance.send();
    console.log(instance);

    const instance2 = PMS_MODAL.create("yyy", "ewi_sms_accuracy");
    // instance2.attach("body", "yyy");
	
    // PMS_MODAL
    // .attach("body", "xxx")
    // .show()
    // .send()
</script>