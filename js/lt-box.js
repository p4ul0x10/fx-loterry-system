function modal_lt_d(id){

	$.post("php/lt/tkt-details.php",{"id":id}, function(data){
		$("body").append(data);
	});

}

function inif(id){ 
	
	//start sets winners	
	if(id.charAt(0) == "w"){
	
		if(id != "w-prev-w-d" && id != "w-next-w-d"){
			
			$(".dropdown-menu-pg-w").toggle(); 
			
		}

		if($(".lights").attr("id") == "#light"){
	
			$(".dropdown-menu-pg-w").removeClass("bg-dark");
			$(".dropdown-menu-pg-w").addClass("bg-light");
			$(".page-nw").removeClass("text-light");
			$(".page-nw").addClass("color-theme");
	
		}else{

			$(".dropdown-menu-pg-w").removeClass("bg-light");
			$(".dropdown-menu-pg-w").addClass("bg-dark");
			$(".page-nw").removeClass("color-theme");
			$(".page-nw").addClass("text-light");
		
		}
	
	}

	np_now = "";

	if(id == 'w12'){
		np = 12;
	}else if(id == 'w24'){
		np = 24;
	}else if(id == 'w48'){
		np = 48;
	}else if(id.charAt(0) == 'w' && id.charAt(1) == "a"){
		str_id = id.replace("wa", "");
		np = str_id;
	}else if(id == "w-prev-w-d" || id == "w-next-w-d"){
		np_now = $(".page-size-w").text();
		np = np_now;
	}else if(id == "wdd"){
		stop();
	}
	
	if(id.charAt(0) == 'w'){

		if(np_now != ""){
			$(".page-size-w").text(np_now);
		}else{
			$(".page-size-w").text(np);
		}

		for (var i = 0; i <= 4;  i++){

			if($(".page-nw:eq("+i+")").text() == np){
				$(".page-nw:eq("+i+")").addClass("bg-theme");
				$(".page-nw:eq("+i+")").removeClass("color-theme");
				$(".page-nw:eq("+i+")").addClass("text-light");
			}else{
				$(".page-nw:eq("+i+")").removeClass("bg-theme");
			}

		}
		
		lt_dt = $(".lt_date").attr("id");
		str_dt0 = lt_dt.replace("-", "");
		str_dt1 = str_dt0.replace(" ", "");

		dt = str_dt1;
	
	}
	//end sets winners

	//start sets network
	if(id.charAt(0) == 'n'){
	
		$(".dropdown-menu-pg-n").toggle(); 
	
		if($(".lights").attr("id") == "#light"){
	
			$(".dropdown-menu-pg-n").removeClass("bg-dark");
			$(".dropdown-menu-pg-n").addClass("bg-light");
			$(".page-nn").removeClass("text-light");
			$(".page-nn").addClass("color-theme");
		
		}else{
	
			$(".dropdown-menu-pg-n").removeClass("bg-light");
			$(".dropdown-menu-pg-n").addClass("bg-dark");
			$(".page-nn").removeClass("color-theme");
			$(".page-nn").addClass("text-light");
		
		}
	
	}

	if(id == 'n10'){
		np = 10;
	}else if(id == 'n25'){
		np = 25;
	}else if(id == 'n50'){
		np = 50;
	}else if(id == 'n100'){
		np = 100;
	}else if(id == 'na'){
		np = 1000;
	}else if(id.charAt(0) == "n" && id.charAt(1) == "a"){
		str_id = id.replace("na", "");
		np = str_id;
	}else if(id == "n-prev-n-d" || id == "n-next-n-d"){
		np_now = $(".page-size-w").text();
		np = np_now;
	}else if(id == "ndd"){	
		stop();
	}

	if(id.charAt(0) == 'n'){
	
		$(".page-size-n").text(np);

		for (var i = 0; i <= 4; i++){
			
			if($(".page-nn:eq("+i+")").text() == np){
				$(".page-nn:eq("+i+")").addClass("bg-theme");
				$(".page-nn:eq("+i+")").removeClass("color-theme");
				$(".page-nn:eq("+i+")").addClass("text-light");
			}else{
				$(".page-nn:eq("+i+")").removeClass("bg-theme");
			}
	
		}
		
		dt = "null";

	}
	//end sets network

	//start att num / view
	if($(".lights").attr("id") == "#light"){
	
		theme_type = "l";
		bg_theme = "bg-light";
	
	}else{
	
		theme_type = "d";
		bg_theme = "bg-dark";
	
	}
	
	ft = "false";

	if(id != "wdd" && id != "ndd"){

		select_filter_w = $(".select-w").val();
		select_search_w = $("#search-w").val();

		if(select_filter_w != "" || select_search_w != ""){

			if(select_filter_w != "" || select_search_w != "undefined" || select_search_w != " "){
				filter_w = select_filter_w;
			}else{
				filter_w = 0;
			}

			if(select_search_w != "" || select_search_w != 0){
				search_w = select_search_w;
			}else{
				search_w = 0
			}

		}
		
		$.post('php/lt/pgs.php', {"id":id, "np":np, "data":dt, "fw":filter_w, "fs":search_w}, function(data){ 
			
			if(id.charAt(0) == "w" && data != ""){ 
				
				$(".show-last-lt").html(data); 
				ft = "true";

				//start pagination nums change status -> winners
				pg_len = $(".page-nnw").length;

				for (var i = 0; i < pg_len; i++) {

					if($(".page-nnw:eq("+i+")").attr("class") == "page-nnw page-link bc-theme color-theme bg-light" || $(".page-nnw:eq("+i+")").attr("class") == "page-nnw page-link bc-theme color-theme bg-dark"){

						$(".page-nnw:eq("+i+")").attr("class", "page-nnw page-link bg-theme bc-theme text-light");
					}
				}
				
				if(theme_type == "l"){
					$(".page-nnw:eq(0)").attr("class", "page-nnw page-link bc-theme color-theme bg-light");		
				}else{
					$(".page-nnw:eq(0)").attr("class", "page-nnw page-link bc-theme color-theme bg-dark");		
				}
				//end 
			}

			if(id.charAt(0) == "n" && data != ""){

				$(".tbodyref").html(data);

				//start pagination nums change status -> network
				pg_len = $(".page-nnn").length;

				for (var i = 0; i < pg_len; i++) {

					if($(".page-nnn:eq("+i+")").attr("class") == "page-nnn page-link bc-theme color-theme bg-light" || $(".page-nnw:eq("+i+")").attr("class") == "page-nnw page-link bc-theme color-theme bg-dark"){

						$(".page-nnn:eq("+i+")").attr("class", "page-nnn page-link bg-theme bc-theme text-light");
					}
				}
				
				if(theme_type == "l"){
					$(".page-nnn:eq(0)").attr("class", "page-nnn page-link bc-theme color-theme bg-light");		
				}else{
					$(".page-nnn:eq(0)").attr("class", "page-nnn page-link bc-theme color-theme bg-dark");		
				}
				//end
			}

			if(id.charAt(0) == "w" && ft == "true"){

				lt_dt = data[44]+""+data[45]+""+data[46]+""+data[47]+""+data[48]+""+data[49]+""+data[50]+""+data[51]+""+data[52]+""+data[53];

				if(data[38] == "a" && data[39] == "m"){
					
					lt_att = "- "+lt_dt+" 0:00 am";
			
				}

				if(data[38] == "p" && data[39] == "m"){

					lt_att = "- "+lt_dt+" 12:00 pm";
				
				}
				
				$(".lt_date").text(lt_att);
				$(".lt_date").attr("id", lt_att);

			}

		});

		//start att num pgs each click
		ts = id.length;
		ll = parseFloat(ts) - parseFloat(1);

		if(id.charAt(0) == 'w'){
		
			max_wi = $(".dropdown-menu-pg-w div:eq(3)").attr("id");
			str_max_wi = max_wi.replace("wa", "");
			max_wi = str_max_wi;

		}

		if(id.charAt(0) == 'n'){

			max_wi = $(".dropdown-menu-pg-n div:eq(4)").attr("id");
			str_max_wi = max_wi.replace("na", "");
			max_wi = str_max_wi;

		}

		iview = np;
		pg_mode = id.charAt(0);
		
		//alert("iv "+iview+" mw "+max_wi+" ivw "+iview+" bt "+bg_theme);

		$.post("php/att/att_pgs.php", {"pg_mode":pg_mode, "max_wi":max_wi, "iview": iview, "bg_theme":bg_theme}, function(data){

			if(id.charAt(0) == "w"){
				$(".pg-w ul").html(data);
			}

			if(id.charAt(0) == "n"){
				$(".pg-n ul").html(data);
			}

		});
		
		//end

	}
	//end att num pgs
}

