<?php
/**
 * Created by PhpStorm.
 * User: Karisma
 * Date: 17/10/2019
 * Time: 14:33
 */

class UniversalModel extends CI_Model
{
	/**
	 * UniversalModel constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * @param string $namaTable
	 * @param string $where
	 * @return mixed
	 */
	public function delete(string $namaTable, string $where)
	{
		$query = $this->db->where($where)
			->delete($namaTable);

		return ([
			"success" => $query,
		]);
	}


	/**
	 * @param string $namaTable
	 * @param array $data
	 * @return mixed
	 */
	public function insert(string $namaTable, array $data)
	{
		$query = $this->db->insert($namaTable, $data);

		$insert_id = $this->db->insert_id();

		return ([
			"success" => $query,
			"id"      => $insert_id,
		]);
	}


	/**
	 * @param string $namaTable
	 * @param array $data
	 * @return mixed
	 */
	public function insertBatch(string $namaTable, array $data)
	{
		$query = $this->db->insert_batch($namaTable, $data);

		$insert_id = $this->db->insert_id();

		return ([
			"success" => $query,
			"id"      => $insert_id,
		]);
	}

	/**
	 * @param string $namaTable
	 * @param string $where
	 * @param array $data
	 * @return mixed
	 */
	public function update(string $namaTable, string $where, array $data)
	{
		$query = $this->db->where($where)
			->update($namaTable, $data);

		return ([
			"success" => $query,
			"data"    => $data,
		]);
	}

	/**
	 * @param string $namaTable
	 * @param string $where
	 * @param string $selectColumn
	 * @return array
	 */
	public function getAllData(string $namaTable, string $where = "", string $selectColumn = "*")
	{
		$query = $this->db->select($selectColumn)
			->from($namaTable);

		if ($where != "") {
			$query = $query->where($where);
		}

		$query = $query->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	/**
	 * @param string $namaTable
	 * @param string $where
	 * @param string $selectColumn
	 * @return array
	 */
	public function getOneData(string $namaTable, string $where = "", string $selectColumn = "*")
	{
		$query = $this->db->select($selectColumn)
			->from($namaTable);

		if ($where != "") {
			$query = $query->where($where);
		}

		$query = $query->get()
			->result_array();

		return ([
			"data"  => count($query) >= 1 ? $query[0] : [],
			"total" => count($query),
		]);
	}

	public function joinGetAll(string $namaTable, array $join, string $where = "", string $selectColumn = "*", string $having = "", string $groupby = "", string $orderBy = "", string $orderByOption = "DESC")
	{
		$query = $this->db->select($selectColumn)
			->from($namaTable);

		if ($where != "") {
			$query = $query->where($where);
		}

		if (count($join) > 0) {
			foreach ($join as $keyJoin => $valueJoin) {
				$query = $query->join($valueJoin["table"], $valueJoin["join"], $valueJoin["tipe"]);
			}
		}

		if ($having != "") {
			$query = $query->having($having);
		}

		if ($groupby != "") {
			$query = $query->group_by($groupby);
		}

		if ($orderBy != "") {
			$query = $query->order_by($orderBy, $orderByOption);
		}

		$query = $query->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

}
