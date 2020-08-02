<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 5/23/2020
 * Time: 11:06 AM
 */

class Kategori extends CI_Controller
{
	/**
	 * Kategori constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model("KategoriModel", "kategori", true);
	}

	public function getAll()
	{
		$dataKategori = $this->kategori->getAll();

		if ($dataKategori['total'] >= 1) {
			$code = 200;
			$return['message'] = "Data Di temukan";
			$return['success'] = true;
			$return['data'] = $dataKategori['data'];
		} else {
			$code = 404;
			$return['message'] = "Data Kosong";
			$return['success'] = false;
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));
	}

}
