$(document).ready(function(){

	obj_resize = $("body").width();
	//w = obj_resize - $(".mudar-senha").width() / 2;
	$("body").css("max-width", obj_resize+"px !important");
	$(".cover-container").css("max-width", obj_resize+"px !important");
	$(".mainoffice").css("max-width", obj_resize+"px !important");

	$(".login").click(function(){
		$(".modal-login").toggle();
		$(".navbar-collapse").hide();
		$("header").css({"z-index":"10001"});
	});

	$(".close").click(function(){
		
		$(".modal").hide();
		$(".box-question-fx").hide();
		$("input[type=text]").each(function () {
			$(this).val("");
		});

		$(".concluir-deposito").hide();
		$(".plan-deposit-mt-2:eq(1)").remove();
		$(".return-deposito").text("");
		$(".return-deposito").html("");
		$(".formdepositar .form-group:eq(4)").hide();
		$(".dep-confirm").remove();
		$(".ac-pay-dep").removeClass("fa-sign-out");

		$(".return-saque").text("");
		$(".return-saque").html("");
		//$(".ac-pay-dep").attr("class", "fa fa-usd fa-2x ac-pay-dep");

		$(".choose-plan a").removeClass("bg-primary");
		$(".choose-coin-dep a").removeClass("bg-light");
		$(".choose-package").removeClass("bg-primary");
		$(".choose-package").removeClass("color-theme");

		$(".prot").removeClass("bg-primary");
		$(".prot a").removeClass("text-light");
		$(".prot-with").removeClass("bg-theme");
		$(".prot-with a").removeClass("text-light");
		
		$(".prot").each(function(){
			if($(this).css("display") != "none"){
			$(this).hide();
			}
		});
	 
	 	$(".prot-with").each(function(){
			if($(this).css("display") != "none"){
			$(this).hide();
			}
		});

		$(".with-in").hide();

		if($(".concluir-saque").css("display") == "block"){
    		$(".list-amount-rest").removeClass("bg-primary");
    		$(".list-amount-rest").removeClass("text-light");
    		$(".list-amount-rest a").removeClass("text-light");
        	$(".concluir-saque").css("display", "none");
      	}  

      	$(".choose-coin-with a").each(function() {
      		$(this).removeClass("bg-light");
      	})
      	
      	$(".list_prot").hide();
    	$(".saque-user").hide();

    	$(".txt-coin-tkt").hide();
    	$(".buy-tkt-user").hide();
    	$(".buy-tkt-user").val("");
       	$(".return-deposito-tkt").html("");
       	$(".concluir-deposito-tkt").hide();
       	$("#show-pending-deps").remove();
       	$(".tkt-response").remove();

	});

	$(".criar-acc").click(function(){
		
		var fname =	$("#fname").val();
		var lname = $("#lname").val();
		var email = $("#emailcriaracc").val();
		var senha = $("#senhacc").val();
	    var sponsor = $("#indicado_por").val();
	    var typea = $(".typea").val();
		
		if(fname == "" || lname == "" || email == "" || senha == "" || sponsor == ""){
		
			$(".return-cria").html("<p class='alert-danger'>Ops, check all fields ...</p>");
			return false;
		
		}else if($(".terms").attr("name") != "checked"){
			
			alert("Terms not selected");
		
		}else if($(".terms").attr("name") == "checked"){

			$(".text-term").hide();
		
			$.post('php/cria-acc.php',{"fname":fname, "lname":lname, "email":email, "senha":senha, "sponsor":sponsor, "subject":typea}, function(data){
		
				$(".return-cria").html(data);
				setTimeout(function(){
					//location.reload();
				}, 2500);
		
			});

		}

	});
   
    var url = location.href;
	
	if(url.indexOf("sponsor")==-1) {
		$('.indicado_por').val("fxrobot");
	}else{
		//$('.sponsor').val("walk");
	}
 
	$(".fazer-login").click(function(){
	
		var email = $(".emaillogin").val();
		var senha = $(".senhalog").val();

		if (email == "" || senha == "") {
			$(".return-login").html("<p class='alert-danger'>Press your email and password !</p>");
		}else{
			$.post('php/login.php',{"email":email,"senha":senha}, function(data){
				$(".return-login").html(data);

			});
		}
	
	});

	$(".btnback").click(function(){
		location.href="backoffice.php";
	});

	$(".open-dc").click(function(){

		$(".container-dc").toggle();

	});

    $(".cancelar-senha").click(function(){

    	$(".senha-atual").val("");
    	$(".nova-senha1").val("");
    	$(".nova-senha2").val("");
		$(".change-pw").toggle();

	});

    $(".cancelar-email").click(function(){ 
    	
    	$(".change-email").toggle(); 
	
	});
    
    $(".link-not").click(function(){

		$(".modal-not").toggle();

	});

	$(".removar-senha").click(function(){
		
		var senha = $(".senha-atual").val();
		var nova1 = $(".nova-senha1").val();
		var nova2 = $(".nova-senha2").val();
		var email = $(".emailuser").text();
		var type = $(".typep").val();
		
		if(senha == "" || nova1 == "" || nova2 == "" || email == ""){
		
			$(".return-nova").html("<p class='alert-danger card'>Please, check fields above.</p>");
			return false;
		
		}

		if(nova1 != nova2){
		
			$(".return-nova").html("<p class='alert-danger card'>Ops, combine password invalid...</p>");
			return false;
		
		}else{
		
			$.post('php/nova-senha.php',{"senha":senha,"nova1":nova1,"nova2":nova2,"email":email,"subject":type}, function(data){
				$(".return-nova").html(data);
				setTimeout(function(){
					location.reload();
				}, 3500);
			});
		
		}

	});
   
    $(".concluir-deposito").click(function(){

    	if($(".concluir-deposito").text() == "Confirm here"){
    			
			$(".concluir-deposito").text("Create");
			$(".return-deposito p").html("<p class='color-theme'>Deposit confirmed <i class='fa fa-check'></i></p>");
			$(".return-deposito p i").addClass("color-theme");
    		$(".concluir-deposito").attr("id", "confirmed-dep");

    	}else if($(".concluir-deposito").text() == "Create"){

	    	plan_b = true;

	   		var coin = $("#coin_selected").val();
	   		
	   		plan = "buy-package";
	   		total_acc = $(".total-acc-user").text();
	   		total_buy = parseFloat(total_acc) - parseFloat($(".deposito-user").val());

	   		if(total_buy < 0 && $("#plan_selected").val() != "founds"){
	   			plan_b = false;
	   		}
	   		
	   		if($("#plan_selected").val() == "founds"){

		 		plan = "founds";
		 		if($(".deposito-user").val() < 5){
		 			plan_b = false;
		 			$(".return-deposito p").remove();
		 			$(".return-deposito").append("<p class='text-warning'>Min for "+Plan+" $ 5</p>");
		 		}else if($("#plan_selected").val() > 50000){
		 			plan_b = false;
		 			$(".return-deposito p").remove();
		 			$(".return-deposito").append("<p class='text-warning'>Max for "+Plan+" $ 50000</p>");
		 		}

		 	}

		 	const region = $("body").attr("id"); // code country

		 	if(region == "US" || region == "en-US" || region == "us" || region == "EN-US" || region == "en-us"){
		 		api_url = "https://api.binance.us";
		 	}else{
		 		api_url = "https://api.binance.com";
		 	}

	   		if(coin == "btc" && plan_b == true){
						
				$.getJSON(""+api_url+"/api/v3/ticker/price?symbol=BTCUSDT", function(data){
		   				
					convert_current = $(".deposito-user").val() / data['price'];
					var nome = $(".nome-user").val();
			   		var quantidade = $(".deposito-user").val();
			   		var email = $(".email-user").val();
			   		var type = $(".typed-user").val();
			   		var plan = $("#plan_selected").val();
			   		var coin = $("#coin_selected").val();

			   		count_prot = $(".prot").length;	

			   		for(i = 0; i < count_prot+1; i++){
			   			if($(".prot:eq("+i+")").attr("class") == "prot bg-theme"){
			   				prot = $(".prot:eq("+i+")").attr("id");
			   			} 
			   		}
				
					$(".return-deposito").html("<p class='alert-success'>Processing your deposit <i class='fa  fa-pulse'></i></p>");
		   			$.post('php/deposito.php', {"nome":nome,"valor":quantidade,"email":email,"subject":type,"coin":coin,"plan":plan,"prot":prot,"convert":convert_current}, function(data){
		   			
			   			setTimeout(function(){
							$(".return-deposito").html(data);
							$(".concluir-deposito").hide();
						}, 1500);
		   			});

				}).fail(function( dat, textStatus, error ) {
			    	alert("api connect error, try again");
				});

			}else if(coin == "eth" && plan_b == true){

				$.getJSON(""+api_url+"/api/v3/ticker/price?symbol=ETHUSDT", function(data){

		   			convert_current = $(".deposito-user").val() / data['price'];
					var nome = $(".nome-user").val();
			   		var quantidade = $(".deposito-user").val();
			   		var email = $(".email-user").val();
			   		var type = $(".typed-user").val();
			   		var plan = $("#plan_selected").val();
			   		var coin = $("#coin_selected").val();

			   		count_prot = $(".prot").length;
			   		for(i = 0; i < count_prot+1; i++){
			   			if($(".prot:eq("+i+")").attr("class") == "prot bg-theme"){
			   				prot = $(".prot:eq("+i+")").attr("id");
			   			} 
			   		}
					
					$(".return-deposito").html("<p class='alert-success'>Processing your deposit <i class='fa  fa-pulse'></i></p>");
		   			$.post('php/deposito.php', {"nome":nome,"valor":quantidade,"email":email,"subject":type,"coin":coin,"plan":plan,"prot":prot,"convert":convert_current}, function(data){
		   			
		   			setTimeout(function(){
							$(".return-deposito").html(data);
							$(".concluir-deposito").hide();
						}, 1500);
		   			});

				}).fail(function( dat, textStatus, error ) {
			    	alert("api connect error, try again");
				});

			}else if(coin == "ltc" && plan_b == true){
				
				$.getJSON(""+api_url+"/api/v3/ticker/price?symbol=LTCUSDT", function(data){
		   			
					convert_current = $(".deposito-user").val() / data['price'];
					var nome = $(".nome-user").val();
			   		var quantidade = $(".deposito-user").val();
			   		var email = $(".email-user").val();
			   		var type = $(".typed-user").val();
			   		var plan = $("#plan_selected").val();
			   		var coin = $("#coin_selected").val();

			   		count_prot = $(".prot").length;
			   		for(i = 0; i < count_prot+1; i++){
			   			if($(".prot:eq("+i+")").attr("class") == "prot bg-theme"){
			   				prot = $(".prot:eq("+i+")").attr("id");
			   			} 
			   		}

					$(".return-deposito").html("<p class='alert-success'>Processing your deposit <i class='fa  fa-pulse'></i></p>");
		   			$.post('php/deposito.php', {"nome":nome,"valor":quantidade,"email":email,"subject":type,"coin":coin,"plan":plan,"prot":prot,"convert":convert_current}, function(data){
		   			
		   			setTimeout(function(){
							$(".return-deposito").html(data);
							$(".concluir-deposito").hide();
						}, 1500);
		   			});

				}).fail(function( dat, textStatus, error ) {
			    	alert("api connect error, try again");
				});

			}else if(coin == "tron" && plan_b == true){

				$.getJSON(""+api_url+"/api/v3/ticker/price?symbol=TRXUSDT", function(data){
		   			
					convert_current = $(".deposito-user").val() / data['price'];
					var nome = $(".nome-user").val();
			   		var quantidade = $(".deposito-user").val();
			   		var email = $(".email-user").val();
			   		var type = $(".typed-user").val();
			   		var plan = $("#plan_selected").val();
			   		var coin = $("#coin_selected").val();

			   		count_prot = $(".prot").length;
			   		for(i = 0; i < count_prot+1; i++){
			   			
			   			if($(".prot:eq("+i+")").attr("class") == "prot bg-theme"){
			   				prot = $(".prot:eq("+i+")").attr("id");
			   			} 
			   		}

					$(".return-deposito").html("<p class='alert-success'>Processing your deposit <i class='fa  fa-pulse'></i></p>");
		   			$.post('php/deposito.php', {"nome":nome,"valor":quantidade,"email":email,"subject":type,"coin":coin,"plan":plan,"prot":prot,"convert":convert_current}, function(data){
		   			
		   				setTimeout(function(){
							$(".return-deposito").html(data);
							$(".concluir-deposito").hide();
						}, 1500);

		   			});

				}).fail(function( dat, textStatus, error ) {
			    	alert("api connect error, try again");
				});

			}else if(coin == "bnb" && plan_b == true){

				$.getJSON(""+api_url+"/api/v3/ticker/price?symbol=BNBUSDT", function(data){
		   			
					convert_current = $(".deposito-user").val() / data['price'];
					var nome = $(".nome-user").val();
			   		var quantidade = $(".deposito-user").val();
			   		var email = $(".email-user").val();
			   		var type = $(".typed-user").val();
			   		var plan = $("#plan_selected").val();
			   		var coin = $("#coin_selected").val();

			   		count_prot = $(".prot").length;
			   		for(i = 0; i < count_prot+1; i++){
			   			if($(".prot:eq("+i+")").attr("class") == "prot bg-theme"){
			   				prot = $(".prot:eq("+i+")").attr("id");
			   			} 
			   		}
					
					$(".return-deposito").html("<p class='alert-success'>Processing your deposit <i class='fa  fa-pulse'></i></p>");
		   			$.post('php/deposito.php', {"nome":nome,"valor":quantidade,"email":email,"subject":type,"coin":coin,"plan":plan,"prot":prot,"convert":convert_current}, function(data){
		   			
			   			setTimeout(function(){
							$(".return-deposito").html(data);
							$(".concluir-deposito").hide();
						}, 1500);

	   				});

				}).fail(function( dat, textStatus, error ) {
			    	alert("api connect error, try again");
				});

			}else if(coin == "usdt" && plan_b == true){

				convert_current = $("#coin_selected").val();
				var nome = $(".nome-user").val();
		   		var quantidade = $(".deposito-user").val();
		   		var email = $(".email-user").val();
		   		var type = $(".typed-user").val();
		   		var plan = $("#plan_selected").val();
		   		var coin = $("#coin_selected").val();

		   		count_prot = $(".prot").length;
		   		for(i = 0; i < count_prot+1; i++){
		   			if($(".prot:eq("+i+")").attr("class") == "prot bg-theme"){
		   				prot = $(".prot:eq("+i+")").attr("id");
		   			} 
		   		}

				//$(".return-deposito p").remove();
				$(".return-deposito").append("<p class='alert-success'>Processing your deposit <i class='fa  fa-pulse'></i></p>");
	   			$.post('php/deposito.php', {"nome":nome,"valor":quantidade,"email":email,"subject":type,"coin":coin,"plan":plan,"prot":prot,"convert":convert_current}, function(data){
					
		   			setTimeout(function(){
						$(".return-deposito").html(data);
						$(".concluir-deposito").hide();		
					}, 1500);

				});	

			}else if(coin == "pix-nubank" && plan_b == true){

				convert_current = $("#coin_selected").val();
				var nome = $(".nome-user").val();
		   		var quantidade = $(".deposito-user").val();
		   		var email = $(".email-user").val();
		   		var type = $(".typed-user").val();
		   		var plan = $("#plan_selected").val();
		   		var coin = $("#coin_selected").val();

		   		count_prot = $(".prot").length;
		   		for(i = 0; i < count_prot+1; i++){
		   			if($(".prot:eq("+i+")").attr("class") == "prot bg-theme"){
		   				prot = $(".prot:eq("+i+")").attr("id");
		   			} 
		   		}
		   		alert(convert_current);
				//$(".return-deposito p").remove();
				$(".return-deposito").append("<p class='alert-success'>Processing your deposit <i class='fa  fa-pulse'></i></p>");
	   			$.post('php/deposito.php', {"nome":nome,"valor":quantidade,"email":email,"subject":type,"coin":coin,"plan":plan,"prot":prot,"convert":convert_current}, function(data){
					
		   			setTimeout(function(){
						$(".return-deposito").html(data);
						$(".concluir-deposito").hide();		
					}, 1500);
		   		});
		   	}
			
			$(".choose-coin-dep a").each(function() {
				$(this).removeClass("bg-theme");
			});
			
	   		if($(".return-deposito").text() != "Deposit pre-valided " || $(".return-deposito").text() != "Processing your deposit "){
	   			document.getElementsByClassName("mbs")[0].scroll({top: 100}); 		
	   		} 

		}

   	});
	

   $(".concluir-deposito").hide();
   $(".confirm-here").hide();
   //$(".concluir-deposito-f").hide();
   
   $(".link-dep").click(function(){
   	$(".modal-depositar").show();
   });
   
   $(".c-deposito-f").click(function(){

   	$(".modal-depositar").show();
   	$(".modal-depositar .modal-title").text("Make a deposit founds");
   	$(".pg").hide();
   	$("#plan_selected").val("founds");
   	
   	//$(".modal-depositar .form-group:eq(3)").hide();

	if($(".lights").attr("id") == "#light"){
			
		$(".modal-content").removeClass("bg-dark");
		$(".modal-content").addClass("bg-light");
		$(".modal-content").removeClass("text-light");
		$(".modal-content").addClass("color-theme");

		$(".modal-depositar .modal-header").addClass("bg-theme");
		$(".modal-depositar .modal-title").addClass("text-light");
		
	}else{

		$(".modal-content").removeClass("bg-light");
		$(".modal-content").addClass("bg-dark");
		$(".modal-content").removeClass("color-theme");
		$(".modal-content").addClass("text-light");

		$(".modal-depositar .modal-header").addClass("bg-theme");
		$(".modal-depositar .modal-title").addClass("text-light");
		
	}

   });

   $(".deposito-user").keyup(function(){

   		$(".mdp").attr("id", "");

   		var quantidade = $(".deposito-user").val();
   		
        $(".return-deposito").html("<p class='alert-success'>Processing your deposit <i class='fa fa-pulse'></i></p>");
	
		setTimeout(function(){

			var coin = $("#coin_selected").val();
	   		Plan = $("#plan_selected").val();
	   		plan_b = true;
	   		amount = $(".deposito-user").val();
	   	
	   		if($("#plan_selected").val() == "founds"){ //for founds deposits
		 		if($(".deposito-user").val() < 5){
		 			$(".return-deposito").append("<p class='text-warning'>Min for "+Plan+" $ 5</p>");
		 			$(".concluir-deposito").hide();
		 		}else if($(".deposito-user").val() >= 5){
		 			$(".return-deposito").html("<p class='alert-success'>Deposit pre-valided");
		 			$(".concluir-deposito").show();
		 		}

		 	}else{

		 		total_acc = $(".total-acc-user").text();
		   		total_buy = parseFloat(total_acc) - parseFloat($(".deposito-user").val());
		   		v_tkt = parseFloat($(".deposito-user").val()) / parseFloat(0.2);

		   		if(total_buy >= 0 && $("#plan_selected").val() != "founds"){

		   			$(".formdepositar .form-group:eq(4) .row span:eq(1)").remove();
		   			$(".formdepositar .form-group:eq(4) .row span").after('<span class="plan-deposit-mt-2">Tickets: <p class="cv text-muted total-tkt-buy" style="display: inline-block;">'+v_tkt+'</p> <i class="fa fa-cubes fa-1x text-muted" aria-hidden="true"></i></span>');
		   			$(".return-deposito").html("<p class='alert-success'>Deposit pre-valided <i class='fa fa-check'></i></p>");
		 			
					$(".concluir-deposito").text("Confirm here");
		 			$(".concluir-deposito").show();
		   		
		   		}
		 	
		 	}

		 	ml = $(".plan-deposit-mt-2 .total-acc-user").text();
		 	str_ml = ml.replace(" ","");
		 	du = $(".deposito-user").val();

		 	res = parseFloat(str_ml) - parseFloat(du);
		 
		 	if(res < 0 && Plan != "founds"){
		 	
		 		$(".return-deposito").html("<p class='alert-danger'>Deposit amount invalid, max limit "+ml+"</p>");
		 		$(".concluir-deposito").hide();
		 	
		 	}

		 	v = $(".deposito-user").val();
		 	
		 	if(v.length < 1){

		 		$(".formdepositar .form-group:eq(4) .row span:eq(1)").remove();
		 		$(".return-deposito p").remove();
		 		$(".concluir-deposito").hide();
		 	
		 	}

		}, 1200);
			
   });

  	$(".c-deposito").click(function(){

    	$(".modal-depositar").toggle();
    	$(".pg").show();	
  		$(".modal-depositar .modal-title").text("Make a deposit");
		
		$(".modal-depositar .form-group:eq(3)").show();

  		if($(".lights").attr("id") == "#light"){
  			
			$(".modal-content").removeClass("bg-dark");
			$(".modal-content").addClass("bg-light");
			$(".modal-content").removeClass("text-light");
			$(".modal-content").addClass("color-theme");

			$(".modal-depositar .modal-header").addClass("bg-theme");
			$(".modal-depositar .modal-title").addClass("text-light");
  		
  		}else{

  			$(".modal-content").removeClass("bg-light");
			$(".modal-content").addClass("bg-dark");
			$(".modal-content").removeClass("color-theme");
			$(".modal-content").addClass("text-light");

			$(".modal-depositar .modal-header").addClass("bg-theme");
  			$(".modal-depositar .modal-title").addClass("text-light");
  		
  		}

  		width = $("body").width();

      	if(width < 700){
  		
  			for (var i = 0; i < 3; i++) {
	    	  	$(".choose-plan a").addClass("btn-sm");
	    	}
		
		}else{

			for (var i = 0; i < 3; i++) {
	    	  	$(".choose-plan a").removeClass("btn-sm");
	    	}

		}

	});

	$(".tkt-buy").click(function(){

    	$(".modal-tkt-buy").toggle();

    	if($(".lights").attr("id") == "#light"){
  			
			$(".modal-content").removeClass("bg-dark");
			$(".modal-content").addClass("bg-light");
			$(".modal-content").removeClass("text-light");
			$(".modal-content").addClass("color-theme");

			$(".modal-contentp .modal-header").addClass("bg-theme");
			$(".modal-contentp .modal-title").addClass("text-light");
  		
  		}else{

  			$(".modal-content").removeClass("bg-light");
			$(".modal-content").addClass("bg-dark");
			$(".modal-content").removeClass("color-theme");
			$(".modal-content").addClass("text-light");

			$(".modal-contentp .modal-header").addClass("bg-theme");
  			$(".modal-contentp .modal-title").addClass("text-light");
  		
  		}

  		package_len = $(".choose-package").length;

		for (var i = 0; i < package_len; i++) {
		 
		  if($(".choose-package:eq("+i+")").attr("class") == "nav-item choose-package"){

		    $(".choose-package:eq("+i+")").addClass("color-theme");
		    
		  }
		 
		}

	});
   
    $(".btnsaque").click(function(){

       $(".modal-saque").show();
    
       if($(".lights").attr("id") == "#light"){
  			
			$(".modal-content").removeClass("bg-dark");
			$(".modal-content").addClass("bg-light");
			$(".modal-content").removeClass("text-light");
			$(".modal-content").addClass("color-theme");

			$(".modal-saque .modal-header").addClass("bg-theme");
			$(".modal-saque .modal-title").addClass("text-light");
  		
  		}else{

  			$(".modal-content").removeClass("bg-light");
			$(".modal-content").addClass("bg-dark");
			$(".modal-content").removeClass("color-theme");
			$(".modal-content").addClass("text-light");

			$(".modal-saque .modal-header").addClass("bg-theme");
  			$(".modal-saque .modal-title").addClass("text-light");
  		
  		}

    });
     
    $(".concluir-saque").click(function(){

   		var v_saque = $("#saque-user").val();
   		var nome_user = $(".nome-user-s").val();
   		var type = "withdraw";
   		var walletw = $("#wallet-user").val();

   		count_list_dep = $(".list-amount-rest").length;
   		for(var i = 0; i < count_list_dep; i++) {
   			
   			if($(".list-amount-rest:eq("+i+")").attr("class") == "list-amount-rest text-light bg-primary"){
   				
   				id_dep = $(".list-amount-rest:eq("+i+")").attr("id");
   				if(id_dep.indexOf("dep") > 0){
   					type_out = "dep";
   				}
   				if(id_dep.indexOf("loterry") > 0){
   					type_out = "loterry";
   				}
   			}

   		}

   		for(var i = 0; i <= 15; i++) {
   			
   			if($(".prot-with:eq("+i+")").attr("class") == "prot-with bg-theme"){
   				prot = $(".prot-with:eq("+i+") a").text();
   			}

   		}

   		for(var i = 0; i <= 15; i++) {
   			
   			if($(".choose-coin-with:eq("+i+") a").attr("class") == "nav-link bg-light"){
   				get_coin = $(".choose-coin-with:eq("+i+") a").attr("href");
   			}

   		}

   		coin = get_coin.replace("#", "");

		$(".return-saque").html("Processing withdraw <i class='fa  fa-pulse'></i>");

   		if(v_saque != "" && nome_user != "" && id_dep != "" && walletw != "" && type != "" && coin != "" && prot != ""){

	   		$.post('php/saque.php',{"type_out":type_out,"valor":v_saque,"nome_user":nome_user,"id_dep":id_dep,"wallet":walletw,"subject":type,"coin":coin,"prot":prot}, function(data){
	   			
	   			$(".return-saque").html(data);

	   		});
   		
   		}else{
   			alert("field invalid");
   		}

    });

   $(".a-rate").click(function(){
   		$(".modal-rate").show();
   });

   $(".concluir-rate").click(function(){
   		
   		var rate = $(".rate_new").val();

   		if(rate == ""){

   			$(".return-rate").text("insert value for rate");
   			return false;
   		}
   		$.post('php/changerate.php',{"rate":rate}, function(data){
   			$(".return-rate").html(data);
   		});
   
   });

   $(".btn-edit-title").click(function(){
   
   		var title = $(".title-edt").val();
   		$(".title-return").text("Editing waiting ...");
   		$.post('php/edit-titulo.php',{"titulo":title}, function(data){
   			setTimeout(function(){
   				$(".title-return").html(data);
   			}, 2000);
   		});
   
   });

    $(".btn-edit-desc").click(function(){
   
   		var desc = $(".desc-edt").val();
   		$(".desc-return").text("Editing description waiting...");
   		$.post('php/edit-desc.php',{"desc":desc}, function(data){
   			setTimeout(function(){
   				$(".desc-return").html(data);
   			}, 2000);
   		});
   
   });

	$(".navbar-toggler").click(function(){
   		
		$(".navbar-collapse").toggle();
	
	});

  	$(".lt-details").click(function(){

  		if($(this).attr("id") == "lt-d-0"){

  			$(this).attr("id", "lt-d-1");
  			
  		}else{
  		
  			$(this).attr("id", "lt-d-0");
  	
  		}

  	});

	//start 1 sec att front data 
	setInterval(function(){
				
		div_len0 = $(".hms-dep-p").length;
		div_len1 = $(".hms-with-p").length;

		if(div_len0 > 0 || div_len1 > 0){ //get set time left

			if(div_len0 > 0){
				show_p_url = "php/dep/show-pending-dep-time";
			}else{
				show_p_url = "php/with/show-pending-with-time";
			}
			
		  	$.post(show_p_url+'.php',{}, function(data){

		  		att_json_time = JSON.parse(data);

		  		if(div_len0 > 0){
	        
	        	    $(".hms-dep-p:eq(0)").text(att_json_time[0]);
	            	$(".hms-dep-p:eq(1)").text(att_json_time[1]);
	            	$(".hms-dep-p:eq(2)").text(att_json_time[2]);
	            	$(".hms-dep-p:eq(3)").text(att_json_time[3]);
	            	$(".hms-dep-p:eq(4)").text(att_json_time[4]);
	        
	        	}else{

	        		$(".hms-with-p:eq(0)").text(att_json_time[0]);
	            	$(".hms-with-p:eq(1)").text(att_json_time[1]);
	            	$(".hms-with-p:eq(2)").text(att_json_time[2]);
	            	$(".hms-with-p:eq(3)").text(att_json_time[3]);
	            	$(".hms-with-p:eq(4)").text(att_json_time[4]);

	        	}
	        
	        });

		}

		getT = location.href;

		if(getT.indexOf("modal-deposits") >= 1){

		   	//start
		   	getTime = $(".timestamp_dep").text();
		   	mode_on = true;
		   	
		   	//time for deposit
		   	re_getTime = getTime.replace("time for deposit ", "");
		   	if(re_getTime >= 0){

			   	if(re_getTime < 1 && mode_on == true){
			
			   	 	$(".ac-pay-dep").each(function(){
			
			   	 		if($(this).attr("class") == "fa fa-2x ac-pay-dep fa-sign-out" || $(this).attr("class") == "fa fa-2x ac-pay-dep fa-usd"){
			   	 			
			   	 			if(getTime == "time for deposit 0"){
			   	 				$(this).removeClass("fa-sign-out");
			   	 				$(this).addClass("fa-usd");
			   	 			}
			
			   	 		}
			
			   	 	});
			   		
			   		$(".dep-confirm").remove();
			   		mode_on = false;
			
			   	}

			   	if(re_getTime >= 1 && mode_on == true){
			   		decTime = parseFloat(re_getTime) - parseFloat(1);
			 	}

			   	if(decTime >= 0 && decTime < 60 && mode_on == true){
			   		mode_on = true;
			   		$(".timestamp_dep").text("time for deposit "+decTime);
			   	}
		   	
		   	}

	   	}
	   	//end

	 	//start att pt1
	 	tacc = $(".ini-top:eq(0) a:eq(0) p").text();
	 	taccp = $(".ini-top:eq(0) a:eq(1) p").text();
	 	tprofit = $(".total-profit-user").text();
	 	tacca = $(".ini-top:eq(1) a:eq(0) p").text();
	 	taccap = $(".ini-top:eq(1) a:eq(1) p").text();

	   	$.post("php/att/t1.php",{"tacc":tacc, "taccp":taccp, "tacca":tacca, "taccap":taccap, "tprofit":tprofit}, function(data){

	   		att_json = JSON.parse(data);

	   		if(att_json[0] != 0){ $(".ini-top:eq(0) a:eq(0) p").text(att_json[0]); }
	   		if(att_json[1] != 0){ $(".ini-top:eq(0) a:eq(1) p").text(att_json[1]); }
	   		if(att_json[2] != 0){ $(".total-acc-user").text(att_json[2]); }
	   		if(att_json[3] != 0){ $(".ini-top:eq(1) a:eq(1) p").text(att_json[3]); }
	   		if(att_json[4] != 0){ $(".total-profit-user").text(att_json[4]); }
	   		
	   	});
	 	//end att pt1

	 	//start att pt2
	   	tparticipants = $(".t-participants").text();
	   	tentrys = $(".t-entrys").text();
	   	ttickets = $(".t-tickets").text();
	   	tmax_winners = $(".t-max-winners").text();
	   	trewards = $(".t-rewards").text();

	   	if($(".lt-details").attr("id") == "lt-d-1"){
	 		lt_d = 0;
	 	}else{
	 		lt_d = 1;
	 	}

	   	$.post("php/att/t2.php",{"tp":tparticipants, "te":tentrys, "tt":ttickets, "tmw":tmax_winners, "tr":trewards, "ltd":lt_d}, function (data){
	   		
	   		att_json = JSON.parse(data);
	   	
	   		if(att_json[0] != 0){ $(".t-participants").text(att_json[0]); }
	   		if(att_json[1] != 0){ $(".t-entrys").text(att_json[1]); }
	   		if(att_json[2] != 0){ $(".t-tickets").text(att_json[2]); }
			if(att_json[3] != 0){ $(".t-max-winners").text(att_json[3]); }
	   		if(att_json[4] != 0){ $(".t-rewards").text(att_json[4]); }
			if(att_json[5] != 0){  

				add_div = '<div class="lt-ys row fluid-container"></div>';	
		
				$(".lt-details").attr("id", "lt-d-1");	
				
				if($(".lt-details:eq(0)").attr("class") == "col-6 btn float-right lt-details color-theme btn-theme-outline"){
					
					$(".lt-details").removeClass("btn-theme-outline");
					$(".lt-details").removeClass("color-theme");
					$(".lt-details").addClass("bg-theme");
		  			$(".lt-details").addClass("text-light");
					
					$(".t-lt-details").remove();
					$(".lt-ys:eq(1)").remove();

				}else{
			
					$(".lt-details").removeClass("bg-theme");
		  			$(".lt-details").removeClass("text-light");
		  			$(".lt-details").addClass("color-theme");
					$(".lt-details").addClass("btn-theme-outline");
					
					$(".lt-ys:eq(0)").after('<h5 class="color-theme mt-3 mb-3 t-lt-details">Your loterry resume</h5>'+add_div);
					$(".lt-ys:eq(1)").html(att_json[5]);	
				
				}

				if(lt_d == 0){

		  			$(this).attr("id", "lt-d-1");
		  			
		  		}else{
		  		
		  			$(this).attr("id", "lt-d-0");
		  		
		  		}	
			
			}
		
	   	});
	   	//end att pt2

		//start session bets
		first_div = $(".box-l a").first();
		first_bet = first_div.attr("id");
	
	   	$.post("php/lt/current_att.php", {"first_id": first_bet}, function(data){
	   		if(data != ""){
	   			$(".box-overflow-xltb div ul").html(data);
	   		}

	   	});
		//end

		//start plans home render
		url_index = location.href;
	   	if(url_index.indexOf("index.php") > 0){

		   	wd = window.innerWidth;
		   	
		   	str_pc = $(".slider-plan").attr("id");
		   	str_pc_replace = str_pc.replace("sec-", "");

			pc = str_pc_replace;

			if(wd > 600 && wd < 990){

				pc++; 
				$(".slider-plan").attr("id", "sec-"+pc);

				if($(".sp-mg-plan:eq(1)").attr("style") == "display: none;" && $(".sp-mg-plan:eq(2)").attr("style") == "display: none;"){
					
					if(pc > 3){
					
						$(".sp-mg-plan:eq(1)").toggle();
						$(".sp-mg-plan:eq(0)").hide();
						pc = 0;
						
						current_banner = 1;
						$(".prev-plan-btn").attr("id", "prev-plan-btn-1");	
						$(".next-plan-btn").attr("id", "next-plan-btn-3");	
						$(".slider-plan").attr("id", "sec-0");

					}
				
					
				}else if($(".sp-mg-plan:eq(1)").attr("style") == ""){
		
					if(pc > 3){
					
						$(".sp-mg-plan:eq(2)").toggle();
						$(".sp-mg-plan:eq(1)").hide();
						pc = 0;
						
						current_banner = 2;
						$(".prev-plan-btn").attr("id", "prev-plan-btn-2");	
						$(".next-plan-btn").attr("id", "next-plan-btn-3");	
						$(".slider-plan").attr("id", "sec-0");

					}

				}else{
					
					if(pc > 3){
						
						$(".sp-mg-plan:eq(0)").toggle();
						$(".sp-mg-plan:eq(2)").hide();
						pc = 0;
						
						current_banner = 3;
						$(".prev-plan-btn").attr("id", "prev-plan-btn-1");	
						$(".next-plan-btn").attr("id", "next-plan-btn-2");	
						$(".slider-plan").attr("id", "sec-0");

					}

				}
			
			}	

		}
		//end

	}, 1000);
	//end 1 sec att front data

	$(".lg-mode").on('click', function(){

		var set_lights = $(".lights").attr("id");

		$.post('php/lights-mode.php', {"lights":set_lights}, function(data){
	   		
	   		console.log(data);
			
			if(data == "dark"){

				$(".lights").attr("id", "#dark");
			
				$(".hr").removeClass("text-light");
				$(".hr").addClass("text-muted");

				$(".bg-light").each(function(){
					$(this).removeClass("bg-light");
					$(this).addClass("bg-dark");
				});

				$("strong").each(function(){
					if($(this).text() != "Network / referrals"){
						$(this).removeClass("color-theme");
						$(this).addClass("text-light");
					}
				});

				$("table").each(function(){
					$(this).removeClass("table-light");
					$(this).addClass("table-dark");
				});

				$("table thead").each(function(){
					$(this).removeClass("color-theme");
					$(this).addClass("text-light");
				});

				$("tbody").each(function(){
					if($(this).attr("class") == "color-theme"){
						$(this).removeClass("color-theme");
						$(this).addClass("text-light");
					}
				});

				$("th a").each(function(){
					$(this).removeClass("color-theme");
					$(this).addClass("text-light");
				});
				
				$("td a").each(function(){
					
					color = $(this).css("color");
					//alert(color);
					if(color == "rgb(17, 18, 36)"){
						$(this).removeClass("color-theme");
						$(this).addClass("text-light");
					}
				});

				$("tr td").each(function(){
					
					$(this).removeClass("color-theme");
					$(this).addClass("text-light");
					
				});

				$("span i").each(function(){
					
					$(this).removeClass("color-theme");
					$(this).addClass("text-light");
					
				});

				$(".gp-col-6 h3").each(function(){

					$(this).removeClass("bg-theme");
					$(this).addClass("text-light");

				});

				$(".text-lt").each(function(){
					$(this).removeClass("color-theme");
					$(this).addClass("text-light");
				});

				/*$("i").each(function(){
					$(this).removeClass("text-light");
					$(this).addClass("color-theme");
				});*/
				
				$(".ul-dep li").each(function(){
					$(this).removeClass("color-theme");
					$(this).addClass("text-light");
				});

				$(".card-lt-wf").each(function(){
					$(this).removeClass("bg-light");
					$(this).addClass("bg-dark");
				});
			
				$("body").removeClass("bg-light");
				$("body").removeClass("bg-dark");
				$("body").addClass("bg-theme-d");

				$(".dropdown-menu span").each(function(){
					$(this).removeClass("color-theme");
					$(this).addClass("text-light");
				});

				$(".dropdown-menu nav ul li a").each(function(){
					$(this).removeClass("color-theme");
					$(this).addClass("text-light");
				});

				$(".activits_profile").each(function(){
					$(this).removeClass("color-theme");
					$(this).addClass("text-light");
				});	

				$(".mg-bnot p").each(function(){
					$(this).removeClass("text-muted");
					$(this).addClass("text-light");	
				});

				$(".mg-bnot i").each(function(){
					$(this).removeClass("text-muted");
					$(this).addClass("text-light");	
				});
				
			}else{

				$(".lights").attr("id", "#light");

				//$(".hr").removeClass("text-muted");
				//$(".hr").addClass("text-light");

				$(".hnav li a").each(function(){
					$(this).removeClass("text-primary");
					$(this).addClass("text-light");
				});

				$(".hr-btn").removeClass("btn-outline-dark");
				$(".hr-btn").addClass("btn-outline-light");
				
				$("h3").removeClass("text-primary");
				$("h3").addClass("text-light");

				$(".bg-dark").each(function(){
					$(this).removeClass("bg-dark");
					$(this).addClass("bg-light");
				});

				$("strong").each(function(){
					if($(this).text() != "Network / referrals"){
						$(this).removeClass("text-light");
						$(this).addClass("color-theme");
					}
				});

				$("table").each(function(){
					$(this).removeClass("table-dark");
					$(this).addClass("table-light");
				});

				$("tbody").each(function(){
					$(this).removeClass("text-light");
					$(this).addClass("color-theme");
				});

				$("table thead").each(function(){
					$(this).removeClass("text-light");
					$(this).addClass("color-theme");
				});

				$("th a").each(function(){
					$(this).removeClass("text-light");
					$(this).addClass("color-theme");
				});

				$("td a").each(function(){
					
					color = $(this).css("color");

					if(color == "rgb(248, 249, 250)"){
						$(this).removeClass("text-light");
						$(this).addClass("color-theme");
					}
			
				});

				$("tr td").each(function(){
					
					$(this).removeClass("text-light");
					$(this).addClass("color-theme");
					
				});

				$("span i").each(function(){
					
					$(this).removeClass("text-light");
					$(this).addClass("color-theme");
					
				});

				$(".gp-col-6 h3").each(function(){

					$(this).removeClass("text-light");
					$(this).addClass("color-theme");
					
				});

				$(".text-lt").each(function(){
					$(this).removeClass("text-light");
					$(this).addClass("color-theme");
				});

				/*$("i").each(function(){
					$(this).removeClass("text-light");
					$(this).addClass("color-theme");
				});*/
				$(".ul-dep li").each(function(){
					$(this).removeClass("text-light");
					$(this).addClass("color-theme");
				});

				$(".card-lt-wf").each(function(){
					$(this).removeClass("bg-dark");
					$(this).addClass("bg-light");
				});
			
				$("body").removeClass("bg-theme-d");
				$("body").addClass("bg-light");

				$(".dropdown-menu span").each(function(){
					$(this).removeClass("text-light");
					$(this).addClass("color-theme");
				});

				$(".dropdown-menu nav ul li a").each(function(){
					$(this).removeClass("text-light");
					$(this).addClass("color-theme");
				});

				$(".activits_profile").each(function(){
					$(this).removeClass("text-light");
					$(this).addClass("color-theme");
				});	

				$(".mg-bnot p").each(function(){
					$(this).removeClass("text-light");
					$(this).addClass("text-muted");	
				});

				$(".mg-bnot i").each(function(){
					$(this).removeClass("text-light");
					$(this).addClass("text-muted");	
				});
				//$(".card-network").addClass("bg-light");
				//$(".card-network").removeClass("bg-dark");
			}

		});

	});
 	
 
});
	
