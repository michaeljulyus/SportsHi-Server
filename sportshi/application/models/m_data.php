<?php
class M_data extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	
	function getAllContent() {
	 $query=$this->db->query("SELECT * from sh_user order by id desc ");
	 return $query;
	}
	
	function getTimelineData() {
	 $query=$this->db->query("SELECT sh_user.id, sh_user.nama, sh_user.foto_profil, sh_moment.deskripsi as deskripsi, sh_moment.foto_moment as foto, sh_moment.location as location, sh_moment.username_tag, sh_moment.olahraga, sh_moment.waktu FROM sh_user INNER JOIN sh_moment ON sh_user.username = sh_moment.username_post UNION SELECT sh_user.id, sh_user.nama, sh_user.foto_profil, sh_event.deskripsi, sh_event.foto_event as foto, sh_event.location as location, '', sh_event.olahraga, sh_event.waktu FROM sh_user INNER JOIN sh_event ON sh_user.username = sh_event.username order by waktu desc ");
	 return $query;
	}
	
	function getAllCategory() {
	 $query=$this->db->query("SELECT * from sh_kategori order by id desc ");
	 return $query;
	}
}
?>
    