<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Server extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','upload'));
		$this->load->model(array('m_user', 'm_data'));
		date_default_timezone_set('Asia/Jakarta');
	}
	
	public function login_user(){
		if($this->input->server('REQUEST_METHOD')=='POST') {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			if(!empty($this->m_user->checkLogin($username,$password)->result_array())){
				echo "success";
			}
			else{
				echo "failure";
			}
		}
	}
	
	public function register_user(){
		if($this->input->server('REQUEST_METHOD')=='POST') {
			$nama = $this->input->post('nama');
			$jenisKelamin = $this->input->post('jenisKelamin');
			$tanggalLahir = $this->input->post('tanggalLahir');
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$email = $this->input->post('email');
			$foto = $this->input->post('foto');
			
			foreach($this->m_user->getUserRegister()->result_array() as $row) {
				$id = $row['id'];
			}
			if(!isset($id)) {
				$id = 0;
			}
			
			if($foto == '') {
				$path = "unavailable.jpg";
			}
			else {
				$path = "$id.png";
			}
			$actualpath = "assets/img/foto_profil/$path";
			
				if(!empty($this->m_user->checkUsername($username)->result_array())) {
					echo 'Username sudah digunakan';
				}
				else{
					if(!empty($this->m_user->checkUserEmail($email)->result_array())) {
						echo 'Email sudah pernah didaftarkan';
					}
					else{
						if($this->m_user->registerUser($nama, $jenisKelamin, $tanggalLahir, $username, $password, $email, $path)) {
							if($foto != '') {
								file_put_contents($actualpath,base64_decode($foto));
							}
					
							echo 'Registrasi berhasil';
						}else{
							echo 'Gagal, silahkan coba kembali';
						}
					}
				}
		}
	}
	
	public function get_name(){
		if($this->input->server('REQUEST_METHOD')=='POST') {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
	
			if($data  = $this->m_user->checkLogin($username,$password)->row()) {
				echo $data->nama;
			}
			else{
				echo "failure";
			}
		}
	}
	
	public function get_data(){
		if($this->input->server('REQUEST_METHOD')=='POST') {
			$username = $this->input->post('username');
			
			$response=array();
	
			if($data = $this->m_user->get_UserData($username)->row()) {
				$response["konten"] = array();
				
				$user["nama"] = $data->nama;
				$user["username"] = $data->username;
				$user["jenisKelamin"] = $data->jenis_kelamin;
				$user["tanggalLahir"] = $data->tanggal_lahir;
				$user["email"] = $data->email;
				$user["foto"] = 'http://192.168.98.50/sportshi/assets/img/foto_profil/'.$data->foto_profil;
				array_push($response["konten"], $user);
				echo json_encode($response);
			}
			else{
				echo "failure";
			}
		}
	}
	
	public function change_profile(){
		if($this->input->server('REQUEST_METHOD')=='POST') {
			$username = $this->input->post('username');
			$nama = $this->input->post('nama');
			$jenisKelamin = $this->input->post('jenisKelamin');
			$tanggalLahir = $this->input->post('tanggalLahir');
			$email = $this->input->post('email');
			$foto = $this->input->post('foto');
			$photo = $this->input->post('waktu');
			
			foreach($this->m_user->getUserRegister()->result_array() as $row) {
				$id = $row['id'];
			}
			if(!isset($id)) {
				$id = 0;
			}
			
			$data = $this->m_user->getDataProfile($username)->row();
			if($foto == '') {
				$path = "unavailable.jpg";
			}
			else {
				$path = "$photo.png";
			}
			$actualpath = "assets/img/foto_profil/$path";
			
			if(!empty($this->m_user->checkUser($username)->result_array())){
					if($nama != $data->nama || $tanggalLahir != $data->tanggal_lahir || $email != $data->email || ($path != $data->foto_profil && $path != "unavilable.jpg") || $jenisKelamin != $data->jenis_kelamin){
						if(empty($this->m_user->checkEmailUser($username, $email)->result_array())){
							if($this->m_user->updateProfile($username, $nama, $jenisKelamin, $tanggalLahir, $email, $path)){
								if($foto != '') {
									file_put_contents($actualpath,base64_decode($foto));
								}
								echo 'Sukses';
							}
							else{
								echo 'Gagal';
							}
						}
						else{
							echo 'Email sudah digunakan oleh pengguna lain';
						}
					}
					else{
						echo 'Silahkan ubah data-data yang ada untuk mengubah data profil anda';
					}
			}
			else {
				echo 'Gagal';
			}
		}
	}
	
	public function change_password(){
		if($this->input->server('REQUEST_METHOD')=='POST') {
			$username = $this->input->post('username');
			$old_password = $this->input->post('old_password');
			$new_password = $this->input->post('new_password');
			
			if(!empty($this->m_user->checkPassword($username, $old_password)->result_array())){
				if($this->m_user->updatePassword($new_password, $username)){
					echo 'Sukses';
				}
				else{
					echo 'Ganti password gagal, silahkan coba kembali';
				}
			}
			else{
				echo 'Gagal';
			}
		}
	}
	
	public function reset_password(){
		if($this->input->server('REQUEST_METHOD')=='POST') {
			$email = $this->input->post('email');

			if(!empty($this->m_user->checkUserEmail($email)->result_array())){
				$password = $this->m_user->generateRandomString();
			
				if($this->m_user->resetPassword($email, $password)){
					$data = $this->m_user->checkUserEmail($email)->row();
						
					$config = Array(
						'protocol' => 'smtp',
						'smtp_host' => 'ssl://smtp.googlemail.com',
						'smtp_port' => 465,
						'smtp_user' => 'yondutheguardian@gmail.com',
						'smtp_pass' => 'guardian3000',
						'mailtype'  => 'html', 
						'charset'   => 'iso-8859-1'
					);
					$this->load->library('email', $config);
					$this->email->set_newline("\r\n");								
						
					$this->email->from('yondutheguardian@gmail.com', 'Sports Hi');
					$this->email->to($email);
					//$this->email->bcc('them@their-example.com');

					$this->email->subject('Pemberitahuan Reset Password');
					$pesan  = "<b>Hai, " .$data->nama."!</b><br><br>";
					$pesan .= "Anda baru saja mengatur ulang password anda pada aplikasi Sports Hi!. Data baru untuk akun anda adalah :<br>";
					$pesan .= "Username : " .$data->username."<br>";
					$pesan .= "Password : " .$password."<br>";

					$this->email->message($pesan);
					$this->email->send();
							
					echo 'Pesan email berhasil dikirim ke email anda';
				}
				else{
					echo 'Gagal, silahkan coba kembali';
				}
			}
			else{
				echo 'Email tidak terdaftar';
			}
		}
	}
	
	public function getDataUser(){
		$response=array();
		$result = $this->m_user->getAllContent();
		if ($result->num_rows() > 0) {
			$response["konten"] = array();
		  
			foreach($result->result() as $row):
				$data = array();
				$data["id"] = $row->id;
				$data["nama"] = $row->nama;
				$data["username"] = $row->username;
				$data["jenisKelamin"] = $row->jenis_kelamin;
				$data["tanggalLahir"] = $row->tanggal_lahir;
				$data["email"] = $row->email;
				$data["foto"] = 'http://192.168.98.50/sportshi/assets/img/foto_profil/'.$row->foto_profil;
				array_push($response["konten"], $data);
			endforeach;
		
		// sukses
		$response["success"] = "Tidak ada data yang ditemukan";

		// echo JSON response
		echo json_encode($response);
		} else {
			$response["success"] = 0;
			$response["message"] = "Tidak ada data yang ditemukan";

			echo json_encode($response);
		}
	}
	
	public function getCategory(){
		$response=array();
		$result = $this->m_data->getAllCategory();
		if ($result->num_rows() > 0) {
			$response["konten"] = array();
		  
			foreach($result->result() as $row):
				$data = array();
				$data["id"] = $row->id;
				$data["kategori"] = $row->nama_olahraga;
				$data["foto"] = 'http://192.168.98.50/sportshi/assets/img/foto_kategori/'.$row->foto;
				array_push($response["konten"], $data);
			endforeach;
		
		// sukses
		$response["success"] = "Tidak ada data yang ditemukan";

		// echo JSON response
		echo json_encode($response);
		} else {
			$response["success"] = 0;
			$response["message"] = "Tidak ada data yang ditemukan";

			echo json_encode($response);
		}
	}
	
	public function postMoment(){
		if($this->input->server('REQUEST_METHOD')=='POST') {
			$username = $this->input->post('username');
			$username_tag = $this->input->post('username_tag');
			$location = $this->input->post('location');
			$olahraga = $this->input->post('kategori');
			$status = $this->input->post('status');
			$foto = $this->input->post('foto');
			$date = date('Y-m-d H:i:s');
			$photo = date('Y-m-d_H-i-s');

			if($foto == '') {
				$path = "unavailable.jpg";
			}
			else {
				$path = "$photo.png";
			}
			$actualpath = "assets/img/foto/$path";
				
			if($this->m_user->postMoment($username, $username_tag, $olahraga, $status, $path, $location, $date)) {
				if($foto != '') {
					file_put_contents($actualpath,base64_decode($foto));
				}
				echo 'Berhasil';
			}else{
				echo 'Gagal, silahkan coba kembali';
			}
		}
	}
	
	public function postEvent(){
		if($this->input->server('REQUEST_METHOD')=='POST') {
			$username = $this->input->post('username');
			$deskripsi = $this->input->post('deskripsi');
			$foto = $this->input->post('foto');
			$olahraga = $this->input->post('kategori');
			$date = date('Y-m-d H:i:s');
			$photo = date('Y-m-d_H-i-s');
			$location = $this->input->post('location');
			
			if($foto == '') {
				$path = "unavailable.jpg";
			}
			else {
				$path = "$photo.png";
			}
			$actualpath = "assets/img/foto/$path";
				
			if($this->m_user->postEvent($username, $olahraga, $deskripsi, $path, $location, $date)) {
				if($foto != '') {
					file_put_contents($actualpath,base64_decode($foto));
				}
				echo 'Berhasil';
			}else{
				echo 'Gagal, silahkan coba kembali';
			}
		}
	}
	
	public function get_TimelineData(){
		$response=array();
	
		if($datas = $this->m_data->getTimelineData()->result()) {
			$response["feed"] = array();
			foreach ($datas as $data) {
				if ($this->m_user->getNama($data->username_tag)->num_rows() > 0) {
					$nama_tag = $this->m_user->getNama($data->username_tag)->result()[0]->nama;
				}else{
					$nama_tag = null;
				}
				$user["nama"] = $data->nama;
				$user["foto_profil"] = 'http://192.168.98.50/sportshi/assets/img/foto_profil/'.$data->foto_profil;
				$user["deskripsi"] = $data->deskripsi;
				if($data->foto == 'unavailable.jpg')
					$user["foto"] = null;
				else
					$user["foto"] = 'http://192.168.98.50/sportshi/assets/img/foto/'.$data->foto;
				//$user["username_tag"] = ;
				$user["nama_tag"] = $nama_tag;
				if($data->olahraga == '')
					$user["kategori"] = null;
				else
					$user["kategori"] = $data->olahraga;
				if($data->location == '')
					$user["location"] = null;
				else
					$user["location"] = $data->location;
				$user["waktu"] = $data->waktu;
				array_push($response["feed"], $user);
			}
			
			echo json_encode($response);
		}
		else{
			echo "failure";
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */