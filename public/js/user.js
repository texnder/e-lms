$(document).ready(function(){
	$('#submit_application').on('click', function (ev) {
		ev.preventDefault();

		var name = filterName($('input[name="name"]').val());
		var dob = $('input[name="dob"]').val();
		var phone = $('input[name="phone"]').val();
		var address = $('input[name="address"]').val();
		var l_amnt = $('input[name="l_amnt"]').val();
		var l_term = $('input[name="l_term"]').val();
		var l_type = $('.js-lone_type').val();
		var aadhar_num = $('.js-idProve').val();
		var u_photo = $('input[name = "u_photo"]')[0].files[0];
		var aadhar_id = $('input[name = "aadhar_id"]')[0].files[0];
		
		if (!name) {
			$('.js-message').text('name cant be empty and no special charactor allowed!!');
			return;
		}
		if (!dob) {
			$('.js-message').text('please select valid date of birth!!');
			return;
		}
		if (!u_photo) {
			$('.js-message').text('please upload valid image!!');
			return;
		}
		
		if (!phone || phone.length < 10 || phone.length > 14) {
			$('.js-message').text('please enter your valid phone number');
			return;
		}

		if (!address) {
			cantEmpty('address');
			return;
		}
		if (!l_amnt) {
			cantEmpty('loan amount');
			return;
		}
		if (!l_term) {
			cantEmpty('loan term');
			return;
		}
		
		if (!aadhar_num) {
			cantEmpty('ID prove');
			return;
		}
		if (!aadhar_id) {
			$('.js-message').text('please upload valid id!!');
			return;
		}

		var fd = new FormData();

		fd.append('_token',csrf_token);
		fd.append('name',name);
		fd.append('dob',dob);
		fd.append('phone',phone);
		fd.append('address',address);
		fd.append('l_amnt',l_amnt);
		fd.append('l_term',l_term);
		fd.append('l_type',l_type);
		fd.append('aadhar_num',aadhar_num);
		fd.append('u_photo',u_photo);
		fd.append('aadhar_id',aadhar_id);
		$(this).attr('disabled','disabled');
		$.ajax({
			url: appUrl('user+request+form+loan'),
			type: "post",
			data: fd,
			contentType: false,
          	processData: false,
			success : function (data) {
				window.setTimeout(function(){
			        window.location.href = appUrl(data);
			    }, 3000);
			}
		});
	});
	

	$('#checkStatus').on('click',function(){
		var id = $('.js-customer_id').val();
		$.ajax({
			url: appUrl('check-application-status'),
			type: "get",
			data: {
				id:id,
				_token : csrf_token
			},
			success : function (data) {
				data = JSON.parse(data);
				if (typeof data === 'object') {
					let total = calculateInterest(data.loan_amount,data.loan_term,data.interest_rate);
					let dob = _calculateAge(data.dob);

					$('.js-u_img').attr('src', appUrl('images/'+data.user_img));
					$('.agent-img').css({"display":"none"});
					$('.js-u_img').css({"display":"flex"});

					$('.js-name').html(data.name);
					$('.js-dob').html(data.dob);
					$('.js-age').html(dob);
					$('.js-phone').html(data.phone);
					$('.js-address').html(data.Address);
					$('.js-aadhar').attr('href',appUrl('images/id_card/'+data.user_id_img));
					$('.js-aadhar').html(data.user_id_num);	
					$('.js-_l_type').html(data.loan_type);	
					$('.js-l_amnt').attr('value', data.loan_amount);
					$('.js-l_term').attr('value', data.loan_term);	
					$('.js-interest').attr('value', data.interest_rate);
					$('.js-monthly').html(total/12);	
					$('.js-total').html(total);	
					$('.js-status').text('new');
					
					if (data.agent_check != 0) {
						$('.js-status').text('forworded');
					}

					if (data.approved != 0) {
						const date = new Date(data.approved*1000);
						$('.js-status').text('approved('+date. toLocaleDateString("en-US")+')');
					}else if(data.deleted_at != null){
						$('.js-status').text('rejected('+data.deleted_at+')');
					}
				}else if(typeof data === 'string') {
					$('.js-status').text(data);
				}
			}
		});
	});

	var cantEmpty = function (field) {
		$('.js-message').text(field + ' field cant be empty!!');
	}
});