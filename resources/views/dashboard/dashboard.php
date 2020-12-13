<!DOCTYPE html>
<html>
<head>
	<title><?= $_GET['role'] ?> dashboard:e-loan management system</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf_token" content="<?= csrf::_token() ?>">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?= url('css/dash.css') ?>">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?= url('js/main.js') ?>"></script>
	<script type="text/javascript" src="<?= url('js/crud-form.js') ?>"></script>
</head>
<body>
	<nav class="navbar navbar-expand-lg fixed-top main-nav">
		<div class="container-fluid">
			<div class="nav-brand">
				<button class="sidenav-toggler">
				    <i class="fa fa-dashboard" style="color: #fff;"></i>
				</button>
				<a class="navbar-brand" href="<?= url('/') ?>">redCarpet</a>
			</div>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar">
			    <i class="fa fa-bars" style="color: #fff;"></i>
			</button>
			<div class="collapse navbar-collapse" id="main-navbar">
				<ul class="navbar-nav">
					<div class="left-nav">
						<li>
							<a  class="nav-link text-white js-new">new</a>
						</li>
						<li>
							<a  class="nav-link text-white js-approved">approved</a>
						</li>
						<li>
							<a  class="nav-link text-white js-rejected">rejected</a>
						</li>
					</div>
					<div class="right-nav">
						<li>
							<a href="<?= url('logout') ?>" class="nav-link"><i class="fa fa-user-circle-o" style="font-size: 15px"></i>&nbsp;&nbsp;logout</a>
						</li>
					</div>
				</ul>
			</div>
		</div>
	</nav>
	<div class="sidenav flex-column">
		<div class="agent-img_container">
			<?php if (!$admin_img): ?>
			<span class="agent-img">
				<i class="fa fa-user" style="font-size: 140px;color: #fff;"></i>
			</span>
			<?php else: ?>
			<img id="authImg" class="agent-img rounded-lg img-fluid " src="<?= url('images/'.$admin_img); ?>">
			<?php endif; ?>
			<a href="javascript.void(0)" class="text-white text-center js-uploadImg" style="font-size: 10px;margin: 0; position: relative;width: 100%;display: block;" data-toggle="modal" data-target="#uploadImg-modal">Upload New</a>
			
		</div>
		<hr>
		<p style="text-align: center;color: #fff"><?= $name; ?></p>
		<ul class="nav-sidenav">
			<li>
				<a class="text-white js-application"><i class="fa fa-users" style="font-size: 14px"></i> &nbsp; Applications</a>
			</li>
			<li>
				<a href="#"><i class="fa fa-500px" style="font-size: 14px"></i> &nbsp; Update Password</a>
			</li>
			<li>
				<a href="#"><i class="fa fa-clone" style="font-size: 14px"></i> &nbsp; Payment History</a>
			</li>
			<?php if (session::get('role') === 'admin'): ?>
			<li>
				<a href="<?= url('register-new-administrator') ?>" class="js-addUser"><i class="fa fa-plus" style="font-size: 14px"></i> &nbsp; Add agent</a>
			</li>
			<?php endif; ?>
			<li>
				<a href="#"><i class="fa fa-cog" style="font-size: 14px"></i> &nbsp; settings</a>
			</li>
		</ul>
	</div>
	<div class="main container-fluid">
		<div class="container-fluid show-data">
			<input class="js-search form-control form-input w-25 float-right" type="text" placeholder="Search..">
			<h4>User Applications: <span class="js-message"></span></h4>
			<br>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>photo</th>
						<th>name</th>
						<th>DOB</th>
						<th>phone</th>
						<th>Address</th>
						<th>Loan Type</th>
						<th>Loan amount</th>
						<th>Loan Term</th>
						<th>edit</th>
						<th>delete</th>
						<th>status</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($data)): ?>
					<?php foreach($data as $obj): ?>
					<tr class="dataRow<?=$obj->id;?>">
						<td><img class="js-userImg<?=$obj->id;?>" src="<?= url('/images/'.$obj->user_img) ?>" width="60" height="60"> </td>
						<td class="js-name<?= $obj->id; ?>"><?= $obj->name ?> </td>
						<td class="js-dob<?= $obj->id; ?>"><?= $obj->dob ?> </td>
						<td class="js-phone<?= $obj->id; ?>"><?= $obj->phone ?> </td>
						<td class="js-address<?= $obj->id; ?>"><?= $obj->Address ?> </td>
						<td class="js-l_type<?= $obj->id; ?>"><?= $obj->loan_type ?> </td>
						<td class="js-l_amnt<?= $obj->id; ?>"><?= $obj->loan_amount ?></td>
						<td class="js-l_term<?= $obj->id; ?>"><?= $obj->loan_term ?></td>
						<td>
							<span class="js-show-data" data-id="<?= $obj->id ?>"><i class="fa fa-edit" style="font-size: 20px" data-toggle="modal" data-target="#edit-modal"></i></span>
						</td>
						<td>
						<?php if (!$obj->approved): ?>
							<span class="js-delete-data" data-id="<?= $obj->id ?>"><i class="fa fa-trash" style="font-size: 20px"></i></span>
						<?php endif ?>
						</td>
						<td class="js-no_icon js-status_icon<?= $obj->id; ?>">
						<?php if ($obj->approved): ?>
							<span><i class="fa fa-check" style="font-size: 20px"></i></span>
						<?php endif; ?>
						<?php if (!is_null($obj->deleted_at)): ?>
							<span><i class="fa fa-close js-destroy" style="font-size: 20px" data-id="<?= $obj->id; ?>"></i></span>
						<?php endif; ?>		
						</td>
					</tr>
					<?php endforeach; ?>
					<?php endif ?>
				</tbody>
			</table>
		
			<div class="modal fade" id="edit-modal">
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
				        				<img src="#" class="js-u_img" style="width: 100%; height: auto;">
				        			</div>
				        			<div class="col-7">
				        				<p>Customer Id: <span class="js-customer">fcvbhur7u89ghjbh</span></p>
				        				<p>Name: <span class="js-name">user name</span></p>
				        				<p>DOB: <span class="js-dob">dd-mm-yyyy</span>&nbsp;&nbsp;&nbsp;&nbsp; Age: <span class="js-age">  00</span></p>
				        				<p>Phone: <span class="js-phone">+91 9876543210</span></p>
				        				<p>Address: <span class="js-address">house no. 123, nehru place, delhi</span></p>
				        				<p>ID prove: <a class="js-aadhar" href="javascript.void(0)" target="_blank" >Id prove</a></p>
				        			</div>
				        			<div class="col-1">
				        				<span class="js-edit-profile"><i class="fa fa-edit" style="font-size: 20px"></i></span>
				        			</div>
				        			<div class="container-fluid pt-3">
				        				<div class="row">
				        					<div class="col">
				        						<div class="form-group">
												    <label>Loan Type: </label>
												    <select name="l_type" class="form-control form-input js-l_type">
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
												    <input type="text" name="l_amnt" class="form-control form-input js-l_amnt" placeholder="amount">
											    </div>

											    <p>Monthly payment(Rs): <span class="js-monthly">000</span></p>
				        					</div>
				        					<div class="col">
				        						 <div class="form-group">
												    <label >loan term:</label>
												    <input type="text" name="l_term" class="form-control form-input js-l_term" placeholder="year" >
											    </div>
											    <div class="form-group">
												    <label >loan interest:</label>
												    <input type="text" class="form-control form-input js-interest" placeholder="int" value="18">
											    </div>

											    <p>Total pyaments(Rs): <span class="js-total">00000 </span></p>
				        					</div>
				        				</div>
				        			</div>
				        			
								   
				        		</div>
				        	</div>
				      	</div>

				      	<!-- Modal footer -->
				      	<div class="modal-footer">
				        	<button class="btn primary-btn ui-btn js-update">update</button>
				        	<?php if (session::get('role') === 'admin'): ?>
			        		<button class="btn success-btn ui-btn js-approve">approve</button>
				        	<?php endif; ?>
				        	<?php if (session::get('role') === 'agent'): ?>
			        		<button class="btn info-btn ui-btn js-forword">forword</button>
				        	<?php endif; ?>
				        	<button class="btn danger-btn ui-btn js-reject">reject</button>
				      	</div>
				      	
			    	</div>
			  	</div>
			</div>
			<!-- The Modal -->
			<div class="modal fade" id="uploadImg-modal">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">

					<!-- Modal Header -->
					<div class="modal-header">
					<h4 class="modal-title">Upload New</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<!-- Modal body -->
					<div class="modal-body">
						<input type="file" name="admin_img" class="form-control form-input">
					</div>

					<!-- Modal footer -->
					<div class="modal-footer">
					<button class="btn primary-btn ui-btn js-upload">Upload</button>
					</div>

					</div>
				</div>
			</div>
		</div>
	</div>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>