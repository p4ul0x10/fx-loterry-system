
$(document).ready(function(){

	//
	$(".choose-coin a").each(function(){

		coin = $("#current_coin").text();

		if(coin == "default" || coin == "usdt"){
			hcoin = "default ";
		}else if(coin == "btc"){
			hcoin = "bitcoin ";
		}else if(coin == "busd"){
			hcoin = "busd ";
		}else if(coin == "eth"){
			hcoin = "ethereum ";
		}else if(coin == "ltc"){
			hcoin = "litecoin ";
		}else if(coin == "tron"){
			hcoin = "tron ";
		}else if(coin == "pix"){
			hcoin = "pix ";
		}
		
		if($(this).text() == hcoin){
			$(this).attr("href", "#coin selected");
		}

	});

	$(".choose-coin a").on("click", function(event){

		selected = $(this).text();
		current_coin = $("#current_coin").text();
		
		api_convert_coin(selected, current_coin);

		if(selected == "default " || selected == "tether "){
			selected_coin = "usdt";
		}else if(selected == "bitcoin "){
			selected_coin = "btc";
		}else if(selected == "busd "){
			selected_coin = "busd";
		}else if(selected == "ethereum "){
			selected_coin = "eth";
		}else if(selected == "litecoin "){
			selected_coin = "ltc";
		}else if(selected == "tron "){
			selected_coin = "tron";
		}else if(selected == "pix "){
			selected_coin = "pix";
		}

		$.post('php/coin_view.php',{"coin":selected_coin}, function(data){
			console.log(data);
		});
		
		$("#current_coin").text(selected_coin);

	});

	//
	$(".choose-coin a").each(function(){
		
		if($(this).attr("href") == "#coin selected"){
			
			if($(this).text() != "default " && $(this).text() != "bitcoin " && $(this).text() != "ethereum " && $(this).text() != "litecoin " && $(this).text() != "tron " && $(this).text() != "busd " && $(this).text() != "tether " && $(this).text() != "pix "){
			
				alert("Invalid coin");
			
			}else{

				coin = $(this).text();
				if(coin == "default " || coin == "tether "){
					selected_coin = "USDT";
				}else if(coin == "bitcoin "){
					selected_coin = "BTC";
				}else if(coin == "busd "){
					selected_coin = "BUSD";
				}else if(coin == "ethereum "){
					selected_coin = "ETH";
				}else if(coin == "litecoin "){
					selected_coin = "LTC";
				}else if(coin == "tron "){
					selected_coin = "TRX";
				}else if(coin == "pix "){
					selected_coin = "PIX";
				}
				
				const region = $("body").attr("id"); // code country

			 	if(region == "US" || region == "en-US" || region == "us" || region == "EN-US" || region == "en-us"){
			 		api_url = "https://api.binance.us";
			 	}else{
			 		api_url = "https://api1.binance.com";
			 	}

				if(selected_coin != "USDT"){

					if(selected_coin == "PIX"){
						maincoin = "BRL";
					}else{
						maincoin = "USDT";
					}
					current_coin = $("#current_coin").text();

					$.getJSON(""+api_url+"/api/v3/ticker/price?symbol="+selected_coin+maincoin, function(data){
				   			
						if(coin == "default " || coin == "tether "){
							img_c = "images/coins/usdt-sm.png";
						}else if(coin == "bitcoin "){
							img_c = "images/coins/btc-sm.png";
						}else if(coin == "litecoin "){
							img_c = "images/coins/ltc-sm.png";
						}else if(coin == "ethereum "){
							img_c = "images/coins/eth-sm.png";
						}else if(coin == "tron "){
							img_c = "images/coins/trx-sm.png";
						}else if(coin == "busd "){
							img_c = "images/coins/busd-sm.png";
						}else if(coin == "pix "){
							img_c = "images/coin/pix.png";
						}
	
						$("#img-c").attr("src", img_c);
						count_cv = $(".cv").length;

						for(var i = 0; i < count_cv+1; i++){

							if(coin != "default " && coin != "tether " && coin != "default" && coin != "tether" && coin != "pix"){
								
								convert_current = parseFloat($(".cv:eq("+i+")").text()) / parseFloat(data['price']); 
								
								$(".cv:eq("+i+")").text(convert_current.toFixed(8));
									
							}
						}

						$(".with-amount").each(function(){
							txt = $(this).text();
							$(this).html(txt+" <img class='img-action-sm' src='"+img_c+"' title='bitcoin' width='16px' height='16px' alt='btc coin deposited'> <i class='fa fa-exchange' aria-hidden='true'></i>");
							
						});

						$(".dep-amount").each(function(){
							txt = $(this).text();
							$(this).html(txt+" <img class='img-action-sm' src='"+img_c+"' title='bitcoin' width='16px' height='16px' alt='btc coin deposited'> <i class='fa fa-exchange' aria-hidden='true'></i>");
						});
					
					});
				
				}
			
			}
		
		} 

	});
	//	

	//
	$(".choose-plan a").on('click', function(){
		
		plan = $(this).text();
		$(this).attr("title", plan+" selected");
		
		$(".choose-plan a").each(function() {
			//$(this).addClass("bg-dark");
			$(this).addClass("color-theme");

			$(this).removeClass("bg-theme");
			$(this).removeClass("text-light");
		});

		$(this).removeClass("bg-dark");
		$(this).addClass("bg-theme");
		$(this).addClass("text-light");

		$("#plan_selected").val(plan);
		$(".deposito-user").val("");
		$(".concluir-deposito").hide();
		$(".return-deposito").html("");
		
		count_prot = $(".prot").length;
	
		for (var i = 0; i < count_prot; i++) {
			$(".prot:eq("+i+")").hide();
		}

		count_coin = $(".choose-coin-dep a").length;

		for (var i = 0; i < count_coin; i++) {
			$(".choose-coin-dep:eq("+i+") a").removeClass("bg-theme");
		}

		if(plan == "Starter"){
			$(".plan-profit").html("Receive 100 Tickets for entry $0.20 each Ticket<br>Min: $0.20 Max: $100 per loterry");
		}else if(plan == "Advanced"){
			$(".plan-profit").html("Receive 250 Tickets for entry $0.20 each Ticket<br>Min: $0.20 Max: $250 per loterry");
		}else if(plan == "Premium"){
			$(".plan-profit").html("Receive 500 Tickets for entry $0.20 each Ticket<br>Min: $0.20 Max: $500 per loterry");
		}else{
			$("#plan_selected").val("founds");
		}
		
	});
	
	count_prot = $(".prot").length;
	
	for (var i = 0; i < count_prot; i++) {
		
		$(".prot:eq("+i+")").hide();
		
	}

	count_prot = $(".prot-with").length;
	
	for (var i = 0; i < count_prot; i++) {
		
		$(".prot-with:eq("+i+")").hide();
		
	}

	$(".choose-coin-dep a").on('click', function(){
	
		coin = $(this).attr("href");
		valid_coin = coin.replace("#", "");
		a = $(".modal-founds").attr("style");
		
		$(this).attr("title", "coin selected");
		
		$(".choose-coin-dep a").each(function() {
			$(this).removeClass("bg-theme");
		});

		$(this).addClass("bg-theme");

		$("#coin_selected").val(valid_coin);
		
		$(".deposito-user").val("");
		$(".concluir-deposito").hide();
		$(".return-deposito").html("");
		
		count_prot = $(".prot").length;
	
		for (var i = 0; i < count_prot+1; i++) {
			
			$(".prot:eq("+i+")").hide();
			$(".prot:eq("+i+")").removeClass("bg-theme");
		
		}

		$(".formdepositar .form-group:eq(4)").hide();
		$(".deposito-user").val("");
		$(".plan-deposit-mt-2:eq(1)").remove();

		enable_prot(coin, "dep");
	
	});

	$(".choose-coin-with a").on('click', function(){
	
		coin = $(this).attr("href");
		valid_coin = coin.replace("#", "");

		$(this).attr("title", "coin selected");
		
		$(".choose-coin-with a").each(function() {
			$(this).removeClass("bg-theme");
		});

		$(this).addClass("bg-theme");
		
		count_prot = $(".prot-with").length;
	
		for (var i = 0; i < count_prot+1; i++) {
			
			$(".prot-with:eq("+i+")").hide();
			
		}

		enable_prot(coin, "with");
	
	});

	$(".choose-coin-with a").on('click', function(){
		
		$(".choose-coin-with a").each(function() {
			$(this).removeClass("bg-theme");
		});

		$(this).addClass("bg-theme");
		
		$(".prot-with").each(function() {
			$(this).removeClass("bg-theme");
		});
	
		$(".prot-with a").each(function() {
			$(this).addClass("color-theme");
			$(this).removeClass("text-light");
		});
	
		$(".list-amount-rest").each(function() {
			$(this).removeClass("bg-primary");
			$(this).removeClass("color-theme");
			$(this).addClass("text-light");
		});
		
		$(".list-amount-rest").each(function() {
			$(this).attr("class", "list-amount-rest color-theme");
		});

		$(".with-in").hide();

	});

	$(".list-amount-rest").on("click", function () {
		
		prot_w_len = $(".prot-with").length;

		for(prot = 0; prot < prot_w_len; prot++){
			
			if($(".prot-with:eq("+prot+")").attr("class") == "prot-with bg-theme"){
				$(".saque-user").show();	
			}	
		
		}
		
	});
	//

	//start
	$(".open-dep-m").on("click", function(){

		$(".modal-not").toggle();
		$(".modal-depinv").toggle();

	});
	//end open-dep-m

});