function pgs(num) {

	//start att num / view
	lt_dt = $(".lt_date").attr("id");
	str_dt0 = lt_dt.replace("-", "");
	str_dt1 = str_dt0.replace(" ", "");

	dt = str_dt1;

	select_filter_w = $(".select-w").val();
	select_search_w = $("#search-w").val();

	if(select_filter_w != "" || select_search_w != ""){
		
		if(select_filter_w != "" || select_search_w != "undefined" || select_search_w != " "){
			filter_w = select_filter_w;
		}else{
			filter_w = 0;
		}

		if(select_search_w != "" || select_search_w != 0){
			search_w = select_search_w;
		}else{
			search_w = 0
		}

	}
	
	$.post('php/lt/pgs.php', {"num":num, "data":dt, "fw":filter_w, "fs":search_w}, function(data){ 
		
		if(data != ""){

			if(num.charAt(0) == "w"){
				pg_len = $(".page-nnw").length;
			}else{
				pg_len = $(".page-nnn").length;
			}

			pg_len_i = parseFloat(pg_len) - parseFloat(1);
		
			for (var i = 0; i < pg_len; i++) {

				if($(".lights").attr("id") == "#light"){
					theme_type = "l";
				}else{
					theme_type = "d";
				}
			
				if(num == "w-prev-w" || num == "w-next-w" || num == "n-prev-n" || num == "n-next-n"){ // left right side mode -> navigation mode
				
					if(num.charAt(0) == "w" && $(".page-nnw:eq("+i+")").attr("class") == "page-nnw page-link bc-theme color-theme bg-light" && theme_type == "l" || num.charAt(0) == "w" && $(".page-nnw:eq("+i+")").attr("class") == "page-nnw page-link bc-theme color-theme bg-dark" && theme_type == "d"
						|| num.charAt(0) == "n" && $(".page-nnn:eq("+i+")").attr("class") == "page-nnn page-link bc-theme color-theme bg-light" && theme_type == "l" || num.charAt(0) == "n" && $(".page-nnn:eq("+i+")").attr("class") == "page-nnn page-link bc-theme color-theme bg-dark" && theme_type == "d"){
											
						if(num == "w-prev-w" || num == "n-prev-n"){
							idx_npg = parseFloat(i) - parseFloat(1);
						}else if(num == "w-next-w" || num == "n-next-n"){
							idx_npg = parseFloat(i) + parseFloat(1);
						}
				
						if(idx_npg < pg_len && idx_npg >= 0){
						
							if(theme_type == "l" && num.charAt(0) == "w" || theme_type == "l" && num.charAt(0) == "n"){
			
								if(num.charAt(0) == "w"){
									$(".page-nnw:eq("+idx_npg+")").attr("class", "page-nnw page-link bc-theme color-theme bg-light");
								}else{
									$(".page-nnn:eq("+idx_npg+")").attr("class", "page-nnn page-link bc-theme color-theme bg-light");
								}

							}else if(theme_type == "d" && num.charAt(0) == "w" || theme_type == "d" && num.charAt(0) == "n"){
								
								if(num.charAt(0) == "w"){
									$(".page-nnw:eq("+idx_npg+")").attr("class", "page-nnw page-link bc-theme color-theme bg-dark");
								}else{
									$(".page-nnn:eq("+idx_npg+")").attr("class", "page-nnn page-link bc-theme color-theme bg-dark");
								}

							}

							if(num.charAt(0) == "w"){
								$(".page-nnw:eq("+i+")").attr("class", "page-nnw page-link bg-theme bc-theme text-light");
							}else if(num.charAt(0) == "n"){
								$(".page-nnn:eq("+i+")").attr("class", "page-nnn page-link bg-theme bc-theme text-light");
							}

							break;

						}

					} 
				
				}else if(num != "w-prev-w-d" && num != "w-next-w-d"){ //clicked on num -> navigation mode

					//start
					if(num.charAt(0) == "w" && $(".page-nnw:eq("+i+")").attr("id") == num || num.charAt(0) == "n" && $(".page-nnn:eq("+i+")").attr("id") == num){

						if(theme_type == "l"){
							
							if(num.charAt(0) == "w"){
								$(".page-nnw:eq("+i+")").attr("class", "page-nnw page-link bc-theme color-theme bg-light");
							}else{
								$(".page-nnn:eq("+i+")").attr("class", "page-nnn page-link bc-theme color-theme bg-light");	
							}

						}else if(theme_type == "d"){

							if(num.charAt(0) == "w"){
								$(".page-nnw:eq("+i+")").attr("class", "page-nnw page-link bc-theme color-theme bg-dark");
							}else{
								$(".page-nnn:eq("+i+")").attr("class", "page-nnn page-link bc-theme color-theme bg-dark");	
							}
						}

					}else if(num.charAt(0) == "w"){
						$(".page-nnw:eq("+i+")").attr("class", "page-nnw page-link bg-theme bc-theme text-light");
					}else{
						$(".page-nnn:eq("+i+")").attr("class", "page-nnn page-link bg-theme bc-theme text-light");	
					}
					//end
				
				}
			
			} 

			if(num.charAt(0) == "w"){ // render for lt lasts winners
				$(".show-last-lt").html(data); 
			}else{ //render for lt network table info
				$(".tbodyref").html(data);
			}
		}

	});
	//end att num  / view
}