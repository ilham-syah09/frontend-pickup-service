<section class="section">
	<div class="section-body">
		<!-- main -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped" id="table-1">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th>Nama Paket</th>
										<th>Ekspedisi</th>
										<th>Total Biaya</th>
										<th>Payment Type</th>
										<th>Bank</th>
										<th>VA Numbers</th>
										<th>PDF</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;
									foreach ($paket as $data) : ?>
										<tr>
											<td><?= $i++; ?></td>
											<td><?= $data->namaPaket; ?></td>
											<td><?= $data->ekspedisi; ?></td>
											<td>Rp. <?= number_format($data->totalBiaya); ?></td>
											<td><?= $data->payment_type; ?></td>
											<td><?= $data->bank; ?></td>
											<td><?= $data->va_numbers; ?></td>
											<td>
												<?php if ($data->status_code != null) : ?>
													<a href="<?= $data->pdf_url; ?>" class="btn btn-info" target="_blank">Download</a>
												<?php endif; ?>
											</td>
											<td>
												<?php if ($data->status_code != null) : ?>
													<?php if ($data->status_code == 200) : ?>
														<span class="badge badge-success text-dark">Success</span>
													<?php else : ?>
														<span class="badge badge-warning text-dark">Pending</span>
													<?php endif; ?>
												<?php endif; ?>
											</td>
											<td>
												<?php if ($data->status_code == null) : ?>
													<button class="btn btn-primary pay-button" data-namapaket="<?= $data->namaPaket . ' - ' . $data->ekspedisi; ?>" data-jmlbayar="<?= $data->totalBiaya; ?>" data-idpaket="<?= $data->id; ?>"><i class="fa fa-coins"></i></button>
												<?php endif; ?>
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
		<!-- end main -->
	</div>
</section>

<form id="payment-form" method="post" action="<?= base_url('pembayaran/finish'); ?>">
	<input type="hidden" name="result_type" id="result-type">
	<input type="hidden" name="result_data" id="result-data">
	<input type="hidden" name="idPaket" id="idPaket">
	<input type="hidden" name="jmlBayar" id="jmlBayar">
	<input type="hidden" name="namaPaket" id="namaPaket">
</form>

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-Mrk4g1k1F9VriMHn"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<script>
	let payButton = $('.pay-button');

	$(payButton).each(function(i) {
		$(payButton[i]).click(function(event) {
			event.preventDefault();
			$(this).prop("disabled", true);

			let idPaket = $(this).data('idpaket');
			let jmlBayar = $(this).data('jmlbayar');
			let namaPaket = $(this).data('namapaket');

			$('#idPaket').val(idPaket);
			$('#jmlBayar').val(jmlBayar);
			$('#namaPaket').val(namaPaket);

			$.ajax({
				type: 'POST',
				url: '<?= base_url('pembayaran/token') ?>',
				data: {
					jmlBayar,
					namaPaket
				},
				cache: false,

				success: function(data) {
					function changeResult(type, data) {
						$("#result-type").val(type);
						$("#result-data").val(JSON.stringify(data));
					}

					snap.pay(data, {
						onSuccess: function(result) {
							changeResult('success', result);
							console.log(result.status_message);
							console.log(result);
							$("#payment-form").submit();
						},
						onPending: function(result) {
							changeResult('pending', result);
							console.log(result.status_message);
							$("#payment-form").submit();
						},
						onError: function(result) {
							changeResult('error', result);
							console.log(result.status_message);
							$("#payment-form").submit();
						}
					});
				}
			});
		});
	});
</script>