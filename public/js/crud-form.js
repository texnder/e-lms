$(document).ready(function(){
	$('.js-show-data').on('click',function(){
		ajaxCall(this,"user-application");
	});
	$('.js-edit-profile').on('click',function(){
		makeEditable();
	});
	$('.js-update').on('click',function(){
		updateProfile(this,'update+user+profile');
	});
	$('.js-approve').on('click',function(){
		approveApplication(this,'approve-application');
	});
	$('.js-forword').on('click',function(){
		forwordApplication(this,'forword+user+profile');
	});
	$('.js-delete-data').on('click',function(){
		deleteLoanApplication(this,'delete+user+profile');
	});
	$('.js-reject').on('click',function(){
		$(this).attr('disabled','disabled');
		deleteLoanApplication(this,'delete+user+profile');
	});
	$('.js-destroy').on('click',function(){
		destroyApplication(this,'delete+permanently+user+profile');
	});

	$('.js-new').click(function () {
		$('tbody tr').css({"display":"table-row"});
		$('.fa-close').closest('tr').css({"display":"none"});
		$('.fa-check').closest('tr').css({"display":"none"});
	});

	$('.js-approved').click(function () {
		$('tbody tr').css({"display":"none"});
		$('.fa-check').closest('tr').css({"display":"table-row"});
	});

	$('.js-rejected').click(function () {
		$('tbody tr').css({"display":"none"});
		$('.fa-close').closest('tr').css({"display":"table-row"});
		
	});

	$('.js-application').click(function () {
		$('tbody tr').css({"display":"table-row"});
	});


	$(".js-search").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("tbody tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});

	$('.js-upload').click(function(){
		var user_img = $('input[name = "admin_img"]')[0].files[0];
		if (user_img) {
			var fd = new FormData();
			fd.append('_token',csrf_token);
			fd.append('user_img',user_img);
			$.ajax({
				url: appUrl('upload-admin-image'),
				type: "post",
				data: fd,
				contentType: false,
              	processData: false,
				success : function (data) {
					$('#authImg').attr('src',appUrl('images/'+data));
					location.reload();
				}
			});
		}
	});

	var ajaxCall = function(ele,url) {
		var row = $(ele);
		var id = row.attr('data-id');
		$.ajax({
			url: appUrl(url),
			type: "post",
			data: {
				id:id,
				_token : csrf_token
			},
			success:function(data){
				data = JSON.parse(data);

				let total = calculateInterest(data.loan_amount,data.loan_term,data.interest_rate);
				let dob = _calculateAge(data.dob);

				$('.js-u_img').attr('src', appUrl('images/'+data.user_img));
				$('.js-customer').html(data.customer_id);
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
				$('.js-update').attr('data-id',data.id);
				$('.js-reject').attr('data-id',data.id);
				$('.js-forword').attr('data-id',data.id);

				$('.js-forword').css({"display":"inline-block"});
				$('.js-approve').css({"display":"inline-block"});
				$('.js-reject').css({"display":"inline-block"});
				$('.js-l_type').removeAttr('disabled');
				$('.js-l_amnt').removeAttr('disabled');
				$('.js-l_term').removeAttr('disabled');	
				$('.js-interest').removeAttr('disabled');
				$('.js-update').removeAttr('disabled');
				$('.js-reject').removeAttr('disabled');
				$('.js-forword').removeAttr('disabled');
				$('.js-status').text('new');

				if (data.agent_check != 0) {
					$('.js-approve').css({"display":"inline-block"});
					$('.js-approve').attr('data-id',data.id);
					$('.js-forword').attr('disabled','disabled');
					$('.js-status').text('forworded');
				}else{
					$('.js-approve').css({"display":"none"});
				}

				if (data.approved != 0) {
					const date = new Date(data.approved*1000);
					$('.js-status').text('approved('+date. toLocaleDateString("en-US")+')');
					$('.js-forword').css({"display":"none"});
					$('.js-approve').css({"display":"none"});
					$('.js-reject').css({"display":"none"});
					$('.js-update').css({"display":"none"});
					$('.js-l_type').attr('disabled','disabled');
					$('.js-l_amnt').attr('disabled','disabled');
					$('.js-l_term').attr('disabled','disabled');	
					$('.js-interest').attr('disabled','disabled');
					$('.js-update').attr('disabled','disabled');
					$('.js-reject').attr('disabled','disabled');
					$('.js-update').removeAttr('data-id');
					$('.js-reject').removeAttr('data-id');
					$('.js-forword').removeAttr('data-id');
					$('.js-approve').removeAttr('data-id');
				}else if(data.deleted_at != null){
					$('.js-status').text('rejected('+data.deleted_at+')');
					$('.js-reject').attr('disabled','disabled');
					$('.js-forword').attr('data-id',data.id);
					$('.js-forword').removeAttr('disabled');
				}

			}
		});
	}

	var makeEditable = function() {
		$('.js-name').html('<input value="'+$('.js-name').text()+'" type="text" name="name" class="form-control form-input js-name" required="required" >');
		$('.js-dob').html('<input value="'+$('.js-dob').text()+'" type="date" name="dob" class="form-control form-input js-dob" required="required" >');
		$('.js-phone').html('<input value="'+$('.js-phone').text()+'" type="text" name="phone" class="form-control form-input js-phone" required="required">');
		$('.js-address').html('<input value="'+$('.js-address').text()+'" type="text" name="address" class="form-control form-input js-address" required="required">');
	}

	var	updateProfile = function(ele, url) {
		var id = $(ele).attr('data-id');
		var _name = $('.js-name').find('.js-name').val();
		var _dob = $('.js-dob').find('.js-dob').val();
		var _phone = $('.js-phone').find('.js-phone').val();
		var _address = $('.js-address').find('.js-address').val();
		var name = (_name !== undefined) ? _name :  $('.js-name').text();
		var dob = (_dob !== undefined) ? _dob :  $('.js-dob').text();
		var phone = (_phone !== undefined) ? _phone :  $('.js-phone').text();
		var address = (_address !== undefined) ? _address :  $('.js-address').text();
		var l_type = $('.js-l_type').val();
		var l_amnt = $('.js-l_amnt').val();
		var l_term = $('.js-l_term').val();
		var interest = $('.js-interest').val();
		
		$.ajax({
			url : appUrl(url),
			type: 'post',
			data: {
				_token: csrf_token,
				id : id,
				name : name,
				dob : dob,
				phone : phone,
				Address : address,
				loan_type : l_type,
				loan_amount : l_amnt,
				loan_term : l_term,
				interest_rate : interest
			},
			success: function (data) {
				var data = JSON.parse(data);
				$('.js-userImg'+data.id).attr('src', appUrl('images/'+data.user_img));
				$('.js-name'+data.id).text(data.name);
				$('.js-dob'+data.id).text(data.dob);
				$('.js-phone'+data.id).text(data.phone);
				$('.js-address'+data.id).text(data.Address);
				$('.js-l_type'+data.id).text(data.loan_type);
				$('.js-l_amnt'+data.id).text(data.loan_amount);
				$('.js-l_term'+data.id).text(data.loan_term);
				$('.js-status').text('data updated successfully!!');
			}
		});
	}

	var forwordApplication = function (ele,url) {
		var id = $(ele).attr('data-id');
		$.ajax({
			url: appUrl(url),
			type: "post",
			data: {
				id:id,
				_token : csrf_token
			},
			success:function(data){
				$(ele).attr('disabled','disabled');
				$('.js-message').text(data);
				$('.js-status').text('forworded');
				$('.js-status_icon'+id).html('');
			}
		});
	}

	var approveApplication = function (ele,url) {
		var id = $(ele).attr('data-id');
		$.ajax({
			url: appUrl(url),
			type: "post",
			data: {
				id:id,
				_token : csrf_token
			},
			success:function(data){
				$(ele).attr('disabled','disabled');
				$('.js-message').text(data);
				$('.js-status').text('approved');
				$('.js-status_icon'+id).html('<span><i class="fa fa-check" style="font-size: 20px"></i></span>');
			}
		});
	}

	var deleteLoanApplication = function (ele,url) {
		var id = $(ele).attr('data-id');
		$.ajax({
			url: appUrl(url),
			type: "post",
			data: {
				id:id,
				_token : csrf_token
			},
			success:function(data){
				$('.js-message').text(data);
				$('.js-status').text('rejected');
				$('.js-status_icon'+id).html('<span><i class="fa fa-close js-destroy" style="font-size: 20px"></i></span>');
			}
		});
	}

	var destroyApplication = function (ele,url) {
		var dump = 	confirm('do you want to delete permanently!!');
		var id = $(ele).attr('data-id');
		if (dump) {
			$.ajax({
				url: appUrl(url),
				type: "post",
				data: {
					id:id,
					_token : csrf_token
				},
				success:function(data){
					$('.js-message').text(data);
					$('.dataRow'+id).remove();
				}
			});
		}	
	}
});
