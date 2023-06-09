<section class="section">
	<div class="section-body">
		<!-- main -->
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4>Alamat Penjemputan</h4>
					</div>
					<div class="card-body">
						<div class="col-lg-12">
							<div class="form-group">
								<div id="map" style="width: 100%; height: 70vh;"></div>
							</div>
						</div>
						<div class="col-lg-12 text-right mt-3">
							<a href="<?= base_url('paket'); ?>" type="button" class="btn btn-warning">Kembali</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end main -->
	</div>
</section>

<script>
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

	let latiKantor = <?= $setting->lati; ?>;
	let longiKantor = <?= $setting->longi; ?>;

	let latiAnda = <?= $paket[0]->lati; ?>;
	let longiAnda = <?= $paket[0]->longi; ?>;

	const map = L.map('map', {
		center: [latiKantor, longiKantor],
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

	// rute
	var routingControl = L.Routing.control({
		waypoints: [
			L.latLng(latiKantor, longiKantor), //titik awal
			L.latLng(latiAnda, longiAnda) //titik akhir
		]
	}).addTo(map);

	// mengambil jarak
	routingControl.on('routesfound', function(e) {
		var routes = e.routes;
		var summary = routes[0].summary;
		var totalDistance = summary.totalDistance;

		animatecar(routes[0]);
	});

	map.addLayer(marker);

	function animatecar(route) {
		var iconMobil = L.icon({
			iconUrl: '<?= base_url('icon/pickup.png') ?>',
			iconSize: [27, 50],
		});
		var mobil = L.marker([route.coordinates[0].lat, route.coordinates[0].lng], {
			icon: iconMobil
		}).addTo(map);
		var index = 0;
		var maxIndex = route.coordinates.length - 1;

		function animate() {
			mobil.setLatLng([route.coordinates[index].lat, route.coordinates[index].lng]);
			index++;
			if (index > maxIndex) {
				index = 0;
			}
			setTimeout(animate, 200);
		}
		animate();
	}
</script>