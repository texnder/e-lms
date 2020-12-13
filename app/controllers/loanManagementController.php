<?php
namespace App\controllers;

use Aditex\src\Container;
use App\controllers\uploadFilesTrait as uploadImages;
use connection\connection;
use DB;
use Auth;
use session;

class loanManagementController
{
	use uploadImages;

	public function index()
	{
		return view('users',['message' => session::flash('message')]);
	}

	public function show_all()
	{
		$auth = DB::table('administration')->select('name','user_img')
					->where('username',session::get('username'))
					->get();

		$data = DB::table('application')->select("*")->get();
		return view('dashboard.dashboard', [
			'data'=> $data,
			'message'=> session::flash('message'),
			'name' => $auth[0]->name,
			'admin_img' => $auth[0]->user_img
		]);
	}

	public function show_ById($id)
	{
		$data = DB::table('application')->find_ById($id);
		return json_encode($data);
	}

	public function checkStatus($id)
	{
		if (filter_text($id) && strlen($id) == 16) {
			$data = DB::table('application')->select('*')->where('customer_id',$id)->get();
			if ($data) {
				return json_encode($data[0]);
			}
		}

		return json_encode("customer_id: '{$id}' not exists!!");

	}

	public function create($name,$dob,$phone,$address,$l_amnt,$l_term,$l_type,$aadhar_num)
	{
		$u_photo = basename($_FILES['u_photo']['name']);
		$aadhar_id = basename($_FILES['aadhar_id']['name']);

		try {
			$this->uploadUserImage($_FILES['u_photo']);
			$this->uploadIdImage($_FILES['aadhar_id']);
		} catch (\Exception $e) {
			session::set('message',$e->getMessage().", please provide actual details or contact our agent!! thank you!!");
			return '/';
		}
		
		$customer_id = substr(md5(rand()), 1,16);
		DB::table('application')->create([
			'customer_id' => $customer_id,
			'name' => filter_name($name),
			'phone' => filter_text($phone),
			'Address' => filter_text($address),
			'dob' => filter_text($dob),
			'loan_type' => filter_text($l_type),
			'loan_amount' => filter_int($l_amnt),
			'loan_term' => filter_int($l_term),
			'user_img' => filter_text($u_photo),
			'user_id_num' => filter_text($aadhar_num),
			'user_id_img' => filter_text($aadhar_id)
		]);

		session::set('message', 'your loan request submited successfuly!! your customer id is "'.$customer_id.'", save it to check your status for approval');
		return '/';
		
	}

	public function update($id,$name,$dob,$phone,$Address,$loan_type,$loan_amount,$loan_term,$interest_rate)
	{
		DB::table('application')->update([
			'name' => filter_name($name),
			'phone' => filter_text($phone),
			'Address' => filter_text($Address),
			'dob' => filter_text($dob),
			'loan_type' => filter_text($loan_type),
			'loan_amount' => filter_int($loan_amount),
			'loan_term' => filter_int($loan_term),
			'interest_rate' => filter_int($interest_rate), 
		],$id);

		return json_encode(DB::table('application')->find_ById($id));
	}


	public function forword($id)
	{
		DB::table('application')->update([
			"agent_check" => 1,
			"deleted_at" => null
		],$id);
		return "application forworded to admin for approval!!";
	}
	
	public function approve($id)
	{
		DB::table('application')->update([
			"approved" => time()
		],$id);
		return "application approved successfully!!";
	}

	public function delete($id)
	{
		$data = DB::table('application')->find_ById($id);
		if ($data) {
			if (!$data->approved) {
				DB::table('application')->update([
					"agent_check" => 0,
				],$id);
				return DB::table('application')->softdelete($id) ? "application rejected successfully!!" : null;
			}
		}
		
	}

	public function destroy($id)
	{
		$data = DB::table('application')->find_ById($id);

		if ($data) {
			if (!is_null($data->deleted_at)) {
				if (file_exists('images/'.$data->user_img)) {
					unlink('images/'.$data->user_img);
				}
				if (file_exists('images/id_card/'.$data->user_id_img)) {
					unlink('images/id_card/'.$data->user_id_img);
				}
				return DB::table('application')->delete($id) ? "data deleted parmanently!!" : null;
			}
		}
	}

	public function uploadImage()
	{
		$auth = DB::table('administration')->select('id','user_img')
					->where('username',session::get('username'))
					->get();
		$user_img = basename($_FILES['user_img']['name']);

		if (!is_null($auth[0]->user_img)) {
			if (file_exists('images/'.$auth[0]->user_img)) {
				print_r('he');
				unlink('images/'.$auth[0]->user_img);
			}
		}

		try {
			$this->uploadUserImage($_FILES['user_img']);
		} catch (\Exception $e) {
			return ;
		}

		DB::table('administration')->update([
				"user_img" => $user_img
			],$auth[0]->id);
		

		return $user_img;
	}


	private function uploadUserImage($file)
	{
		$this->file_set($file);
		if ($this->save_it()) {
			return true;
		}else{
			throw new \Exception(implode(", ", $this->error));
		}
	}

	private function uploadIdImage($file)
	{
		$this->file_set($file);
		$this->upload_directory = "images/id_card";
		if ($this->save_it()) {
			return true;
		}else{
			throw new \Exception(implode(", ", $this->error));
		}
	}

}