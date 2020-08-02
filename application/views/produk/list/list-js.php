<script type="text/javascript">
	// checkall('todoAll', 'todochkbox');
</script>
<script src="<?= base_url() ?>/assets/plugins/table/datatable/datatables.js"></script>
<script>
	$('#zero-config').DataTable({
		"oLanguage": {
			"oPaginate": {
				"sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
				"sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
			},
			"sInfo": "Showing page _PAGE_ of _PAGES_",
			"sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
			"sSearchPlaceholder": "Search...",
			"sLengthMenu": "Results :  _MENU_",
		}
	});


	function hapus(id, title) {
		swal({
			title: 'Apa Anda Yakin Akan Menghapus ' + title + " ?",
			text: "Setelah Di Hapus Data Tidak Bisa Di Kembalikan",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Hapus',
			cancelButtonText: 'Batal',
			padding: '2em'
		}).then(function (result) {
			if (result.value) {
				$.redirect("<?= base_url() ?>produk/hapus", {idProduk: id}, "POST");
			}
		})
	}


	function gantiStatus(id) {
		$.blockUI({
			message: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>',
			fadeIn: 800,
			overlayCSS: {
				backgroundColor: '#1b2024',
				opacity: 0.8,
				zIndex: 1200,
				cursor: 'wait'
			},
			css: {
				border: 0,
				color: '#fff',
				zIndex: 1201,
				padding: 0,
				backgroundColor: 'transparent'
			}
		});

		var status = $('#status-' + id).is(':checked');

		var request = $.ajax({
			"url": "<?= base_url("produk/ganti-status") ?>",
			"method": "POST",
			"data": {
				"idProduk": id,
				"status": status ? "tersedia" : "kosong"
			}
		});

		request.done(function (data, status, error) {
			if (data.success) {
				swal({
					title: 'Berhasil',
					text: "Status Berubah Menjadi " + (status ? "Tersedia" : "Kosong"),
					type: 'success',
					padding: '2em'
				})
			} else {
				swal({
					title: 'Gagal',
					text: "Status Gagal Di Rubah",
					type: 'error',
					padding: '2em'
				});

			}
		});

		request.always(function (data, status, error) {
			$.unblockUI();
		});

		request.fail(function (data, status, error) {
			swal({
				title: 'Gagal',
				text: "Status Gagal Di Rubah",
				type: 'error',
				padding: '2em'
			})
		});

	}


</script>