function btntx(){

	//start send tx
	id_charnun = $(".inptx").attr("id");
	id_dep = id_charnun.replace("prof-payment-", "");
	id_depcharnum = id_dep.replace(" ", "");

	amount_f = $("#amount_f_dep").text();
	txidText = $(".inptx").val(); 
	
	dep_list_len = $(".dep-list").length;

	for(i=0; i < dep_list_len; i++){

		str_id_depcharnum = "tr"+id_depcharnum;
	
		if($(".dep-list:eq("+i+")").attr("id") == str_id_depcharnum){
			usd_v = $(".dep-list:eq("+i+") .dep-amount").text();
			break;
		}

	}

	if(txidText.length > 20 && usd_v > 0){
		
		$.post("php/dep/confirm-dep.php",{"id_dep":id_depcharnum, "tx":txidText, "amount_f":amount_f, "usd_v":usd_v}, function(data){
			$("#return_tx").html(data);
		});

	}else{
		alert("tx id wrong");
	}
	//end send tx

}

function copy_wallet(){

  	// Copy the text inside the text field
 	var text = document.getElementById("wallet_api");
    var selection = window.getSelection();
    var range = document.createRange();
    range.selectNodeContents(text);
    selection.removeAllRanges();
    selection.addRange(range);

    //add to clipboard.
    document.execCommand('copy');
	setTimeout(function(){
		$("#copy_wallet").removeClass("fa-files-o");
		$("#copy_wallet").addClass("fa-check");
	}, 500);

	setTimeout(function(){
		$("#copy_wallet").removeClass("fa-check");
		$("#copy_wallet").addClass("fa-files-o");
	}, 2500);

}

function copy_amountf(){

  	// Copy the text inside the text field
 	var text = document.getElementById("amount_f_dep");
    var selection = window.getSelection();
    var range = document.createRange();
    range.selectNodeContents(text);
    selection.removeAllRanges();
    selection.addRange(range);
   
    //add to clipboard.
    document.execCommand('copy');

    $("#prof-payment").select();
    $("#prof-payment").attr("placeholder", "copy txId / hash id here");
    
	setTimeout(function(){
		$("#copy_amount").removeClass("fa-files-o");
		$("#copy_amount").addClass("fa-check");
	}, 500);
	
	setTimeout(function(){
		$("#copy_amount").removeClass("fa-check");
		$("#copy_amount").addClass("fa-files-o");
	}, 2500);

}

function copy_link(){

  	// Copy the text inside the text field
 	var text = document.getElementById("my_link");
    var selection = window.getSelection();
    var range = document.createRange();
    range.selectNodeContents(text);
    selection.removeAllRanges();
    selection.addRange(range);
    
    //add to clipboard.
    document.execCommand('copy');
	
	setTimeout(function(){
		$("#copy_link").removeClass("fa-files-o");
		$("#copy_link").addClass("fa-check");
	}, 500);
	
	setTimeout(function(){
		$("#copy_link").removeClass("fa-check");
		$("#copy_link").addClass("fa-files-o");
	}, 2500);

}

function rmconfirm(id){
	
	console.log(id);

	$(".dep-confirm").remove();
	$(".fa-2x").each(function(){     

		if($(this).attr("class") == "fa fa-2x ac-pay-dep color-theme float-left fa-sign-out" || $(this).attr("class") == "fa fa-2x ac-pay-dep color-theme fa-sign-out float-left" || $(this).attr("class") == "fa fa-2x ac-pay-dep text-light fa-sign-out float-left" || $(this).attr("class") == "fa fa-2x ac-pay-dep fa-sign-out"){

			$(this).removeClass("fa-sign-out");
			$(this).addClass("fa-usd");

		}

	});

	//
	obj_id = id.replace("close", "");

	$(".col-10-"+obj_id).css({"margin-top": "0"});
	$(".col-10-"+obj_id+"").removeClass("mb-3");
	//

 	if(location.href.indexOf("investimentos") >= 1 || location.href.indexOf("dep-packages") >= 1){
 		//mod_show('modal_dep_p','modal-dep');
 	}

 	if(location.href.indexOf("dep-tickets") >= 1){
 		//mod_show('modal_dep_t','modal-dep');
 	}

}

