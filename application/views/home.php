<?php
	include "header.php";
?>
<div class="row">
	<div class="columns large-12 page">
		<div class="row">
			<div class="columns large-8 konten">
				<div class="row">
					<div class="columns large-12">
						<h4 id="title">Daftar Undangan <?php if(isset($param)) echo '('.$param.')';?></h4>
						<a href="#" data-dropdown="drop" class="tiny button dropdown" id="filter">Filter</a><br>
						<ul id="drop" data-dropdown-content class="f-dropdown">
							<li><a href="<?=base_url()?>home/filter/semua/masuk" >Masuk</a></li>
							<li><a href="<?=base_url()?>home/filter/semua/keluar" >Keluar</a></li>
							<li><a href="<?=base_url()?>home/filter/sudah/semua" >Sudah Lewat</a></li>
							<li><a href="<?=base_url()?>home/filter/belum/semua" >Akan Datang</a></li>
							<li><a href="<?=base_url()?>" >Semua</a></li>
						</ul>
					</div>
				</div>
				<?php foreach ($entry as $acara): ?>
					<div class="row entry">
						<div class="columns large-12">
							<strong><?php echo htmlspecialchars($acara["Nama_acara"]); ?></strong> 
							<br />
							Tanggal <?php echo strftime("%d %B %Y", strtotime($acara["Waktu"])); ?>
							jam <?php echo strftime("%H:%M", strtotime($acara["Waktu"])); ?>
							di <?php echo htmlspecialchars($acara["Tempat"]); ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="columns large-4 konten">
				<h4>Yang Akan Datang</h4>
			</div>
		</div>
		
	</div>
</div>

<?php
	include "footer.php";
?>