$( ".senhalog" ).on( "keydown", function( event ) {
	
	if(event.which == 13){

		var email = $(".emaillogin").val();
		var senha = $(".senhalog").val();

		if (email == "" || senha == "") {
			$(".return-login").html("<p class='alert-danger'>Press your email or password !</p>");
		}else{
			$.post('php/login.php',{"email":email,"senha":senha}, function(data){
				$(".return-login").html(data);
			});
		}
	
	}  

});
	
function toggle_about(id){
	
	if(id == 0){
		$(".box-question-fx").toggle();
	}

}	


function toggledd(){

	nav = $(".dropdown-menu:eq(0)").css("display");
	
	if(nav == "none"){
		
		$(".dropdown-menu:eq(0)").show();
		$(".navbar-collapse").show();
		
	}else{

		$(".dropdown-menu:eq(0)").hide();
		
	}
	wd = $("body").innerWidth();

	if(wd < 975){
		
		$(".hnav").toggle();
	}

	$(".count-not").toggle();

}

function toggleddbtn(){

	wd = $("body").innerWidth();

	if(wd < 975){
		$(".navbar-toggler").click();
	}

	$(".hr").click();
}	

function terms0() {

	status = document.getElementsByClassName("terms")[0].getAttribute("name");
	
	if(status == "checked"){

    	document.getElementsByClassName("terms")[0].setAttribute("name", "not checked");
    	document.getElementsByClassName("text-term")[0].style.display = "none";
		$("main").css({"height": "600px"}); //reset default 
		$(".cria-acc").css({"margin-top": "0px"});
	
	}else{
	
		document.getElementsByClassName("terms")[0].setAttribute("name", "checked");
		document.getElementsByClassName("text-term")[0].style.display = "block";
		$("main").css({"height": "790px"}); //180 terms + 10 btn create acc
		$(".criar-acc").css({"margin-top": "10px"});
	
	}

}