function api_convert_coin(coin, current_coin){

	if(coin != "default " && coin != "bitcoin " && coin != "ethereum " && coin != "litecoin " && coin != "tron " && coin != "busd " && coin != "tether " && coin != "pix "){
			
		alert("Invalid coin");
	
	}else{
		
		if(current_coin == "btc"){
			selected_coinc = "BTC";
		}else if(current_coin == "busd"){
			selected_coinc = "BNB";
		}else if(current_coin == "eth"){
			selected_coinc = "ETH";
		}else if(current_coin == "ltc"){
			selected_coinc = "LTC";
		}else if(current_coin == "tron"){
			selected_coinc = "TRX";
		}else if(current_coin == "pix"){
			selected_coinc = "PIX";
		}
		
		const region = $("body").attr("id"); // code country

	 	if(region == "US" || region == "en-US" || region == "us" || region == "EN-US" || region == "en-us"){
	 		api_url = "https://api.binance.us";
	 	}else{
	 		api_url = "https://api1.binance.com";
	 	}
	 	
		if(coin == "default " && current_coin != "default" && current_coin != "usdt" && current_coin != "tether" && current_coin != "tether "){

			if(current_coin == "btc"){
				selected_coinc = "BTC";
			}else if(current_coin == "busd"){
				selected_coinc = "BNB";
			}else if(current_coin == "eth"){
				selected_coinc = "ETH";
			}else if(current_coin == "ltc"){
				selected_coinc = "LTC";
			}else if(current_coin == "tron"){
				selected_coinc = "TRX";
			}else if(current_coin == "pix"){
				selected_coinc = "BRL";
			}
			
			if(selected_coinc ==  "BRL"){
				maincoin = "BTL";
				selected_coinc = "USDT";
			}else{
				maincoin = "USDT";
			}

			$.getJSON(""+api_url+"/api/v3/ticker/price?symbol="+selected_coinc+maincoin, function(data){
	   			
				convert_coin(data['price'], 0, current_coin, coin);

			}).fail(function( dat, textStatus, error ) {
		    	
	    		alert("api connect error, try again");
			});

		}else if(coin == "bitcoin "){
			
			$.getJSON(""+api_url+"/api/v3/ticker/price?symbol=BTCUSDT", function(data0){

				if(current_coin != "usdt"){
	 				$.getJSON(""+api_url+"/api/v3/ticker/price?symbol="+selected_coinc+"USDT", function(data1){
						//alert(data0['price']+" "+"arrr "+data1['price']);
						convert_coin(data0['price'], data1['price'], current_coin, coin);
					});
				}else{
					convert_coin(data0['price'], 0, current_coin, coin);
				}

			}).fail(function( dat, textStatus, error ) {
	    		alert("api connect error, try again");
			});

		}else if(coin == "ethereum "){

			$.getJSON(""+api_url+"/api/v3/ticker/price?symbol=ETHUSDT", function(data0){
			
				if(current_coin != "usdt"){
	 				$.getJSON(""+api_url+"/api/v3/ticker/price?symbol="+selected_coinc+"USDT", function(data1){
						//alert(data0['price']+" "+" "+data1['price']);
						convert_coin(data0['price'], data1['price'], current_coin, coin);
					});
				}else{
					convert_coin(data0['price'], 0, current_coin, coin);
				}

			}).fail(function( dat, textStatus, error ) {
		    	alert("api connect error, try again");
			});

		}else if(coin == "litecoin "){
			
			$.getJSON(""+api_url+"/api/v3/ticker/price?symbol=LTCUSDT", function(data0){

				if(current_coin != "usdt"){
	 				$.getJSON(""+api_url+"/api/v3/ticker/price?symbol="+selected_coinc+"USDT", function(data1){
						//alert(data0['price']+" "+" "+data1['price']);
						convert_coin(data0['price'], data1['price'], current_coin, coin);
					});
				}else{
					convert_coin(data0['price'], 0, current_coin, coin);
				}


			}).fail(function( dat, textStatus, error ) {
		    	alert("api connect error, try again");
			});

		}else if(coin == "tron "){

			$.getJSON(""+api_url+"/api/v3/ticker/price?symbol=TRXUSDT", function(data0){
	   			
				if(current_coin != "usdt"){
	 				$.getJSON(""+api_url+"/api/v3/ticker/price?symbol="+selected_coinc+"USDT", function(data1){
						//alert(data0['price']+" "+" "+data1['price']);
						convert_coin(data0['price'], data1['price'], current_coin, coin);
					});
				}else{
					convert_coin(data0['price'], 0, current_coin, coin);
				}
				

			}).fail(function( dat, textStatus, error ) {
		    	var err = textStatus + ", " + error;
	    		alert(err);
			});

		}else if(coin == "busd "){

			$.getJSON(""+api_url+"/api/v3/ticker/price?symbol=BNBUSDT", function(data0){
	   		
				if(current_coin != "usdt"){
	 				$.getJSON(""+api_url+"/api/v3/ticker/price?symbol="+selected_coinc+"USDT", function(data1){
						//alert(data0['price']+" "+" "+data1['price']);
						convert_coin(data0['price'], data1['price'], current_coin, coin);
					});
				}else{
					convert_coin(data0['price'], 0, current_coin, coin);
				}


			}).fail(function( dat, textStatus, error ) {
		    	alert("api connect error, try again");
			});

		}else if(coin == "pix "){

			$.getJSON(""+api_url+"/api/v3/ticker/price?symbol="+selected_coinc+"BRL", function(data0){
	   		
				convert_coin(data0['price'], 0, current_coin, coin);
				
			}).fail(function( dat, textStatus, error ) {
		    	alert("api connect error, try again");
			});

		}else if(coin == "tether " && current_coin != "default" && current_coin != "default " && current_coin != "tether" && current_coin != "pix"){

			if(coin == "bitcoin "){
				selected_coinc = "BTC";
			}else if(coin == "busd "){
				selected_coinc = "BNB";
			}else if(coin == "ethereum "){
				selected_coinc = "ETH";
			}else if(coin == "litecoin "){
				selected_coinc = "LTC";
			}else if(coin == "tron "){
				selected_coinc = "TRX";
			}else if(coin == "pix "){
				selected_coinc = "PIX";
			}
			
			$.getJSON(""+api_url+"/api/v3/ticker/price?symbol="+selected_coinc+"USDT", function(data){
	   			
				convert_coin(data['price'], 0, current_coin, coin);

			}).fail(function( dat, textStatus, error ) {
		    	alert("api connect error, try again");
			});

		}
		
	}

}

