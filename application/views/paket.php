<section class="section">
	<div class="section-body">
		<!-- main -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<a href="<?= base_url('paket/add'); ?>" class="btn btn-primary"><i class="fas fa-plus"></i></a>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped" id="table-1">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th>Nama Paket</th>
										<th>Ekspedisi</th>
										<th>Berat</th>
										<th>Catatan</th>
										<th>Alamat Penjemputan</th>
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
											<td><?= $data->berat . ' Kg'; ?></td>
											<td><?= $data->catatan; ?></td>
											<td>
												<a href="<?= base_url('paket/alamat/' . $data->id); ?>" class="btn btn-info">Lihat</a>
											</td>
											<td>Rp. <?= number_format($data->totalBiaya); ?></td>
											<td><?= $data->status; ?></td>
											<td>
												<?php if ($data->status != 'Lunas') : ?>
													<div class="dropdown">
														<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Action
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
															<a href="<?= base_url('paket/edit/' . $data->id); ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit</a>
															<a href="<?= base_url('paket/delete/' . $data->id); ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete</a>
														</div>
													</div>
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