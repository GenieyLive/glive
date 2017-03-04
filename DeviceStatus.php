  	<?php

		$QUERY_STRING= $_SERVER['QUERY_STRING'];
		parse_str($QUERY_STRING, $deviceDetails);
		$data_string['send']="ok";
  	?>
  	<span id="device_status"></span>
  	<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="dist/js/firebase.js"></script>
    <script type="text/javascript">
    var url="/Device/RunningStatus/<?php echo $deviceDetails['device_id'];?>.json";
    var url1="/Device/HistoryStatus/<?php echo $deviceDetails['device_id'];?>.json";
    var data=<?php print json_encode($data_string); ?>;
    var s= $.get(geniey_host+url+geniey_auth, { Send: "ok"} )
		  .done(function( data ) {
		    // console.log(data);
		    var keys=Object.keys(data);
		    var res="";
		   		 for (key in keys) 
		    	{ 
		    		res=res+keys[key]+" : "+data[keys[key]]+",<br />";
		    	}
		    $("#device_status").html(res+"<br /> <br /> Note: developlment under progress...please open console to view hstory status");
		  });
		  $.get(geniey_host+url1+geniey_auth, { Send: "ok"} )
		  .done(function( data ) {
		    console.log(data);
		  });
    </script>
<?php
?>