function convert_coin(value, cc, current_coin, coin){
	
	current_coin = current_coin.toUpperCase();
	count_cv = $(".cv").length;
	
	//alert(value+" "+cc+""+coin);
	
	if(coin == "default " || coin == "tether "){
		img_c = "images/coins/usdt-sm.png";
	}else if(coin == "bitcoin "){
		img_c = "images/coins/btc-sm.png";
	}else if(coin == "litecoin "){
		img_c = "images/coins/ltc-sm.png";
	}else if(coin == "ethereum "){
		img_c = "images/coins/eth-sm.png";
	}else if(coin == "tron "){
		img_c = "images/coins/trx-sm.png";
	}else if(coin == "busd "){
		img_c = "images/coins/busd-sm.png";
	}else if(coin == "pix "){
		img_c = "images/coins/pix.png";
	}
	
	$("#img-c").attr("src", img_c);

	for(var i = 0; i < count_cv+1; i++){

		if(coin != "default " && coin != "tether " && coin != "default" && coin != "tether" && coin != "pix "){

			if(current_coin != "USDT"){
				convert_usdt = parseFloat($(".cv:eq("+i+")").text()) * parseFloat(cc);
				convert_current = parseFloat(convert_usdt) / parseFloat(value); 
			}else{
				convert_current = parseFloat($(".cv:eq("+i+")").text()) / parseFloat(value); 
			}

			$(".cv:eq("+i+")").text(convert_current.toFixed(8));
				
		}else{

			if(current_coin == "USDT" && coin != "pix "){
				convert_current = parseFloat($(".cv:eq("+i+")").text()) / parseFloat(value);	
				$(".cv:eq("+i+")").text(convert_current.toFixed(2));
			}else if(current_coin == "USDT" && coin == "pix "){
				convert_current = parseFloat($(".cv:eq("+i+")").text()) * parseFloat(value);	
				$(".cv:eq("+i+")").text(convert_current.toFixed(2));
			}else if(current_coin == "PIX"){
				convert_current = parseFloat($(".cv:eq("+i+")").text()) / parseFloat(value);	
				$(".cv:eq("+i+")").text(convert_current.toFixed(2));
			}else{
				convert_current = parseFloat($(".cv:eq("+i+")").text()) * parseFloat(value);	
				$(".cv:eq("+i+")").text(convert_current.toFixed(2));
			}
		
		}
	
	}

	$(".with-amount").each(function(){
		txt = $(this).text();
		$(this).html(txt+" <img class='img-action-sm' src='"+img_c+"' title='bitcoin' width='16px' height='16px' alt='btc coin deposited'> <i class='fa fa-exchange' aria-hidden='true'></i>");
		
	});

	$(".dep-amount").each(function(){
		txt = $(this).text();
		$(this).html(txt+" <img class='img-action-sm' src='"+img_c+"' title='bitcoin' width='16px' height='16px' alt='btc coin deposited'> <i class='fa fa-exchange' aria-hidden='true'></i>");
	});

}

function enable_prot(prot, type){

	if(type=="dep"){
		prot_choose = "prot";
	}else{
		prot_choose = "prot-with";
	}

	count_prot = $("."+prot_choose+"").length;
	
	for (var i = 0; i < count_prot; i++) {

		if($("."+prot_choose+":eq("+i+") a").attr("href") != prot){
			$("."+prot_choose+":eq("+i+")").hide();
		}else{
			$("."+prot_choose+":eq("+i+")").show();
		}

	}

}

function rm_dep_m_d(id){

	id_dep = id;
	dm = $(".col-10-"+id_dep).attr("class");
	dl = $(".col-10-"+id_dep).length;

	dmd = $("#trrm"+id_dep).length;
	dmm = $("#rm"+id_dep).length;

	if(dmd >= 1 || dmm >= 1){
		ini_rm = false;
	}else{
		ini_rm = true;
	}

	if(ini_rm == true){
		
		if(dm == "undefined" || dl < 1){
			
			tr_dep_len = $(".tr-dep").length;
			
			for (var i = 0; i < tr_dep_len; i++) {
			
				if($(".tr-dep:eq("+i+")").attr("id") == "tr"+id_dep){

					rl = $(".tr-dep:eq("+i+")").attr("id");
					dm = "undefined";
			
				}
			
			}
		
		}else{
		
			rl = false;
		
		}
		
		if(rl == "tr"+id_dep || $(".col-10-"+id_dep).attr("class") == "col-10 col-sm-10 col-10-"+id_dep+"" || $(".col-10-"+id_dep).attr("class") == "col-10-"+id_dep+" col-12 col-sm-12" || $(".col-10-"+id_dep).attr("class") == "col-10-"+id_dep+" col-10 col-sm-10"){
			
			$.post('php/dep/gen_dep_after_action.php',{"cod_dep":id_dep,"dm":dm}, function(data){
				
				if(rl == "tr"+id_dep){
					$("#tr"+id_dep).after(data);
				}else{
					$(".col-10-"+id_dep).hide();
					$(".col-10-"+id_dep).after(data);
				}

			});
	
		}else{
		
			$("#trrm"+id_dep+"").remove();

		}
	
	}

}

