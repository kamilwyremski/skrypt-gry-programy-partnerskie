$(window).load(function(){
	document_height = $(document).height();
	window_height = $(window).height();
	if(document_height>window_height){
		$('footer').css('position','relative');
	}
})

$(document).ready(function(){
	
	$('.link').click(function(){
		var $this = $(this);
		$($this.attr('href')).fadeIn();
		return false;
	})
	
	$('.nie').click(function(){
		$('.page_box').fadeOut();
		$('.red').html('');
		return false;
	})
	
	$('.link_form').click(function(){
		var $this = $(this);
		$parents = $this.parent().parent();
		$cel = $($this.attr('href'));
		$cel.find('.this_id').attr('value', $this.data('id'));
		$cel.find('.this_nazwa').attr('value', $this.data('nazwa'));
		$cel.find('.this_url').attr('value', $this.data('url'));
		$cel.find('.this_tresc').html($parents.find('.tresc').html());
		$cel.find('.this_nazwa_text').text($this.data('nazwa'));
		$cel.fadeIn().find('.input').first().focus();
		return false;
	})
		
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
	
	$(".form_ustawienia").submit( function () {    
		var formObj = $(this);
		var formURL = formObj.attr("action");
		var formData = new FormData(this);
		$.ajax({
			url: formURL,
			type: 'POST',
			data:  formData,
			mimeType:"multipart/form-data",
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){
				document.location.reload(true);
			}          
		});
        return false;   
    });  

	$("#form_gra").submit(function(){    
		$form = $(this);
		var validate = true;
		$('.red').fadeOut();
		$form.find('.required').each(function(){
			$this = $(this);
			if ($this.val()==''){
				$this.parent().find('.red').fadeIn();
				validate=false;
			}
		})
		if ($form.find("input:checkbox:checked").length == 0 && $form.find("input[name=nowakategoria]").val()=='' ){
			$('.check_span').fadeIn();
			validate=false;
		}
		for (instance in CKEDITOR.instances)
        CKEDITOR.instances[instance].updateElement();
        $('textarea').trigger('keyup');
		/*if(jQuery("#cke_editor1 iframe").contents().find("body").text()==''){
			$('.check_span2').fadeIn();
			validate=false;
		}*/
		if(validate==true){
			$.post(
			$form.attr("action"),
            $form.serialize(),
            function(data){
				window.location = $('#base_url').html()+'cms/gry';
            });
		}
        return false;   
    });  	

	$(".pokaz_tagi").click(function(){   
		$(".hide_tag").css({'display':'block'});
		$(this).remove();
		return false;
	});

	$(".pozycja").click(function(){    
		$this = $(this);
		$.post('php/gry.php', {
			'action' : $this.data('action'),
			'id' : $this.data('id'),
			'kategoria' : $this.data('kategoria'),
			'send': 'ok'}, 
			function() {
				document.location.reload(true);
		});
        return false;   
    }); 
	
	$('.dodaj_komentarz').click(function(){
		$.post('php/komentarze.php', {
			'action' : 'dodaj',
			'id' : $(this).data('id'),
			'send': 'ok'}, 
			function() {
				document.location.reload(true);
		});
		return false;
	}); 
	
	$('.usun_komentarz').click(function(){
		$.post('php/komentarze.php', {
			'action' : 'usun',
			'id' : $(this).data('id'),
			'send': 'ok'}, 
			function() {
				document.location.reload(true);
		});
		return false;
	}); 	
	
	$('.pobierz_url').click(function(){
		$('input[name=base_url]').attr('value',window.location.origin+'/');
		return false;
	})
})

$(document).on('click', '#zapisz_ustawienia', function(){

	var validate = true;
	$('.u').text('');
	
	if($('.u0').val().length ==0){ 
		validate = false;
		$('.u_login').text('Wpisz login');	
	}
	
	if($('.u1').val() != $('.u2').val()){ 
		validate = false;
		$('.u_password').text('Podane hasła są różne');	
	}
	
	if($('.u1').val().length ==0){ 
		validate = false;
		$('.u_password').text('Podane hasło jest za krótkie');	
	}
		
	if(validate == true){
		$.post('php/login.php', {
			'login' : $('.u0').val(),
			'password' : $('.u1').val(),
			'send': 'ok'}, 
			function() {
				document.location.reload(true);
		});
	}
});

$(document).keyup(function(e) { 
    if (e.which == 27) { $('.nie').click();}
});