<?php
	include "header.php";
?>
<div class="row">
	<div class="columns large-12 page">
		<div class="row">
			<div class="columns large-8">
				<div class="formulir">
					<?php if($posted != FALSE): ?>
						<div class="panel">
							<em>Undangan <?php echo $nama_acara." dari ".$dari; ?> telah dibuat.</em>
						</div>
					<?php endif; ?>
					<h3><em>Buat Undangan Baru</em></h3>
					<br />
					<form method="post" enctype="multipart/form-data">
						<label for="jenis">Jenis Undangan</label>
						<input type="radio" name="jenis" value="masuk" id="masuk"><label for="masuk">Masuk</label>
						<input type="radio" name="jenis" value="keluar" id="keluar"><label for="keluar">Keluar</label>

						<label for="dari">Dari</label>
						<input type="text" name="dari" id="dari">

						<label for="kepada">Kepada</label>
						<input type="text" name="kepada" id="kepada">

						<label for="nama_acara">Nama Acara</label>
						<input type="text" name="nama_acara" id="nama_acara">

						<label for="tanggal">Tanggal</label>
						<input type="text" name="tanggal" id="tanggal" placeholder="31/01/2014">

						<label for="jam">Jam</label>
						<input type="text" name="jam" id="jam" placeholder="19:30">

						<label for="tempat">Tempat</label>
						<input type="text" name="tempat" id="tempat">
						
						<label for="berkas_asli"></label>
						<input type="file" name="berkas_asli" placeholder="berkas_asli">
						
						<button class="small button">Buat Undangan Baru</button>
					</form>					
				</div>
			</div>
			<div class="columns large-4"></div>
		</div>
	</div>
</div>

<?php
	include "footer.php";
?>