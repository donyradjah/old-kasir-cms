<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 5/21/2020
 * Time: 9:21 AM
 */

class ProdukModel extends CI_Model
{

	private $table = "produk";

	public function getDataPaging(string $search = "", string $order = "namaProduk ASC", int $limit = 10, int $start = 0)
	{
		$query = $this->db->select("*")
			->from("produk");


		if ($search != "") {
			$query = $query->grouo_start()
				->where("namaProduk like %{$search}%")
				->group_end();
		}

		$query = $query->order_by($order);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*")
			->from("produk");


		if ($search != "") {
			$query = $query->grouo_start()
				->where("namaProduk like %{$search}%")
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
			->from('produk')
			->where('idProduk', $id)
			->get()
			->result_array();

		return ([
			"data"  => count($query) >= 1 ? $query[0] : [],
			"total" => count($query),
		]);
	}

	public function saveData($data)
	{
		return $this->db->insert('produk', $data);
	}

	public function updateData($id, $data)
	{
		$this->db->where('idProduk', $id);

		return $this->db->update('produk', $data);
	}

	public function deleteData($id)
	{
		$this->db->where('idProduk', $id);

		return $this->db->delete('produk');
	}

	public function getAll()
	{
		$query = $this->db->select("*")
			->from('produk')
			->order_by('namaProduk', "ASC")
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

}
