<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class=" col-12 layout-spacing">

                <?php $this->load->view("layout/alert") ?>

                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                                <h4>Detail Transaksi</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">

                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 20%;"> Nomor Transaki</th>
                                <th style="width: 80%;"> <?= nomorTransaksi($transaksi["waktuPesan"], $transaksi["idTransaksi"]) ?></th>
                            </tr>
                            <tr>
                                <th style="width: 20%;"> Nama Pemesan</th>
                                <th style="width: 80%;"> <?= $transaksi["namaPemesan"] ?></th>
                            </tr>
                            <tr>
                                <th style="width: 20%;"> Nomor Meja</th>
                                <th style="width: 80%;"> <?= $transaksi["nomorMeja"] ?></th>
                            </tr>
                            <tr>
                                <th style="width: 20%;"> Total Beli</th>
                                <th style="width: 80%;"> <?= rupiah($transaksi["totalPembelian"]) ?></th>
                            </tr>
                            <tr>
                                <th style="width: 20%;"> Total Bayar</th>
                                <th style="width: 80%;"> <?= rupiah($transaksi["totalBayar"]) ?></th>
                            </tr>
                            <tr>
                                <th style="width: 20%;"> Status</th>
                                <th style="width: 80%;"> <?= statusTransaksi($transaksi["status"]) ?></th>
                            </tr>
                            <tr>
                                <th style="width: 20%;"> Waktu Pesan</th>
                                <th style="width: 80%;"> <?= ($transaksi["waktuPesan"]) ?></th>
                            </tr>
                            <tr>
                                <th style="width: 20%;"> Waktu Bayar</th>
                                <th style="width: 80%;"> <?= ($transaksi["waktuBayar"]) ?></th>
                            </tr>
                            <tr>
                                <th style="width: 20%;"> Waktu Selesai</th>
                                <th style="width: 80%;"> <?= ($transaksi["waktuSelesai"]) ?></th>
                            </tr>
                            <tr>
                                <th style="width: 20%;"> Nama Perangkat</th>
                                <th style="width: 80%;"> <?= $transaksi["namaPerangkat"] ?></th>
                            </tr>
                        </table>

                    </div>
                </div>
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                                <h4>Daftar Produk</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <table id="zero-config" class="table table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 12%;">Kode Produk</th>
                                <th class="">Nama Produk</th>
                                <th style="width: 12%;">Harga Produk</th>
                                <th class="text-center" style="width: 5%;">Jumlah</th>
                                <th class="text-right" style="width: 15%;">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($detailTransaksi["total"] > 0):
                                foreach ($detailTransaksi["data"] as $keyTransaksi => $valueTransaksi):
                                    ?>
                                    <tr>


                                        <td class="text-center">
                                            <p class="mb-0"><?= $valueTransaksi["kodeProduk"] ?></p>
                                        </td>
                                        <td>
                                            <p class="mb-0"><?= $valueTransaksi["namaProduk"] ?></p>
                                        </td>
                                        <td>
                                            <p class="mb-0"><?= rupiah($valueTransaksi["harga"]) ?></p>
                                        </td>
                                        <td>
                                            <?= ($valueTransaksi["jumlah"]) ?>
                                        </td>
                                        <td>
                                            <p class="mb-0 text-right"><?= rupiah($valueTransaksi["jumlah"] * $valueTransaksi["harga"]) ?></p>
                                        </td>


                                    </tr>

                                <?php
                                endforeach;
                            endif;
                            ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
