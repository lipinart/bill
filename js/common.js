$(document).ready(function() {
	
	$(".btn-close").on("click", function(e){
		e.preventDefault();
		var close = $(this).attr("data-target");
		$("."+close).fadeOut().removeClass("open");
		$("html").removeClass("fix-body");
		$(".form-result").hide();
			setTimeout(function(){
			    $("."+close+" form").trigger("reset").show();
			}, 500);
	});

	$("body").on("click", "a.btn-toggle", function(e){
		e.preventDefault();
		var target = $(this).attr("href");
		yaCounter45548784.reachGoal("order");
		if(target != '#'){
			$("html").addClass("fix-body");
			$(".modal-"+target).fadeIn().addClass("open");
        }
	});

	$("body").on("click", "a.btn-getdoc", function(e){
		e.preventDefault();
		var target = $(this).attr("href");
		yaCounter45548784.reachGoal("message");
		if(target != '#'){
			$("html").addClass("fix-body");
			$(".modal-"+target).fadeIn().addClass("open");
			$(".modal-docs .card").load("politic.html");
        }
	});

	$('input[type="text"],input[type="email"],input[type="tel"]').on("focus", function(){
		$(this).addClass('active');
	});
	$('input[type="text"],input[type="email"],input[type="tel"]').on("blur", function(){
		$(this).removeClass('active');
	});

	
	$(".btn-collapse").on("click", function(e){
		e.preventDefault();
		var target = $(this).attr("href");
		var items = $("#menu-main").get(0).outerHTML+"<hr>"+$("#menu-call").get(0).outerHTML;

		
		if($(this).hasClass("active")&&$(".nav-menu").hasClass("active")){
			$(this).removeClass("active");
			$(".nav-menu").slideUp(300, function(){
				$(".nav-menu").removeClass("active").html("");
			});
		}else{
			$(".btn-collapse").removeClass("active");
			$(this).addClass("active");
			$(".nav-menu").hide().html(items).addClass("active").slideDown();
		}
	});

	//submit
		$("form").on('submit', function(e){
		e.preventDefault();	
		var form_data=$(this).serialize();
		$.ajax({
			type: 'POST',
			url: 'send.php',
			data: form_data,
			success: function(response){
				if(response != "1"){
					$(".form-group").removeClass("error");
					$("#"+response).parents(".form-group").addClass("error");
				}else{
					$(".form-group").removeClass("error");
					$("form").hide();
					$(".form-result").show();
					setTimeout(function(){
					    $("form").trigger("reset");
					    $(".form-wrapper .form-result").hide();
					    $(".form-wrapper form").show();
					}, 6000);
				}
			},
			error: function(response){
				alert('Error');
			}
		});
	});

	function form_reset(form){
		$(':input', form)
		.not(':button, :submit, :reset, :hidden')
		.val('')
		.removeAttr('checked')
		.removeAttr('selected');
	}


});