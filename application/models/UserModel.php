<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 5/21/2020
 * Time: 9:21 AM
 */

class UserModel extends CI_Model
{

	private $table = "user";

	public function getDataPaging(string $search = "", string $order = "nama ASC", int $limit = 10, int $start = 0)
	{
		$query = $this->db->select("*")
			->from("user");


		if ($search != "") {
			$query = $query->grouo_start()
				->where("nama like %{$search}%")
				->or_where("username like %{$search}%")
				->or_where("email like %{$search}%")
				->group_end();
		}

		$query = $query->order_by($order);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*")
			->from("user");


		if ($search != "") {
			$query = $query->grouo_start()
				->where("nama like %{$search}%")
				->or_where("username like %{$search}%")
				->or_where("email like %{$search}%")
				->group_end();
		}

		$query = $query->order_by($order);

		$queryLimit = $query->limit($limit, $start)
			->get()
			->result_array();

		return ([
			"total"         => $count_all_result,
			"data"          => $queryLimit,
			"total_in_page" => count($queryLimit),
			"total_page"    => ceil($count_all_result / $limit),
		]);
	}

	public function getById($id)
	{
		$query = $this->db->select("*")
			->from('user')
			->where('idUser', $id)
			->get()
			->result_array();

		return ([
			"data"  => count($query) >= 1 ? $query[0] : [],
			"total" => count($query),
		]);
	}

	public function saveData($data)
	{
		return $this->db->insert('user', $data);
	}

	public function updateData($id, $data)
	{
		$this->db->where('idUser', $id);

		return $this->db->update('user', $data);
	}

	public function deleteData($id)
	{
		$this->db->where('idUser', $id);

		return $this->db->delete('user');
	}

	public function getAll($where = "")
	{
		$query = $this->db->select("*")
			->from('user');

		if ($where != "") {
			$query = $query->where($where);
		}

		$query = $query->order_by('nama', "ASC")
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function isLoggedIn($page = '/login')
	{
		if (!$this->session->userdata("idUser")) {
			alert("danger", "Aksed Di Tolak", "Silahkan login terlebih dahulu");
			redirect(base_url() . $page);
		}
	}

	public function cariUsernamev2($username)
	{
		$query = $this->db->select("*")
			->from("user")
			->where("username", $username)
			->get()
			->result_array();

		return ([
			"data"  => count($query) >= 1 ? $query[0] : [],
			"total" => count($query),
		]);
	}

	public function cariEmailv2($email)
	{
		$query = $this->db->select("*")
			->from("user")
			->where("email", $email)
			->get()
			->result_array();

		return ([
			"data"  => count($query) >= 1 ? $query[0] : [],
			"total" => count($query),
		]);
	}

}
