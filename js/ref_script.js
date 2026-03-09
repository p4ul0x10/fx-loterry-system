
function ref_click(id){

	if($("#rf"+id).attr("class") == "fa fa-ref fa-sort-desc text-light"){
		$("#rf"+id).removeClass("fa fa-ref fa-sort-desc text-light");
		$("#rf"+id).addClass("fa fa-ref fa-sort-asc text-light");	
		var type = "asc";	
	}else if($("#rf"+id).attr("class") == "fa fa-ref fa-sort-asc text-light"){
		$("#rf"+id).removeClass("fa fa-ref fa-sort-asc text-light");
		$("#rf"+id).addClass("fa fa-ref fa-sort-desc text-light");	
		var type = "dec";
	}

	if($("#rf"+id).attr("class") == "fa fa-ref fa-sort-desc color-theme"){
		$("#rf"+id).removeClass("fa fa-ref fa-sort-desc color-theme");
		$("#rf"+id).addClass("fa fa-ref fa-sort-asc color-theme");	
		var type = "asc";	
	}else if($("#rf"+id).attr("class") == "fa fa-ref fa-sort-asc color-theme"){
		$("#rf"+id).removeClass("fa fa-ref fa-sort-asc color-theme");
		$("#rf"+id).addClass("fa fa-ref fa-sort-desc color-theme");	
		var type = "dec";
	}

	var count = $(".id_ref").length;
	count = parseFloat(count) - parseFloat(1);

	arid = [count];
	arname = [count];
	arlevel = [count];
	ardate = [count];
	arup = [count];
	arstatus = [count];
	arearns = [count];
	aractivity = [count];
	
	//
	var i = 0;
	$(".id_ref").each(function() {
		arid[i] = $(this).text();
		//console.log(arid[i]);
		i++;
	});

	i = 0;
	$(".name_ref").each(function() {
		arname[i] = $(this).text();
		//console.log(arname[i]);
		i++;
	});
	
	i = 0;
	$(".level_ref").each(function() {
		arlevel[i] = $(this).text();
		console.log("level "+arlevel[i]);
		i++;
	});
	i = 0;
	$(".date_ref").each(function() {
		ardate[i] = $(this).text();
		//console.log(ardate[i]);
		i++;
	});
	i = 0;
	$(".up_ref").each(function() {
		arup[i] = $(this).text();
		//console.log(arup[i]);
		i++;
	});
	i = 0;
	$(".status_ref").each(function() {
		arstatus[i] = $(this).text();
		//console.log(arstatus[i]);
		i++;
	});
	i = 0;
	$(".earns_ref").each(function() {
		arearns[i] = $(this).text();
		//console.log(arearns[i]);
		i++;
	});
	i = 0;
	$(".activity_ref").each(function() {
		aractivity[i] = $(this).text();
		//console.log(aractivity[i]);
		i++;
	});
	//
	
	//
	filter = id;
	block_add_df = "false";
	check_num = "false";
	
	if(filter == "1"){

		i = 0;
		ii = 1;
		auxi = 0;
		idx = 0;
		
		while(auxi < count){

			if(type == "asc"){
				
				n1n2 = parseFloat($(".id_ref:eq("+i+")").text()) - parseFloat($(".id_ref:eq("+ii+")").text());
				if(n1n2 < 1){

					var p1 = $(".level_ref:eq("+i+")").text();
					var p2 = $(".level_ref:eq("+ii+")").text();
					$(".level_ref:eq("+i+")").text(p2);
					$(".level_ref:eq("+ii+")").text(p1);
					var p1 = $(".id_ref:eq("+i+")").text();
					var p2 = $(".id_ref:eq("+ii+")").text();
					$(".id_ref:eq("+i+")").text(p2);
					$(".id_ref:eq("+ii+")").text(p1);
					var p1 = $(".name_ref:eq("+i+")").text();
					var p2 = $(".name_ref:eq("+ii+")").text();
					$(".name_ref:eq("+i+")").text(p2);
					$(".name_ref:eq("+ii+")").text(p1);
					var p1 = $(".date_ref:eq("+i+")").text();
					var p2 = $(".date_ref:eq("+ii+")").text();
					$(".date_ref:eq("+i+")").text(p2);
					$(".date_ref:eq("+ii+")").text(p1);
					var p1 = $(".up_ref:eq("+i+")").text();
					var p2 = $(".up_ref:eq("+ii+")").text();
					$(".up_ref:eq("+i+")").text(p2);
					$(".up_ref:eq("+ii+")").text(p1);
					var p1 = $(".status_ref:eq("+i+")").text();
					var p2 = $(".status_ref:eq("+ii+")").text();
					$(".status_ref:eq("+i+")").text(p2);
					$(".status_ref:eq("+ii+")").text(p1);
					var p1 = $(".earns_ref:eq("+i+")").text();
					var p2 = $(".earns_ref:eq("+ii+")").text();
					$(".earns_ref:eq("+i+")").text(p2);
					$(".earns_ref:eq("+ii+")").text(p1);
					var p1 = $(".activity_ref:eq("+i+")").text();
					var p2 = $(".activity_ref:eq("+ii+")").text();
					$(".activity_ref:eq("+i+")").text(p2);
					$(".activity_ref:eq("+ii+")").text(p1);
					idx++;

				}else{
				
					auxi++;
				
				}

				if(idx == 0){
					i++;
					ii++;
				}else{
					i = 0;
					ii = 1;
					auxi = 0;	
					idx = 0;
				}

			}else if(type == "dec"){
				n1n2 = parseFloat($(".id_ref:eq("+ii+")").text()) - parseFloat($(".id_ref:eq("+i+")").text());
				if(n1n2 < 1){

					var p1 = $(".level_ref:eq("+i+")").text();
					var p2 = $(".level_ref:eq("+ii+")").text();
					$(".level_ref:eq("+i+")").text(p2);
					$(".level_ref:eq("+ii+")").text(p1);
					var p1 = $(".id_ref:eq("+i+")").text();
					var p2 = $(".id_ref:eq("+ii+")").text();
					$(".id_ref:eq("+i+")").text(p2);
					$(".id_ref:eq("+ii+")").text(p1);
					var p1 = $(".name_ref:eq("+i+")").text();
					var p2 = $(".name_ref:eq("+ii+")").text();
					$(".name_ref:eq("+i+")").text(p2);
					$(".name_ref:eq("+ii+")").text(p1);
					var p1 = $(".date_ref:eq("+i+")").text();
					var p2 = $(".date_ref:eq("+ii+")").text();
					$(".date_ref:eq("+i+")").text(p2);
					$(".date_ref:eq("+ii+")").text(p1);
					var p1 = $(".up_ref:eq("+i+")").text();
					var p2 = $(".up_ref:eq("+ii+")").text();
					$(".up_ref:eq("+i+")").text(p2);
					$(".up_ref:eq("+ii+")").text(p1);
					var p1 = $(".status_ref:eq("+i+")").text();
					var p2 = $(".status_ref:eq("+ii+")").text();
					$(".status_ref:eq("+i+")").text(p2);
					$(".status_ref:eq("+ii+")").text(p1);
					var p1 = $(".earns_ref:eq("+i+")").text();
					var p2 = $(".earns_ref:eq("+ii+")").text();
					$(".earns_ref:eq("+i+")").text(p2);
					$(".earns_ref:eq("+ii+")").text(p1);
					var p1 = $(".activity_ref:eq("+i+")").text();
					var p2 = $(".activity_ref:eq("+ii+")").text();
					$(".activity_ref:eq("+i+")").text(p2);
					$(".activity_ref:eq("+ii+")").text(p1);
					idx++;

				}else{
				
					auxi++;
				
				}

				if(idx == 0){
					i++;
					ii++;
				}else{
					i = 0;
					ii = 1;
					auxi = 0;	
					idx = 0;
				}
			}

		}

	}else if(filter == "2" || filter == "4" || filter == "5"){
		
		i = 0;
		ii = 1;
		auxi = 0;
		idx = 0;

		while(auxi < count){

			//start
			block_add_df = "false";
			check_num = "false";
		
			if(filter == "2" && type == "asc" || filter == "5" && type == "asc"){
				
				if(filter == "2"){

					if($(".level_ref:eq("+i+")").text() < $(".level_ref:eq("+ii+")").text()){
						check_num = "true";
					}else{
						block_add_df = "true";
					}
		
				}else{
		
					if($(".activity_ref:eq("+i+")").text() < $(".activity_ref:eq("+ii+")").text()){
						check_num = "true";
					}else{
						block_add_df = "true";
					}
				}
		
			}else if(filter == "4" && type == "asc"){
				
				num1 = parseFloat(10000) - parseFloat($(".earns_ref:eq("+i+")").text());
				num2 = parseFloat(10000) - parseFloat($(".earns_ref:eq("+ii+")").text());
			
				if(num1 > num2){
					check_num = "true";
				}else{
					block_add_df = "true";
				}
				
			}
		
			if(filter == "2" && type == "dec"  || filter == "5" && type == "dec"){
				
				if(filter == "2"){	
					
					if($(".level_ref:eq("+ii+")").text() < $(".level_ref:eq("+i+")").text()){
						check_num = "true";
					}else{
						block_add_df = "true";
					}

				}else{
					
					if($(".activity_ref:eq("+ii+")").text() < $(".activity_ref:eq("+i+")").text()){
						check_num = "true";
					}else{
						block_add_df = "true";
					}
				}

			}else if(filter == "4" && type == "dec"){
			
				num1 = parseFloat(10000) - parseFloat($(".earns_ref:eq("+ii+")").text());
				num2 = parseFloat(10000) - parseFloat($(".earns_ref:eq("+i+")").text());
			
				if(num1 > num2){
					check_num = "true";
				}else{
					block_add_df = "true";
				}
			}
			//end 
			
			if(type == "dec"){
				
				if(check_num == "true" && block_add_df == "false"){

					var p1 = $(".level_ref:eq("+i+")").text();
					var p2 = $(".level_ref:eq("+ii+")").text();
					$(".level_ref:eq("+i+")").text(p2);
					$(".level_ref:eq("+ii+")").text(p1);
					var p1 = $(".id_ref:eq("+i+")").text();
					var p2 = $(".id_ref:eq("+ii+")").text();
					$(".id_ref:eq("+i+")").text(p2);
					$(".id_ref:eq("+ii+")").text(p1);
					var p1 = $(".name_ref:eq("+i+")").text();
					var p2 = $(".name_ref:eq("+ii+")").text();
					$(".name_ref:eq("+i+")").text(p2);
					$(".name_ref:eq("+ii+")").text(p1);
					var p1 = $(".date_ref:eq("+i+")").text();
					var p2 = $(".date_ref:eq("+ii+")").text();
					$(".date_ref:eq("+i+")").text(p2);
					$(".date_ref:eq("+ii+")").text(p1);
					var p1 = $(".up_ref:eq("+i+")").text();
					var p2 = $(".up_ref:eq("+ii+")").text();
					$(".up_ref:eq("+i+")").text(p2);
					$(".up_ref:eq("+ii+")").text(p1);
					var p1 = $(".status_ref:eq("+i+")").text();
					var p2 = $(".status_ref:eq("+ii+")").text();
					$(".status_ref:eq("+i+")").text(p2);
					$(".status_ref:eq("+ii+")").text(p1);
					var p1 = $(".earns_ref:eq("+i+")").text();
					var p2 = $(".earns_ref:eq("+ii+")").text();
					$(".earns_ref:eq("+i+")").text(p2);
					$(".earns_ref:eq("+ii+")").text(p1);
					var p1 = $(".activity_ref:eq("+i+")").text();
					var p2 = $(".activity_ref:eq("+ii+")").text();
					$(".activity_ref:eq("+i+")").text(p2);
					$(".activity_ref:eq("+ii+")").text(p1);
					idx++;

				}else{
				
					auxi++;
				}

				if(idx == 0){
					i++;
					ii++;
				}else{
					i = 0;
					ii = 1;
					auxi = 0;	
					idx = 0;
					
				}

			}else if(type == "asc"){

				if(check_num == "true" && block_add_df == "false"){

					var p1 = $(".level_ref:eq("+i+")").text();
					var p2 = $(".level_ref:eq("+ii+")").text();
					$(".level_ref:eq("+i+")").text(p2);
					$(".level_ref:eq("+ii+")").text(p1);
					var p1 = $(".id_ref:eq("+i+")").text();
					var p2 = $(".id_ref:eq("+ii+")").text();
					$(".id_ref:eq("+i+")").text(p2);
					$(".id_ref:eq("+ii+")").text(p1);
					var p1 = $(".name_ref:eq("+i+")").text();
					var p2 = $(".name_ref:eq("+ii+")").text();
					$(".name_ref:eq("+i+")").text(p2);
					$(".name_ref:eq("+ii+")").text(p1);
					var p1 = $(".date_ref:eq("+i+")").text();
					var p2 = $(".date_ref:eq("+ii+")").text();
					$(".date_ref:eq("+i+")").text(p2);
					$(".date_ref:eq("+ii+")").text(p1);
					var p1 = $(".up_ref:eq("+i+")").text();
					var p2 = $(".up_ref:eq("+ii+")").text();
					$(".up_ref:eq("+i+")").text(p2);
					$(".up_ref:eq("+ii+")").text(p1);
					var p1 = $(".status_ref:eq("+i+")").text();
					var p2 = $(".status_ref:eq("+ii+")").text();
					$(".status_ref:eq("+i+")").text(p2);
					$(".status_ref:eq("+ii+")").text(p1);
					var p1 = $(".earns_ref:eq("+i+")").text();
					var p2 = $(".earns_ref:eq("+ii+")").text();
					$(".earns_ref:eq("+i+")").text(p2);
					$(".earns_ref:eq("+ii+")").text(p1);
					var p1 = $(".activity_ref:eq("+i+")").text();
					var p2 = $(".activity_ref:eq("+ii+")").text();
					$(".activity_ref:eq("+i+")").text(p2);
					$(".activity_ref:eq("+ii+")").text(p1);
					idx++;

				}else{
				
					auxi++;
				
				}

				if(idx == 0){
					i++;
					ii++;
				}else{
					i = 0;
					ii = 1;
					auxi = 0;	
					idx = 0;
				}
			}

		}
				
	}else if(filter == "3"){
		
	}else if(filter == "4"){

	}else if(filter == "5"){

	}else if(filter == "6"){
	
	}else if(filter == "7"){
		
	}

	if(filter == "10"){


		i = 0;
		ii = 1;
		auxi = 0;
		idx = 0;
		console.log($(this).children());
	/*	while(auxi < count){

			//start
			block_add_df = "false";
			check_num = "false";
		
			if(filter == "10" && type == "asc"){
				
				if(filter == "10"){

					if($(".dep-list:eq("+i+") td:eq(2)").text() < $(".dep-list:eq("+ii+") td:eq(2)").text()){
						check_num = "true";
					}else{
						block_add_df = "true";
					}
		
				}
		
			}else if(filter == "10" && type == "dec"){
				
				num1 = parseFloat(10000) - parseFloat($(".dep-list:eq("+i+") td:eq(2)").text());
				num2 = parseFloat(10000) - parseFloat($(".dep-list:eq("+ii+") td:eq(2)").text());
			
				if(num1 > num2){
					check_num = "true";
				}else{
					block_add_df = "true";
				}
				
			}
		
			//end 
			
			if(type == "dec"){
				
				if(check_num == "true" && block_add_df == "false"){

					var p1 = $(".dep-list:eq("+i+")").html();
					var p2 = $(".dep-list:eq("+ii+")").html();
					$(".dep-list:eq("+i+")").html(p2);
					$(".dep-list:eq("+ii+")").html(p1);
					
					idx++;

				}else{
				
					auxi++;
				}

				if(idx == 0){
					i++;
					ii++;
				}else{
					i = 0;
					ii = 1;
					auxi = 0;	
					idx = 0;
					
				}

			}else if(type == "asc"){

				if(check_num == "true" && block_add_df == "false"){

					var p1 = $(".dep-list:eq("+i+")").html();
					var p2 = $(".dep-list:eq("+ii+")").html();
					$(".dep-list:eq("+i+")").html(p2);
					$(".dep-list:eq("+ii+")").html(p1);
					
					idx++;

				}else{
				
					auxi++;
				
				}

				if(idx == 0){
					i++;
					ii++;
				}else{
					i = 0;
					ii = 1;
					auxi = 0;	
					idx = 0;
				}
			}

		}	*/
	}
	//
}

