<?php
namespace App\controllers;

use DB;
use Auth;
use session;
use migrations;

class adminController
{
	public function index()
	{
		$data = DB::table('administration')->select('*')->get();

		if (!$data) {
			return view('register');
		}else{
			if (Auth::user()) {
				return view('register');
			}
		}
		session::set('message','only one admin can register!! and agents can only register through admin dashboard!!');
		return redirect('/');
	}

	public function login()
	{
		if (Auth::user()) {
			return redirect('dashboard/'.session::get('role'));
		}

		return view('login', ['message' => session::flash('message')]);
	}


	public function submit($username,$password)
	{
		if (Auth::checkLoginStatus()) {
			return redirect('dashboard/'.session::get('role'));
		}else{
			$username = filter_email($username);
			if ($username) {
				$data = DB::table('administration')->select('name','username','password','role')->where('username',$username)->get();
				if ($data) {
					if (password_verify($password,$data[0]->password)) {
						Auth::login($username);
						session::set('role', $data[0]->role);
						return redirect('dashboard/'.$data[0]->role);
					}else{
						session::message("password not matched!!");
						return redirect(session::get('prev_url'));
					}
				}else{
					session::message("username not registered or verfied!!");
					return redirect(session::get('prev_url'));
				}
			}else{
				session::message("please enter valid email!!");
				return redirect(session::get('prev_url'));
			}
		}
	}

	public function register($name, $username, $password, $phone)
	{
		$data = DB::table('administration')->select('*')->get();
		$role = $data ? 'agent' : 'admin';
		$exec = DB::table('administration')->create([
			"name" => filter_name($_POST['name']),
			"username" => filter_email($_POST['username']),
			"password" => password_hash(filter_text($_POST['password']), PASSWORD_BCRYPT),
			"phone" => isset($_POST['phone']) ? filter_text($_POST['phone']) : null,
			"role" => $role
		]);

		// TODO: add email sending functionality here..
		return json_encode("admin is register successfuly! PLease note only first admin can register here..others will be through admin dashboard");
	}

	public function logout()
	{
		session::unset('role');
		Auth::logout();
		return redirect('/');
	}

	public function migrate(migrations $migrations)
	{
		$migrations->migrate();
	}

}