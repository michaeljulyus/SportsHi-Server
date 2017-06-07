<?php
class M_user extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	
	function getDataProfile($username){
	 $query=$this->db->query("select * from sh_user where username = '$username' ");
     return $query;
	}
	
	function getUserRegister(){
	 $query=$this->db->query("select id from sh_user order by id asc ");
     return $query;
	}
	
	function checkLogin($username,$password){
	 $query=$this->db->query("select * from sh_user where username = '$username' and password = md5('".$password."') ");
     return $query;
	}
	
	function get_UserData($username){
	 $query=$this->db->query("select * from sh_user where username = '$username' ");
     return $query;
	}
	
	function checkUser($username){
	 $query=$this->db->query("SELECT * FROM sh_user WHERE username = '$username' ");
     return $query;
	}
	
	function checkUserEmail($email){
	 $query=$this->db->query("SELECT * FROM sh_user WHERE email = '$email' ");
     return $query;
	}
	
	function checkUsername($username){
	 $query=$this->db->query("SELECT * FROM sh_user WHERE username = '$username' ");
     return $query;
	}
	
	function checkEmailUser($username, $email){
	 $query=$this->db->query("SELECT * FROM sh_user WHERE username != '$username' and email = '$email' ");
     return $query;
	}
	
	function registerUser($nama, $jenisKelamin, $tanggalLahir, $username, $password, $email, $path){
	 $query=$this->db->query("INSERT INTO sh_user (nama, jenis_kelamin, tanggal_lahir, username, password, email, foto_profil) VALUES('$nama', '$jenisKelamin', '$tanggalLahir', '$username', md5('".$password."'), '$email', '$path') ");
     return $query;
	}
	
	function postMoment($username, $username_tag, $olahraga, $status, $path, $location, $date){
	$query=$this->db->query("INSERT INTO sh_moment (username_post, username_tag, olahraga, deskripsi, foto_moment, location, waktu) VALUES('$username', '$username_tag', '$olahraga', '$status', '$path', '$location', '$date') ");
	return $query;
	}
	
	function postEvent($username, $olahraga, $deskripsi, $path, $location, $date){
	 $query=$this->db->query("INSERT INTO sh_event (username, olahraga, deskripsi, foto_event, location, waktu) VALUES('$username', '$olahraga', '$deskripsi', '$path', '$location', '$date') ");
     return $query;
	}
	
	function updateProfile($username, $nama, $jenisKelamin, $tanggalLahir, $email, $path){
	 $query=$this->db->query("UPDATE sh_user SET nama = '$nama', jenis_kelamin = '$jenisKelamin', tanggal_lahir = '$tanggalLahir', email = '$email', foto_profil = '$path' where username = '$username' ");
     return $query;
	}
	
	function updatePassword($new_password,$username){
	 $query=$this->db->query("UPDATE sh_user SET password = md5('".$new_password."') where username = '$username' ");
     return $query;
	}
	
	function checkPassword($username,$old_password){
	 $query=$this->db->query("SELECT * FROM sh_user WHERE username = '$username' AND password = md5('".$old_password."') ");
     return $query;
	}
	
	function resetPassword($email, $password){
	 $query=$this->db->query("UPDATE sh_user SET password = md5('".$password."') where email = '$email' ");
     return $query;
	}
	
	function generateRandomString($length = 8) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	function getAllContent() {
	 $query=$this->db->query("SELECT * from sh_user order by id desc ");
	 return $query;
	}
	
	public function getNama($id='') {
	 $this->db->where('username',$id);
	 return $this->db->get('sh_user');
	}
}	
?>
    