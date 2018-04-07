<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Model extends CI_Model {

	// Tên table
	var $table = '';

	// Key chính của table
	var $key = 'id';

	// Order mặc định (VD: $order = array('id', 'desc))
	var $order = '';

	// Các field select mặc định khi get_list (VD: $select = 'id, name')
	var $select = '';

	/**
	 * Them row moi
	 * $data : Dữ liệu mà ta cần thêm
	 */
	function create($data = array())
	{
		if($this->db->insert($this->table, $data))
		{
		   return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	 * Cập nhật row từ id
	 * $id : Khóa chính của bảng cần sửa
	 * $data : Mảng dữ liệu cần sửa
	 */
	function update($id, $data)
	{
		if (!$id)
		{
			return FALSE;
		}

		$where = array();
	 	$where[$this->key] = $id;
	    $this->update_rule($where, $data);

	 	return TRUE;
	}

	/**
	 * Cap nhat row tu dieu kien
	 * $where : dieu kien
	 * $data : mang du lieu can cap nhat
	 */
	function update_rule($where, $data)
	{
		if (!$where)
		{
			return FALSE;
		}

	 	$this->db->where($where);
	 	$this->db->update($this->table, $data);

	 	return TRUE;
	}

	/**
	 * Xóa row từ id
	 * $id : giá trị của khóa chính
	 */
	function delete($id)
	{
		if (!$id)
		{
			return FALSE;
		}
		//neu la so
		if(is_numeric($id))
		{
			$where = array($this->key => $id);
		}else
		{
		    //$id = 1,2,3...
			$where = $this->key . " IN (".$id.") ";
		}
	 	$this->del_rule($where);

		return TRUE;
	}

	/**
	 * Xóa row từ điều kiện
	 * $where : mảng điều kiện để xóa
	 */
	function del_rule($where)
	{
		if (!$where)
		{
			return FALSE;
		}

	 	$this->db->where($where);
		$this->db->delete($this->table);

		return TRUE;
	}

	/**
	 * Thực hiện câu lệnh query
	 * $sql : câu lệnh sql
	 */
	function query($sql){
		$rows = $this->db->query($sql);
		return $rows->result;
	}

	/**
	 * Lấy thông tin của row từ id
	 * $id : id id cần lấy thông tin
	 * $field : cột dữ liệu mà cần lấy
	 */
	function get_info($id, $field = '')
	{
		if (!$id)
		{
			return FALSE;
		}

	 	$where = array();
	 	$where[$this->key] = $id;

	 	return $this->get_info_rule($where, $field);
	}

	/**
	 * Lấy thông tin row từ điều kiện
	 * $where: Mảng điều kiện
	 * $field: Cột muốn lấy dữ liệu
	 */
	function get_info_rule($where = array(), $field= '')
	{
	    if($field)
	    {
	        $this->db->select($field);
	    }
		$this->db->where($where);
		$query = $this->db->get($this->table);
		if ($query->num_rows())
		{
			return $query->row();
		}

		return FALSE;
	}

	/**
	 * Lấy tổng số
	 */
	function get_total($input = array())
	{
		$this->get_list_set_input($input);

		$query = $this->db->get($this->table);

		return $query->num_rows();
	}

	/**
	 * lấy tổng sô
	 * $field: cột muốn tính tổng
	 */
	function get_sum($field, $where = array())
	{
		$this->db->select_sum($field);//tinh rong
		$this->db->where($where);//dieu kien
		$this->db->from($this->table);

		$row = $this->db->get()->row();
		foreach ($row as $f => $v)
		{
			$sum = $v;
		}
		return $sum;
	}

	/**
	 * lấy 1 row
	 */
	function get_row($input = array()){
		$this->get_list_set_input($input);

		$query = $this->db->get($this->table);

		return $query->row();
	}

	/**
	 * Lấy danh sách
	 * $input : các mảng dữ liệu đầu vào
	 */
	function get_list($input = array())
	{
	    //xu ly ca du lieu dau vao
		$this->get_list_set_input($input);

		//thuc hien truy van du lieu
		$query = $this->db->get($this->table);
		//echo $this->db->last_query();
		return $query->result();
	}

	/**
	 * Gắn các thuộc tính trong input khi lấy dữ liệu
	 * $input : mảng dữ liệu đầu vào
	 */

	protected function get_list_set_input($input = array())
	{

		// Thêm điều kiện cho câu truy vấn truyền qua biến $input['where']
		//(vi du: $input['where'] = array('email' => 'hocphp@gmail.com'))
		if ((isset($input['where'])) && $input['where'])
		{
			$this->db->where($input['where']);
		}

		//tim kiem like
		// $input['like'] = array('name' => 'abc');
	    if ((isset($input['like'])) && $input['like'])
		{
			$this->db->like($input['like'][0], $input['like'][1]);
		}

		// Thêm sắp xếp dữ liệu thông qua biến $input['order']
		//(ví dụ $input['order'] = array('id','DESC'))
		if (isset($input['order'][0]) && isset($input['order'][1]))
		{
			$this->db->order_by($input['order'][0], $input['order'][1]);
		}
		else
		{
			//mặc định sẽ sắp xếp theo id giảm dần
			$order = ($this->order == '') ? array($this->table.'.'.$this->key, 'desc') : $this->order;
			$this->db->order_by($order[0], $order[1]);
		}

		// Thêm điều kiện limit cho câu truy vấn thông qua biến $input['limit']
		//(ví dụ $input['limit'] = array('10' ,'0'))
		if (isset($input['limit'][0]) && isset($input['limit'][1]))
		{
			$this->db->limit($input['limit'][0], $input['limit'][1]);
		}

	}

	/**
	 * kiểm tra sự tồn tại của dữ liệu theo 1 điều kiện nào đó
	 * $where : mang du lieu dieu kien
	 */
    function check_exists($where = array())
    {
	    $this->db->where($where);
	    //thuc hien cau truy van lay du lieu
		$query = $this->db->get($this->table);

		if($query->num_rows() > 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

}
?>