<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Sample Client App</title>
	<link href="bootstrap-3.3.51/css/bootstrap.css" rel="stylesheet"/>
</head>

<body>
	<div class="container">
		<br/>
		<?php
		
		$idBarang=$_GET['idBarang'];

		$namaBarang="";
		$kategori="";
		$stok="";
		$hargaBeli="";
		$hargaJual="";

		// URL API
		$url = 'http://localhost:8080/NativeREST/api/barang/'.$idBarang;

		// if submit, EDIT DATA
		if(isset($_POST["namaBarang"])){

			$client = curl_init();

			// get POST
			$namaBarang=$_POST['namaBarang'];
			$kategori=$_POST['kategori'];
			$stok=$_POST['stok'];
			$hargaBeli=$_POST['hargaBeli'];
			$hargaJual=$_POST['hargaJual'];

			$data = array("namaBarang"=>$namaBarang, "kategori"=>$kategori, "stok"=>$stok, "hargaBeli"=>$hargaBeli, "hargaJual"=>$hargaJual);
			$data = json_encode($data);
			$options = array(
			    CURLOPT_URL				=> $url, // Set URL of API
			    CURLOPT_CUSTOMREQUEST 	=> "PUT", // Set request method
			    CURLOPT_RETURNTRANSFER	=> true, // true, to return the transfer as a string
			    CURLOPT_POSTFIELDS 		=> $data, // Send the data in HTTP POST
			    );

			curl_setopt_array( $client, $options );

			// Execute and Get the response
			$response = json_decode(curl_exec($client));
			// Get HTTP Code response
			$httpCode = curl_getinfo($client, CURLINFO_HTTP_CODE);
			// Close cURL session
			curl_close($client);
			if($httpCode=="200"){ // if success
				echo "<div class='alert alert-success' style='width:300px;'>Berhasi Diedit</div>";
				header( "refresh:1;url=index.php");
			}else{ // if failed
				echo "<div class='alert alert-danger' style='width:300px;'>Terjadi Kesalahan<br/>".$response->error."</div>";
			}

		}else{

			// Load Data
			$client = curl_init();

			$options = array(
			    CURLOPT_URL				=> $url, // Set URL of API
			    CURLOPT_CUSTOMREQUEST 	=> "GET", // Set request method
			    CURLOPT_RETURNTRANSFER	=> true, // true, to return the transfer as a string
			    );
			curl_setopt_array( $client, $options );

			// Execute and Get the response
			$response = curl_exec($client);
			// Get HTTP Code response
			$httpCode = curl_getinfo($client, CURLINFO_HTTP_CODE);
			// Close cURL session
			curl_close($client);

			$daftarBarang=null;
			if($httpCode=="200"){ // if success
				$data=json_decode($response);
				$namaBarang=$data->namaBarang;
				$kategori=$data->kategori;
				$stok=$data->stok;
				$hargaBeli=$data->hargaBeli;
				$hargaJual=$data->hargaJual;				
			}else{ // if failed
				$response=json_decode($response);
				echo "<div class='alert alert-danger' style='width:300px;'>Terjadi Kesalahan<br/>".$response->error."</div>";
			}

		}

		?>


		<h1>Edit Barang</h1>
		<br/>
		<div style="width:300px;">
			<form role="form" method="POST">
				<div class="form-group">
					<label>Nama Barang :</label>
					<input type="text" class="form-control" name="namaBarang" value="<?php echo $namaBarang; ?>"/>
				</div>
				<div class="form-group">
					<label>Kategori :</label>
					<input type="text" class="form-control" name="kategori" value="<?php echo $kategori; ?>"/>
				</div>
				<div class="form-group">
					<label>Stok :</label>
					<input type="text" class="form-control" name="stok" value="<?php echo $stok; ?>"/>
				</div>
				<div class="form-group">
					<label>Harga Beli :</label>
					<input type="text" class="form-control" name="hargaBeli" value="<?php echo $hargaBeli; ?>"/>
				</div>
				<div class="form-group">
					<label>Harga Jual :</label>
					<input type="text" class="form-control" name="hargaJual" value="<?php echo $hargaJual; ?>"/>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-success" value="Simpan">
					<a class="btn btn-default" href="index.php">Batal</a>
				</div>
			</form>
		</div>

	</div>

</body>
</html>