function ac_pay_dep(id){

	//confirm dep
	
	id_dep = id;
	r_id_dep = id_dep.replace("con-", "");
		
	net_proto = $("#net-proto"+r_id_dep+"").text();
	id_dep_tr = r_id_dep;

	wd = $("body").width();
	
	if(wd <= 1024){

		mode = "mobile";
		net_proto = $("#net-proto"+r_id_dep+"").text();
		str_id_dep_tr = $(".ac-pay-dep").attr("id");
		id_dep_tr = id_dep.replace("con-", "");
	
	}else{
	
		mode = "desktop";
	
	}
	
	if(r_id_dep <= 8){ //package table

	}else{ //ticket table

	}

	console.log(id_dep_tr+" "+net_proto); 
	
	if($("#"+id_dep).attr("class") == "fa fa-2x ac-pay-dep color-theme fa-usd" || $("#"+id_dep).attr("class") == "fa fa-usd fa-2x ac-pay-dep text-light" || $("#"+id_dep).attr("class") == "fa fa-2x ac-pay-dep text-light fa-usd" || $("#"+id_dep).attr("class") == "fa fa-usd fa-2x ac-pay-dep color-theme float-left" || $("#"+id_dep).attr("class") == "fa fa-2x ac-pay-dep color-theme float-left fa-usd" || $("#"+id_dep).attr("class") == "fa fa-usd fa-2x ac-pay-dep" || $("#"+id_dep).attr("class") == "fa fa-2x ac-pay-dep fa-usd" || $("#"+id_dep).attr("class") == "fa fa-usd fa-2x ac-pay-dep" || $("#"+id_dep).attr("class") == "fa fa-window-close fa-2x ac-rm-dep color-theme" || $("#"+id_dep).attr("class") == "fa fa-window-close fa-2x ac-rm-dep text-light"){
		
		$("#con-"+r_id_dep).removeClass("fa-usd");
		$("#con-"+r_id_dep).addClass("fa-sign-out");
	
		$.post("php/get_paymentadds.php",{"id_dep":id_dep_tr,"net_proto":net_proto}, function(data){
			
			payments = JSON.parse(data);
			
			const region = $("body").attr("id"); // code country

		 	if(region == "US" || region == "en-US" || region == "us" || region == "EN-US" || region == "en-us"){
		 		api_url = "https://api.binance.us";
		 	}else{
		 		api_url = "https://api1.binance.com";
		 	}

		 	if($("#current_coin").text() == "usdt"){
 				
 				if(mode == "desktop"){
			   		selected_coin = $("#tr"+r_id_dep+" td:eq(3) img").attr("src");
			 	}else{
			 		selected_coinv = $(".img-"+r_id_dep+"").attr("id");
			 		selected_coin = $(".img-"+r_id_dep+"").attr("src");
			 	}
			 	
			 	if(selected_coin == "images/coins/btc-sm.png"){
			 		selected_coin="BTC";
			 	}else if(selected_coin == "images/coins/ltc-sm.png"){
			 		selected_coin="LTC";
			 	}else if(selected_coin == "images/coins/eth-sm.png"){
			 		selected_coin="ETH";
			 	}else if(selected_coin == "images/coins/trx-sm.png"){
			 		selected_coin="TRX";
			 	}else if(selected_coin == "images/coins/usdt-sm.png"){
			 		selected_coin="USDT";
			 	}else if(selected_coin == "images/coins/busd-sm.png"){
			 		selected_coin="BNB";
			 	}else if(selected_coin == "images/coins/pix.png"){
			 		selected_coin="PIX";
			 	}
			 	
			 	get_theme = $(".lights").attr("id");
			 
			   	if(get_theme == "#dark"){
			   		color_theme = "text-light";
			   	}else{
			   		color_theme = "color-theme";
			   	}

			 	if(selected_coin != "USDT"){
			   		
			   		if(selected_coin == "PIX"){
			   			
			   			//start desktop 
					   	if(mode == 'desktop'){

					   		amountt = parseFloat($("#tr"+r_id_dep+" td:eq(2)").text());
					   		
					   		if(id_dep_tr.indexOf("-") >= 1){
						   		amount_f = parseFloat(0.20)*parseFloat(amountt.toFixed(2));
						   	}else{
						   		amount_f = amountt.toFixed(2);
						   	}

							add_payment = '<div class="dep-confirm text-light container" id="confirmuox2usja" style="margin-left: 22%; padding: 7px 0px;"><div style="position: absolute; margin-top: 41px !important;margin-left: 40%;" class="col-md-6 float-right"><span class="'+color_theme+'">payment amount <a id="amount_f_dep" class="text-muted" href="#amountf">0.01071811</a> <i aria-hidden="true" id="copy_amount" class="fa fa-files-o fa-1x float-right" onclick="copy_amountf();" style="position: absolute;margin-top: 2;margin-left: 10px;"></i></span><form></form><input type="text" id="prof-payment-uox2usja" class="inptx" name="hash-dep" placeholder="tx / id de confirmação" style="width: 250px;height: 30px;border: none;padding: 0px 10px; background: #ddd;"><button type="button" id="btn-tx" onclick="btntx();" style="height: 30px;border: none;padding: 0px 4px;">Confirm</button><br><a class="text-muted" href="#">after pay copy and paste our confirmation code</a><br><div class="timestamp_dep '+color_theme+'">60</div><div id="return_tx" style="position: absolute;float: right;margin-left: 37%;margin-top: 3%;"></div></div><div class="'+color_theme+'" style="margin-top: 0px;">Wallet: <a id="wallet_api" class="text-muted" href="#wallet-confirmed" title="wallet for deposit">LLY2NBhgBCYUYucugWzDPWqczxi11MNzqu</a><i aria-hidden="true" id="copy_wallet" class="fa fa-files-o fa-1x float-right" onclick="copy_wallet();" style="position: absolute;margin-top: 2;margin-left: 10px;"></i></div><span class="'+color_theme+'"><br>QR CODE:<br><img src="images/qr-code/ltc.png" width="150" height="150"></span></div>';
							$("#tr"+r_id_dep).html(add_payment);
							//end desktop mobile

						}else if(mode == "mobile"){ // if == mobile

							str_amountt = selected_coinv;
							rid_dep_tr = id_dep_tr.indexOf("-");
						 
						   	if(rid_dep_tr >= 1){
						   		amount_f = parseFloat(0.20)*parseFloat(amountt);
						   	}else{
						   		amount_f = str_amountt;
						   	}

					   		add_payment = '<div class="dep-confirm '+color_theme+' container" id="confirm'+color_theme+'" style="width: 100% !important; min-height: 200px; overflow-y: auto !important; overflow-x: hidden; position: relative;"><span>Wallet:<br><a id="wallet_api" href="#wallet-confirmed" class="text-muted" title="wallet for deposit">'+payments['wallet']+'</a><i aria-hidden="true" id="copy_wallet" class="fa fa-files-o fa-1x float-right" onclick="copy_wallet();" style="position: absolute;margin-top: 2;margin-left: 5px;"></i><br>QR CODE:<br><img src="'+payments['qr']+'" width="150" height="150"></span><div style="position: absolute; left: 0px; margin: 0px auto !important;" class="col"><span>payment amount: <a id="amount_f_dep" class="text-muted" href="#amountf">'+amount_f+'</a><i aria-hidden="true" id="copy_amount" class="fa fa-files-o fa-1x float-right" onclick="copy_amountf();" style="position: absolute;margin-top: 2;margin-left: 5px;"></i></span><form></form><input type="text" id="prof-payment-'+r_id_dep+'" class="inptx" name="hash-dep" placeholder="tx / id de confirmação" style="width: 250px;height: 30px;border: none;padding: 0px 10px; background: #ddd;"><button type="button" id="btn-tx" onclick="btntx();" style="height: 30px;border: none;padding: 0px 4px;">Confirm</button><br><a class="text-muted" href="#" style="font-size: 13px;">after pay copy and paste our confirmation code</a><br><div class="col timestamp_dep" style="position:relative; margin: 0px auto !important; font-size: 13px;">60</div><div id="return_tx" style="position: absolute;float: left;margin-left: 0%;margin-top: 3%;"></div></div></div>';

							$(".col-10-"+r_id_dep+"").after(add_payment);
				   			$(".col-10-"+r_id_dep+"").addClass("mb-3");
							
						}

			   		}else{

			   			maincoin = "USDT";
			   			
			   			$.getJSON(""+api_url+"/api/v3/ticker/price?symbol="+selected_coin+""+maincoin+"", function(data1){
			   				
			   				get_theme = $(".lights").attr("id");
						   	if(get_theme == "#dark"){
						   		color_theme = "text-light";
						   	}else{
						   		color_theme = "color-theme";
						   	}

							if(mode == "desktop"){			
								
								amountt = parseFloat($("#tr"+r_id_dep+" td:eq(2)").text());
						
							   	if(id_dep_tr.indexOf("-") >= 1){
							   		amount_f = parseFloat(0.20)*parseFloat(amountt.toFixed(2)) / parseFloat(data1['price']);
							   	}else{
							   		amount_f = parseFloat(amountt) / parseFloat(data1['price']);
							   	}
							   	
							   	amount_ff = amount_f.toFixed(8);
							   	hinfo = $("#tr"+r_id_dep).html();
	
							 	add_payment = '<div class="dep-confirm text-light container" id="confirmuox2usja" style="margin-left: 22%; padding: 7px 0px;"><div style="position: absolute; margin-top: 41px !important;margin-left: 40%;" class="col-md-6 float-right"><span class="'+color_theme+'">payment amount <a id="amount_f_dep" class="text-muted" href="#amountf">0.01071811</a> <i aria-hidden="true" id="copy_amount" class="fa fa-files-o fa-1x float-right" onclick="copy_amountf();" style="position: absolute;margin-top: 2;margin-left: 10px;"></i></span><form></form><input type="text" id="prof-payment-uox2usja" class="inptx" name="hash-dep" placeholder="tx / id de confirmação" style="width: 250px;height: 30px;border: none;padding: 0px 10px; background: #ddd;"><button type="button" id="btn-tx" onclick="btntx();" style="height: 30px;border: none;padding: 0px 4px;">Confirm</button><br><a class="text-muted" href="#">after pay copy and paste our confirmation code</a><br><div class="timestamp_dep '+color_theme+'">60</div><div id="return_tx" style="position: absolute;float: right;margin-left: 37%;margin-top: 3%;"></div></div><div class="'+color_theme+'" style="margin-top: 0px;">Wallet: <a id="wallet_api" class="text-muted" href="#wallet-confirmed" title="wallet for deposit">LLY2NBhgBCYUYucugWzDPWqczxi11MNzqu</a><i aria-hidden="true" id="copy_wallet" class="fa fa-files-o fa-1x float-right" onclick="copy_wallet();" style="position: absolute;margin-top: 2;margin-left: 10px;"></i></div><span class="'+color_theme+'"><br>QR CODE:<br><img src="images/qr-code/ltc.png" width="150" height="150"></span></div>';

								$("#tr"+r_id_dep).html(hinfo);
								$("#tr"+r_id_dep).after(add_payment);
								//end desktop mobile
								
							}else if(mode == "mobile"){ // if == mobile
								
								str_amountt = selected_coinv;
						
							   	if(id_dep_tr.indexOf("-") >= 1){
							   		amount_f = parseFloat(0.20)*parseFloat(amountt.toFixed(2)) / parseFloat(data1['price']);
							   	}else{
							   		amount_f = parseFloat(str_amountt) / parseFloat(data1['price']);
							   	}
								
								amount_ff = amount_f.toFixed(8);

							   	get_theme = $(".lights").attr("id");
						
					   			add_payment = '<div class="dep-confirm '+color_theme+' container" id="confirm'+color_theme+'" style="width: 100% !important; min-height: 200px; overflow-y: auto !important; overflow-x: hidden; position: relative;"><span>Wallet:<br><a id="wallet_api" href="#wallet-confirmed" class="text-muted" title="wallet for deposit">'+payments['wallet']+'</a><i aria-hidden="true" id="copy_wallet" class="fa fa-files-o fa-1x float-right" onclick="copy_wallet();" style="position: absolute;margin-top: 2;margin-left: 5px;"></i><br>QR CODE:<br><img src="'+payments['qr']+'" width="150" height="150"></span><div style="position: absolute; left: 0px; margin: 0px auto !important;" class="col"><span>payment amount: <a id="amount_f_dep" class="text-muted" href="#amountf">'+amount_ff+'</a><i aria-hidden="true" id="copy_amount" class="fa fa-files-o fa-1x float-right" onclick="copy_amountf();" style="position: absolute;margin-top: 2;margin-left: 5px;"></i></span><form></form><input type="text" id="prof-payment-'+r_id_dep+'" class="inptx" name="hash-dep" placeholder="tx / id de confirmação" style="width: 250px;height: 30px;border: none;padding: 0px 10px; background: #ddd;"><button type="button" id="btn-tx" onclick="btntx();" style="height: 30px;border: none;padding: 0px 4px;">Confirm</button><br><a class="text-muted" href="#" style="font-size: 13px;">after pay copy and paste our confirmation code</a><br><div class="col timestamp_dep" style="position:relative; margin: 0px auto !important; font-size: 13px;">60</div><div id="return_tx" style="position: absolute;float: left;margin-left: 0%;margin-top: 3%;"></div></div></div>';

								$(".col-10-"+r_id_dep+"").after(add_payment);
				   				$(".col-10-"+r_id_dep+"").addClass("mb-3");			   		
							   	
							}

						});
			   		
			   		}
			   		
				}else{ //usdt usdt
				
					if(mode == "desktop"){
						
						amountt = parseFloat($("#tr"+r_id_dep+" td:eq(2)").text());
					
					    if(id_dep_tr.indexOf("-") >= 1){
					   		amount_f = parseFloat(0.20)*parseFloat(amountt.toFixed(2)) / parseFloat(data1['price']);
					   	}else{
					   		amount_f = amountt;
					   	}
					
					   	hinfo = $("#tr"+r_id_dep).html();
						
						add_payment = '<div class="dep-confirm text-light container" id="confirmuox2usja" style="margin-left: 22%; padding: 7px 0px;"><div style="position: absolute; margin-top: 41px !important;margin-left: 40%;" class="col-md-6 float-right"><span class="'+color_theme+'">payment amount <a id="amount_f_dep" class="text-muted" href="#amountf">0.01071811</a> <i aria-hidden="true" id="copy_amount" class="fa fa-files-o fa-1x float-right" onclick="copy_amountf();" style="position: absolute;margin-top: 2;margin-left: 10px;"></i></span><form></form><input type="text" id="prof-payment-uox2usja" class="inptx" name="hash-dep" placeholder="tx / id de confirmação" style="width: 250px;height: 30px;border: none;padding: 0px 10px; background: #ddd;"><button type="button" id="btn-tx" onclick="btntx();" style="height: 30px;border: none;padding: 0px 4px;">Confirm</button><br><a class="text-muted" href="#">after pay copy and paste our confirmation code</a><br><div class="timestamp_dep '+color_theme+'">60</div><div id="return_tx" style="position: absolute;float: right;margin-left: 37%;margin-top: 3%;"></div></div><div class="'+color_theme+'" style="margin-top: 0px;">Wallet: <a id="wallet_api" class="text-muted" href="#wallet-confirmed" title="wallet for deposit">LLY2NBhgBCYUYucugWzDPWqczxi11MNzqu</a><i aria-hidden="true" id="copy_wallet" class="fa fa-files-o fa-1x float-right" onclick="copy_wallet();" style="position: absolute;margin-top: 2;margin-left: 10px;"></i></div><span class="'+color_theme+'"><br>QR CODE:<br><img src="images/qr-code/ltc.png" width="150" height="150"></span></div>';

						$("#tr"+r_id_dep).html(hinfo);
						$("#tr"+r_id_dep).after(add_payment);
						//end desktop mobile
		
					}else if(mode == "mobile"){
											
					   	str_amountt = selected_coinv;
		
					   	if(id_dep_tr.indexOf("-") >= 1){
					   		amount_f = parseFloat(0.20)*parseFloat(amountt.toFixed(2)) / parseFloat(data1['price']);
					   	}else{
					   		amount_f = str_amountt;
					   	}

					   	get_theme = $(".lights").attr("id");
		
					   	add_payment = '<div class="dep-confirm '+color_theme+' container" id="confirm'+color_theme+'" style="width: 100% !important; min-height: 200px; overflow-y: auto !important; overflow-x: hidden; position: relative;"><span>Wallet:<br><a id="wallet_api" href="#wallet-confirmed" class="text-muted" title="wallet for deposit">'+payments['wallet']+'</a><i aria-hidden="true" id="copy_wallet" class="fa fa-files-o fa-1x float-right" onclick="copy_wallet();" style="position: absolute;margin-top: 2;margin-left: 5px;"></i><br>QR CODE:<br><img src="'+payments['qr']+'" width="150" height="150"></span><div style="position: absolute; left: 0px; margin: 0px auto !important;" class="col"><span>payment amount: <a id="amount_f_dep" class="text-muted" href="#amountf">'+amount_f+'</a><i aria-hidden="true" id="copy_amount" class="fa fa-files-o fa-1x float-right" onclick="copy_amountf();" style="position: absolute;margin-top: 2;margin-left: 5px;"></i></span><form></form><input type="text" id="prof-payment-'+r_id_dep+'" class="inptx" name="hash-dep" placeholder="tx / id de confirmação" style="width: 250px;height: 30px;border: none;padding: 0px 10px; background: #ddd;"><button type="button" id="btn-tx" onclick="btntx();" style="height: 30px;border: none;padding: 0px 4px;">Confirm</button><br><a class="text-muted" href="#" style="font-size: 13px;">after pay copy and paste our confirmation code</a><br><div class="col timestamp_dep" style="position:relative; margin: 0px auto !important; font-size: 13px;">60</div><div id="return_tx" style="position: absolute;float: left;margin-left: 0%;margin-top: 3%;"></div></div></div>';
					
						$(".col-10-"+r_id_dep+"").after(add_payment);
				   		$(".col-10-"+r_id_dep+"").addClass("mb-3");
						
					}

				}
				
		 	}else if($("#current_coin").text() != "usdt"){
		 
			 	if(mode == "desktop"){
			   		selected_coin = $("#tr"+r_id_dep+" td:eq(3) img").attr("src");
			 	}else{
			 		selected_coin = $("#val-"+r_id_dep+" img").attr("id");
			 		selected_coinc = $(".img-"+r_id_dep+"").attr("src");
			 	}

			 	if(selected_coinc == "images/coins/btc-sm.png"){
			 		selected_coinc="BTC";
			 	}else if(selected_coinc == "images/coins/ltc-sm.png"){
			 		selected_coinc="LTC";
			 	}else if(selected_coinc == "images/coins/eth-sm.png"){
			 		selected_coinc="ETH";
			 	}else if(selected_coinc == "images/coins/trx-sm.png"){
			 		selected_coinc="TRX";
			 	}else if(selected_coinc == "images/coins/usdt-sm.png"){
			 		selected_coinc="USDT";
			 	}else if(selected_coinc == "images/coins/busd-sm.png"){
			 		selected_coinc="BUSD";
			 	}else if(selected_coinc == "images/coins/pix.png"){
			 		selected_coinc="PIX";
			 	}
		 		
		 		if(selected_coinc == "PIX"){
		   			maincoin = "BRL";
		   			selected_coinc = "USDT";
		   		}else{
		   			maincoin = "USDT";
		   		}

		   		if(maincoin == "BRL" && $("#current_coin").text() == "pix"){
		   			maincoin = "USDT";
		   		}

			 	$.getJSON(""+api_url+"/api/v3/ticker/price?symbol="+selected_coinc+maincoin, function(data){

					if(mode == "desktop"){
			   			selected_coin = $("#tr"+r_id_dep+" td:eq(3) img").attr("src");
			 		}else{
			 			selected_coin = $("#val-"+r_id_dep+" img").attr("id");
			 		}
				 	
				 	if(selected_coin == "images/coins/btc-sm.png"){
				 		selected_coin="BTC";
				 	}else if(selected_coin == "images/coins/ltc-sm.png"){
				 		selected_coin="LTC";
				 	}else if(selected_coin == "images/coins/eth-sm.png"){
				 		selected_coin="ETH";
				 	}else if(selected_coin == "images/coins/trx-sm.png"){
				 		selected_coin="TRX";
				 	}else if(selected_coin == "images/coins/usdt-sm.png"){
				 		selected_coin="USDT";
				 	}else if(selected_coin == "images/coins/pix.png"){
				 		selected_coin="PIX";
				 	}else if(selected_coin == "images/coins/busd-sm.png"){
				 		selected_coin="BNB";
				 	}

				 	if(maincoin != "BRL"){

				   		$.getJSON(""+api_url+"/api/v3/ticker/price?symbol="+selected_coin+"USDT", function(data1){

				   			get_theme = $(".lights").attr("id");
						   	
						   	if(get_theme == "#dark"){
						   		color_theme = "text-light";
						   	}else{
						   		color_theme = "color-theme";
						   	}

							if(mode == "desktop"){
						
								amountt = parseFloat($("#tr"+r_id_dep+" td:eq(2)").text());
		
							   	if(id_dep_tr.indexOf("-") >= 1){
							   		amount_f = (parseFloat(0.20)*parseFloat(amountt)) / parseFloat(data1['price']);
							   	}else{
							   		amount_f = parseFloat(amountt) / parseFloat(data1['price']);
							   	}
							   
							   	amount_ff = amount_f.toFixed(8);

							   	get_theme = $(".lights").attr("id");
		
								add_payment = '<div class="dep-confirm text-light container" id="confirmuox2usja" style="margin-left: 22%; padding: 7px 0px;"><div style="position: absolute; margin-top: 41px !important;margin-left: 40%;" class="col-md-6 float-right"><span class="'+color_theme+'">payment amount <a id="amount_f_dep" class="text-muted" href="#amountf">0.01071811</a> <i aria-hidden="true" id="copy_amount" class="fa fa-files-o fa-1x float-right" onclick="copy_amountf();" style="position: absolute;margin-top: 2;margin-left: 10px;"></i></span><form></form><input type="text" id="prof-payment-uox2usja" class="inptx" name="hash-dep" placeholder="tx / id de confirmação" style="width: 250px;height: 30px;border: none;padding: 0px 10px; background: #ddd;"><button type="button" id="btn-tx" onclick="btntx();" style="height: 30px;border: none;padding: 0px 4px;">Confirm</button><br><a class="text-muted" href="#">after pay copy and paste our confirmation code</a><br><div class="timestamp_dep '+color_theme+'">60</div><div id="return_tx" style="position: absolute;float: right;margin-left: 37%;margin-top: 3%;"></div></div><div class="'+color_theme+'" style="margin-top: 0px;">Wallet: <a id="wallet_api" class="text-muted" href="#wallet-confirmed" title="wallet for deposit">LLY2NBhgBCYUYucugWzDPWqczxi11MNzqu</a><i aria-hidden="true" id="copy_wallet" class="fa fa-files-o fa-1x float-right" onclick="copy_wallet();" style="position: absolute;margin-top: 2;margin-left: 10px;"></i></div><span class="'+color_theme+'"><br>QR CODE:<br><img src="images/qr-code/ltc.png" width="150" height="150"></span></div>';
								$("#tr"+r_id_dep).html(add_payment);
								//end desktop mobile

							}else if(mode == "mobile"){

								str_amountt = selected_coinv;  

							   	if(id_dep_tr.indexOf("-") >= 1){
							   		amount_f = parseFloat(0.20)*parseFloat(amountt) / parseFloat(data1['price']);
							   	}else{
							   		amount_f = parseFloat(str_amountt) / parseFloat(data1['price']);
							   	}

							   	amount_ff = amount_f.toFixed(8);

							   	get_theme = $(".lights").attr("id");

					   			add_payment = '<div class="dep-confirm '+color_theme+' container" id="confirm'+color_theme+'" style="width: 100% !important; min-height: 200px; overflow-y: auto !important; overflow-x: hidden; position: relative;"><span>Wallet:<br><a id="wallet_api" href="#wallet-confirmed" class="text-muted" title="wallet for deposit">'+payments['wallet']+'</a><i aria-hidden="true" id="copy_wallet" class="fa fa-files-o fa-1x float-right" onclick="copy_wallet();" style="position: absolute;margin-top: 2;margin-left: 5px;"></i><br>QR CODE:<br><img src="'+payments['qr']+'" width="150" height="150"></span><div style="position: absolute; left: 0px; margin: 0px auto !important;" class="col"><span>payment amount: <a id="amount_f_dep" class="text-muted" href="#amountf">'+amount_ff+'</a><i aria-hidden="true" id="copy_amount" class="fa fa-files-o fa-1x float-right" onclick="copy_amountf();" style="position: absolute;margin-top: 2;margin-left: 5px;"></i></span><form></form><input type="text" id="prof-payment-'+r_id_dep+'" class="inptx" name="hash-dep" placeholder="tx / id de confirmação" style="width: 250px;height: 30px;border: none;padding: 0px 10px; background: #ddd;"><button type="button" id="btn-tx" onclick="btntx();" style="height: 30px;border: none;padding: 0px 4px;">Confirm</button><br><a class="text-muted" href="#" style="font-size: 13px;">after pay copy and paste our confirmation code</a><br><div class="col timestamp_dep" style="position:relative; margin: 0px auto !important; font-size: 13px;">60</div><div id="return_tx" style="position: absolute;float: left;margin-left: 0%;margin-top: 3%;"></div></div></div>';							   	

								$(".col-10-"+r_id_dep+"").after(add_payment);								
				   				$(".col-10-"+r_id_dep+"").addClass("mb-3");

							}
								
						});

			   		}else{

			   			if(mode == "desktop"){
						
							amountt = parseFloat($("#tr"+r_id_dep+" td:eq(2)").text());

						    if(id_dep_tr.indexOf("-") >= 1){
						   		amount_f = (parseFloat(0.20)*parseFloat(amountt.toFixed(2))) / parseFloat(data1['price']);
						   	}else{
						   		amount_f = parseFloat(amountt) / parseFloat(data1['price']);
						   	}

						   	get_theme = $(".lights").attr("id");

							add_payment = '<div class="dep-confirm text-light container" id="confirmuox2usja" style="margin-left: 22%; padding: 7px 0px;"><div style="position: absolute; margin-top: 41px !important;margin-left: 40%;" class="col-md-6 float-right"><span class="'+color_theme+'">payment amount <a id="amount_f_dep" class="text-muted" href="#amountf">0.01071811</a> <i aria-hidden="true" id="copy_amount" class="fa fa-files-o fa-1x float-right" onclick="copy_amountf();" style="position: absolute;margin-top: 2;margin-left: 10px;"></i></span><form></form><input type="text" id="prof-payment-uox2usja" class="inptx" name="hash-dep" placeholder="tx / id de confirmação" style="width: 250px;height: 30px;border: none;padding: 0px 10px; background: #ddd;"><button type="button" id="btn-tx" onclick="btntx();" style="height: 30px;border: none;padding: 0px 4px;">Confirm</button><br><a class="text-muted" href="#">after pay copy and paste our confirmation code</a><br><div class="timestamp_dep '+color_theme+'">60</div><div id="return_tx" style="position: absolute;float: right;margin-left: 37%;margin-top: 3%;"></div></div><div class="'+color_theme+'" style="margin-top: 0px;">Wallet: <a id="wallet_api" class="text-muted" href="#wallet-confirmed" title="wallet for deposit">LLY2NBhgBCYUYucugWzDPWqczxi11MNzqu</a><i aria-hidden="true" id="copy_wallet" class="fa fa-files-o fa-1x float-right" onclick="copy_wallet();" style="position: absolute;margin-top: 2;margin-left: 10px;"></i></div><span class="'+color_theme+'"><br>QR CODE:<br><img src="images/qr-code/ltc.png" width="150" height="150"></span></div>';
							$("#tr"+r_id_dep).html(add_payment);
							//end desktop mobile
						
						}else if(mode == "mobile"){

							str_amountt = selected_coinv;

						   	if(id_dep_tr.indexOf("-") >= 1){
						   		amount_f = (parseFloat(0.20)*parseFloat(amountt.toFixed(2))) / parseFloat(data1['price']);
						   	}else{
						   		amount_f = parseFloat(str_amountt) / parseFloat(data1['price']);
						   	}

					   		add_payment = '<div class="dep-confirm '+color_theme+' container" id="confirm'+color_theme+'" style="width: 100% !important; min-height: 200px; overflow-y: auto !important; overflow-x: hidden; position: relative;"><span>Wallet:<br><a id="wallet_api" href="#wallet-confirmed" class="text-muted" title="wallet for deposit">'+payments['wallet']+'</a><i aria-hidden="true" id="copy_wallet" class="fa fa-files-o fa-1x float-right" onclick="copy_wallet();" style="position: absolute;margin-top: 2;margin-left: 5px;"></i><br>QR CODE:<br><img src="'+payments['qr']+'" width="150" height="150"></span><div style="position: absolute; left: 0px; margin: 0px auto !important;" class="col"><span>payment amount: <a id="amount_f_dep" class="text-muted" href="#amountf">'+amount_f+'</a><i aria-hidden="true" id="copy_amount" class="fa fa-files-o fa-1x float-right" onclick="copy_amountf();" style="position: absolute;margin-top: 2;margin-left: 5px;"></i></span><form></form><input type="text" id="prof-payment-'+r_id_dep+'" class="inptx" name="hash-dep" placeholder="tx / id de confirmação" style="width: 250px;height: 30px;border: none;padding: 0px 10px; background: #ddd;"><button type="button" id="btn-tx" onclick="btntx();" style="height: 30px;border: none;padding: 0px 4px;">Confirm</button><br><a class="text-muted" href="#" style="font-size: 13px;">after pay copy and paste our confirmation code</a><br><div class="col timestamp_dep" style="position:relative; margin: 0px auto !important; font-size: 13px;">60</div><div id="return_tx" style="position: absolute;float: left;margin-left: 0%;margin-top: 3%;"></div></div></div>';						  	

							$(".col-10-"+r_id_dep+"").after(add_payment);
				   			$(".col-10-"+r_id_dep+"").addClass("mb-3");
						   	
						}
			   		
			   		}
				
				});
	
		 	}
		 	
		});

	}else{ //close payment settings

		idr_id_dep = "close"+r_id_dep;
		rmconfirm(idr_id_dep);
	
	}
	//end
}