function network_table(){

	$("#box-menu").remove();

	if($(".lights").attr("id") == "#light"){
		dv = "<div id='box-menu' class='col-md-12 card bg-light'></div>";
	}else{
		dv = "<div id='box-menu' class='col-md-12 card bg-dark'></div>";
	}
	
	$(".space-fix-cc:eq(2)").after(dv);

	$.post("php/ref/return_net_table.php", {}, function(data){
		$("#box-menu").html(data);
	});

}

function network_analitics(wd_window, ht_window){

	$("#box-menu").remove();

	if($(".lights").attr("id") == "#light"){
		dv = "<div id='box-menu' class='col-md-12 card bg-light'></div>";
	}else{
		dv = "<div id='box-menu' class='col-md-12 card bg-dark an'></div>";
	}
	
	$(".space-fix-cc:eq(2)").after(dv);

	$.post("php/ref/return_net_analitics.php", {"wd_window": wd_window, "ht_window": ht_window}, function(data){
		$("#box-menu").html(data);
	});
	
}

function network_banners(){

	$("#box-menu").remove();

	if($(".lights").attr("id") == "#light"){
		dv = "<div id='box-menu' class='col-md-12 card bg-light'></div>";
	}else{
		dv = "<div id='box-menu' class='col-md-12 card bg-dark'></div>";
	}
	
	$(".space-fix-cc:eq(2)").after(dv);

	$.post("php/ref/return_net_banners.php", {}, function(data){
		$("#box-menu").html(data);
	});

}

