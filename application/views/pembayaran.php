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
										<th>Catatan</th>
										<th>Total Biaya</th>
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
											<td><?= $data->catatan; ?></td>
											<td>Rp. <?= number_format($data->totalBiaya); ?></td>
											<td><?= $data->status; ?></td>
											<td>

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