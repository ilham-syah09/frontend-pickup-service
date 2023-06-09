<section class="section">
	<div class="section-body">
		<!-- main -->
		<form action="<?= base_url('paket/post_add'); ?>" method="POST">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header">
							<h4>Tambah Paket</h4>
						</div>
						<div class="card-body">
							<div class="row">
								<input type="hidden" name="lati" id="lati">
								<input type="hidden" name="longi" id="longi">
								<input type="hidden" class="form-control" name="totalBiaya" autocomplete="off" readonly id="totalBiaya">

								<div class="col-md-6">
									<div class="form-group">
										<label>Nama Paket</label>
										<input type="text" class="form-control" name="namaPaket" autocomplete="off" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Berat Paket</label>
										<input type="text" class="form-control" name="berat" autocomplete="off" required id="berat">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Ekspedisi</label>
										<select name="idEkspedisi" class="form-control" required>
											<option value="">-- Pilih Ekspedisi --</option>
											<?php foreach ($ekspedisi as $eks) : ?>
												<option value="<?= $eks->id; ?>"><?= $eks->ekspedisi; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Jarak <sup>(Km)</sup></label>
										<input type="text" class="form-control" name="jarak" autocomplete="off" readonly id="jarak">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Catatan</label>
										<textarea name="catatan" cols="30" rows="100" class="form-control"></textarea>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label>Lokasi Jemput</label>
										<div id="map" style="width: 100%; height: 70vh;"></div>
									</div>
								</div>
								<div class="col-md-12 text-right mt-3">
									<button type="button" class="btn btn-primary" id="hitung">Hitung Biaya</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header">
							<h4>Rincian Biaya</h4>
						</div>
						<div class="card-body">
							<div class="d-flex justify-content-between mb-3 pt-1">
								<h6 class="font-weight-medium" id="textBerat">Berat</h6>
								<h6 class="font-weight-medium" id="hargaBerat"></h6>
							</div>
							<div class="d-flex justify-content-between">
								<h6 class="font-weight-medium" id="textJarak">Jarak</h6>
								<h6 class="font-weight-medium" id="hargaJarak"></h6>
							</div>
						</div>
						<div class="card-footer border-secondary bg-transparent">
							<div class="d-flex justify-content-between mt-2">
								<h5 class="font-weight-bold">Total</h5>
								<h5 class="font-weight-bold" id="hargaTotal"></h5>
							</div>
							<div class="text-right">
								<a href="<?= base_url('paket'); ?>" type="button" class="btn btn-danger">Batalkan</a>
								<button type="submit" class="btn btn-success" disabled id="btnSubmit">Simpan Pesanan</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<!-- end main -->
	</div>
</section>