function ajust_card(div_width) {
  
	//start ajust data on card -> deposits mobile (smartphone)
	wd_col = $(".col-mb-dep-h").width();
	$(".col-12 .col-sm-12").css({"margin-top": "2%"});

	wd_li = wd_col / 3;
	wd_li2 = wd_col / 2;

	if(div_width < 768){

	  wd_li = wd_col / 3;
	  wd_li2 = wd_col / 2;

	  for(ic = 0; ic < 5; ic++){
	   
	    for(i = 0; i < 3; i++){
	      $(".col-mb-dep-h:eq("+ic+") .ul-dep:eq(0) li:eq("+i+")").css({"width": wd_li});
	    }

	    for(i = 0; i < 2; i++){
	      $(".col-mb-dep-h:eq("+ic+") .ul-dep:eq(1) li:eq("+i+")").css({"width": wd_li2});
	    }
	  
	  }

	}else if(div_width >= 768 && div_width <= 1024){
		
		wd_li = wd_col / 5.1;
	    
	    for(var ic = 0; ic < 5; ic++) {
	      
	      for (var i = 0; i < 3; i++) {
	        $(".col-mb-dep-h:eq("+ic+") .ul-dep:eq(0) li:eq("+i+")").css({"width": wd_li});
	      }

	      for (var i = 0; i < 2; i++) {
	        $(".col-mb-dep-h:eq("+ic+") .ul-dep:eq(1) li:eq("+i+")").css({"width": wd_li});
	      }

	    }

	}
	//end
}  

