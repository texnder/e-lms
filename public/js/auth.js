$(document).ready(function(){
	$('.js-submit').on('click',function (ev) {
		ev.preventDefault();

		var url = 'register-new-admin';
		var name = filterName($('input[name="name"]').val());
		var username = validateEmail($('input[name="username"]').val());
		var password = $('input[name="password"]').val();
		var confirm_password = $('input[name="confirm_password"]').val();
		var phone = $('input[name="phone"]').val();

		if (!name) {
			$('.js-message').text('name cant be empty and no special charactor allowed!!');
			$('.js-message').css({"display":"block"});
			return;
		}
		
		if (!username) {
			$('.js-message').text('please type correct email!!');
			$('.js-message').css({"display":"block"});
			return;
		}
		if (password.length < 8 || password.length > 15) {
			$('.js-message').text('password length should be between 8 to 15 character!!');
			$('.js-message').css({"display":"block"});
			return;
		}
		if (password !== confirm_password) {
			$('.js-message').text('password do not match!!');
			$('.js-message').css({"display":"block"});
			return;
		}

		if (!phone || phone.length < 10 || phone.length > 14) {
			$('.js-message').text('please enter your valid phone number');
			$('.js-message').css({"display":"block"});
			return;
		}

		$.ajax({
			url: appUrl(url),
			type: "post",
			data: {
				_token : csrf_token,
				name : name,
				username : username,
				password : password,
				phone : phone
			},
			success:function(data){
				$('.js-success').text(JSON.parse(data));
				$('.js-success').css({"padding" : "20px","max-width": "500px","margin":"auto"});
				 window.setTimeout(function(){
			        window.location.href = appUrl('login/Admin');
			    }, 5000);
			}
		});


	})
});