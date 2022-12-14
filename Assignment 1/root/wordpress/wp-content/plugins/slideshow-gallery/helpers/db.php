<?php
	
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class GalleryDbHelper extends GalleryPlugin {

	var $name = 'Db';
	
	function __construct() {
		
	}
	
	function count($conditions = array()) {
		global $wpdb;
		
		$query = "SELECT COUNT(*) FROM `" . $this -> table . "`";
		if ($count = $wpdb -> get_var($query)) {
			return $count;
		}
		
		return false;
	}
	
	function find($conditions = array(), $fields = false, $order = array('id', "DESC"), $assign = true, $atts = array()) {
		global $wpdb;
		
		$newfields = "*";
		
		if (!empty($fields)) {
			if (is_array($fields)) {
				$newfields = "";
				$f = 1;
				
				foreach ($fields as $field) {
					$newfields .= "`" . $field . "`";
					
					if ($f < count($fields)) {
						$newfields .= ", ";
					}
					
					$f++;
				}
			} else {
				$newfields = $fields;
			}
		}
		
		$query = "SELECT " . $newfields . " FROM `" . $this -> table . "`";
		
		if (!empty($conditions) && is_array($conditions)) {
			$query .= " WHERE";
			$c = 1;
			
			foreach ($conditions as $ckey => $cval) {
				$query .= " `" . $ckey . "` = '" . ($cval) . "'";
				
				if ($c < count($conditions)) {
					$query .= " AND";
				}
				
				$c++;
			}
		}
		
		if (!empty($order) && $order == "RAND") {
			$query .= " ORDER BY RAND()";	
		} else {
			$order = (empty($order)) ? array('id', "DESC") : $order;
			list($ofield, $odir) = $order;
			$query .= " ORDER BY `" . $ofield . "` " . ($odir) . "";
		}
			
		$query .= " LIMIT 1";
		
		$query_hash = md5($query);
		if ($oc_record = wp_cache_get($query_hash, 'slideshowgallery')) {
			$record = $oc_record;
		} else {
			$record = $wpdb -> get_row($query);
			wp_cache_set($query_hash, $record, 'slideshowgallery', 0);
		}
			
		if (!empty($record)) {			
			$data = $this -> init_class($this -> model, $record);
			
			if ($assign == true) {
				$this -> data = $data;
			}

			return $data;
		}
		
		return false;
	}
	
	function find_all($conditions = array(), $fields = false, $order = array('id', "DESC"), $limit = false, $assign = false, $distinct = false) {
		global $wpdb;
		
		$newfields = "*";
		if (!empty($fields) && !is_array($fields)) { $newfields = $fields; }
		$distinct = (!empty($distinct)) ? "DISTINCT " : "";
		
		$query = "SELECT " . $distinct . $newfields . " FROM `" . $this -> table . "`";
		
		if (!empty($conditions) && is_array($conditions)) {
			$query .= " WHERE";
			$c = 1;
			
			foreach ($conditions as $ckey => $cval) {
				$query .= " `" . $ckey . "` = '" . ($cval) . "'";
				
				if ($c < count($conditions)) {
					$query .= " AND";
				}
				
				$c++;
			}
		}
		
		$order = (empty($order)) ? array('id', "DESC") : $order;
		
		if ($order == "random") {
			$query .= " ORDER BY RAND()";
		} else {
			if (!is_array($order)) { $order = array('id', "DESC"); }
			list($ofield, $odir) = $order;
			$query .= " ORDER BY `" . $ofield . "` " . ($odir) . "";
		}
			
		$query .= (empty($limit)) ? '' : " LIMIT " . $limit . "";
		
		$query_hash = md5($query);
		if ($oc_records = wp_cache_get($query_hash, 'slideshowgallery')) {
			$records = $oc_records;
		} else {
			$records = $wpdb -> get_results($query);
			wp_cache_set($query_hash, $records, 'slideshowgallery', 0);
		}
		
		if (!empty($records)) {
			$data = array();
		
			foreach ($records as $record) {
				$data[] = $this -> init_class($this -> model, $record);
			}
			
			if ($assign == true) {
				$this -> data = $data;
			}
			
			return $data;
		}
		
		return false;
	}
	
	function save($data = null, $validate = true) {
		global $wpdb;
		$this -> errors = false;
		
		$defaults = (method_exists($this, 'defaults')) ? $this -> defaults() : false;
		$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
		
		$r = wp_parse_args($data, $defaults);
		$this -> data = (object) $r;
		
		switch ($this -> model) {
			case 'Slide'				:
				if ($this -> language_do()) {
					$this -> data -> title = $this -> language_join($this -> data -> title);
					$this -> data -> description = $this -> language_join($this -> data -> description);
					$this -> data -> link = $this -> language_join($this -> data -> link);
				}
				break;
			case 'Gallery'				:
				if ($this -> language_do()) {
					$this -> data -> title = $this -> language_join($this -> data -> title);
				}
				break;
		}
		
		if ($validate == true) {
			if (method_exists($this, 'validate')) {
				$errors = $this -> validate((array) $this -> data);
				
				if (!empty($errors)) {
					$this -> errors = array_merge($this -> errors, $errors);
				}
			}
		}
		
		if (empty($this -> errors)) {
			switch ($this -> model) {
				case 'Slide'				:
					if ($this -> data -> type == "file") {
						//$this -> data -> image = $_FILES['image_file']['name'];	
					} elseif ($this -> data -> type == "media") {
						//do nothing
					} else {
						$this -> data -> image = basename($this -> data -> image_url);
					}
					
					if (empty($this -> data -> uselink) || $this -> data -> uselink == "N") {
						$this -> data -> link = "";
					}
					break;
			}
			
			$query = (empty($this -> data -> id)) ? $this -> insert_query($this -> model) : $this -> update_query($this -> model);			
			
			if ($wpdb -> query($query)) {
				$this -> insertid = $insertid = (empty($this -> data -> id)) ? $wpdb -> insert_id : $this -> data -> id;
				
				switch ($this -> model) {
					case 'Slide'				:					
					
						$slide_id = $this -> insertid;
						$deletequery = "DELETE FROM `" . $wpdb -> prefix . strtolower($this -> pre) . "_galleriesslides` WHERE `slide_id` = '" . $slide_id . "'";
						$wpdb -> query($deletequery);
						
						if (!empty($this -> data -> galleries)) {						
							foreach ($this -> data -> galleries as $gallery_id) {
								$date = date("Y-m-d H:i:s", time());
								$galleryslidequery = "INSERT INTO `" . $wpdb -> prefix . strtolower($this -> pre) . "_galleriesslides` (`slide_id`, `gallery_id`, `created`, `modified`) VALUES ('" . $slide_id . "', '" . $gallery_id . "', '" . $date . "', '" . $date . "');";
								$wpdb -> query($galleryslidequery);
							}
						}
						break;
				}
								
				return true;
			}
		}
		
		return false;
	}
	
	function save_field($field = null, $value = null, $conditions = array()) {
		if (!empty($this -> model)) {
			global $wpdb;
			
			if (!empty($field)) {
				$query = "UPDATE `" . $this -> table . "` SET `" . $field . "` = '" . ($value) . "'";
				
				if (!empty($conditions) && is_array($conditions)) {
					$query .= " WHERE";
					$c = 1;
					
					foreach ($conditions as $ckey => $cval) {
						$query .= " `" . $ckey . "` = '" . ($cval) . "'";
						
						if ($c < count($conditions)) {
							$query .= " AND";
						}
						
						$c++;
					}
				}
				
				if ($wpdb -> query($query)) {
					return true;
				}
			}
		}
		
		return false;
	}
	
	function delete($record_id = null) {
		global $wpdb;
		
		if (!empty($record_id) && $record = $this -> find(array('id' => $record_id))) {
			$query = "DELETE FROM `" . $this -> table . "` WHERE `id` = '" . ($record_id) . "' LIMIT 1";
			
			if ($wpdb -> query($query)) {			
				switch ($this -> model) {
					case 'Gallery'			:
						$query = "DELETE FROM `" . $wpdb -> prefix . strtolower($this -> pre) . "_galleriesslides` WHERE `gallery_id` = '" . $record_id . "'";
						$wpdb -> query($query);
						break;
					case 'Slide'			:
						$imagepath = $this -> Html -> uploads_path() . DS . $this -> plugin_name . DS . $record -> image;
						@unlink($imagepath);
						$query = "DELETE FROM `" . $wpdb -> prefix . strtolower($this -> pre) . "_galleriesslides` WHERE `slide_id` = '" . $record_id . "'";
						$wpdb -> query($query);
						break;
				}
							
				return true;
			}
		}
		
		return false;
	}
	
	function delete_all($conditions = null) {
		global $wpdb;
		
		$query = "DELETE FROM " . $this -> {$this -> model}() -> table;
		
		if (!empty($conditions)) {
			$query .= " WHERE";
			$c = 1;
			foreach ($conditions as $ckey => $cval) {
				$query .= " `" . $ckey . "` = '" . $cval . "'";
				if ($c < count($conditions)) {
					$query .= " AND";
				}
				
				$c++;
			}
		}
		
		$wpdb -> query($query);
		return true;
	}
	
	function insert_query($model = null) {	
		if (!empty($model)) {
			global $wpdb;
			
			if (!empty($this -> data)) {
				if (empty($this -> data -> id)) {
					$query1 = "INSERT INTO `" . $this -> table . "` (";
					$query2 = "";
					$c = 1;
					unset($this -> fields['key']);
					
					foreach (array_keys($this -> fields) as $field) {
						if (!empty($this -> data -> {$field}) || $this -> data -> {$field} == "0") {						
							if (is_array($this -> data -> {$field}) || is_object($this -> data -> {$field})) {
								$value = serialize($this -> data -> {$field});
							} else {
								$value = ($this -> data -> {$field});
							}
				
							$query1 .= "`" . $field . "`";
							$query2 .= "'" . ($value) . "'";
							
							if ($c < count($this -> fields)) {
								$query1 .= ", ";
								$query2 .= ", ";
							}
						}
						
						$c++;
					}
					
					$query1 .= ") VALUES (";
					$query = $query1 . "" . $query2 . ");";
					
					return $query;
				} else {
					$query = $this -> update_query($model);
					
					return $query;
				}
			}
		}
	
		return false;
	}
	
	function update_query($model = null) {	
		if (!empty($model)) {
			global $wpdb;
			
			if (!empty($this -> data)) {			
				$query = "UPDATE `" . $this -> table . "` SET ";
				$c = 1;
				
				unset($this -> fields['id']);
				unset($this -> fields['key']);
				unset($this -> fields['created']);
				
				foreach (array_keys($this -> fields) as $field) {
					if (is_array($this -> data -> {$field}) || is_object($this -> data -> {$field})) {
						$value = serialize($this -> data -> {$field});
					} else {
						$value = ($this -> data -> {$field});
					}
				
					$query .= "`" . $field . "` = '" . ($value) . "'";
					
					if ($c < count($this -> fields)) {
						$query .= ", ";
					}
					
					$c++;
				}
				
				$query .= " WHERE `id` = '" . $this -> data -> id . "' LIMIT 1";
				
				return $query;
			}
		}
	
		return false;
	}
}

?>