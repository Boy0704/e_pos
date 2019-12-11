<?php 
function upload_gambar_biasa($nama_gambar, $lokasi_gambar, $tipe_gambar, $ukuran_gambar, $name_file_form)
{
    $CI =& get_instance();
    $nmfile = $nama_gambar."_".time();
    $config['upload_path'] = './'.$lokasi_gambar;
    $config['allowed_types'] = $tipe_gambar;
    $config['max_size'] = $ukuran_gambar;
    $config['file_name'] = $nmfile;
    // load library upload
    $CI->load->library('upload', $config);
    // upload gambar 1
    if ( ! $CI->upload->do_upload($name_file_form)) {
    	return $CI->upload->display_errors();
    } else {
	    $result1 = $CI->upload->data();
	    $result = array('gambar'=>$result1);
	    $dfile = $result['gambar']['file_name'];
	    
	    return $dfile;
	}	
}

function get_ph($no_po,$total_h)
{
	$CI =& get_instance();
	// log_r($total_h);
	// if ($total_h = '') {
	// 	$total_h = 0;
	// }
	$ph = $CI->db->get_where('po_master', array('no_po'=>$no_po))->row()->potongan_harga;
	$d_ph = explode(';', $ph);
	$t_h_now = $total_h;
	foreach ($d_ph as $key => $value) {
		if (strstr($value, '%')) {
			$t_persen = str_replace('%', '', $value) /100;
			$n_persen = $t_persen * $t_h_now;
			$t_h_now = $t_h_now - $n_persen;
		} else {
			$t_h_now = $t_h_now - floatval($value);
			// log_r($t_h_now);
		}
	}
	return $t_h_now;

}

function get_waktu()
{
	date_default_timezone_set('Asia/Jakarta');
	return date('Y-m-d H:i:s');
}
function select_option($name, $table, $field, $pk, $selected = null,$class = null, $extra = null, $option_tamabahan = null) {
    $ci = & get_instance();
    $cmb = "<select name='$name' class='form-control $class  ' $extra>";
    $cmb .= $option_tamabahan;
    $data = $ci->db->get($table)->result();
    foreach ($data as $row) {
        $cmb .="<option value='" . $row->$pk . "'";
        $cmb .= $selected == $row->$pk ? 'selected' : '';
        $cmb .=">" . $row->$field . "</option>";
    }
    $cmb .= "</select>";
    return $cmb;
}

function status_pemilih($id_pemilih,$id_pemilihan)
{
	$CI =& get_instance();
	$data = $CI->db->get_where('detail_pilih',array('id_pemilih'=>$id_pemilih,'id_pemilihan'=>$id_pemilihan))->num_rows();
	$status = '';
	if ($data > 0) {
		$status = '<i class="fa fa-check-square color-green1-dark"></i> Sudah';
	} else {
		$status = '<i class="fa fa-check-square color-red1-dark"></i> Belum';
	}
	return $status;
}

function get_data($tabel,$primary_key,$id,$select)
{
	$CI =& get_instance();
	$data = $CI->db->query("SELECT $select FROM $tabel where $primary_key='$id' ")->row_array();
	return $data[$select];
}

function persentase_suara($id_pemilihan,$total)
{
	$CI =& get_instance();
	$data = $CI->db->query("SELECT sum(total) as semua from total_suara where id_pemilihan='$id_pemilihan' ")->row();
	$n = ($total/$data->semua)*100;
	return $n;
}

function alert_biasa($pesan,$type)
{
	return 'swal("'.$pesan.'", "You clicked the button!", "'.$type.'");';
}

function alert_tunggu($pesan,$type)
{
	return '
	swal("Silahkan Tunggu!", {
	  button: false,
	  icon: "info",
	});
	';
}

function selisih_waktu($start_date)
{
	date_default_timezone_set('Asia/Jakarta');
	$waktuawal  = date_create($start_date); //waktu di setting

	$waktuakhir = date_create(date('Y-m-d H:i:s')); //2019-02-21 09:35 waktu sekarang

	//Membandingkan
	$date1 = new DateTime($start_date);
	$date2 = new DateTime(date('Y-m-d H:i:s'));
	if ($date2 < $date1) {
	    $diff  = date_diff($waktuawal, $waktuakhir);
		return $diff->d . ' hari '.$diff->h . ' jam lagi ';
	} else {
		return 'berlangsung';
	}

	

	// echo 'Selisih waktu: ';

	// echo $diff->y . ' tahun, ';

	// echo $diff->m . ' bulan, ';

	// echo $diff->d . ' hari, ';

	// echo $diff->h . ' jam, ';

	// echo $diff->i . ' menit, ';

	// echo $diff->s . ' detik, ';
}

function total_nilai_ujian($user_id, $soal_id)
{
	$CI 	=& get_instance();
	$data = $CI->db->get_where('skor_detail',array('user_id'=>$user_id, 'soal_id'=>$soal_id))->result();
	$nilai = 0;
	foreach ($data as $rw) {
		$nilai = $nilai + $rw->nilai;
	}
	return $nilai;

} 

