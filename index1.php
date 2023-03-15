<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Faris Rasyid</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5
	.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
  <div class="container">
		<h1 class="text-center">Faris Rasyid</h1>
		<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="card">
					<div class="card-header bg-primary text-white text-center">Pendaftaran Rute Penerbangan</div>
					<div class="card-body">
	
		<div class="card">	
        <div class="form-group">
				<label for="nama">Nama Maskapai:</label>
				<input type="text" class="form-control" id="nama" name="nama">
			</div>
			<div class="form-group">
				<label for="nomor">Nomor Pelanggan:</label>
				<input type="text" class="form-control" id="nomor" name="nomor">
			</div>
			<div class="form-group">
				<label for="asal">Bandara Asal:</label>
				<select class="form-control" id="asal" name="asal">
					<option value="CGK">Soekarno-Hatta (CGK)</option>
					<option value="BDO">Husein Sastranegara (BDO)</option>
					<option value="MLG">Abdul Rachman Saleh (MLG)</option>
					<option value="SUB">Juanda (SUB) </option>
				</select>
				</div>
				<div class="form-group">
				<label for="tujuan">Bandara Tujuan:</label>
				<select class="form-control" id="tujuan" name="tujuan">
					<option value="DPS">Ngurah Rai (DPS) </option>
					<option value="UPG">Hasanuddin (UPG)</option>
					<option value="INX">Inanwatan (INX)</option>
					<option value="BTJ">Sultan Iskandarmuda (BTJ)</option>
				</select>
				</div>
			
			<div class="form-group">
				<label for="tiket">Harga tiket:</label>
				<input type="text" class="form-control" id="tiket" name="tiket">
			</div>
			<br>
			<button type="submit" class="btn btn-success">Submit</button>
		</form>
	</div>
	<table class="table table-bordered border-dark ">
    <thead class="table-primary">
	<tr>
        <th scope="col">Maskapai</th>
		<th scope="col">Nomor</th>
        <th scope="col">Asal Penerbangan</th>
        <th scope="col">Tujuan Penerbangan</th>
        <th scope="col">Harga tiket</th>
        <th scope="col">Pajak</th>
        <th scope="col">Total Harga Tiket</th>
        
        </tr>
    </thead>

	<?php 
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$nama = $_POST["nama"];
		$nomor = $_POST["nomor"];
		$asal = $_POST["asal"];
		$tujuan = $_POST["tujuan"];
		$tiket = $_POST["tiket"];
	
		$tarif_tujuan = array(
			"DPS" => 80000,
			"UPG" => 70000,
			"INX" => 90000,
			"BTJ" => 70000
		);
	
		$tarif_asal = array(
			"CGK" => 50000,
			"BDO" => 70000,
			"MLG" => 90000,
			"SUB" => 70000
		);
	
		$hargatiket = $tarif_tujuan[$tujuan] + $tarif_asal[$asal];
	
		// Menghitung total harga
		$total_harga = $hargatiket + $tiket;
	
		$data = array(
			"nama" => $nama,      
			"nomor" => $nomor,
			"asal" => $asal,
			"tujuan" => $tujuan,
			"tiket" => $tiket,
			"tarif_tujuan" => $tarif_tujuan[$tujuan],
			"total_tagihan" => $total_harga
		);
	
		$fileJson = 'data.json';
		$dataKaryawan = array();
		$dataJson = file_get_contents($fileJson);
		if (!empty($dataJson)) {
			$dataKaryawan = json_decode($dataJson, true);
		}
	
		$dataKaryawan[] = $data;
		$dataJson = json_encode($dataKaryawan, JSON_PRETTY_PRINT);
		file_put_contents($fileJson, $dataJson);
	}
	?>
	
	<?php
	$fileJson = 'data.json';
	$dataKaryawan = array();
	$dataJson = file_get_contents($fileJson);
	if (!empty($dataJson)) {
		$dataKaryawan = json_decode($dataJson, true);
	}
	?>
	
	<div class="container">
		<h2>Data Penerbangan</h2>
		<?php 
		// fungsi yg digunkan untuk mendeklarasikan rupiah
		function rupiah($angka){
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
}
function text_format($data){
	$abjad = "" . text_format($data,A-Z);
	return $abjad;
}
		?>
		<!-- akhir fungsi rupiah -->

		<!-- fungsi dibawah digunka -->
			<?php foreach ($dataKaryawan as $data) { ?>
				<tr>
					<td><?php echo $data["nama"]; ?></td>
					<td><?php echo $data["nomor"]; ?></td>
					<td><?php echo $data["asal"]; ?></td>
					<td><?php echo $data["tujuan"]; ?></td>
					<td><?php echo rupiah($data["tiket"]); ?></td>
					<td><?php echo rupiah($data["tarif_tujuan"] + $tarif_asal[$data["asal"]]); ?></td>
					<td><?php echo rupiah($data["total_tagihan"]); ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
	

	
    

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>    