function main_change(){

	wd = window.innerWidth;
	ht = window.innerHeight;
	hb = $("body").height();

    ajust_card(wd);
   
	if($(".net-resources:eq(0)").attr("id") != "net-mobile"){

        //start left right graph btn sets 
        $("#box-country").css({"width":wd+"px !important"});
        $(".fa-angle-right").each(function(){
                                        
            if($(this).attr("class") == "r1fa max-limit-graph fa fa-2x fa-angle-right float-right" || $(this).attr("class") == "max-limit-graph fa fa-angle-right float-right"){
                $(this).css({"cursor":"pointer","position":"absolute","float":"right !important", "top":"0px"});
            }

        });
        //end
    }

	for(var idxc = 1; idxc <= 6; idxc++){ 

	    for (var i = 0; i <= 30; i++) {

	        rest_div = $("#f"+idxc+" .max-limit-graph:eq("+i+")").text();
	        idx = idxc;
		
	        //start wd graph limits
	       	if(wd < 1050){

		        if(wd > 625){

		            left_px = 6;
		        
		        }else{
		        
		            left_px = 11;
		        	
		        }	

		        d = $("#f"+idx+" .max-limit-graph:eq("+i+") .percent-col").attr("style");    
					       
		        if(d){

		        	c1 = 39;
		        	c2 = 40;
		        	wd1 = d.charAt(c1);
	                wd2 = d.charAt(c2);

		            if(d.charAt(40) != " " && d.charAt(40) != "" && d.charAt(40) != "%"){
		                wd2 = d.charAt(40);   
		            }else{
		                wd2 = "";
		            }	

	        		wd3 = "";
	                wd_ajust = parseFloat(wd1+""+wd2+""+wd3) - parseFloat(15); //-15 ajust div wd 

				    if(rest_div % 2 == 0){
		                left_ajust = parseFloat(100) - parseFloat(wd_ajust) - parseFloat(15) - parseFloat(left_px); //-11 default margin
		            }else{
		                left_ajust = left_px; //default margin
		            }                 	                

		            //start wd graph limits
		          	$("#f"+idx+" .max-limit-graph:eq("+i+") .percent-col").css({"left":""+left_ajust+"%"});
		          	$("#f"+idx+" .max-limit-graph:eq("+i+") .percent-col").removeClass("mt-1");    
		            //end

		        }

	    	}
	        //end

	        //start tablet smartphone
	        if(wd < 768 && wd >= 480){
	         	
	            if(rest_div % 2 == 0){
	                $(".max-limit-graph:eq("+i+")").css({"margin-right": "0px"});
	            }else{
	                $(".max-limit-graph:eq("+i+")").css({"margin-left": "0px"});
	            }   
	        
	        }else if(wd >= 463 && wd < 480){
	        
	            if(rest_div % 2 == 0){
	                $(".max-limit-graph:eq("+i+")").css({"margin-right": "0px"});
	            }else{
	                $(".max-limit-graph:eq("+i+")").css({"margin-left": "0px"});
	            }   
	        
	        }else if(wd < 463){
	       		
	           if(rest_div % 2 == 0){
	              $(".max-limit-graph:eq("+i+")").css({"margin-right": "0px"});
	           }else{
	              $(".max-limit-graph:eq("+i+")").css({"margin-left": "0px"});
	           }   
	        
	        }

	    }
		
	}

	h = $( ".col-fa-text").height();
  	porcent_h = 50 / h * 100;

  	$(".col-fa-align").css({"top":"40px !important"});
	$(".fa-globe").css({"top":"40px !important"});
	
	//start
	about_more_0 = $(".about-more div:eq(1)").height();
	$(".about-more div:eq(0)").css({"height": about_more_0+"px"});

	about_more_1 = $(".about-more div:eq(4)").height();	
	$(".about-more div:eq(3)").css({"height": about_more_1+"px"});
	//end

	btheme = $("body").attr("class");
	check_h = $(".mf").attr("id");
	
	/*if(!check_h || check_h != "mf0"){
		check_h = 1;
	}*/
	
	if(wd < 850){

		$(".modal-dialog").css("width", "100% !important");
		$(".count-not-cog").css({"position": "absolute", "margin-left": "-4%", "font-size": "10px", "margin-top": "43px"});
		
		//start front sets modify
		$(".main-container").addClass("mt-m");
		$(".col-md-6-m3").addClass("mt-mm");
		$(".col-info-sys").addClass("col-md-12");
		$(".network-resources").css({"display":"contents"});
		$(".network-resources a").css({"margin-bottom":"5px"});
		
		$(".space-fix-c").hide();
		$(".pg-w").removeClass("float-right");
		$(".pg-w").css({"display":"block ruby", "margin":"0px auto"});
		$(".win-resources").addClass("mb-3");
		$(".net-resources").addClass("mb-3");
		$(".box-overflow-xltb").css({"top": "11px"});
		//
		$(".lt-tkt-box").css({"padding":"0px"});
		$(".box-l img").attr("width", "10px");
		$(".box-l img").attr("height", "10px");

		$(".box-l").each(function() {
			$(this).removeClass("btn-sm");	
		});
		//end

	}else if(wd >= 850){

		$(".main-container").removeClass("mt-m");
		$(".modal-dialog").css("width", "80% !important");
		
		$(".network-resources").css({"display": "block"});
		$(".network-main").remove();
		
		$(".main-container").removeClass("mt-m");
		$(".col-md-6-m3").removeClass("mt-mm");
		$(".col-info-sys:eq(0)").removeClass("col-md-12");
		$(".col-info-sys:eq(1)").removeClass("col-md-12");
		$(".space-fix-c").show();
		$(".pg-w").addClass("float-right");
		$(".pg-w").css({"display":"block", "margin":"0px"});
		$(".win-resources").removeClass("mb-3");
		$(".net-resources").removeClass("mb-3");
		$(".box-overflow-xltb").css({"top": "0px"});

		$(".lt-tkt-box").css({"padding":"auto"});
		$(".box-l").each(function() {
			$(this).addClass("btn-sm");	
		});

		if(btheme == "text-center bg-theme-d"){
			$("#box-menu table").removeClass("color-theme");
			$("#box-menu table").addClass("text-light");
		}else{	
			$("#box-menu table").removeClass("text-light");
			$("#box-menu table").addClass("color-theme");
		}
		
	}	
	
	//start att render graph px att 20/07/25
	
	if(wd > 483 && wd <= 1024){//tablet <

		for (var i = 30 ; i >= 0; i--) {
			$(".max-limit-graph:eq("+i+")").css({"width": "50% !important", "height":"20px"}); 
		}
		
	}else if(wd < 483){ //smartphone

		for (var i = 30 ; i >= 0; i--) {
			$(".max-limit-graph:eq("+i+")").css({"width": "50% !important", "height":"20px"}); 
		}
	
	}

	//end

	//start mobile col detected
	if(wd < 1000){
		$(".mobile-col").show();	
		if(wd < 992){
			$(".profile-mobile").show();
			$("#profile-desktop").hide();
		}else{
			$(".profile-mobile").hide();
		}
	}else{
		$(".mobile-col").hide();
		$(".profile-mobile").hide();
		$("#profile-desktop").show();
	}

	/*if(wd < 523){
		$(".max-limit-graph").addClass("graph-l");
		$(".max-limit-graph").removeClass("graph-r");
	}else{
		//$(".max-limit-graph").css({"margin": "0px", "float": "inherit"});
	}*/

	if(wd > 250 && wd < 1050){

		/*$(".box-graph").css({"clear": "both", "margin-top": "50px !important", "padding": "0px"});
		$(".box-graph .col-12").css({"padding": "0px"});

		for (var i = 30; i >= 0; i--) {

			rest_div = $(".max-limit-graph:eq("+i+")").text() % 2;
			
			if(rest_div == 0){
				$(".max-limit-graph:eq("+i+")").addClass("graph-r");
				$(".max-limit-graph:eq("+i+")").css({"text-align": "right"});
			}else{
				$(".max-limit-graph:eq("+i+")").addClass("graph-l");				
				$(".max-limit-graph:eq("+i+")").css({"text-align": "left"});
			}
			
			if(rest_div == 1 && $(".max-limit-graph:eq("+i+")").text() > 2){
				$(".max-limit-graph:eq("+i+")").css({"clear": "both"});
			}

		}*/
	
	}else if(wd > 1050){

		$(".max-limit-graph").removeClass("graph-r");
		$(".max-limit-graph").removeClass("graph-l");
	
	}
	//end

	//start analitics ajust desktop / mobile
	/*if(wd > 850 && wd < 966){
		$(".box-graph").addClass("ml-graph");
	}else if(wd > 950){
		$(".box-graph").removeClass("ml-graph");
	}else if(wd > 711 && wd < 850){
		//$(".box-graph").removeClass("ml-graph");
	}else if(wd > 360 && wd <= 711){
		$(".box-graph").removeClass("ml-graph");
		$(".box-graph").addClass("ml-graph-min-m");
	}

	if(wd <= 360){
		$(".box-graph").removeClass("ml-graph");
		$(".box-graph").removeClass("ml-graph-min-m");
		$(".box-graph").addClass("ml-graph-min-0");
	}else if(wd > 360 && wd < 375){
		$(".box-graph").removeClass("ml-graph-min-0");
		$(".box-graph").removeClass("ml-graph-min-m");
		$(".box-graph").addClass("ml-graph");
	}else{
		$(".box-graph").removeClass("ml-graph-min-0");
		if(wd > 711){
			//$(".box-graph").removeClass("ml-graph-min-m");
		}
	}*/
	//end

	//start get set info render winner daily
	col0_children = $(".col-win-pack-info").children();
	col0_info = col0_children.attr("class");
	len_c0 = $(".col-win-pack-info").length;

	col1_children = $(".col-win-pack-info-t").children();
	col1_info = col1_children.attr("class");
	len_c1 = $(".col-win-pack-info-t").length;
	
	col2_children = $(".col-win-pack-info-m").children();
	col2_info = col2_children.attr("class");
	len_c2 = $(".col-win-pack-info-m").length;
	
	col3_children = $(".col-win-pack-info-dt").children();
	col3_info = col2_children.attr("class");
	len_c3 = $(".col-win-pack-info-dt").length;
	
	if(len_c0 > 0){
		col_info = "fluid-container col-win-pack-info";
		$(".col-win-pack-info").attr("style", "");
	}else if(len_c1 > 0){
		col_info = "fluid-container col-win-pack-info-t";
		$(".col-win-pack-info-t").attr("style", "");
	}else if(len_c2 > 0){
		col_info = "fluid-container col-win-pack-info-m";
		$(".col-win-pack-info-m").attr("style", "");
	}else if(len_c3 > 0){
		col_info = "fluid-container col-win-pack-info-dt";
		$(".col-win-pack-info-dt").attr("style", "");
	} 

	ajust_div_html = $(".wd0 a").length; //length daily winners div

	if(wd >= 990){

		if(wd < 1200){

			$(".lt-win-pack-info").attr("class", "lt-win-pack-info fluid-container col-win-pack-info-t");
			$(".nav-win-info").addClass("nav-win-info-ajust-dt");
			$(".read-more-idx").attr("class", "col sm-about-idx text-primary read-more-idx");
		
		}else{
		
			$(".lt-win-pack-info").attr("class", "lt-win-pack-info fluid-container col-win-pack-info");
			$(".nav-win-info").removeClass("nav-win-info-ajust-dt");
			$(".read-more-idx").attr("class", "sm-about-idx text-primary float-right read-more-idx");	
		
		}

		$(".lt-win-pack-info nav").attr("class", "nav-win-info");
		$(".lt-win-pack-info nav ul").attr("class", "");
		$(".nav-win-info ul li").addClass("fs-win-info");

		$(".nav-win-info ul").removeClass("m-0");

		$(".nav-win-info ul li").removeClass("fs-win-info-t");
		$(".nav-win-info").removeClass("nav-win-info-ajust-m");
		$(".nav-win-info").removeClass("nav-m-win-left");
		$(".nav-win-info").removeClass("nav-dt-win-left");
		$(".mobile-sep:eq(0)").removeClass("mb-1");
		$(".mobile-sep:eq(1) a").removeClass("ml-1");

		//start ajust px left
		for (var i = 0; i < ajust_div_html; i++) {
		
			div_str_qtd = $(".wd0:eq("+i+") a").text();
		
			if(div_str_qtd.length < 2){

				ajust_px = -9;
				$(".wd0:eq("+i+")").css({"left": ajust_px+"px"});
			
			}else if(div_str_qtd.length > 2 && div_str_qtd.length < 4){
			
				ajust_px = 9;
				$(".wd0:eq("+i+")").css({"left": ajust_px+"px"});
			
			}

			$(".nav-win-info:eq("+i+")").css({"position": "relative", "left": "0px"});
		
		}

		$(".col-win-pack-info-dt nav ul").attr("class", "");
		//end

		//start remove set class for plans div
		$(".sp-mg-plan:eq(0)").show();
		$(".sp-mg-plan:eq(1)").show();
		$(".sp-mg-plan:eq(2)").show();
		
		$(".sp-mg-plan:eq(0)").removeClass("col-md-12");
		$(".sp-mg-plan:eq(1)").removeClass("col-md-12");
		$(".sp-mg-plan:eq(2)").removeClass("col-md-12");

		$(".sp-mg-plan:eq(0)").addClass("col-md-4");
		$(".sp-mg-plan:eq(1)").addClass("col-md-4");
		$(".sp-mg-plan:eq(2)").addClass("col-md-4");
		
		$(".slider-plan").remove();
		//end

	}else if(wd > 600 && wd < 990){
		
		$(".lt-win-pack-info").attr("class", "lt-win-pack-info fluid-container col-win-pack-info-dt");
		$(".nav-win-info ul li").addClass("fs-win-info-t");
		$(".nav-win-info ul li").removeClass("fs-win-info");

		$(".nav-win-info").addClass("nav-win-info-ajust-dt");
		$(".nav-win-info").removeClass("nav-m-win-left");

		$(".read-more-idx").attr("class", "col sm-about-idx text-primary read-more-idx");

		//start ajust px left
		for (var i = 0; i < ajust_div_html; i++) {
		
			div_str_qtd = $(".wd0:eq("+i+") a").text();
		
			if(div_str_qtd.length < 2){

				ajust_px = -9;
				$(".wd0:eq("+i+")").css({"left": ajust_px+"px"});
			
			}else if(div_str_qtd.length > 2 && div_str_qtd.length < 4){
			
				ajust_px = 9;
				$(".wd0:eq("+i+")").css({"left": ajust_px+"px"});
			
			}

		}	
		//end
		
		//start plans home render 
		slider_added = '<div id="sec-0" class="slider-plan"><div id="next-plan-btn" class="col-1 float-right next-plan-btn" onclick="slid_plan(id);" style="top: 138px;z-index: 1111;"><div><i aria-hidden="true" class="fa fa-3x fa-angle-right text-light float-right" style="float:right"></i></div></div><div id="prev-plan-btn" class="col-1 float-left prev-plan-btn" onclick="slid_plan(id);" style="top: 138px;z-index: 1111;"><div><i aria-hidden="true" class="fa fa-3x fa-angle-left text-light" style="float: left;"></i></div></div></div>';

		len_slider = $(".slider-plan").length;

		if(len_slider == 0){

			$("marquee:eq(0)").after(slider_added);
	
			$(".sp-mg-plan:eq(1)").hide();
			$(".sp-mg-plan:eq(2)").hide();

			$(".sp-mg-plan:eq(0)").removeClass("col-md-4");
			$(".sp-mg-plan:eq(1)").removeClass("col-md-4");
			$(".sp-mg-plan:eq(2)").removeClass("col-md-4");

			$(".sp-mg-plan:eq(0)").addClass("col-md-12");
			$(".sp-mg-plan:eq(1)").addClass("col-md-12");
			$(".sp-mg-plan:eq(2)").addClass("col-md-12");
	
		}
		//end

		if(wd < 768){
			
			$(".lt-win-pack-info").attr("class", "lt-win-pack-info fluid-container col-win-pack-info-m");
			$(".nav-win-info").attr("class", "nav-win-info-m");
			$(".col-win-pack-info-m nav ul").attr("class", "ul-win-info-m ul-win-info-top-m");
			$(".nav-win-info-m").addClass("nav-dt-win-left");
			
			$(".nav-win-info-m nav ul").removeClass("m-0");
				
			$(".mobile-sep:eq(0)").addClass("mb-1");
			$(".mobile-sep:eq(1) a").removeClass("ml-1");

		}else if(wd == 768 || wd == 810 || wd >= 912){

			$(".lt-win-pack-info").attr("class", "lt-win-pack-info fluid-container col-win-pack-info-dt");
			$(".nav-win-info-m").attr("class", "nav-win-info nav-win-info-ajust-dt");
			$(".col-win-pack-info-dt nav ul").attr("class", "");
			
			$(".col-win-pack-info-dt nav ul").removeClass("m-0");

			$(".mobile-sep:eq(1) a").addClass("ml-1");
			$(".mobile-sep:eq(0)").removeClass("mb-1");
		
		}else{

			$(".lt-win-pack-info").attr("class", "lt-win-pack-info fluid-container col-win-pack-info-dtt");
			$(".nav-win-info-m").attr("class", "nav-win-info nav-win-info-ajust-dt");
			$(".col-win-pack-info-dt nav ul").attr("class", "");
			
			$(".col-win-pack-info-dt nav ul").removeClass("m-0");

			$(".mobile-sep:eq(1) a").addClass("ml-1");
			$(".mobile-sep:eq(0)").removeClass("mb-1");
		
		}
		
		/**/

		//<i aria-hidden="true" class="fa fa-3x fa-angle-left text-primary" style="position: absolute;top: 604px; left: -48px; z-index: 10000;/*! background: #ccc; */margin: 0p;margin: 0px;padding: 0px;left: 81px;z-index: 10000;"></i> left
		//<i aria-hidden="true" class="fa fa-3x fa-angle-right text-primary" style="position: absolute;top: 604px; left: 604px; /*! z-index: 100000; */display: block;"></i> right
	
		//box-plans
	
	}else{
	
		div_html = $(".profile-change-mb").html();
		$(".profile-change-mb").remove();
		
		$(".account-statusv").after('<div class="col mb-3 profile-change-mb">'+div_html+'</div>');
		$(".lt-win-pack-info").attr("class", "lt-win-pack-info fluid-container col-win-pack-info-m");
		$(".col-win-pack-info-m nav ul").attr("class", "ul-win-info-m");
		$(".col-win-pack-info-d nav").attr("class", "nav-win-info-m");

		$(".nav-win-info-m ul li").removeClass("fs-win-info");
		$(".nav-win-info-m ul li").addClass("fs-win-info-t");
		$(".nav-win-info-m").removeClass("nav-dt-win-left");
		$(".nav-win-info-m").removeClass("nav-win-info-ajust-dt");
		$(".nav-win-info-m").removeClass("nav-win-info-ajust-dt");

		$(".nav-win-info ul").addClass("m-0");

		$(".mobile-sep:eq(0)").addClass("mb-1");
		$(".mobile-sep:eq(1) a").removeClass("ml-1");

		$(".read-more-idx").attr("class", "col sm-about-idx text-primary read-more-idx");

		div_card_dw = $(".daily-winners .card-body").length;

		for(i = 0; i < div_card_dw; i++){

			mw = $(".daily-winners .card-body:eq("+i+") .row div:eq(0)").width();
			mw3 = $(".daily-winners .card-body:eq("+i+") .row div:eq(3)").width();
			
			df_left = parseFloat(mw) - parseFloat(mw3) + parseFloat(7);
			$(".col-win-pack-info-m:eq("+i+")").css({"top":"13px", "left":df_left+"px"});
		
		}

		//start reset left px 
		for(var i = 0; i < ajust_div_html; i++){
		
			$(".wd0:eq("+i+")").css({"left": "0px"});
			$(".nav-win-info:eq("+i+")").css({"position": "relative", "left": "0px"});

		}
		//end

		//start remove set class for plans div
		$(".sp-mg-plan:eq(0)").show();
		$(".sp-mg-plan:eq(1)").show();
		$(".sp-mg-plan:eq(2)").show();

		$(".sp-mg-plan:eq(0)").removeClass("col-md-4");
		$(".sp-mg-plan:eq(1)").removeClass("col-md-4");
		$(".sp-mg-plan:eq(2)").removeClass("col-md-4");

		$(".sp-mg-plan:eq(0)").addClass("col-md-12");
		$(".sp-mg-plan:eq(1)").addClass("col-md-12");
		$(".sp-mg-plan:eq(2)").addClass("col-md-12");
		
		$(".slider-plan").remove();
		//end
	}
	//end

	//start register pw mt add / remove && index page mb add / remove -> index page
	if(wd < 768){
		
		$(".p-r .form-control").addClass("mt-2");
		$(".last-win-block-info").removeClass("last-win-block-dsp-d");
		$(".last-win-block-info").addClass("last-win-block-dsp-m");
		$(".last-win-block-info-l").removeClass("last-win-block-dsp-d");
		$(".last-win-block-info-l").addClass("last-win-block-dsp-m");
		$("#howwork").removeClass("mb-5");

	}else if(wd >= 768){
		
		$(".p-r .form-control").removeClass("mt-2");
		$(".last-win-block-info").removeClass("last-win-block-dsp-m");
		$(".last-win-block-info").addClass("last-win-block-dsp-d");
		$(".last-win-block-info-l").removeClass("last-win-block-dsp-m");
		$(".last-win-block-info-l").addClass("last-win-block-dsp-d");
		$("#howwork").addClass("mb-5");

	}
	//end

	//start current lt status -> index page
	if(wd < 768){
	
		$(".current-loterry-container nav ul li").addClass("lt-current-status-tm");
	
		$(".current-loterry-container nav ul li").removeClass("lt-current-status-l-dt-0");
		$(".current-loterry-container nav ul li").removeClass("lt-current-status-r-dt-0");

		$(".current-loterry-container nav ul li").removeClass("lt-current-status-l-dt-1");
		$(".current-loterry-container nav ul li").removeClass("lt-current-status-r-dt-1");
		
		$(".current-loterry-container nav ul li").removeClass("lt-current-status-l-d");
		$(".current-loterry-container nav ul li").removeClass("lt-current-status-r-d");

		$(".current-loterry-container nav ul li").removeClass("lt-current-status-td");

	}else if(wd >= 768 && wd < 1200){
	
		if(wd < 991){
			
			$(".current-loterry-container nav ul li").addClass("lt-current-status-td");
	
			$(".current-loterry-container nav ul li:eq(0)").addClass("lt-current-status-l-dt-0");
			$(".current-loterry-container nav ul li:eq(2)").addClass("lt-current-status-r-dt-0");

			$(".current-loterry-container nav ul li:eq(0)").removeClass("lt-current-status-l-dt-1");
			$(".current-loterry-container nav ul li:eq(2)").removeClass("lt-current-status-r-dt-1");
			
			$(".current-loterry-container nav ul li").removeClass("lt-current-status-l-d");
			$(".current-loterry-container nav ul li").removeClass("lt-current-status-r-d");

			$(".current-loterry-container nav ul li").removeClass("lt-current-status-tm");

		}else{

			$(".current-loterry-container nav ul li").addClass("lt-current-status-td");
		
			$(".current-loterry-container nav ul li:eq(0)").addClass("lt-current-status-l-dt-1");
			$(".current-loterry-container nav ul li:eq(2)").addClass("lt-current-status-r-dt-1");

			$(".current-loterry-container nav ul li:eq(0)").removeClass("lt-current-status-l-dt-0");
			$(".current-loterry-container nav ul li:eq(2)").removeClass("lt-current-status-r-dt-0");

			$(".current-loterry-container nav ul li").removeClass("lt-current-status-l-d");
			$(".current-loterry-container nav ul li").removeClass("lt-current-status-r-d");

			$(".current-loterry-container nav ul li").removeClass("lt-current-status-tm");

		}

	}else{

		$(".current-loterry-container nav ul li").addClass("lt-current-status-td");

		$(".current-loterry-container nav ul li:eq(0)").addClass("lt-current-status-l-d");
		$(".current-loterry-container nav ul li:eq(2)").addClass("lt-current-status-r-d");

		$(".current-loterry-container nav ul li").removeClass("lt-current-status-l-dt-0");
		$(".current-loterry-container nav ul li").removeClass("lt-current-status-r-dt-0");

		$(".current-loterry-container nav ul li").removeClass("lt-current-status-l-dt-1");
		$(".current-loterry-container nav ul li").removeClass("lt-current-status-r-dt-1");
		
		$(".current-loterry-container nav ul li").removeClass("lt-current-status-tm");

	}
	//end

	//start select mode show
	url = location.href;

	if(url.indexOf("referral=analitics") >= 0 && check_h == "mf0"){

		if(wd <= 1050){
			if($(".net-resources:eq(0)").attr("id") != "net-mobile"){		
				network_analitics(wd, ht);
			}
		}else{
			if($(".net-resources:eq(0)").attr("id") != "net-desktop"){		
				network_analitics(wd, ht);
			}
		}

	}else if(url.indexOf("referral=banners") >= 0 && check_h == "mf0"){
		network_banners();	
	}
	//end

}
