<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserFront extends CI_Controller
{

	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->model("UserModel", "user", true);
		$this->data["menu"] = "user";

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

		$dataUser = $this->user->getAll();

		if ($dataUser["total"] <= 0) {
			alert("warning", "Data Kosong", "");
		}


		$this->data["title"] = "Daftar User";
		$this->data["content"] = "user.list";
		$this->data["user"] = $dataUser;

		$this->load->view('main', $this->data);
	}

	public function tambah()
	{
		$this->data["title"] = "Tambah User Baru";
		$this->data["content"] = "user.form";
		$this->data["action"] = base_url("user/simpan");

		$this->load->view('main', $this->data);
	}

	public function simpan()
	{
		$data = [
			"nama"     => $_POST["nama"] ?? "",
			"username" => $_POST["username"] ?? "",
			"email"    => $_POST["email"] ?? "",
			"password" => $_POST["password"] ?? "",
		];

		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			alert("danger", "Form Tidak Valid", "");
			$this->data["user"] = $data;
			$this->tambah();
		} else {
			if ($data["password"] != "") {
				$data["password"] = crypt($data["password"]);
			}
			$insert = $this->user->saveData($data);

			if ($insert) {
				alert("success", "Data Berhasil Di Simpan", "<p> Data Dengan User <b>{$data["nama"]}</b> Berhasil Di Tambahkan</p>");
				redirect(base_url("user"));
			} else {
				alert("danger", "Data Gagal Di Simpan", "<p> Terjadi Kesalahan Di Server");
				$this->data["user"] = $data;
				$this->tambah();
			}
		}

	}

	public function ubah($id = 0)
	{

		$user = $this->user->getById($id);

		if ($user["total"] > 0) {
			$this->data["user"] = $user["data"];
			$this->data["title"] = "Ubah User";
			$this->data["content"] = "user.form";
			$this->data["action"] = base_url("user/simpan-ubah");

			$this->load->view('main', $this->data);
		} else {
			alert("danger", "Data Tidak Di Temukan", "<p> Data Yang Akan Di Ubah Sudah Terhapus");
			redirect(base_url("user"));
		}

	}

	public function simpanUbah()
	{

		$id = $_POST["idUser"] ?? 0;

		$user = $this->user->getById($id);

		if ($user["total"] > 0) {

			$data = [
				"nama"     => $_POST["nama"] ?? "",
				"username" => $_POST["username"] ?? "",
				"email"    => $_POST["email"] ?? "",
				"password" => $_POST["password"] ?? "",
			];

			$this->form_validation->set_rules('nama', 'Nama', 'required');

			if ($data["username"] != $user["data"]["username"]) {
				$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');
			} else {
				$this->form_validation->set_rules('username', 'Username', 'required');
			}

			if ($data["email"] != $user["data"]["email"]) {
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email_user]');
			} else {
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			}

			if ($data["password"] != "") {
				$this->form_validation->set_rules('password', 'Password', '');
				$this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', '');
			}

			if ($this->form_validation->run() == FALSE) {
				$this->data["user"] = $data;
				$this->ubah($id);
			} else {

				if ($data["password"] != "") {
					$data["password"] = crypt($data["password"]);
				} else {
					unset($data["password"]);
				}

				$insert = $this->user->updateData($id, $data);

				if ($insert) {
					if ($id == $_SESSION["idUser"]) {
						$user = $this->user->getById($id)["data"];
						$user["loggedin"] = true;
						$user["nama_depan"] = explode(" ", $user["nama_user"])[0];
						$this->session->set_userdata($user);
					}
					alert("success", "Data Berhasil Di Simpan", "<p> Data Dengan User <b>{$data["nama"]}</b> Berhasil Di Rubah</p>");
					redirect(base_url("user"));
				} else {
					alert("danger", "Data Gagal Di Simpan", "<p> Terjadi Kesalahan Di Server");
					$this->data["user"] = $data;
					$this->ubah($id);
				}
			}
		} else {
			alert("danger", "Data Tidak Di Temukan", "<p> Data Yang Akan Di Ubah Sudah Terhapus");
			redirect(base_url("user"));
		}

	}


	public function hapus()
	{
		$id = $_POST["idUser"] ?? 0;

		$user = $this->user->getById($id);

		if ($user["total"] > 0) {

			$insert = $this->user->deleteData($id);

			if ($insert) {
				alert("success", "Data Berhasil Di Simpan", "<p> Data Dengan User <b>{$user["data"]["nama"]}</b> Berhasil Di Hapus</p>");
				redirect(base_url("user"));
			} else {
				alert("danger", "Data Gagal Di Simpan", "<p> Terjadi Kesalahan Di Server");
				redirect(base_url("user"));
			}
		} else {
			alert("danger", "Data Tidak Di Temukan", "<p> Data Yang Akan Di Ubah Sudah Terhapus");
			redirect(base_url("user"));
		}
	}
}
