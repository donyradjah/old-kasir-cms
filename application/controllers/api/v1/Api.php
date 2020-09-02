<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 5/23/2020
 * Time: 11:06 AM
 */

class Api extends CI_Controller
{
    private $firebase, $messaging;

    /**
     * Kategori constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("KategoriModel", "kategori", true);
        $this->load->model("PerangkatModel", "perangkat", true);
        $this->load->model("ProdukModel", "produk", true);

        $factory = (new \Kreait\Firebase\Factory())->withServiceAccount('./najieb-pos-firebase-adminsdk-aq5ac-ab6850be34.json');
        $this->firebase = $factory->createDatabase();
        $this->messaging = $factory->createMessaging();
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

    public function gantiStatus()
    {
        $id = $_POST["idProduk"] ?? 0;

        $produk = $this->produk->getById($id);

        if ($produk["total"] > 0) {
            $data = [
                "status" => $_POST["status"] ?? "kosong",
            ];

            $insert = $this->produk->updateData($id, $data);

            if ($insert) {
                $produk["data"]["status"] = $_POST["status"] ?? "kosong";
                $this->firebase->getReference("produk/{$id}")
                    ->set($produk["data"]);
                $response = [
                    "success" => true,
                    "pesan"   => "Berhasil Menyimpan Data"
                ];
            } else {
                $response = [
                    "success" => false,
                    "pesan"   => "Gagal Menyimpan Data"
                ];
            }
        } else {
            $response = [
                "success" => false,
                "pesan"   => "Data Tidak Di Temukan"
            ];
        }


        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($response));
    }

    public function simpanBayar()
    {
        $id = $_POST["idTransaksi"] ?? 0;
        $bayar = $_POST["totalBayar"] ?? 0;

        $produk = $this->UniversalModel->getOneData("transaksi", "IdTransaksi = {$id}");

        if ($produk["total"] > 0) {
            $data = [
                "totalBayar"  => $bayar,
                "waktuBayar`" => date("Y-m-d H:i:s"),
                "status`"     => "proses",
            ];

            $insert = $this->UniversalModel->update("transaksi", "IdTransaksi = {$id}", $data);

            if ($insert) {
                $produk["data"]["status"] = $_POST["status"] ?? "kosong";
                $this->firebase->getReference("transaksi/{$id}/totalBayar")
                    ->set($bayar);
                $this->firebase->getReference("transaksi/{$id}/waktuBayar")
                    ->set(date("Y-m-d H:i:s"));
                $this->firebase->getReference("transaksi/{$id}/status")
                    ->set("proses");

                $response = [
                    "success" => true,
                    "pesan"   => "Berhasil Menyimpan Data"
                ];

                $transaksiBelum = $this->UniversalModel->getAllData("transaksi", "status = 'belum-bayar'");

                $this->firebase->getReference("transaksi-belum")
                    ->set($transaksiBelum["total"]);

                $transaksiBelum = $this->UniversalModel->getAllData("transaksi", "status = 'proses'");

                if ($transaksiBelum["total"] > 0) {
                    $message = \Kreait\Firebase\Messaging\CloudMessage::withTarget('topic', "dapur")
                        ->withNotification(\Kreait\Firebase\Messaging\Notification::create('Pesanan Baru', "Ada {$transaksiBelum["total"]} Transaksi Baru")) // optional
                        ->withData(["transaksibaru" => $transaksiBelum["total"]]);

                    $this->messaging->send($message);
                }


                $this->firebase->getReference("transaksi-proses")
                    ->set($transaksiBelum["total"]);


            } else {
                $response = [
                    "success" => false,
                    "pesan"   => "Gagal Menyimpan Data"
                ];
            }
        } else {
            $response = [
                "success" => false,
                "pesan"   => "Data Tidak Di Temukan"
            ];
        }


        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($response));
    }

    public function transaksiBatal()
    {
        $id = $_POST["idTransaksi"] ?? 0;

        $produk = $this->UniversalModel->getOneData("transaksi", "IdTransaksi = {$id}");

        if ($produk["total"] > 0) {
            $data = [
                "waktuSelesai`" => date("Y-m-d H:i:s"),
                "status`"       => "batal",
            ];

            $insert = $this->UniversalModel->update("transaksi", "IdTransaksi = {$id}", $data);

            if ($insert) {
                $produk["data"]["status"] = $_POST["status"] ?? "kosong";
                $this->firebase->getReference("transaksi/{$id}/waktuSelesai")
                    ->set(date("Y-m-d H:i:s"));
                $this->firebase->getReference("transaksi/{$id}/status")
                    ->set("batal");

                $response = [
                    "success" => true,
                    "pesan"   => "Berhasil Menyimpan Data"
                ];

                $transaksiBelum = $this->UniversalModel->getAllData("transaksi", "status = 'belum-bayar'");

                if ($transaksiBelum["total"] > 0) {
                    $message = \Kreait\Firebase\Messaging\CloudMessage::withTarget('topic', "kasir")
                        ->withNotification(\Kreait\Firebase\Messaging\Notification::create('Pesanan Baru', "Ada {$transaksiBelum["total"]} Transaksi Baru")) // optional
                        ->withData(["transaksibaru" => $transaksiBelum["total"]]);

                    $this->messaging->send($message);
                }

                $this->firebase->getReference("transaksi-belum")
                    ->set($transaksiBelum["total"]);

                $transaksiBelum = $this->UniversalModel->getAllData("transaksi", "status = 'proses'");

                if ($transaksiBelum["total"] > 0) {
                    $message = \Kreait\Firebase\Messaging\CloudMessage::withTarget('topic', "dapur")
                        ->withNotification(\Kreait\Firebase\Messaging\Notification::create('Pesanan Baru', "Ada {$transaksiBelum["total"]} Transaksi Baru")) // optional
                        ->withData(["transaksibaru" => $transaksiBelum["total"]]);

                    $this->messaging->send($message);
                }

                $this->firebase->getReference("transaksi-proses")
                    ->set($transaksiBelum["total"]);


            } else {
                $response = [
                    "success" => false,
                    "pesan"   => "Gagal Menyimpan Data"
                ];
            }
        } else {
            $response = [
                "success" => false,
                "pesan"   => "Data Tidak Di Temukan"
            ];
        }


        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($response));
    }

    public function simpanTransaksiBaru()
    {
        $transaksi = json_decode($_POST["transaksi"], TRUE);

        $idPerangkat = $transaksi["idPerangkat"];
        $uniqueId = $transaksi["uniqueId"];
        $namaPemesan = $transaksi["namaPemesan"];
        $totalPembelian = $transaksi["totalPembelian"];

        $perangkat = $this->perangkat->getById($idPerangkat);
        $perangkat = $perangkat["data"];

        $dataTransaksi = [
            "perangkatId"    => $idPerangkat,
            "namaPemesan"    => $namaPemesan,
            "waktuPesan`"    => date("Y-m-d H:i:s"),
            "status"         => "belum-bayar",
            "totalPembelian" => $totalPembelian,
            "namaPerangkat"  => $perangkat["namaPerangkat"],
            "nomorMeja"      => $perangkat["nomorMeja"],
            "totalBayar"     => 0,
        ];

        $simpan = $this->UniversalModel->insert("transaksi", $dataTransaksi);

        if ($simpan["success"]) {
            $idTransaksi = $simpan["id"];
            $detailTransaksi = [];
            foreach ($transaksi["produks"] as $keyProduk => $valueProduk) {
                $detailTransaksi[] = [
                    'transaksiId'    => $idTransaksi,
                    'produkId'       => $valueProduk["id"],
                    'namaProduk'     => $valueProduk["namaProduk"],
                    'kategoriProduk' => $valueProduk["kategoriId"],
                    'kodeProduk'     => $valueProduk["kodeProduk"],
                    'harga'          => $valueProduk["harga"],
                    'jumlah'         => $valueProduk["qty"],
                    'pesan'          => "",
                ];
            }

            $simpan = $this->UniversalModel->insertBatch("detailtransaksi", $detailTransaksi);

            if ($simpan["success"]) {

                $transaksiFirebase = $this->UniversalModel->getOneData("transaksi", "idTransaksi = {$idTransaksi}");
                $transaksiFirebase = $transaksiFirebase["data"];
                $transaksiFirebase["detailTransaksi"] = $detailTransaksi;

                $this->firebase->getReference("transaksi/{$idTransaksi}")
                    ->set($transaksiFirebase);

                $response = [
                    "success"     => true,
                    "pesan"       => "Tranasksi Berhasil",
                    "idTransaksi" => $idTransaksi
                ];
            } else {
                $response = [
                    "success" => false,
                    "pesan"   => "Terjadi Kesalahan"
                ];
            }
        } else {
            $response = [
                "success" => false,
                "pesan"   => "Terjadi Kesalahan"
            ];
        }

        $transaksiBelum = $this->UniversalModel->getAllData("transaksi", "status = 'belum-bayar'");

        if ($transaksiBelum["total"] > 0) {
            $message = \Kreait\Firebase\Messaging\CloudMessage::withTarget('topic', "kasir")
                ->withNotification(\Kreait\Firebase\Messaging\Notification::create('Pesanan Baru', "Ada {$transaksiBelum["total"]} Transaksi Baru")) // optional
                ->withData(["transaksibaru" => $transaksiBelum["total"]]);

            $this->messaging->send($message);
        }

        $this->firebase->getReference("transaksi-belum")
            ->set($transaksiBelum["total"]);

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($response));
    }

    public function simpanSelesai()
    {
        $id = $_POST["idTransaksi"] ?? 0;

        $produk = $this->UniversalModel->getOneData("transaksi", "IdTransaksi = {$id}");

        if ($produk["total"] > 0) {
            $data = [
                "waktuSelesai`" => date("Y-m-d H:i:s"),
                "status`"       => "selesai",
            ];

            $insert = $this->UniversalModel->update("transaksi", "IdTransaksi = {$id}", $data);

            if ($insert) {
                $produk["data"]["status"] = $_POST["status"] ?? "kosong";
                $this->firebase->getReference("transaksi/{$id}/waktuSelesai")
                    ->set(date("Y-m-d H:i:s"));
                $this->firebase->getReference("transaksi/{$id}/status")
                    ->set("selesai");

                $response = [
                    "success" => true,
                    "pesan"   => "Berhasil Menyimpan Data"
                ];

                $transaksiBelum = $this->UniversalModel->getAllData("transaksi", "status = 'belum-bayar'");

                if ($transaksiBelum["total"] > 0) {
                    $message = \Kreait\Firebase\Messaging\CloudMessage::withTarget('topic', "kasir")
                        ->withNotification(\Kreait\Firebase\Messaging\Notification::create('Pesanan Baru', "Ada {$transaksiBelum["total"]} Transaksi Baru")) // optional
                        ->withData(["transaksibaru" => $transaksiBelum["total"]]);

                    $this->messaging->send($message);
                }

                $this->firebase->getReference("transaksi-belum")
                    ->set($transaksiBelum["total"]);

                $transaksiBelum = $this->UniversalModel->getAllData("transaksi", "status = 'proses'");

                if ($transaksiBelum["total"] > 0) {
                    $message = \Kreait\Firebase\Messaging\CloudMessage::withTarget('topic', "dapur")
                        ->withNotification(\Kreait\Firebase\Messaging\Notification::create('Pesanan Baru', "Ada {$transaksiBelum["total"]} Transaksi Baru")) // optional
                        ->withData(["transaksibaru" => $transaksiBelum["total"]]);

                    $this->messaging->send($message);
                }

                $this->firebase->getReference("transaksi-proses")
                    ->set($transaksiBelum["total"]);


            } else {
                $response = [
                    "success" => false,
                    "pesan"   => "Gagal Menyimpan Data"
                ];
            }
        } else {
            $response = [
                "success" => false,
                "pesan"   => "Data Tidak Di Temukan"
            ];
        }


        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($response));
    }
}
