<div class="col-md-10 content">
	<br/>
	<h3>Ujian Online</h3>
	<hr/>
	<?php
		if($status == 'fail'){
			 echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a> '.$text.' !</div>';
		}else{
	?>
	
	<form id="form_ujian_online">
	<input type="hidden" name="id_buat_ujian" value="<?=$soal->result()[0]->id_buat_ujian?>">
	<input type="hidden" name="id_soal" value="<?=$soal->result()[0]->id_soal?>">
	<input type="hidden" name="jumlah_soal" value="<?=$soal->result()[0]->jumlah_soal?>">
	<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<tr>
			<td>Judul</td>
			<td>:</td>
			<td><?=$soal->result()[0]->judul_buat_ujian?></td>
		</tr>
		<tr>
			<td>Matakuliah</td>
			<td>:</td>
			<td><?=$soal->result()[0]->nama_mk?></td>
		</tr>
		<tr>
			<td>Jumlah Soal</td>
			<td>:</td>
			<td><?=$soal->result()[0]->jumlah_soal?></td>
		</tr>
		<tr>
			<td>Jumlah Soal</td>
			<td>:</td>
			<td><?=$soal->result()[0]->waktu_pengerjaan?> Menit</td>
		</tr>
	</table>
	<table class="table table-bordered">
	<?php foreach($soal->result() as $row){?>
		<tr>
			<td class="col-md-1">No</td>
			<td class="col-md-1">:</td>
			<td class="col-md-10">
			<input type="hidden" name="no_soal[]" value="<?=$row->no_soal?>">
			<?=$row->no_soal?></td>
		</tr>
		<tr>
			<td class="col-md-1">Soal</td>
			<td class="col-md-1">:</td>
			<td class="col-md-10"><?=$row->isi_soal?></td>
		</tr>
		<tr>
			<td class="col-md-1">Jawaban</td>
			<td class="col-md-1">:</td>
			<td class="col-md-10">
			<select name="jawaban_user[]" id="jawaban_user" class="form-control">
				<option value="">--pilih--</option>
				<option value="a">a</option>
				<option value="b">b</option>
				<option value="c">c</option>
				<option value="d">d</option>
				<option value="e">e</option>
			</select>
			</td>
		</tr>
		<tr bgcolor="#f1f1f1">
			<td class="col-md-1">&nbsp;</td>
			<td class="col-md-1"></td>
			<td class="col-md-10"></td>
		</tr>
	<?php }?>
	</table>
	</div>
	<nav class="navbar navbar-default navbar-fixed-bottom">
	  	<div class="container">
	    	<ul class="nav navbar-nav navbar-right">
	    		<li>
	      			<a href="#" id="notif_simpan_jawaban">

	      			</a>
	      		</li>
	      		<li>
	      			<a href="#">
	      			<span id="timer" style="color: red"></span>
	      			<button type="submit" class="btn btn-primary" ><i class="fa fa-save" aria-hidden="true"></i> Simpan</button></a>
	      		</li>
	    	</ul>
	  	</div>
	</nav>
	</form>
	<?php
		}
	?>
</div>
<script type="text/javascript">
 
   $(document).ready(function() {
      /** Membuat Waktu Mulai Hitung Mundur Dengan 
       * var detik = 0,
       * var menit = 1,
       * var jam = 1
       */
       var detik = 0;
       var menit = <?=$soal->result()[0]->waktu_pengerjaan?>;
       var jam = 0;
	  
 
      /**
       * Membuat function hitung() sebagai Penghitungan Waktu
       */
       function hitung() {
          /** setTimout(hitung, 1000) digunakan untuk 
	   *  mengulang atau merefresh halaman selama 1000 (1 detik) */
	   setTimeout(hitung,1000);
 
	  /** Menampilkan Waktu Timer pada Tag #Timer di HTML yang tersedia */
	   $('#timer').html( 'Sisa Waktu : ' + jam + ' Jam - ' + menit + ' Menit - ' + detik + ' Detik &nbsp; &nbsp;');
 
	  /** Melakukan Hitung Mundur dengan Mengurangi variabel detik - 1 */
	   detik --;
 
	  /** Jika var detik < 0
	   *  var detik akan dikembalikan ke 59
	   *  Menit akan Berkurang 1
	   */
	   if(detik < 0) {
	      detik = 59;
	      menit --;
 
	      /** Jika menit < 0
	       *  Maka menit akan dikembali ke 59
	       *  Jam akan Berkurang 1
	       */
	       if(menit < 0) {
 			alert("waktu habis !");
  			$.ajax({
				type:"POST",
				url:"<?=base_url()?>m_mulai_ujian/simpan_jawaban",
				data:$("#form_ujian_online").serialize(),
				success: function(data){					
					clearInterval();
					$('#notif_simpan_jawaban').html(data);
					// window.location = "<?=base_url()?>m_mulai_ujian";
				}
			});
						
		  /** Jika var jam < 0
		   *  clearInterval() Memberhentikan Interval 
		   *  Dan Halaman akan membuka http://tahukahkau.com/
		   */
		  
	       }
	   } 		
        }
 	/** Menjalankan Function Hitung Waktu Mundur */
        hitung();

        $(document).on('submit', '#form_ujian_online', function(e){
			e.preventDefault();

			var data = $("#form_ujian_online").serialize();
			$('#notif_simpan_jawaban').html('Loading...');

			$.ajax({
				type:"POST",
				url:"<?=base_url()?>m_mulai_ujian/simpan_jawaban",
				data: data,
				success: function(msg){
					$('#notif_simpan_jawaban').html(msg);
				}
			});
		});
   });
// ]]></script>