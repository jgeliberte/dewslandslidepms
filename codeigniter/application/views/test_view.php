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
    const instance = PMS_MODAL.create({
        modal_id: "xxx",
        metric_name: "bulletin_accuracy",
        module_name: "Bulletin"
    });

    instance.set({
        ts_data: "2017-10-10 00:00:00",
        reference_id: 12,
        reference_table: "public_alert_release"
    });
    
    instance.show();

    console.log(instance);

    const instance2 = PMS_MODAL.create({
        modal_id: "yyy",
        metric_name: "ewi_sms_accuracy",
        module_name: "Chatterbox"
    });
</script>