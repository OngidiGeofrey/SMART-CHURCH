<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		$this->permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_topic(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(isset($_POST['description'])){
			if(!empty($data)) $data .=",";
				$data .= " `description`='".addslashes(htmlentities($description))."' ";
		}
		$check = $this->conn->query("SELECT * FROM `topics` where `name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Topic already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `topics` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `topics` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Topic successfully saved.");
			else
				$this->settings->set_flashdata('success',"Topic successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_topic(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `topics` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Topic successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_sched_type(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(isset($_POST['description'])){
			if(!empty($data)) $data .=",";
				$data .= " `description`='".addslashes($description)."' ";
		}
		$check = $this->conn->query("SELECT * FROM `schedule_type` where `sched_type` = '{$sched_type}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Schedule Type already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `schedule_type` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `schedule_type` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Schedule Type successfully saved.");
			else
				$this->settings->set_flashdata('success',"Schedule Type successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_sched_type(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `schedule_type` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Schedule Type successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function generate_string($input, $strength = 10) {
		
		$input_length = strlen($input);
		$random_string = '';
		for($i = 0; $i < $strength; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}
	 
		return $random_string;
	}
	function upload_files(){
		extract($_POST);
		$data = "";
		if(empty($upload_code)){
			while(true){
				$code = $this->generate_string($this->permitted_chars);
				$chk = $this->conn->query("SELECT * FROM `uploads` where dir_code ='{$code}' ")->num_rows;
				if($chk <= 0){
					$upload_code = $code;
					$resp['upload_code'] =$upload_code;
					break;
				}
			}
		}

		if(!is_dir(base_app.'uploads/blog_uploads/'.$upload_code))
			mkdir(base_app.'uploads/blog_uploads/'.$upload_code);
		$dir = 'uploads/blog_uploads/'.$upload_code.'/';
		$images = array();
		for($i = 0;$i < count($_FILES['img']['tmp_name']); $i++){
			if(!empty($_FILES['img']['tmp_name'][$i])){
				$fname = $dir.(time()).'_'.$_FILES['img']['name'][$i];
				$f = 0;
				while(true){
					$f++;
					if(is_file(base_app.$fname)){
						$fname = $f."_".$fname;
					}else{
						break;
					}
				}
				$move = move_uploaded_file($_FILES['img']['tmp_name'][$i],base_app.$fname);
				if($move){
					$this->conn->query("INSERT INTO `uploads` (dir_code,user_id,file_path)VALUES('{$upload_code}','{$this->settings->userdata('id')}','{$fname}')");
					$this->capture_err();
					$images[] = $fname;
				}
			}
		}
		$resp['images'] = $images;
		$resp['status'] = 'success';
		return json_encode($resp);
	}
	function save_blog(){
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','content','upload_code','banner_image','img','blog_url'))){
				if(!empty($data)) $data .=",";
				$v = addslashes($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($blog_url)){
			$blog_url = 'pages/'.(strtolower(str_replace(" ","_",$title))).'.php';
			
		}
		if(!empty($data)) $data .=",";
				$data .= " `blog_url`='".$blog_url."' ";
		if(isset($_POST['content'])){
			if(!empty($data)) $data .=",";
				$data .= " `content`='".addslashes(htmlentities($content))."' ";
		}
		if(!empty($data)) $data .=",";
			$data .= " `upload_dir_code`='{$upload_code}' ";
		if(empty($id)){
			$data .= ", `author_id`='{$this->settings->userdata('id')}' ";
			$sql = "INSERT INTO `blogs` set {$data} ";
			$save = $this->conn->query($sql);
			$id= $this->conn->insert_id;
		}else{
			$sql = "UPDATE `blogs` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Blog successfully saved.");
			else
				$this->settings->set_flashdata('success',"Blog successfully updated.");
			$id = empty($id) ? $this->conn->insert_id : $id;
			$dir = 'uploads/blog_uploads/banners/';
			if(!is_dir(base_app.$dir))
				mkdir(base_app.$dir);
			if(isset($_FILES['banner_image'])){
				if(!empty($_FILES['banner_image']['tmp_name'])){
					$fname = $dir.$id."_banner.".(pathinfo($_FILES['banner_image']['name'], PATHINFO_EXTENSION));
					$move =  move_uploaded_file($_FILES['banner_image']['tmp_name'],base_app.$fname);
					if($move){
						$this->conn->query("UPDATE `blogs` set `banner_path` = '{$fname}' where id = '{$id}' ");
					}
				}
			}
			if(!isset($fnme))
				$fname = $this->conn->query("SELECT banner_path FROM `blogs` where id = '{$id}' ")->fetch_array()['banner_path'];
			$date_created = $this->conn->query("SELECT date_created FROM `blogs` where id = '{$id}' ")->fetch_array()['date_created'];
			
			if(!is_file(base_app.$blog_url))
				file_put_contents(base_app.$blog_url,'');
				$content = stripslashes($content);
				$contents = "<?php require_once('../config.php'); ?>\n";
				$contents .= "<!DOCTYPE HTML>\n";
				$contents .= "<head>\n";
				$contents .= "<title> ".$title." | <?php echo \$_settings->info('short_name') ?></title>\n";
				$contents .= "<meta name=\"description\" content=\"".$meta_description."\">\n";
				$contents .= "<meta name=\"keywords\" content=\"".$keywords."\">\n";
				$contents .= "<meta name=\"robots\" content=\"index, follow\">\n";
				$contents .= '<meta property="og:type" content="article" />';
				$contents .= "\n";
				$contents .= '<meta property="og:title" content="'.(addslashes($title)).'" />';
				$contents .= "\n";
				$contents .= '<meta property="og:description" content="'.(addslashes($meta_description)).'" />';
				$contents .= "\n";
				$contents .= '<meta property="og:image" content="'.(validate_image($fname)).'" />';
				$contents .= "\n";
				$contents .= '<meta property="og:url" content="'.(base_url.$blog_url).'" />';
				$contents .= "\n";
				$contents .= "<?php require_once('../inc/page_header.php') ?>\n";
				$contents .= "</head>\n";
				$contents .= "<?php include(base_app.'inc/body_block.php') ?>\n";
				$contents .= '<h2>'.addslashes($title).'</h2>';
				$contents .= "\n";
				$contents .= '<input name="blog_id" value="'.(md5($id)).'" type="hidden">';
				$contents .= "\n";
				$contents .= '<hr>';
				$contents .= "\n";
				$contents .= "<small><span class='text-muted'><i class='fa fa-calendar-day'></i> Published: ".(date("M d,Y h:i A",strtotime($date_created)))."</span></small>";
				$contents .= "\n";
				$contents .= '<center><img src="'.(validate_image($fname)).'" class="img-thumbnail img-banner" alt="'.(base_url.$blog_url).'" /></center>';
				
				$contents .= "\n";
				$contents .= ($content);
				$contents .= "\n";
				$contents .= "<?php include(base_app.'inc/body_block_end.php') ?>\n";
				file_put_contents(base_app.$blog_url, html_entity_decode($contents));
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_blog(){
		extract($_POST);
		$qry = $this->conn->query("SELECT * FROM `blogs` where id = '{$id}'");
		foreach($qry->fetch_array() as $k =>  $v){
			$meta[$k] = $v;
		}
		$del = $this->conn->query("DELETE FROM `blogs` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			if(is_file(base_app.$meta['blog_url']))
				unlink((base_app.$meta['blog_url']));
			$this->settings->set_flashdata('success',"Product successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_daily_verse(){
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','cur_img'))){
				if(!empty($data)) $data .=",";
				$v = addslashes($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		
		if(empty($id)){
			$sql = "INSERT INTO `daily_verses` set {$data} ";
		}else{
			$sql = "UPDATE `daily_verses` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Daily Verse successfully saved.");
			else
				$this->settings->set_flashdata('success',"Daily Verse successfully updated.");
			$id = empty($id) ? $this->conn->insert_id : $id;
			$dir = 'uploads/verse_bg/';
			if(!is_dir(base_app.$dir))
				mkdir(base_app.$dir);
			if(isset($_FILES['img'])){
				if(!empty($_FILES['img']['tmp_name'])){
					$fname = $dir.$id.".".(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
					$img = $_FILES['img']['tmp_name'];
					list($width, $height) = getimagesize($img);
					$new_width = 1280;
					$new_height = 720;
					$mimeType = mime_content_type($img);
					
					if(!in_array($mimeType,array('image/jpg','image/jpeg','image/png'))){
						$this->settings->set_flashdata('success',"Daily Verse successfully saved but unable to upload the image due to invalid type.");
					}else{
						$image_p = imagecreatetruecolor($new_width, $new_height);
						$gdImg = ($mimeType =='image/png') ? imagecreatefrompng($img) : imagecreatefromjpeg($img);
						imagecopyresampled($image_p, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

						if($image_p){
							if(is_file(base_app.$fname)){
								unlink(base_app.$fname);
							}
							if($mimeType =='image/png'){
								imagepng($image_p,base_app.$fname);
							}else{
								imagejpeg($image_p,base_app.$fname);
							}
							$this->conn->query("UPDATE `daily_verses` set `image_path` = '{$fname}' where id = '{$id}' ");
						}else{
						$this->settings->set_flashdata('success',"Daily Verse successfully saved but unable to upload the image due to invalid image convertions.");
						}

					}
					
					
				}
			}
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_daily_verse(){
		extract($_POST);
		$qry = $this->conn->query("SELECT * FROM `daily_verses` where id = '{$id}'");
		foreach($qry->fetch_array() as $k =>  $v){
			$meta[$k] = $v;
		}
		$del = $this->conn->query("DELETE FROM `daily_verses` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			if(is_file(base_app.$meta['image_path']))
				unlink((base_app.$meta['image_path']));
			$this->settings->set_flashdata('success',"Daily Verse successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function delete_img(){
		extract($_POST);
		if(is_file(base_app.$path)){
			if(unlink(base_app.$path)){
				$del = $this->conn->query("DELETE FROM `uploads` where file_path = '{$path}'");
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
	function save_event(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			$v = addslashes($v);
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `events` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `events` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			if(empty($id))
				$this->settings->set_flashdata('success',"New Event successfully saved.");
			else
				$this->settings->set_flashdata('success',"Event successfully updated.");
			$resp['status'] = 'success';
			$id = empty($id) ? $this->conn->insert_id : $id;
			if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name'])){
				$dir = 'uploads/events/';
				if(!is_dir(base_app.$dir))
				mkdir(base_app.$dir);
				$fname = $dir.$id.'.'.(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
				$move = move_uploaded_file($_FILES['img']['tmp_name'], base_app.$fname);
				if($move){
					$this->conn->query("UPDATE `events` set img_path = '{$fname}' where id = '{$id}'");
				}
			}
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_event(){
		extract($_POST);
		$img_path = $this->conn->query("SELECT img_path FROM `events` where id = '{$id}'")->fetch_array()['img_path'];
		$del = $this->conn->query("DELETE FROM `events` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Event successfully deleted.");
			if(is_file(base_app.$img_path)){
				unlink(base_app.$img_path);
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_donation(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		
		$sql = "INSERT INTO `donations` set {$data} ";
		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Donation successfully Added. Thank you!");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function save_cause(){
		extract($_POST);
		$blog_url = "causes.php";
		if(!is_file(base_app.$blog_url))
			file_put_contents(base_app.$blog_url,'');
		$data['keywords'] = $keywords;
		$data['meta_description'] = $meta_description;
		$data['content'] = addslashes(htmlentities($content));
		file_put_contents(base_app.'/cause.json',json_encode($data));
			$content = stripslashes($content);
			$contents = "<?php require_once('config.php'); ?>\n";
			$contents .= "<!DOCTYPE HTML>\n";
			$contents .= "<head>\n";
			$contents .= "<title> Causes | <?php echo \$_settings->info('short_name') ?></title>\n";
			$contents .= "<meta name=\"description\" content=\"".$meta_description."\">\n";
			$contents .= "<meta name=\"keywords\" content=\"".$keywords."\">\n";
			$contents .= "<meta name=\"robots\" content=\"index, follow\">\n";
			$contents .= '<meta property="og:type" content="article" />';
			$contents .= "\n";
			$contents .= '<meta property="og:title" content="Charity Causes" />';
			$contents .= "\n";
			$contents .= '<meta property="og:description" content="'.(addslashes($meta_description)).'" />';
			$contents .= "\n";
			$contents .= '<meta property="og:image" content="'.(validate_image($this->settings->info('logo'))).'" />';
			$contents .= "\n";
			$contents .= '<meta property="og:url" content="'.(base_url.$blog_url).'" />';
			$contents .= "\n";
			$contents .= "<?php require_once(base_app.'inc/page_header.php') ?>\n";
			$contents .= "</head>\n";
			$contents .= "<?php include(base_app.'inc/body_block.php') ?>\n";
			$contents .= "\n";
			$contents .= ($content);
			$contents .= "\n";
			$contents .= "<?php include(base_app.'inc/body_block_end.php') ?>\n";
			file_put_contents(base_app.$blog_url, html_entity_decode($contents));

			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', ' Causes Page Content Successfully updated.');
			return json_encode($resp);
	}
	function save_appointment_req(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k=>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `appointment_request` set {$data}";
		}else{
			$sql = "UPDATE `appointment_request` set {$data} where id = '{$id}'";
		}
		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
			if(isset($status)){
				$this->settings->set_flashdata("Appointment Request Successfully Updated.");
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error_sql'] = $sql;
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_appointment_request (){
		extract($_POST);
		$save = $this->conn->query("DELETE FROM `appointment_request` where id ='{$id}'");
		if($save){
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success"," Appointment Request Successfully Deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
		}
		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_topic':
		echo $Master->save_topic();
	break;
	case 'delete_topic':
		echo $Master->delete_topic();
	break;
	case 'save_sched_type':
		echo $Master->save_sched_type();
	break;
	case 'delete_sched_type':
		echo $Master->delete_sched_type();
	break;
	case 'upload_files':
		echo $Master->upload_files();
	break;
	case 'save_blog':
		echo $Master->save_blog();
	break;
	case 'delete_blog':
		echo $Master->delete_blog();
	break;
	case 'save_daily_verse':
		echo $Master->save_daily_verse();
	break;
	case 'delete_daily_verse':
		echo $Master->delete_daily_verse();
	break;
	case 'save_event':
		echo $Master->save_event();
	break;
	case 'delete_event':
		echo $Master->delete_event();
	break;
	case 'save_donation':
		echo $Master->save_donation();
	break;
	case 'save_cause':
		echo $Master->save_cause();
	break;
	case 'delete_img':
		echo $Master->delete_img();
	break;
	case 'save_appointment_req':
		echo $Master->save_appointment_req();
	break;
	case 'delete_appointment_request':
		echo $Master->delete_appointment_request();
	break;
	default:
		// echo $sysset->index();
		break;
}