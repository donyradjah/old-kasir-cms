<div id="content" class="main-content">
	<div class="layout-px-spacing">

		<div class="row layout-top-spacing">

			<div class=" col-12 layout-spacing">

				<?php $this->load->view("layout/alert") ?>

				<div class="statbox widget box box-shadow">
					<div class="widget-header">
						<div class="row">
							<div class="col-xl-6 col-md-6 col-sm-6 col-6">
								<h4>Daftar Transaksi</h4>
							</div>
						</div>
					</div>
					<div class="widget-content widget-content-area">
						<table id="zero-config" class="table table-hover" style="width:100%">
							<thead>
							<tr>

								<th style="width: 15%;" class="">Nomor Transaksi</th>
								<th style="width: 10%;" class="">Nomor Meja</th>
								<th style="width: 15%;" class="">Nama Pemesan</th>
								<th style="width: 15%;" class="">Total Pembayaran</th>
								<th style="width: 35%;" class="">Status</th>
								<th class="text-center">AKSI</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($transaksi["total"] > 0):
								foreach ($transaksi["data"] as $keyTransaksi => $valueTransaksi):
									?>
									<tr>

										<td>
											<p class="mb-0"><?= nomorTransaksi($valueTransaksi["waktuPesan"], $valueTransaksi["idTransaksi"]) ?></p>
										</td>
										<td class="text-center">
											<p class="mb-0"><?= $valueTransaksi["nomorMeja"] ?></p>
										</td>
										<td>
											<p class="mb-0"><?= $valueTransaksi["namaPemesan"] ?></p>
										</td>
										<td>
											<p class="mb-0"><?= rupiah($valueTransaksi["totalPembelian"]) ?></p>
										</td>
										<td>
											<?= statusTransaksi($valueTransaksi["status"]) ?>
										</td>

										<td class="text-center">
											<ul class="table-controls">
												<li>
													<a href="<?= base_url("transaksi/detail/{$valueTransaksi["idTransaksi"]}") ?>"
													   data-toggle="tooltip"
													   data-placement="top"
													   title="" data-original-title="Detail Transaksi">
														<i class="text-primary" data-feather="eye"></i>
													</a>
												</li>

											</ul>
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
