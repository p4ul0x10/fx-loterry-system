<?php

$host = $_SERVER['REQUEST_METHOD'];
if($host == "GET"){
	exit();
}

$cod_dep = $_POST['cod_dep'];
$dm = $_POST['dm'];

if($dm == "undefined"){
	echo "<tr id='trrm".$cod_dep."'>
<td colspan='2'>Do you want to delete this deposit?<br><button class='btn btn-sm btn-primary yesdep' id='dy-".$cod_dep."' title='exclude dep'>Yes</button><button class='btn btn-sm btn-danger ndep' id='dn-".$cod_dep."' title='no delete deposit'>No</button></td>
</tr>";
}else{
	echo "<div id='rm".$cod_dep."' style='margin:0px auto !important;'>
<p>Do you want to delete this deposit?<br><button class='btn btn-sm btn-primary yesdep' id='my-".$cod_dep."' title='exclude dep'>Yes</button><button class='btn btn-sm btn-danger ndep' id='mn-".$cod_dep."' title='no delete deposit'>No</button></p>
</div>";
}

?>
<script type="text/javascript">
$(document).ready(function() {
	$(".yesdep").on("click", function(){
	
		id_dep = $(this).attr("id");
		
		if(id_dep.indexOf("dy") >= 0){
			rm_dep = id_dep.replace("dy-", "");
		}else{
			rm_dep = id_dep.replace("my-", "");
		}
		
		$.post("php/dep/attdep.php",{"dep_id": rm_dep}, function(data){
		
			if(id_dep.indexOf("dy") >= 0){
				rm_mode = "d";
			}else{
				rm_mode = "m";
			}

			if(rm_mode == "d"){
				$("#tr"+rm_dep).remove();
				$("#trrm"+rm_dep).remove();
			}else{
				$(".card-"+rm_dep).remove();
			}

		});
		//alert(id_dep);

	});

	$(".ndep").on("click", function(){

		id_dep = $(this).attr("id");
		
		if(id_dep.indexOf("dn") >= 0){
			hide_dep = id_dep.replace("dn-", "");
		}else{
			hide_dep = id_dep.replace("mn-", "");
		}

		if(id_dep.indexOf("dn") >= 0){	
			$("#trrm"+hide_dep).remove();
		}else{
			$("#rm"+hide_dep).remove();
			$(".col-10-"+hide_dep).show();
		}

	});
});
</script>