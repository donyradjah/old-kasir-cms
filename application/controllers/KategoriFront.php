<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KategoriFront extends CI_Controller
{

	private $data;
	private $firebase;

	public function __construct()
	{
		parent::__construct();
		$this->load->model("KategoriModel", "kategori", true);
		$this->data["menu"] = "kategori";
		$factory = (new \Kreait\Firebase\Factory())->withServiceAccount('./najieb-pos-firebase-adminsdk-aq5ac-ab6850be34.json');
		$this->firebase = $factory->createDatabase();
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

		$dataKategori = $this->kategori->getAll();

		if ($dataKategori["total"] <= 0) {
			alert("warning", "Data Kosong", "");
		}


		$this->data["title"] = "Daftar Kategori";
		$this->data["content"] = "kategori.list";
		$this->data["kategori"] = $dataKategori;

		$this->load->view('main', $this->data);
	}

	public function tambah()
	{
		$this->data["title"] = "Tambah Kategori Baru";
		$this->data["content"] = "kategori.form";
		$this->data["action"] = base_url("kategori/simpan");

		$this->load->view('main', $this->data);
	}

	public function simpan()
	{
		$data = [
			"kategori" => $_POST["kategori"] ?? ""
		];


		$this->form_validation->set_rules('kategori', 'Kategori', 'required|is_unique[kategori.kategori]');

		if ($this->form_validation->run() == FALSE) {
			alert("danger", "Form Tidak Valid", "");
			$this->data["kategori"] = $data;
			$this->tambah();
		} else {
			$this->db->trans_start();
			$insert = $this->kategori->saveData($data);

			if ($insert) {
				$this->firebase->getReference('kategori/' + $this->db->insert_id())
					->set($data);

				$this->db->trans_complete();

				alert("success", "Data Berhasil Di Simpan", "<p> Data Dengan Kategori <b>{$data["kategori"]}</b> Berhasil Di Tambahkan</p>");
				redirect(base_url("kategori"));
			} else {
				alert("danger", "Data Gagal Di Simpan", "<p> Terjadi Kesalahan Di Server");
				$this->data["kategori"] = $data;
				$this->tambah();
			}
		}

	}

	public function ubah($id = 0)
	{

		$kategori = $this->kategori->getById($id);

		if ($kategori["total"] > 0) {
			$this->data["kategori"] = $kategori["data"];
			$this->data["title"] = "Ubah Kategori";
			$this->data["content"] = "kategori.form";
			$this->data["action"] = base_url("kategori/simpan-ubah");

			$this->load->view('main', $this->data);
		} else {
			alert("danger", "Data Tidak Di Temukan", "<p> Data Yang Akan Di Ubah Sudah Terhapus");
			redirect(base_url("kategori"));
		}

	}

	public function simpanUbah()
	{

		$id = $_POST["idKategori"] ?? 0;

		$kategori = $this->kategori->getById($id);

		if ($kategori["total"] > 0) {

			$data = [
				"kategori"   => $_POST["kategori"],
				"idKategori" => $_POST["idKategori"],
			];

			$this->form_validation->set_rules('kategori', 'Kategori', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->data["kategori"] = $data;
				$this->tambah();
			} else {
				$insert = $this->kategori->updateData($id, $data);

				if ($insert) {
					$this->firebase->getReference("kategori/{$id}")
						->set(["kategori" => $_POST["kategori"],]);

					alert("success", "Data Berhasil Di Simpan", "<p> Data Dengan Kategori <b>{$data["kategori"]}</b> Berhasil Di Rubah</p>");
					redirect(base_url("kategori"));
				} else {
					alert("danger", "Data Gagal Di Simpan", "<p> Terjadi Kesalahan Di Server");
					$this->data["kategori"] = $data;
					$this->tambah();
				}
			}
		} else {
			alert("danger", "Data Tidak Di Temukan", "<p> Data Yang Akan Di Ubah Sudah Terhapus");
			redirect(base_url("kategori"));
		}

	}


	public function hapus()
	{
		$id = $_POST["idKategori"] ?? 0;

		$kategori = $this->kategori->getById($id);

		if ($kategori["total"] > 0) {

			$insert = $this->kategori->deleteData($id);

			if ($insert) {
				$this->firebase->getReference("kategori/{$id}")->remove();

				alert("success", "Data Berhasil Di Simpan", "<p> Data Dengan Kategori <b>{$kategori["data"]["kategori"]}</b> Berhasil Di Hapus</p>");
				redirect(base_url("kategori"));
			} else {
				alert("danger", "Data Gagal Di Simpan", "<p> Terjadi Kesalahan Di Server");
				redirect(base_url("kategori"));
			}
		} else {
			alert("danger", "Data Tidak Di Temukan", "<p> Data Yang Akan Di Ubah Sudah Terhapus");
			redirect(base_url("kategori"));
		}
	}
}