function ref_clickm(id){


	if($("#rfm"+id).attr("class") == "fa fa-ref fa-sort-desc text-light"){

		$("#rfm"+id).removeClass("fa fa-ref fa-sort-desc text-light");
		$("#rfm"+id).addClass("fa fa-ref fa-sort-asc text-light");	
		var type = "asc";	
	}else if($("#rfm"+id).attr("class") == "fa fa-ref fa-sort-asc text-light"){
	
		$("#rfm"+id).removeClass("fa fa-ref fa-sort-asc text-light");
		$("#rfm"+id).addClass("fa fa-ref fa-sort-desc text-light");	
		var type = "dec";
	}

	var count = $(".tbodyref tr").length;
	count = parseFloat(count) - parseFloat(1);
	
	arid = [count];
	arname = [count];
	arlevel = [count];
	ardate = [count];
	arup = [count];
	arstatus = [count];
	arearns = [count];
	aractivity = [count];
	
	//
	var i = 0;
	$(".id_refm").each(function() {
		arid[i] = $(this).text();
		console.log(arid[i]);
		i++;
	});

	i = 0;
	$(".name_refm").each(function() {
		arname[i] = $(this).text();
		console.log(arname[i]);
		i++;
	});
	
	i = 0;
	$(".level_refm").each(function() {
		arlevel[i] = $(this).text();
		console.log(arlevel[i]);
		i++;
	});
	i = 0;
	$(".date_refm").each(function() {
		ardate[i] = $(this).text();
		console.log(ardate[i]);
		i++;
	});
	i = 0;
	$(".up_refm").each(function() {
		arup[i] = $(this).text();
		console.log(arup[i]);
		i++;
	});
	i = 0;
	$(".status_refm").each(function() {
		arstatus[i] = $(this).text();
		console.log(arstatus[i]);
		i++;
	});
	i = 0;
	$(".earns_refm").each(function() {
		arearns[i] = $(this).text();
		console.log(arearns[i]);
		i++;
	});
	i = 0;
	$(".activity_refm").each(function() {
		aractivity[i] = $(this).text();
		console.log(aractivity[i]);
		i++;
	});
	//
	

	//
	filter = id;
	if(filter == "1"){

		i = 0;
		ii = 1;
		auxi = 0;
		idx = 0;
		while(auix < count){

			if(type == "asc"){
				
				if($(".id_refm:eq("+i+")").text() < $(".id_refm:eq("+ii+")").text()){

					var p1 = $(".level_refm:eq("+i+")").text();
					var p2 = $(".level_refm:eq("+ii+")").text();
					$(".level_refm:eq("+i+")").text(p2);
					$(".level_refm:eq("+ii+")").text(p1);
					var p1 = $(".id_refm:eq("+i+")").text();
					var p2 = $(".id_refm:eq("+ii+")").text();
					$(".id_refm:eq("+i+")").text(p2);
					$(".id_refm:eq("+ii+")").text(p1);
					var p1 = $(".name_refm:eq("+i+")").text();
					var p2 = $(".name_refm:eq("+ii+")").text();
					$(".name_refm:eq("+i+")").text(p2);
					$(".name_refm:eq("+ii+")").text(p1);
					var p1 = $(".date_refm:eq("+i+")").text();
					var p2 = $(".date_refm:eq("+ii+")").text();
					$(".date_refm:eq("+i+")").text(p2);
					$(".date_refm:eq("+ii+")").text(p1);
					var p1 = $(".up_refm:eq("+i+")").text();
					var p2 = $(".up_refm:eq("+ii+")").text();
					$(".up_refm:eq("+i+")").text(p2);
					$(".up_refm:eq("+ii+")").text(p1);
					var p1 = $(".status_refm:eq("+i+")").text();
					var p2 = $(".status_refm:eq("+ii+")").text();
					$(".status_refm:eq("+i+")").text(p2);
					$(".status_refm:eq("+ii+")").text(p1);
					var p1 = $(".earns_refm:eq("+i+")").text();
					var p2 = $(".earns_refm:eq("+ii+")").text();
					$(".earns_refm:eq("+i+")").text(p2);
					$(".earns_refm:eq("+ii+")").text(p1);
					var p1 = $(".activity_refm:eq("+i+")").text();
					var p2 = $(".activity_refm:eq("+ii+")").text();
					$(".activity_refm:eq("+i+")").text(p2);
					$(".activity_refm:eq("+ii+")").text(p1);
					idx++;

				}else{
				
					auxi++;
				
				}

				if(idx == 0){
					i++;
					ii++;
				}else{
					i = 0;
					ii = 1;
					auxi = 0;
					idx = 0;	
				}

			}else if(type == "dec"){

				if($(".id_refm:eq("+i+")").text() > $(".id_refm:eq("+ii+")").text()){

					var p1 = $(".level_refm:eq("+i+")").text();
					var p2 = $(".level_refm:eq("+ii+")").text();
					$(".level_refm:eq("+i+")").text(p2);
					$(".level_refm:eq("+ii+")").text(p1);
					var p1 = $(".id_refm:eq("+i+")").text();
					var p2 = $(".id_refm:eq("+ii+")").text();
					$(".id_refm:eq("+i+")").text(p2);
					$(".id_refm:eq("+ii+")").text(p1);
					var p1 = $(".name_refm:eq("+i+")").text();
					var p2 = $(".name_refm:eq("+ii+")").text();
					$(".name_refm:eq("+i+")").text(p2);
					$(".name_refm:eq("+ii+")").text(p1);
					var p1 = $(".date_refm:eq("+i+")").text();
					var p2 = $(".date_refm:eq("+ii+")").text();
					$(".date_refm:eq("+i+")").text(p2);
					$(".date_refm:eq("+ii+")").text(p1);
					var p1 = $(".up_refm:eq("+i+")").text();
					var p2 = $(".up_refm:eq("+ii+")").text();
					$(".up_refm:eq("+i+")").text(p2);
					$(".up_refm:eq("+ii+")").text(p1);
					var p1 = $(".status_refm:eq("+i+")").text();
					var p2 = $(".status_refm:eq("+ii+")").text();
					$(".status_refm:eq("+i+")").text(p2);
					$(".status_refm:eq("+ii+")").text(p1);
					var p1 = $(".earns_refm:eq("+i+")").text();
					var p2 = $(".earns_refm:eq("+ii+")").text();
					$(".earns_refm:eq("+i+")").text(p2);
					$(".earns_refm:eq("+ii+")").text(p1);
					var p1 = $(".activity_refm:eq("+i+")").text();
					var p2 = $(".activity_refm:eq("+ii+")").text();
					$(".activity_refm:eq("+i+")").text(p2);
					$(".activity_refm:eq("+ii+")").text(p1);
					idx++;

				}else{
				
					auxi++;
				
				}

				if(idx == 0){
					i++;
					ii++;
				}else{
					i = 0;
					ii = 1;
					auxi = 0;
					idx = 0;	
				}
			}

		}

	}else if(filter == "2"){
		
		i = 0;
		ii = 1;
		auxi = 0;
		idx = 0;
		while(auix < count){

			if(type == "dec"){
				
				if($(".level_refm:eq("+i+")").text() < $(".level_refm:eq("+ii+")").text()){

					var p1 = $(".level_refm:eq("+i+")").text();
					var p2 = $(".level_refm:eq("+ii+")").text();
					$(".level_refm:eq("+i+")").text(p2);
					$(".level_refm:eq("+ii+")").text(p1);
					var p1 = $(".id_refm:eq("+i+")").text();
					var p2 = $(".id_refm:eq("+ii+")").text();
					$(".id_refm:eq("+i+")").text(p2);
					$(".id_refm:eq("+ii+")").text(p1);
					var p1 = $(".name_refm:eq("+i+")").text();
					var p2 = $(".name_refm:eq("+ii+")").text();
					$(".name_refm:eq("+i+")").text(p2);
					$(".name_refm:eq("+ii+")").text(p1);
					var p1 = $(".date_refm:eq("+i+")").text();
					var p2 = $(".date_refm:eq("+ii+")").text();
					$(".date_refm:eq("+i+")").text(p2);
					$(".date_refm:eq("+ii+")").text(p1);
					var p1 = $(".up_refm:eq("+i+")").text();
					var p2 = $(".up_refm:eq("+ii+")").text();
					$(".up_refm:eq("+i+")").text(p2);
					$(".up_refm:eq("+ii+")").text(p1);
					var p1 = $(".status_refm:eq("+i+")").text();
					var p2 = $(".status_refm:eq("+ii+")").text();
					$(".status_refm:eq("+i+")").text(p2);
					$(".status_refm:eq("+ii+")").text(p1);
					var p1 = $(".earns_refm:eq("+i+")").text();
					var p2 = $(".earns_refm:eq("+ii+")").text();
					$(".earns_refm:eq("+i+")").text(p2);
					$(".earns_refm:eq("+ii+")").text(p1);
					var p1 = $(".activity_refm:eq("+i+")").text();
					var p2 = $(".activity_refm:eq("+ii+")").text();
					$(".activity_refm:eq("+i+")").text(p2);
					$(".activity_refm:eq("+ii+")").text(p1);
					idx++;

				}else{
				
					auxi++;
				
				}

				if(idx == 0){
					i++;
					ii++;
				}else{
					i = 0;
					ii = 1;	
					auxi = 0;
					idx = 0;
				}

			}else if(type == "asc"){

				if($(".level_refm:eq("+i+")").text() > $(".level_refm:eq("+ii+")").text()){

					var p1 = $(".level_refm:eq("+i+")").text();
					var p2 = $(".level_refm:eq("+ii+")").text();
					$(".level_refm:eq("+i+")").text(p2);
					$(".level_refm:eq("+ii+")").text(p1);
					var p1 = $(".id_refm:eq("+i+")").text();
					var p2 = $(".id_refm:eq("+ii+")").text();
					$(".id_refm:eq("+i+")").text(p2);
					$(".id_refm:eq("+ii+")").text(p1);
					var p1 = $(".name_refm:eq("+i+")").text();
					var p2 = $(".name_refm:eq("+ii+")").text();
					$(".name_refm:eq("+i+")").text(p2);
					$(".name_refm:eq("+ii+")").text(p1);
					var p1 = $(".date_refm:eq("+i+")").text();
					var p2 = $(".date_refm:eq("+ii+")").text();
					$(".date_refm:eq("+i+")").text(p2);
					$(".date_refm:eq("+ii+")").text(p1);
					var p1 = $(".up_refm:eq("+i+")").text();
					var p2 = $(".up_refm:eq("+ii+")").text();
					$(".up_refm:eq("+i+")").text(p2);
					$(".up_refm:eq("+ii+")").text(p1);
					var p1 = $(".status_refm:eq("+i+")").text();
					var p2 = $(".status_refm:eq("+ii+")").text();
					$(".status_refm:eq("+i+")").text(p2);
					$(".status_refm:eq("+ii+")").text(p1);
					var p1 = $(".earns_refm:eq("+i+")").text();
					var p2 = $(".earns_refm:eq("+ii+")").text();
					$(".earns_refm:eq("+i+")").text(p2);
					$(".earns_refm:eq("+ii+")").text(p1);
					var p1 = $(".activity_refm:eq("+i+")").text();
					var p2 = $(".activity_refm:eq("+ii+")").text();
					$(".activity_refm:eq("+i+")").text(p2);
					$(".activity_refm:eq("+ii+")").text(p1);
					idx++;

				}else{
				
					auxi++;
				
				}

				if(idx == 0){
					i++;
					ii++;
				}else{
					i = 0;
					ii = 1;
					auxi = 0;
					idx = 0;	
				}
			}

		}
				

	}else if(filter == "3"){
		
	}else if(filter == "4"){

	}else if(filter == "5"){

	}else if(filter == "6"){
	
	}else if(filter == "7"){
		
	}
	//
}