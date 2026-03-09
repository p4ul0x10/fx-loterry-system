$(document).ready(function(){

   //fa fa-question float-right ico-question
   $(".fa-fx-question").click(function() {

		if($(".fa-fx-question").attr("class") == "fa-fx-question fa fa-question float-right ico-question" || $(".ico-question").attr("class") == "fa-fx-question fa float-right ico-question fa-question"){
		
			$(".fa-fx-question").removeClass("fa-question");
			$(".fa-fx-question").addClass("fa-close");
			$(".fa-fx-question").after("<div class='box-question-fx col-md-12 bg-theme'><small class='alert-primary' style='position: relative; float: left; margin-top:10px; color:#fff; background: rgba(17,18,36, 0.95); font-size: 12px;'>Total of 50% of participants received part of 80% of the total value of the daily draw. There is 20% left for the system to carry out activities.<b>*</b> note that 50% of participants is a ratio for the number of lottery participants, if the total number of participants is not divisible by 2, whose total division is exact, the system will round the total prizes to - 1 winner in the round.<br><b>ex: 55 participants is not divisible by 2, so 54 drawn will win.</b></small></div>");	
		
		}else{
		
			$(".fa-fx-question").removeClass("fa-close");
			$(".fa-fx-question").addClass("fa-question");
			$(".box-question-fx").remove();
		
		}

   });
   //end fa-question loterry

   //start
   $(".fa-lastw-question").click(function (){

      if($(".fa-lastw-question").attr("class") == "fa-lastw-question fa fa-question float-right ico-question" || $(".fa-lastw-question").attr("class") == "fa-lastw-question fa float-right ico-question fa-question"){
            
         $(".fa-lastw-question").removeClass("fa-question");
         $(".fa-lastw-question").addClass("fa-close");
         $(".fa-lastw-question").after("<div class='box-question-fxw col-md-12 bg-theme'><small class='alert-primary' style='position: relative; float: left; margin-top:10px; color:#fff; background: rgba(17,18,36, 0.95); font-size: 12px;'>Total of 50% of participants received part of 80% of the total value of the daily draw. There is 20% left for the system to carry out activities.<b>*</b> note that 50% of participants is a ratio for the number of lottery participants, if the total number of participants is not divisible by 2, whose total division is exact, the system will round the total prizes to - 1 winner in the round.<br><b>ex: 55 participants is not divisible by 2, so 54 drawn will win.</b></small></div>"); 
         
      }else{
         
         $(".fa-lastw-question").removeClass("fa-close");
         $(".fa-lastw-question").addClass("fa-question");
         $(".box-question-fxw").remove();
         
      }
  
   });
   //end

   //start fa-withdraw list
   $(".fa-with-exclamation").click(function () {

   		if($(".fa-with-exclamation").attr("class") == "fa-with-exclamation fa fa-question" || $(".fa-with-exclamation").attr("class") == "fa float-right ico-question fa-with-exclamation"){
   			
   			$(".fa-with-exclamation").removeClass("fa-question");
   			$(".fa-with-exclamation").addClass("fa-close");
   			txt = "Display showing latest withdrawal requests including (fx lottery, reference, rakeback). In case of a confirmed order, a confirmation link will be generated and accessible in the payments column.";
   			$(".modal-extrato .modal-header").after("<div class='box-question-withlist col-md-12 bg-theme'><small class='alert-primary' style='position: relative; float: left; color:#fff; background: rgba(17,18,36, 0.95); font-size: 12px;'>"+txt+"</b></small></div>");	
   		
   		}else{
   		
   			$(".fa-with-exclamation").removeClass("fa-close");
   			$(".fa-with-exclamation").addClass("fa-question");
   			$(".box-question-withlist").remove();
   	
   		}
   });
   //end fa-withdraw list

   //start fa-deposit list
   $(".fa-dep-exclamation").click(function () {

   		if($(".fa-dep-exclamation").attr("class") == "fa-dep-exclamation fa fa-question" || $(".fa-dep-exclamation").attr("class") == "fa float-right ico-question fa-with-exclamation"){
   			
   			$(".fa-dep-exclamation").removeClass("fa-question");
   			$(".fa-dep-exclamation").addClass("fa-close");
   			txt = "Display showing deposit orders, both activated and inactive. In action choose between confirming or deleting request if you haven't already confirmed.";
   			$(".modal-depinv .modal-header").after("<div class='box-question-deplist col-md-12 bg-theme'><small class='alert-primary' style='position: relative; float: left; color:#fff; background: rgba(17,18,36, 0.95); font-size: 12px;'>"+txt+"</b></small></div>");	
   		
   		}else{
   		
   			$(".fa-dep-exclamation").removeClass("fa-close");
   			$(".fa-dep-exclamation").addClass("fa-question");
   			$(".box-question-deplist").remove();
   	
   		}
   });
   //end fa-deposits list

   //start fa-depositar modal
   $(".fa-depm-exclamation").click(function () {

   		if($(".fa-depm-exclamation").attr("class") == "fa-depm-exclamation fa fa-question" || $(".fa-dep-exclamation").attr("class") == "fa float-right ico-question fa-with-exclamation"){
   			
   			$(".fa-depm-exclamation").removeClass("fa-question");
   			$(".fa-depm-exclamation").addClass("fa-close");
   			txt = "Display showing deposit options including package, currency, protocol and quantity. When generating an order, payment information will appear, this payment information display can also be viewed in the deposit column of the main menu.";
   			$(".modal-depositar .modal-header").after("<div class='box-question-depmodal col-md-12 bg-theme'><small class='alert-primary' style='position: relative; float: left; color:#fff; background: rgba(17,18,36, 0.95); font-size: 12px;'>"+txt+"</b></small></div>");	
   		
   		}else{
   		
   			$(".fa-depm-exclamation").removeClass("fa-close");
   			$(".fa-depm-exclamation").addClass("fa-question");
   			$(".box-question-depmodal").remove();
   	
   		}
   });
   //end fa-depositar modal

   //start fa-withdraw modal
   $(".fa-withm-exclamation").click(function () {

   		if($(".fa-withm-exclamation").attr("class") == "fa-withm-exclamation fa fa-question" || $(".fa-dep-exclamation").attr("class") == "fa float-right ico-question fa-with-exclamation"){
   			
   			$(".fa-withm-exclamation").removeClass("fa-question");
   			$(".fa-withm-exclamation").addClass("fa-close");
   			txt = "Display showing withdrawal options, currency, protocol and deposit or assets, with withdrawal balance. After choosing these fields, put the total to withdraw and place a request. If successful, you can track it in the main menu withdrawals column.";
   			$(".modal-saque .modal-header").after("<div class='box-question-withmodal col-md-12 bg-theme'><small class='alert-primary' style='position: relative; float: left; color:#fff; background: rgba(17,18,36, 0.95); font-size: 12px;'>"+txt+"</b></small></div>");	
   		
   		}else{
   		
   			$(".fa-withm-exclamation").removeClass("fa-close");
   			$(".fa-withm-exclamation").addClass("fa-question");
   			$(".box-question-withmodal").remove();
   	
   		}
   });
   //end fa-withdraw modal

   //start lt session
   $(".fa-lt-exclamation").click(function() {
      
      box_len = $(".box-question-ltk").length;
    
      if(box_len < 1){
         txt = "Display showing withdrawal options, currency, protocol and deposit or assets, with withdrawal balance. After choosing these fields, put the total to withdraw and place a request. If successful, you can track it in the main menu withdrawals column.";      
         $(".lt-timeb").after("<div class='box-question-ltk col-md-12 card bg-theme text-light'><small class='alert-primary' style='position: relative; float: left; color:#fff; background: rgba(17,18,36, 0.95); font-size: 12px;'>"+txt+"</b></small></div>");
      }else{
         $(".box-question-ltk").toggle();
      }

   });
   //end lt session

   //start reset exclamation
   $(".close").click(function () {

   		$(".fa-with-exclamation").removeClass("fa-close");
   		$(".fa-with-exclamation").addClass("fa-question");
   		$(".box-question-withlist").remove();

   		$(".fa-withm-exclamation").removeClass("fa-close");
   		$(".fa-withm-exclamation").addClass("fa-question");	
   		$(".box-question-withmodal").remove();

   		$(".fa-depm-exclamation").removeClass("fa-close");
   		$(".fa-depm-exclamation").addClass("fa-question");
   		$(".box-question-depmodal").remove();

   		$(".fa-dep-exclamation").removeClass("fa-close");
   		$(".fa-dep-exclamation").addClass("fa-question");
   		$(".box-question-deplist").remove();
   		
         $(".fa-lastw-question").removeClass("fa-close");
         $(".fa-lastw-question").addClass("fa-question");
         $(".box-question-fxw").remove();
   });
   //end reset exclamation

});