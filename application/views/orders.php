<section class="section">
	<div class="section-body">
		<div class="card">
			<div class="card-header">
				<h4>Keranjang</h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table class="table table-striped" id="table-1">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th>Nama Perusahan</th>
										<th>No. HP</th>
										<th>Alamat</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;
									foreach ($orders as $data) : ?>
										<tr>
											<td><?= $i++; ?></td>
											<td><?= $data->namaPT; ?></td>
											<td><?= $data->nohp; ?></td>
											<td><?= $data->alamat; ?></td>
											<td>
												<div class="dropdown">
													<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Action
													</button>
													<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
														<a href="javascript:void(0)" class="dropdown-item list_btn" data-toggle="modal" data-target="#listBarang" data-idkhusus="<?= $data->idKhusus; ?>"><i class="fas fa-arrow-left"></i> List Barang</a>
														<a href="javascript:void(0)" class="dropdown-item progres_btn" data-toggle="modal" data-target="#progresPesanan" data-idkhusus="<?= $data->idKhusus; ?>"><i class="fas fa-arrow-left"></i> Progres</a>
													</div>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade" id="listBarang" tabindex="-1" role="dialog" aria-labelledby="listBarangTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">List Barang</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<div id="tampil-list" class="d-none">
								<div class="table-responsive" style="overflow-y: auto; max-height: 500px;">
									<table class="table table-bordered table-hover table-vcenter" id="tabel-list">
										<thead>
											<tr>
												<th class="text-center">#</th>
												<th>Kode Barang</th>
												<th>Nama Barang</th>
												<th>Gambar</th>
											</tr>
										</thead>
										<tbody id="isi_table-list">

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- modal progres pesanan -->
<div class="modal fade" id="progresPesanan" tabindex="-1" role="dialog" aria-labelledby="progresPesananTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Progres Pesanan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<div id="tampil-progres" class="d-none">
								<div class="table-responsive" style="overflow-y: auto; max-height: 500px;">
									<table class="table table-bordered table-hover table-vcenter" id="tabel-progres">
										<thead>
											<tr>
												<th class="text-center">#</th>
												<th>Status</th>
												<th>Tanggal</th>
												<th>Keterangan</th>
											</tr>
										</thead>
										<tbody id="isi_table-progres">

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
	let list_btn = $('.list_btn');

	$(list_btn).each(function(i) {
		$(list_btn[i]).click(function() {
			let idKhusus = $(this).data('idkhusus');

			$.ajax({
				url: `<?= base_url('user/orders/getListBarang'); ?>`,
				type: 'get',
				dataType: 'json',
				data: {
					idKhusus
				},
				async: true,
				beforeSend: function(e) {
					$('#tampil-list').addClass('d-none');
				},
				success: function(res) {
					$('#tampil-list').removeClass('d-none');
					$('.tr_isi-list').remove();

					console.log(res);

					if (res.data != null) {
						$(res.data).each(function(i) {
							$("#tabel-list").append(
								`<tr class='tr_isi-list'>
                                <td class='text-center'>${i + 1}</td>
                                <td>${res.data[i].kodeBarang}</td>
                                <td>${res.data[i].namaBarang}</td>
                                <td><img src="<?= base_url('uploads/gambar/'); ?>${res.data[i].gambar}" width="100" class="img-fluid img-thumbnail" alt="${res.data[i].namaBarang}"></td>
                                <tr>`
							);
						});

					} else {
						$("#tabel-list").append(
							"<tr class='tr_isi-list'>" +
							"<td colspan='4' class='text-center'>Kosong</td>" +
							"<tr>");
					}
				},
				complete: function() {
					$('#tampil-list').removeClass('d-none');
				}
			});
		});
	});

	let progres_btn = $('.progres_btn');

	$(progres_btn).each(function(i) {
		$(progres_btn[i]).click(function() {
			let idKhusus = $(this).data('idkhusus');

			$.ajax({
				url: `<?= base_url('user/orders/getListProgres'); ?>`,
				type: 'get',
				dataType: 'json',
				data: {
					idKhusus
				},
				async: true,
				beforeSend: function(e) {
					$('#tampil-progres').addClass('d-none');
				},
				success: function(res) {
					$('#tampil-progres').removeClass('d-none');
					$('.tr_isi-progres').remove();

					if (res.data != null) {
						$(res.data).each(function(i) {
							$("#tabel-progres").append(
								`<tr class='tr_isi-progres'>
                                <td class='text-center'>${i + 1}</td>
                                <td>${res.data[i].status}</td>
                                <td>${(res.data[i].tanggal != null) ? res.data[i].tanggal : ''}</td>
                                <td>${(res.data[i].ket != null) ? res.data[i].ket : ''}</td>
                                <tr>`
							);
						});

					} else {
						$("#tabel-progres").append(
							"<tr class='tr_isi-progres'>" +
							"<td colspan='4' class='text-center'>Kosong</td>" +
							"<tr>");
					}
				},
				complete: function() {
					$('#tampil-progres').removeClass('d-none');
				}
			});
		});
	});
</script>