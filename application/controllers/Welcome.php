<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	private $data;
	private $firebase;


	public function __construct()
	{
		parent::__construct();

		$this->load->model("UserModel");
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

		$this->UserModel->isLoggedIn();
		$return = [
			"title"   => "Dashboard",
			"content" => "dashboard",
			"menu"    => "dashboard"
		];

		$this->load->view('main', $return);
	}

	public function login()
	{

		$this->data["title"] = "Login";
		$this->data["content"] = "login";
		$this->data["menu"] = "login";


		$this->load->view('login', $this->data);
	}

	public function logout()
	{
		$this->session->unset_userdata(array("idUser", "loggedin"));


		// Remove local Facebook session
		// Remove user data from session
		$this->session->unset_userdata('userData');
		// Redirect to login page

		redirect(base_url("login"));
	}

	public function submitLogin()
	{
		$email = $_POST["username"] ?? "";
		$password = $_POST["password"] ?? "";

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			alert("danger", "Form Tidak Valid", "");
			$this->data["username"] = $email;
			$this->login();
		} else {
			$userData = $this->UserModel->getAll("username = '{$email}' OR email = '{$email}'");

			if ($userData["total"] > 0) {
				$found = 0;
				$user = [];
				foreach ($userData["data"] as $keyUser => $valueUser) {
					if (crypt($password, $valueUser["password"]) == $valueUser["password"]) {
						$found++;
						$user = $valueUser;
						break;
					}
				}

				if ($found > 0) {
					$user["loggedin"] = true;
					$user["nama_depan"] = explode(" ", $user["nama_user"])[0];
					$this->session->set_userdata($user);

					redirect(base_url());
				} else {
					alert("warning", "Password Salah", "");
					$this->data["username"] = $email;
					$this->login();
				}
			} else {
				alert("warning", "Username/Email Tidak Di Temukan", "");
				$this->data["username"] = $email;
				$this->login();
			}
		}
	}

	public function coba()
	{

		$reference = $db->getReference("transaksi");

		$db->getReference('transaksi')
			->set([
				'name'    => 'My Application',
				'emails'  => [
					'support' => 'support@domain.tld',
					'sales'   => 'sales@domain.tld',
				],
				'website' => 'https://app.domain.tld',
			]);

		$db->getReference('transaksi/name')->set('New name');
	}
}
