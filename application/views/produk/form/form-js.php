<script src="<?= base_url() ?>/assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript">
	$(".kategori").select2({
		tags: true,
		placeholder: "Pilih Kategori"
	});

	$("#kategori").change(function () {
		$("#kategoriId").val($("#kategori").val().join());
	});

	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#imgProduk').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]); // convert to base64 string
		}
	}

	$("#gambarProduk").change(function () {
		readURL(this);
	});
</script>