function cek_nilai_permapel($skor_id, $user_id, $mapel_id)
{
	$CI 	=& get_instance();
	$sql = "
	SELECT
	    sd.user_id,sd.soal_id ,so.soal, mp.mapel, mp.nilai_lulus, SUM(sd.nilai) as total_nilai
	FROM
	    skor_detail AS sd,
	    soal AS so,
	    mapel AS mp 
	WHERE
	    sd.soal_id = so.soal_id 
	AND so.mapel_id=mp.mapel_id
	and so.mapel_id='$mapel_id'
	and sd.skor_id='$skor_id'
	and sd.user_id='$user_id'

	GROUP BY sd.soal_id
	";
	$data = $CI->db->query($sql);
	if ($data->num_rows() == 0) {
		return 0;
	} else {
		return $CI->db->query($sql)->row()->total_nilai;
	}
	

}

function batch($batch_id)
{
	$CI 	=& get_instance();
	$data = $CI->db->get_where('batch', array('batch_id'=>$batch_id))->row()->nama_batch;
	return $data;
}

function kat_mapel($kat)
{
	if ($kat == 'waktu_soal_muatan_lokal') {
		return 'muatan lokal';
	} elseif ($kat == 'waktu_soal_umum') {
		return 'umum';
	}
}

function mapel($mapel_id)
{
	$CI 	=& get_instance();
	$data = $CI->db->get_where('mapel', array('mapel_id'=>$mapel_id))->row()->mapel;
	return $data;
}

function cek_status($status)
{
	if ($status == '1') {
		return "<span class=\"label label-success\">Aktif</span>";
	} elseif ($status == '0') {
		return "<span class=\"label label-danger\">Tidak Aktif</span>";
	}
}

function jawaban_benar($butir_soal_id)
{
	$CI 	=& get_instance();
	$d =$CI->db->get_where('butir_soal', array('butir_soal_id'=>$butir_soal_id))->row();
	if ($d->bobot_jawaban1 >= 4) {
		return $d->jawaban1;
	} elseif ($d->bobot_jawaban2 >= 4) {
		return $d->jawaban2;
	} elseif ($d->bobot_jawaban3 >= 4) {
		return $d->jawaban3;
	} elseif ($d->bobot_jawaban4 >= 4) {
		return $d->jawaban4;
	} elseif ($d->bobot_jawaban5 >= 4) {
		return $d->jawaban5;
	}
}

function select_jawaban($butir_soal_id, $user_id)
{
	$CI 	=& get_instance();
	$jawaban =$CI->db->get_where('skor_detail', array('butir_soal_id'=>$butir_soal_id,'user_id'=>$user_id));
	if ($jawaban->num_rows() == 0) {
		return '';
	} else {
		$j = $jawaban->row();
		return $j->jawaban;
	}
	
}

function cek_btn_soal($butir_soal_id, $user_id)
{
	$CI 	=& get_instance();
	$btn =$CI->db->get_where('skor_detail', array('butir_soal_id'=>$butir_soal_id,'user_id'=>$user_id));
	if ($btn->num_rows() == 0) {
		return 'btn btn-default';
	} else {
		return 'btn btn-success';
	}
	
}

function get_nama_soal($soal_id)
{
	$CI 	=& get_instance();
	$nm = $CI->db->get_where('soal', array('soal_id'=>$soal_id))->row()->soal;
	return $nm;
}

function get_soal_paket($paket_soal_id)
{
	$CI 	=& get_instance();
	$data = $CI->db->query("SELECT soal.soal FROM item_soal, soal where item_soal.soal_id=soal.soal_id and item_soal.paket_soal_id='$paket_soal_id' ");
	$nilai = "";
	foreach ($data->result() as $rw) {
		$nilai .= "<span class=\"label label-info\">".$rw->soal."</span> ";
	}
	return $nilai;

} 

function filter_string($n)
{
	$hasil = str_replace('"', "'", $n);
	return $hasil;
}

function cek_nilai_lulus()
{	
	$CI 	=& get_instance();
	$nilai = $CI->db->query("SELECT sum(nilai_lulus) as lulus FROM mapel ")->row()->lulus;
	return $nilai;
}

function ket_lulus($total)
{
	if ($total >= cek_nilai_lulus()) {
		return "<span class=\"label label-success\">LULUS</span> ";
	} else {
		return "<span class=\"label label-danger\">TIDAK LULUS</span> ";
	}
}

function cek_query()
{
	$CI 	=& get_instance();
	print_r($CI->db->last_query()); 
	exit();
}

function setting($field)
{
	$CI 	=& get_instance();
	$data = $CI->db->get_where('setting', array('id_setting'=>1))->row_array();
	return $data[$field];
}

function log_r($string = null, $var_dump = false)
    {
        if ($var_dump) {
            var_dump($string);
        } else {
            echo "<pre>";
            print_r($string);
        }
        exit;
    }

    function log_data($string = null, $var_dump = false)
    {
        if ($var_dump) {
            var_dump($string);
        } else {
            echo "<pre>";
            print_r($string);
        }
        // exit;
    }