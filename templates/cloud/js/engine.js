$(document).ready(function(){
	
    $(".link_zero").click(function(){
        return false;
    });

	$(".jcarousel").hover(function(){
        $(".jcarousel-control-prev, .jcarousel-control-next").toggleClass('vissible');
    });
	
	skrollr.init({forceHeight: false});
	
	if (window.addEventListener) window.addEventListener('DOMMouseScroll', wheel, false);
	window.onmousewheel = document.onmousewheel = wheel;
	var time = 500;
	var distance = $(window).height()/3;
	function wheel(event) {
		if (event.wheelDelta) delta = event.wheelDelta / 120;
		else if (event.detail) delta = -event.detail / 3;
		handle();
		if (event.preventDefault) event.preventDefault();
		event.returnValue = false;
	}
	function handle() {
		$('html, body').stop().animate({
			scrollTop: $(window).scrollTop() - (distance * delta)
		}, time);
	}
	
	$('#back_top').on("click", function(){
		$('html, body').stop().animate({ 
			scrollTop: 0
		}, 300);
	})
	
	$(window).scroll(function(){
		if($(this).scrollTop()>0){      		//przycisk powrotu na górę strony
			$('#back_top').fadeIn(1000);
		}else{
			$('#back_top').fadeOut(300);
		}
	}); 	// end scroll
	
	$(".form").submit( function () {    
		$this = $(this);
		$.post(
			$this.attr("action"),
            $this.serialize(),
            function(data){
				document.location.reload(true);
            }
        );
        return false;   
    });  

	$("#form_komentarz").submit(function(){    
		$form = $(this);
		var validate = true;
		$('input[name=url]').val(window.location);
		if($('input[name=code]').val()==''){ 
			validate = false;
			$('.red').text('Przepisz kod captcha.');	
		}
		if($('input[name=podpis]').val()==''){ 
			validate = false;
			$('.red').text('Podpisz się!');	
		}
		var regex = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
		if(regex.test($('input[name=email]').val()) === false){
			validate = false;
			$('.red').text('Wpisz prawidłowy adres e-mail');	
		}
		if($('textarea[name=komentarz]').val()==''){ 
			validate = false;
			$('.red').text('Wpisz swój komentarz');	
		}
		if(validate==true){
			$.post(
			$form.attr("action"),
            $form.serialize(),
            function(data){	
				if(data=='error'){
					var form = $('<form action="' + window.location + '" method="post">' +
					'<input type="text" name="error_komentarz" value="1"/>' +
					'<input type="text" name="komentarz" value="' + $('textarea[name=komentarz]').val() + '"/>' +
					'<input type="text" name="podpis" value="' + $('input[name=podpis]').val() + '"/>' +
					'<input type="text" name="email" value="' + $('input[name=email]').val() + '"/>' +
					  '</form>');
					$('body').append(form);
					$(form).submit();
				}else if(data=='ok'){
					if($('input[name=status]').val()=='2'){
						document.location.reload(true);
					}else{
						$('.red').text('Twój komentarz został dodany. Potwierdź swój adres e-mail klikając w link aktywacyjny.');
						$('input[type=text]').val('');
						$('textarea').val('');
					}
				}else{
					$('.red').text('Nie udało się dodać komentarza');
				}
            });
		}
        return false;   
    });  	
	
	$("#form_kontakt").submit( function () {    
		var validate = true;
		var regex = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
		$form = $(this);
		$('.span_kontakt').html('');
		if($form.find('[name=code]').val() == ''){ 
			validate = false;
			$('.span_kontakt').html('Przepisz kod sprawdzający.');	
		}
		if($form.find('[name=temat]').val() == ''){ 
			validate = false;
			$('.span_kontakt').html('Wpisz temat wiadomości.');	
		}
		if($form.find('[name=tresc]').val() == ''){ 
			validate = false;
			$('.span_kontakt').html('Wpisz treść wiadomości.');	
		}
		if(regex.test($form.find('[name=email]').val()) === false){
			validate = false;
			$('.span_kontakt').html('Wprowadź poprawny adres e-mail.');
		}
		if($form.find('[name=imie]').val() == ''){ 
			validate = false;
			$('.span_kontakt').html('Wpisz swoje imię i nazwisko.');	
		}
		if(validate==true){
			$.post(
			$form.attr("action"),
			$form.serialize(),
			function(data){
				if(data=='error'){
					var form = $('<form action="' + window.location + '" method="post">' +
					'<input type="text" name="error_email" value="1"/>' +
					'<input type="text" name="imie" value="' + $('input[name=imie]').val() + '"/>' +
					'<input type="text" name="email" value="' + $('input[name=email]').val() + '"/>' +
					'<input type="text" name="temat" value="' + $('input[name=temat]').val() + '"/>' +
					'<input type="text" name="tresc" value="' + $('textarea[name=tresc]').val() + '"/>' +
					  '</form>');
					$('body').append(form);
					$(form).submit();
				}else if(data=='ok'){
					$form.find('input').not('[type=submit]').val('');
					$form.find('textarea').val('');
					$('.span_kontakt').html('Wiadomość została wysłana.');
				}else{
					$('.span_kontakt').html('Nie udało się wysłać wiadomości.');
				}	
			});
		}
		return false;  
    });  	

	$("#facebook2_2").hover(function(){$(this).stop(true,false).animate({right: "0px"}, 500 );},
		function(){$("#facebook2_2").stop(true,false).animate({right: "-304px"}, 500 );});
		
})

//facebook
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pl_PL/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

