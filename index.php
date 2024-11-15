<?php
//  Buat fungsi bernama total_rupiah untuk menghitung nilai rupiah hasil penukaran valas 
//	sesuai INSTRUKSI KERJA 7.

function total_rupiah($jumlah, $nilaiValas)
{
	return $jumlah * $nilaiValas;
}

//  Buat sebuah array satu dimensi yang berisi beberapa valuta asing (valas)
$currency = ['USD', 'SGD', 'GBP', 'YEN', 'WON', 'YUAN'];
rsort($currency);
//	sesuai INSTRUKSI KERJA 1 dan urutkan sesuai INSTURKSI KERJA 2.


?>

<!DOCTYPE html>
<html>

<head>
	<title>Money Changer Amanah</title>
	<!-- Hubungkan halaman web dengan file library CSS yang sudah tersedia -->
	<link rel="stylesheet" href="./assets/css/bootstrap.css">
	<!-- sesuai INSTRUKSI KERJA 4. -->

</head>

<body>
	<div class="container border">
		<div class="d-flex align-items-center mb-5">
			<!-- Menampilkan judul halaman -->
			<h1>Money Changer Amanah</h1>

			<!-- Tampilkan logo sesuai INSTRUKSI KERJA 5. -->
			<img src="./assets/img/money-logo.png" alt="..." class="ml-3" style="width: 72px;">
		</div>



		<!-- Form untuk memasukkan data pemesanan. -->
		<form action="index.php" method="post" id="formMoneyChanger">
			<div class="row">
				<!-- Masukan nama pemesan. Tipe data text. -->
				<div class="col-lg-2"><label for="nama">Nama Pemesan:</label></div>
				<div class="col-lg-2"><input type="text" id="nama" name="nama"></div>
			</div>
			<div class="row">
				<!-- Masukan NIK pemesan. Tipe data text. -->
				<!-- Modifikasi input supaya NIK yang dimasukkan harus tepat 16 karakter sesuai INSTRUKSI KERJA 6. -->

				<div class="col-lg-2"><label for="nik">NIK:</label></div>
				<div class="col-lg-2">
					<input type="text" id="nik" name="nik">
					<div id="alert-nik">
						<p class="text-danger">
							<?php
							if (isset($_GET['alert'])) {
								if ($_GET['alert'] == "true") {
									echo "NIK harus 16 karakter!";
									}
									} else {
									echo "";
										}

							?>
							</p>
					</div>
				</div>
				<!--Type berubah menjadi text karena NIK bukan Number -->

			</div>
			<div class="row">
				<!-- Masukan pilihan valuta asing. -->
				<div class="col-lg-2"><label for="valas">Valuta asing:</label></div>
				<div class="col-lg-2">
					<select id="valas" name="valas">
						<option value="">- Pilih valas -</option>
						<!-- Tampilkan dropdown valas berdasarkan data pada array valas menggunakan perulangan -->
						<?php foreach ($currency as $valas) { ?>
							<option value="<?= $valas ?>"><?= $valas ?></option>
						<?php } ?>
						<!-- sesuai INSTRUKSI KERJA 3. -->

					</select>
				</div>
			</div>
			<div class="row">
				<!-- Masukan jumlah valas. Tipe data number. -->
				<div class="col-lg-2"><label for="jumlah">Jumlah valas:</label></div>
				<div class="col-lg-2"><input type="number" id="jumlah" name="jumlah" maxlength="4"></div>
			</div>
			<div class="row">
				<!-- Tombol Submit -->
				<div class="col-lg-2"><button class="btn btn-primary" type="submit" form="formMoneyChanger" value="Hitung" name="Hitung">Hitung</button></div>
				<div class="col-lg-2"></div>
			</div>
		</form>
	</div>
	<?php
	//	Kode berikut dieksekusi setelah tombol Hitung ditekan.
	if (isset($_POST['Hitung'])) {

		$nikLen = strlen($_POST['nik']);

		if ($nikLen !== 16) {
			$alert = "NIK harus 16 karakter!";
			return header('Location: /money-changer?alert=true');
		} else {
			$dataKonversiValas = array(
				'nama' => $_POST['nama'],
				'nik' => $_POST['nik'],
				'valas' => $_POST['valas'],
				'jumlah' => $_POST['jumlah']
			);

			//	Simpan data pemesanan valas dari array $dataKonversiValas ke dalam file JSON/TXT/Excel/database sesuai INSTRUKSI KERJA 11.

			// mengambil data-data di json dan ubah ke array
			$db = json_decode(file_get_contents('./db/data.json'), true);

			// menambahkan inputan baru ke array
			array_push($db, $dataKonversiValas);

			// menulis hasil penambahan data baru menjadi data.json
			file_put_contents('./db/data.json', json_encode($db), JSON_PRETTY_PRINT);

			//	Simpan jumlah valas dalam variabel $jumlah sesuai INSTRUKSI KERJA 8
			$jumlah = $_POST['jumlah'];


			//	Variabel $nilaiValas menyimpan nilai valas berdasarkan valas yang dipilih.
			$nilaiValas = $_POST['valas'];

			//	Gunakan pencabangan untuk menentukan nilai variabel $nilaiValas berdasarkan INSTRUKSI KERJA 9.
			switch ($dataKonversiValas['valas']) {
				case 'USD':
					$nilaiValas = 15000;
					break;

				case 'SGD':
					$nilaiValas = 11000;
					break;

				case 'GBP':
					$nilaiValas = 18500;
					break;

				case 'YEN':
					$nilaiValas = 110;
					break;

				case 'WON':
					$nilaiValas = 11;
					break;

				case 'YUAN':
					$nilaiValas = 2200;
					break;

				default:
					$nilaiValas = 0;
					break;
			}

			//	Variabel $totalRupiah menyimpan nilai konversi valas ke dalam Rupiah.
			$totalRupiah = total_rupiah($jumlah, $nilaiValas);
			//	Gunakan fungsi yang sudah dibuat dalam Instruksi Kerja 7 untuk menghitung nilai $totalRupiah
			//		sesuai INSTRUKSI KERJA 10.


			//	Tampilkan data pemesanan dan hasil perhitungan konversi valas.
			echo "
					<br/>
					<div class='container'>
						<div class='row'>
							<!-- Menampilkan nama pemesan. -->
							<div class='col-lg-2'>Nama pemesan:</div>
							<div class='col-lg-2'>" . $dataKonversiValas['nama'] . "</div>
						</div>
						<div class='row'>
							<!-- Menampilkan NIK pemesan. -->
							<div class='col-lg-2'>NIK:</div>
							<div class='col-lg-2'>" . $dataKonversiValas['nik'] . "</div>
						</div>
						<div class='row'>
							<!-- Menampilkan valas yang dikonversi. -->
							<div class='col-lg-2'>Valas:</div>
							<div class='col-lg-2'>" . $dataKonversiValas['valas'] . "</div>
						</div>
						<div class='row'>
							<!-- Menampilkan jumlah valas. -->
							<div class='col-lg-2'>Jumlah valas:</div>
							<div class='col-lg-2'>" . $dataKonversiValas['jumlah'] . "</div>
						</div>
						<div class='row'>
							<!-- Menampilkan hasil konversi. -->
							<div class='col-lg-2'>Total Rupiah:</div>
							<div class='col-lg-2'>Rp" . number_format($totalRupiah, 0, ".", ".") . ",-</div>
						</div>
				</div>
				";
		}
	}
	?>
</body>

</html>