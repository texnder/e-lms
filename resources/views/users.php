<!DOCTYPE html>
<html>
<head>
	<title>Basic Loan Management System</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf_token" content="<?= csrf::_token() ?>">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= url('css/users.css') ?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?= url('js/main.js') ?>"></script>
	<script type="text/javascript" src="<?= url('js/user.js') ?>"></script>
</head>
<body>
	<div class="title default-shadow">
		<h1>e-Loan Management System</h1>
	</div>
	<div class="container-fluid" >
		<h3 class="text-center"><?= $message; ?></h3>
		<div class="row">
			<div class="col-6 lg-col-6 md-col-6">
				<div class="u-form default-shadow">
					<div class="req-form">
						<p>REQUEST FOR LOAN</p>
					</div>
					<p class="js-message text-center" style="color: red"></p>
					<form id="userForm" class="p-4" action="<?= url('user+request+form+loan') ?>" method='post' enctype="multipart/form-data">
						<?= csrf::input() ?>
						<div class="row">
							<div class="col">
								<div class="form-group">
								    <label >Name:</label>
								    <input type="text" name="name" class="form-control form-input" placeholder="your name" required="required">
							    </div>
							</div>
							<div class="col">
								<div class="form-group">
								    <label >DOB:</label>
								    <input type="date" name="dob"class="form-control form-input" placeholder="your name" required="required">
							    </div>
							</div>	
					    </div>
					    <div class="form-group">
						    <label>your Photo:</label>
						    <input type="file" name="u_photo" class="form-control form-input" required="required">
					    </div>
					    <div class="form-group">
						    <label >Phone:</label>
						    <input type="text" name="phone" class="form-control form-input" placeholder="(+91) Phone Number" required="required">
					    </div>
					    <div class="form-group">
						    <label >Address:</label>
						    <input type="text" name="address" class="form-control form-input" placeholder="your Address" required="required">
					    </div>
					    <div class="row">
					    	<div class="col">
					    		<div class="form-group">
								    <label>Loan amount:</label>
								    <input type="text"  name="l_amnt" class="form-control form-input" placeholder="amount" required="required">
							    </div>
					    	</div>
					    	<div class="col">
					    		<div class="form-group">
								    <label for="pwd">loan term</label>
								    <input type="text" name="l_term" class="form-control form-input" placeholder="year" required="required">
							    </div>
					    	</div>
					    </div>
					    <div class="form-group">
						    <label>Loan Type:</label>
						    <select class="form-control form-input js-lone_type" name="l_type">
						    	<option>Home loan</option>
						    	<option>Gold loans</option>
						    	<option>Personal loan</option>
						    	<option>Short-term business loans</option>
						    	<option>Education loans</option>
						    	<option>Vehicle loans</option>
						    </select>
					    </div>
					    
					    <div class="form-group">
						    <label for="pwd">ID prove:</label>
						    <input type="text" name="aadhar_num" class="form-control form-input js-idProve" placeholder="Aadhar number (0000-0000-0000)" required="required">
					    </div>
					    <div class="form-group">
						    <label>upload ID:</label>
						    <input type="file" name="aadhar_id" class="form-control form-input" placeholder="upload aadhar: jpg,png,jepg" required="required">
					    </div>
					    <button id="submit_application" class="btn ui-btn primary-btn ui-round-btn w-100" type="submit">Submit Request</button>
					</form>
				</div>
			</div>
			<div class="col-6 lg-col-6 md-col-6">
				<div class="auth-login d-flex justify-content-center align-content-center flex-column h-100">
					<button type="button" class="btn ui-btn warning-btn  ui-round-btn default-shadow" data-toggle="modal" data-target="#show-modal">Check Status</button>
					<br>
					<a href="<?= url('login/Agent') ?>" class="btn ui-btn info-btn  ui-round-btn default-shadow">Agent Login</a>
					<br>
					<a href="<?= url('login/Admin') ?>"  class="btn ui-btn danger-btn ui-round-btn default-shadow">Admin Login</a>
				</div>
			</div>
		</div>
		<div class="modal fade" id="show-modal">
			  	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
			    	<div class="modal-content">
			    		
				      	<!-- Modal Header -->
				      	<div class="modal-header">
				        	<h6 class="modal-title">user Profile: <span class="js-status">status</span></h6>
				        	<button type="button" class="close" data-dismiss="modal">&times;</button>
				      	</div>

				      	<!-- Modal body -->
				      	<div class="modal-body">
				        	<div class="u-card container-fluid">
				        		<div class="row">
				        			<div class="col-4">
				        				<img src="#" class="js-u_img" style="width: 100%; height: auto;display: none;">
				        				<span class="agent-img">
											<i class="fa fa-user" style="font-size: 240px;color: #000;"></i>
										</span>
				        			</div>
				        			<div class="col-8">
				        				Customer Id: 
				        				<div class="d-flex">
				        					<input type="text" name="customer_id" class="form-input form-control mr-3 js-customer_id" placeholder="enter your customer id.."/> 
				        					<button id="checkStatus" class="btn info-btn ui-btn ui-round-btn">check</button>
				        				</div>
				        				<hr>
				        				<p>Name: <span class="js-name">user name</span></p>
				        				<p>DOB: <span class="js-dob">dd-mm-yyyy</span>&nbsp;&nbsp;&nbsp;&nbsp; Age: <span class="js-age">  00</span></p>
				        				<p>Phone: <span class="js-phone">+91 9876543210</span></p>
				        				<p>Address: <span class="js-address">house no. 123, nehru place, delhi</span></p>
				        				<p>ID prove: <a class="js-aadhar" href="#" target="_blank" >Id prove</a></p>
				        			</div>
				        			<div class="container-fluid pt-3">
				        				<div class="row">
				        					<div class="col">
				        						<div class="form-group">
												    <label>Loan Type: </label>
												    <select name="l_type" class="form-control form-input js-l_type" disabled>
												    	<option class="js-_l_type" selected="selected"></option>
												    	<option>Home loan</option>
												    	<option>Gold loans</option>
												    	<option>Personal loan</option>
												    	<option>Short-term business loans</option>
												    	<option>Education loans</option>
												    	<option>Vehicle loans</option>
												    </select>
											    </div>
						        				<div class="form-group">
												    <label >Loan amount:</label>
												    <input type="text" name="l_amnt" class="form-control form-input js-l_amnt" placeholder="amount" disabled>
											    </div>

											    <p>Monthly payment(Rs): <span class="js-monthly">000</span></p>
				        					</div>
				        					<div class="col">
				        						 <div class="form-group">
												    <label >loan term:</label>
												    <input type="text" name="l_term" class="form-control form-input js-l_term" placeholder="year" disabled>
											    </div>
											    <div class="form-group">
												    <label >loan interest:</label>
												    <input type="text" class="form-control form-input js-interest" placeholder="int" value="18" disabled>
											    </div>

											    <p>Total pyaments(Rs): <span class="js-total">00000 </span></p>
				        					</div>
				        				</div>
				        			</div>
				        			
								   
				        		</div>
				        	</div>
				      	</div>
			    	</div>
			  	</div>
			</div>
	</div>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>