<script>
	if (navigator.geolocation) {
		// posisi user/perangkat terdeteksi
		navigator.geolocation.getCurrentPosition(showPosition);
	} else {
		alert("Geolocation tidak didukung oleh browser ini.");
	}

	const googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
		maxZoom: 20,
		subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
	});

	const googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
		maxZoom: 20,
		subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
	});

	const peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	});

	const googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
		maxZoom: 20,
		subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
	});

	const lat_kantor = '<?= $setting->lati; ?>';
	const long_kantor = '<?= $setting->longi; ?>';
	const jarak = <?= $setting->maxJarak; ?>;
	const hargaKm = '<?= $setting->hargaKm; ?>';
	const hargaKg = '<?= $setting->hargaKg; ?>';

	const map = L.map('map', {
		center: [lat_kantor, long_kantor],
		zoom: 14,
		layers: [googleStreets],
	});

	const baseLayers = {
		'Default': peta3,
		'Street': googleStreets,
		'Dark': googleHybrid,
		'Satelite': googleSat,
	};

	const layerControl = L.control.layers(baseLayers).addTo(map);

	var circle = L.circle([lat_kantor, long_kantor], {
		color: 'red',
		radius: jarak * 1000, //jangkauang radius dalam meter
	}).addTo(map);

	var markerKantor = L.marker([lat_kantor, long_kantor], {
		draggable: false,
	}).addTo(map).bindPopup(`<span class="text-danger">Lokasi Kantor</span>`).openPopup();

	function showPosition(position) {
		let jrk = getDistanceFromLatLonInKm(lat_kantor, long_kantor, position.coords.latitude, position.coords.longitude).toFixed(1);

		jrk = Math.round(((jrk / 1000) + Number.EPSILON) * 1000) / 1000;

		// menampilkan ke map
		if (jrk <= jarak) {
			var marker = L.marker([position.coords.latitude, position.coords.longitude], {
				draggable: true,
			}).addTo(map).bindPopup(`<span class="text-info">Posisi Anda</span>`).openPopup();

			$('#lati').val(position.coords.latitude);
			$('#longi').val(position.coords.longitude);

			$('#jarak').val(jrk);
		} else {
			var marker = L.marker([lat_kantor, long_kantor], {
				draggable: true,
			}).addTo(map).bindPopup(`<span class="text-info">Posisi Anda</span>`).openPopup();

			$('#lati').val('');
			$('#longi').val('');

			$('#jarak').val('');
		}

		// mengambil coordinat saat digeser
		marker.on('dragend', function(event) {
			// mendapatkan titik coordinat
			var latlng = event.target.getLatLng();
			// menghitung jarak marke dengan lingkaran
			var distance = latlng.distanceTo(circle.getLatLng());

			if (distance <= circle.getRadius()) {
				// jika coordinat didalam radius 
				$('#lati').val(latlng.lat);
				$('#longi').val(latlng.lng);

				var jarak = Math.round((distance + Number.EPSILON) * 1000) / 1000;
				jarak = Math.round(((jarak / 1000) + Number.EPSILON) * 1000) / 1000;

				$('#jarak').val(jarak);

				clear();
			} else {
				// jika coordinat tidak didalam radius 
				iziToast.error({
					title: 'Error',
					message: 'Maaf, titik yang dipilih berada di luar radius lingkarang!!',
					position: 'topRight'
				});

				marker.setLatLng([lat_kantor, long_kantor]);

				$('#lati').val('');
				$('#longi').val('');

				$('#jarak').val('');

				clear();
			}
		});

		// mengambil coordinat saat diclick
		map.on("click", function(event) {
			// mendapatkan titik coordinat
			var latlng = event.latlng;

			// menghitung jarak marke dengan lingkaran
			var distance = latlng.distanceTo(circle.getLatLng());

			if (distance <= circle.getRadius()) {
				if (!marker) {
					marker = L.marker(event.latlng).addTo(map);
				} else {
					marker.setLatLng(event.latlng);
				}

				// jika coordinat didalam radius 
				$('#lati').val(latlng.lat);
				$('#longi').val(latlng.lng);

				var jarak = Math.round((distance + Number.EPSILON) * 1000) / 1000;
				jarak = Math.round(((jarak / 1000) + Number.EPSILON) * 1000) / 1000;

				$('#jarak').val(jarak);

				clear();
			} else {
				// jika coordinat tidak didalam radius 
				iziToast.error({
					title: 'Error',
					message: 'Maaf, titik yang dipilih berada di luar radius lingkarang!!',
					position: 'topRight'
				});

				marker.setLatLng([lat_kantor, long_kantor]);

				$('#lati').val('');
				$('#longi').val('');

				$('#jarak').val('');

				clear();
			}
		});
	}

	function getDistanceFromLatLonInKm(latitude1, longitude1, latitude2, longitude2, units) {
		var R = 6371; // km
		var dLat = toRad(latitude2 - latitude1);
		var dLon = toRad(longitude2 - longitude1);
		var latitude1 = toRad(latitude1);
		var latitude2 = toRad(latitude2);

		var a =
			Math.sin(dLat / 2) * Math.sin(dLat / 2) +
			Math.sin(dLon / 2) *
			Math.sin(dLon / 2) *
			Math.cos(latitude1) *
			Math.cos(latitude2);
		var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
		var d = R * c;

		return d * 1000;
	}

	// Converts numeric degrees to radians
	function toRad(Value) {
		return (Value * Math.PI) / 180;
	}

	$('#hitung').click(function() {
		let berat = Number($('#berat').val());
		let jarak = Number($('#jarak').val());

		hitung(berat, jarak);
	});

	$('#berat').change(function() {
		clear();
	});

	const hitung = (berat, jarak) => {
		let rupiah = new Intl.NumberFormat('id-ID', {
			style: 'currency',
			currency: 'IDR'
		});

		if ((berat == '' || berat == 0) || (jarak == '' || jarak == 0)) {
			iziToast.warning({
				title: 'Warning',
				message: 'Silahkan isi form dengan benar !',
				position: 'topRight'
			});

			clear();

			return 0;
		}

		let priceByWeight = hargaKg * berat;
		let priceByDistance = hargaKm * jarak;

		let totalPrice = priceByWeight + priceByDistance;

		$('#textBerat').text(`Berat (${berat} * ${rupiah.format(hargaKg)})`);
		$('#hargaBerat').text(rupiah.format(priceByWeight));

		$('#textJarak').text(`Jarak (${jarak} * ${rupiah.format(hargaKm)})`);
		$('#hargaJarak').text(rupiah.format(priceByDistance));

		$('#hargaTotal').text(rupiah.format(totalPrice));
		$('#totalBiaya').val(totalPrice);

		$('#btnSubmit').prop("disabled", false);
	}

	function clear() {
		$('#textBerat').text('Berat');
		$('#hargaBerat').text('');

		$('#textJarak').text('Jarak');
		$('#hargaJarak').text('');

		$('#hargaTotal').text('');
		$('#totalBiaya').val('');

		$('#btnSubmit').prop("disabled", true);
	}
</script>