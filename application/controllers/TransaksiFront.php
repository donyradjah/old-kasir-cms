<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TransaksiFront extends CI_Controller
{

    private $data;

    public function __construct()
    {
        parent::__construct();
        $this->load->model("TransaksiModel", "transaksi", true);
        $this->data["menu"] = "transaksi";

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

        $dataTransaksi = $this->transaksi->getAll();

        if ($dataTransaksi["total"] <= 0) {
            alert("warning", "Data Kosong", "");
        }


        $this->data["title"] = "Daftar Transaksi";
        $this->data["content"] = "transaksi.list";
        $this->data["transaksi"] = $dataTransaksi;

        $this->load->view('main', $this->data);
    }


    public function detail($id = 0)
    {
        $transaksi = $this->transaksi->getById($id);

        if ($transaksi["total"] > 0) {
            $this->data["transaksi"] = $transaksi["data"];
            $this->data["title"] = "Detail Transaksi #" . nomorTransaksi($this->data["transaksi"]["waktuPesan"], $this->data["transaksi"]["idTransaksi"]);
            $this->data["content"] = "transaksi.detail";
            $this->data["detailTransaksi"] = $this->UniversalModel->getAllData("detailtransaksi", "transaksiId = {$this->data["transaksi"]["idTransaksi"]}");
            $this->load->view('main', $this->data);
        } else {
            alert("danger", "Data Tidak Di Temukan", "<p> Data Yang Akan Di Ubah Sudah Terhapus");
            redirect(base_url("transaksi"));
        }

    }


}
