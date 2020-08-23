<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProdukFront extends CI_Controller
{

    private $data;
    private $firebase;

    public function __construct()
    {
        parent::__construct();
        $this->load->model("ProdukModel", "produk", true);
        $this->load->model("KategoriModel", "kategori", true);
        $this->data["menu"] = "produk";

        $factory = (new \Kreait\Firebase\Factory())->withServiceAccount('./najieb-pos-firebase-adminsdk-aq5ac-ab6850be34.json');
        $this->firebase = $factory->createDatabase();

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

        $dataProduk = $this->produk->getAll();


        if ($dataProduk["total"] <= 0) {
            alert("warning", "Data Kosong", "");
        } else {
            foreach ($dataProduk["data"] as $keyProduk => $valueProduk) {
                $dataProduk["data"][$keyProduk]["kategori"] = $this->kategori->getAll("idKategori IN ({$valueProduk["kategoriId"]})");
            }
        }

        $this->data["title"] = "Daftar Produk";
        $this->data["content"] = "produk.list";
        $this->data["produk"] = $dataProduk;


        $this->load->view('main', $this->data);
    }

    public function tambah()
    {
        $this->data["title"] = "Tambah Produk Baru";
        $this->data["content"] = "produk.form";
        $this->data["action"] = base_url("produk/simpan");
        $dataKategori = $this->kategori->getAll();

        if ($dataKategori["total"] <= 0) {
            alert("warning", "Data Kosong", "");
        }

        $this->data["kategori"] = $dataKategori;

        $this->load->view('main', $this->data);
    }

    public function simpan()
    {
        $data = [
            "namaProduk" => $_POST["namaProduk"] ?? "",
            "harga"      => $_POST["harga"] ?? "",
            "kodeProduk" => $_POST["kodeProduk"] ?? "",
            "kategoriId" => $_POST["kategoriId"] ?? "",
            "status"     => "kosong",
        ];

        $error = [];

        if (!isset($_FILES['gambarProduk']['name']) || $_FILES['gambarProduk']['name'] == "") {
            $nama_file = "default.jpg";
        } else {
            $config['upload_path'] = './upload/produk';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['encrypt_name'] = true;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('gambarProduk')) {
                $error['image'] = $this->upload->display_errors();
                $nama_file = "default.jpg";
            } else {
                $nama_file = $this->upload->data('file_name');
            }
        }

        $data['gambarProduk'] = $nama_file;

        $this->form_validation->set_rules('namaProduk', 'Nama Produk', 'required|is_unique[produk.namaProduk]');
        $this->form_validation->set_rules('kodeProduk', 'Kode Produk', 'required|is_unique[produk.kodeProduk]');
        $this->form_validation->set_rules('harga', 'Harga Produk', 'required|numeric');
        $this->form_validation->set_rules('kategoriId', 'Kategori Produk', 'required');

        if ($this->form_validation->run() == FALSE) {
            alert("danger", "Form Tidak Valid", ul($this->form_validation->error_array()));
            $this->data["produk"] = $data;
            $this->tambah();
        } elseif (isset($error) && isset($error["image"])) {
            alert("danger", "Upload Gambar Tidak Valid", "");
            $this->data["produk"] = $data;
            $this->tambah();
        } else {

            $this->db->trans_start();

            $insert = $this->produk->saveData($data);
            $id = $this->db->insert_id();
            if ($insert) {

                $this->firebase->getReference("produk/{$id}")
                    ->set($data);

                $this->db->trans_complete();

                alert("success", "Data Berhasil Di Simpan", "<p> Data Dengan Produk <b>{$data["produk"]}</b> Berhasil Di Tambahkan</p>");
                redirect(base_url("produk"));
            } else {
                alert("danger", "Data Gagal Di Simpan", "<p> Terjadi Kesalahan Di Server");
                $this->data["produk"] = $data;
                $this->tambah();
            }
        }

    }

    public function ubah($id = 0)
    {

        $produk = $this->produk->getById($id);

        if ($produk["total"] > 0) {
            $this->data["produk"] = $produk["data"];
            $this->data["title"] = "Ubah Produk";
            $this->data["content"] = "produk.form";
            $this->data["action"] = base_url("produk/simpan-ubah");
            $dataKategori = $this->kategori->getAll();

            if ($dataKategori["total"] <= 0) {
                alert("warning", "Data Kosong", "");
            }

            $this->data["kategori"] = $dataKategori;

            $this->load->view('main', $this->data);
        } else {
            alert("danger", "Data Tidak Di Temukan", "<p> Data Yang Akan Di Ubah Sudah Terhapus");
            redirect(base_url("produk"));
        }

    }

    public function simpanUbah()
    {

        $id = $_POST["idProduk"] ?? 0;

        $produk = $this->produk->getById($id);

        if ($produk["total"] > 0) {

            $data = [
                "namaProduk" => $_POST["namaProduk"] ?? $produk["data"]["namaProduk"],
                "harga"      => $_POST["harga"] ?? $produk["data"]["harga"],
                "kodeProduk" => $_POST["kodeProduk"] ?? $produk["data"]["kodeProduk"],
                "kategoriId" => $_POST["kategoriId"] ?? $produk["data"]["kategoriId"],
            ];

            $error = [];

            if (!isset($_FILES['gambarProduk']['name']) || $_FILES['gambarProduk']['name'] == "") {
                $nama_file = $produk["data"]["gambarProduk"];
            } else {
                $config['upload_path'] = './upload/produk';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['encrypt_name'] = true;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('gambarProduk')) {
                    $error['image'] = $this->upload->display_errors();
                    $nama_file = $produk["data"]["gambarProduk"];
                } else {
                    if ($produk["data"]["gambarProduk"] != "default.jpg") {
                        unlink("./upload/produk/{$produk["data"]["gambarProduk"]}");
                    }

                    $nama_file = $this->upload->data('file_name');
                }
            }

            $data['gambarProduk'] = $nama_file;

            $this->form_validation->set_rules('namaProduk', 'Nama Produk', 'required');
            $this->form_validation->set_rules('kodeProduk', 'Kode Produk', 'required');
            $this->form_validation->set_rules('harga', 'Harga Produk', 'required|numeric');
            $this->form_validation->set_rules('kategoriId', 'Kategori Produk', 'required');

            if ($this->form_validation->run() == FALSE) {
                alert("danger", "Form Tidak Valid", ul($this->form_validation->error_array()));
                $this->data["produk"] = $data;
                $this->ubah($id);
            } elseif (isset($error) && isset($error["image"])) {
                alert("danger", "Upload Gambar Tidak Valid", "");
                $this->data["produk"] = $data;
                $this->ubah($id);
            } else {
                $insert = $this->produk->updateData($id, $data);

                if ($insert) {
                    $this->firebase->getReference("produk/{$id}")
                        ->set([
                            "namaProduk"   => $_POST["namaProduk"] ?? $produk["data"]["namaProduk"],
                            "harga"        => $_POST["harga"] ?? $produk["data"]["harga"],
                            "kodeProduk"   => $_POST["kodeProduk"] ?? $produk["data"]["kodeProduk"],
                            "kategoriId"   => $_POST["kategoriId"] ?? $produk["data"]["kategoriId"],
                            'gambarProduk' => $nama_file,
                            "status"       => "kosong"
                        ]);
                    alert("success", "Data Berhasil Di Simpan", "<p> Data Dengan Produk <b>{$data["produk"]}</b> Berhasil Di Rubah</p>");
                    redirect(base_url("produk"));
                } else {
                    alert("danger", "Data Gagal Di Simpan", "<p> Terjadi Kesalahan Di Server");
                    $this->data["produk"] = $data;
                    $this->ubah($id);
                }
            }
        } else {
            alert("danger", "Data Tidak Di Temukan", "<p> Data Yang Akan Di Ubah Sudah Terhapus");
            redirect(base_url("produk"));
        }

    }


    public function hapus()
    {
        $id = $_POST["idProduk"] ?? 0;

        $produk = $this->produk->getById($id);

        if ($produk["total"] > 0) {

            $insert = $this->produk->deleteData($id);

            if ($insert) {

                if ($produk["data"]["gambarProduk"] != "default.jpg") {
                    unlink("./upload/produk/{$produk["data"]["gambarProduk"]}");
                }

                $this->firebase->getReference("produk/{$id}")->remove();

                alert("success", "Data Berhasil Di Simpan", "<p> Data Dengan Produk <b>{$produk["data"]["produk"]}</b> Berhasil Di Hapus</p>");
                redirect(base_url("produk"));
            } else {
                alert("danger", "Data Gagal Di Simpan", "<p> Terjadi Kesalahan Di Server");
                redirect(base_url("produk"));
            }
        } else {
            alert("danger", "Data Tidak Di Temukan", "<p> Data Yang Akan Di Ubah Sudah Terhapus");
            redirect(base_url("produk"));
        }
    }


}
