<section class="section">
	<div class="section-body">
		<!-- main -->
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<select name="by_paket" id="by_paket" class="form-control">
							<option value="">-- Pilih Paket --</option>
							<?php if ($paket) : ?>
								<?php foreach ($paket as $p) : ?>
									<option value="<?= $p->id; ?>" <?= ($p->id == $idPaket) ? 'selected' : ''; ?>><?= $p->namaPaket; ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped" id="table-1">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th>Tanggal</th>
										<th>Status</th>
										<th>Catatan</th>
										<th>Foto</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1; ?>
									<?php if ($progres) : ?>
										<?php foreach ($progres as $data) : ?>
											<tr>
												<td><?= $i++; ?></td>
												<td><?= $data->tanggal; ?></td>
												<td><?= $data->status; ?></td>
												<td><?= $data->catatan; ?></td>
												<td>
													<?php if ($data->foto != null) : ?>
														<a href="<?= $data->foto; ?>" target="_blank"><img src="<?= $data->foto; ?>" class="img-thumbnail" width="200"></a>
													<?php else : ?>
														-
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php endif; ?>
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

<script>
	$('#by_paket').change(function() {
		let idPaket = $(this).val();

		if (idPaket != '') {
			document.location.href = `<?php echo base_url('progres/') ?>${idPaket}`;
		}
	});
</script>