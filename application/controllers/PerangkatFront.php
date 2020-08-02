<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PerangkatFront extends CI_Controller
{

	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->model("PerangkatModel", "perangkat", true);
		$this->data["menu"] = "perangkat";

		$this->UserModel->isLoggedIn();
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 *        http://example.com/index.php/welcome
	 *    - or -
	 *        http://example.com/index.php/welcome/index
	 *    - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

		$dataPerangkat = $this->perangkat->getAll();

		if ($dataPerangkat["total"] <= 0) {
			alert("warning", "Data Kosong", "");
		}


		$this->data["title"] = "Daftar Perangkat";
		$this->data["content"] = "perangkat.list";
		$this->data["perangkat"] = $dataPerangkat;

		$this->load->view('main', $this->data);
	}


	public function ubah($id = 0)
	{

		$perangkat = $this->perangkat->getById($id);

		if ($perangkat["total"] > 0) {
			$this->data["perangkat"] = $perangkat["data"];
			$this->data["title"] = "Ubah Perangkat";
			$this->data["content"] = "perangkat.form";
			$this->data["action"] = base_url("perangkat/simpan-ubah");

			$this->load->view('main', $this->data);
		} else {
			alert("danger", "Data Tidak Di Temukan", "<p> Data Yang Akan Di Ubah Sudah Terhapus");
			redirect(base_url("perangkat"));
		}

	}

	public function simpanUbah()
	{

		$id = $_POST["idPerangkat"] ?? 0;

		$perangkat = $this->perangkat->getById($id);

		if ($perangkat["total"] > 0) {

			$data = [
				"nomorMeja"   => $_POST["nomorMeja"] ?? "",
				"idPerangkat" => $_POST["idPerangkat"],
			];

			$this->form_validation->set_rules('nomorMeja', 'Nomor Meja Perangkat', 'required|number|is_unique[perangkat.nomorMeja]');

			if ($this->form_validation->run() == FALSE) {
				$this->data["perangkat"] = $data;
				$this->tambah();
			} else {
				$insert = $this->perangkat->updateData($id, $data);

				if ($insert) {
					alert("success", "Data Berhasil Di Simpan", "<p> Data Dengan Perangkat <b>{$data["perangkat"]}</b> Berhasil Di Rubah</p>");
					redirect(base_url("perangkat"));
				} else {
					alert("danger", "Data Gagal Di Simpan", "<p> Terjadi Kesalahan Di Server");
					$this->data["perangkat"] = $data;
					$this->tambah();
				}
			}
		} else {
			alert("danger", "Data Tidak Di Temukan", "<p> Data Yang Akan Di Ubah Sudah Terhapus");
			redirect(base_url("perangkat"));
		}

	}


	public function hapus()
	{
		$id = $_POST["idPerangkat"] ?? 0;

		$perangkat = $this->perangkat->getById($id);

		if ($perangkat["total"] > 0) {

			$insert = $this->perangkat->deleteData($id);

			if ($insert) {
				alert("success", "Data Berhasil Di Simpan", "<p> Data Dengan Perangkat <b>{$perangkat["data"]["perangkat"]}</b> Berhasil Di Hapus</p>");
				redirect(base_url("perangkat"));
			} else {
				alert("danger", "Data Gagal Di Simpan", "<p> Terjadi Kesalahan Di Server");
				redirect(base_url("perangkat"));
			}
		} else {
			alert("danger", "Data Tidak Di Temukan", "<p> Data Yang Akan Di Ubah Sudah Terhapus");
			redirect(base_url("perangkat"));
		}
	}
}
