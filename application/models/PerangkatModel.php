<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 5/21/2020
 * Time: 9:21 AM
 */

class PerangkatModel extends CI_Model
{

	private $table = "perangkat";

	public function getDataPaging(string $search = "", string $order = "nomorMeja ASC", int $limit = 10, int $start = 0)
	{
		$query = $this->db->select("*")
			->from("perangkat");


		if ($search != "") {
			$query = $query->grouo_start()
				->where("nomorMeja like %{$search}%")
				->or_where("namaPerangkat like %{$search}%")
				->group_end();
		}

		$query = $query->order_by($order);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*")
			->from("perangkat");


		if ($search != "") {
			$query = $query->grouo_start()
				->where("nomorMeja like %{$search}%")
				->or_where("namaPerangkat like %{$search}%")
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
			->from('perangkat')
			->where('idPerangkat', $id)
			->get()
			->result_array();

		return ([
			"data"  => count($query) >= 1 ? $query[0] : [],
			"total" => count($query),
		]);
	}

	public function saveData($data)
	{
		return $this->db->insert('perangkat', $data);
	}

	public function updateData($id, $data)
	{
		$this->db->where('idPerangkat', $id);

		return $this->db->update('perangkat', $data);
	}

	public function deleteData($id)
	{
		$this->db->where('idPerangkat', $id);

		return $this->db->delete('perangkat');
	}

	public function getAll($where = "")
	{
		$query = $this->db->select("*")
			->from('perangkat');

		if ($where != "") {
			$query = $query->where($where);
		}

		$query = $query->order_by('nomorMeja', "ASC")
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

}
