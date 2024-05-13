<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Progurinda_lib
{
    //mencari nilai basic TPP guru/pengawas sekolah
    public function get_basic_tpp($pegawai,$list_tambahan){
        $respons_nominal = 0;
        $guru = false;
        $pengawas = false;
        //cek status apakah guru atau pegawas sekolah
        if (strpos(strtoupper($pegawai["ket_jab"]),"GURU") !== false){
            $guru = true;
        }elseif(strpos(strtoupper($pegawai["ket_jab"]),"PENGAWAS SEKOLAH") !== false){
            $pengawas = true;
        }
        
        $nominal = array(
            "guru" => array(
                "PNS" => array(
                    "PTM" => 1100000, //1.100.000,
                    "MDA" => 1200000, //1.200.000
                    "MDY" => 1300000, //1.300.000
                    "FUN" => 1050000, //1.050.000
                    "XX"  => 0
                ),
                "PPPK" => array(
                    "PTM" => 1000000, //1.000.000
                    "XX"  => 0
                )
            ),
            "pengawas" => array(
                "PNS" => array(
                    "PTM" => 1300000, //1.300.000
                    "MDA" => 1300000, //1.300.000
                    "MDY" => 1300000, //1.300.000
                    "XX"  => 0
                ),
                "PPPK" => array(
                    "PTM" => 0,
                    "MDA" => 0,
                    "MDY" => 0,
                    "XX"  => 0
                )
            ) 
        );

        $jenjang = $this->get_jenjang($pegawai);

        if ($guru){            
            if($pegawai["kode_status"] <= 2){
                //PNS/CPNS
                $respons_nominal = $nominal["guru"]["PNS"][$jenjang];
            }else{
                //PPPK
                $respons_nominal = $nominal["guru"]["PPPK"][$jenjang];
            }
        }elseif($pengawas){
            if($pegawai["kode_status"] <= 2){
                //PNS/CPNS
                $respons_nominal = $nominal["pengawas"]["PNS"][$jenjang];
            }else{
                //PPPK
                $respons_nominal = $nominal["pengawas"]["PPPK"][$jenjang];
            }
        }
        //menanggulangi jika PPPK tanpa riwayat golongan
        if ($respons_nominal == 0 && $pegawai["kode_status"] == 3){
          $respons_nominal = 1000000;
        }
        //kalau ada list tambahan
        if ($list_tambahan !== false){
          foreach ($list_tambahan as $key => $value) {
            if ($value["nip"] == $pegawai["nip"]){
              //nilai basic ditambahkan
              $respons_nominal += $value["nominal"];
              break;
            }
          }
        }
        $respons["respons_nominal"] = $respons_nominal;
        $respons["jenjang"] = $jenjang;
        return $respons;
    }

    function get_jenjang($pegawai){
        //cek jenjang jabatan
        $jenjang = "XX";
        // if (strpos(strtoupper($pegawai["ket_jab"]),"PERTAMA") !== false){
        //     $jenjang = "PTM";
        // }elseif(strpos(strtoupper($pegawai["ket_jab"]),"MUDA") !== false){
        //     $jenjang = "MDA";
        // }elseif(strpos(strtoupper($pegawai["ket_jab"]),"MADYA") !== false){
        //     $jenjang = "MDY";
        // }elseif(strpos(strtoupper($pegawai["ket_jab"]),"GURU") !== false){
        //     $jenjang = "FUN";
        // }
        if ($pegawai["kode_gol"] == 31 || $pegawai["kode_gol"] == 32){
          $jenjang = "PTM"; // Pertama
        }elseif($pegawai["kode_gol"] == 33 || $pegawai["kode_gol"] == 34){
          $jenjang = "MDA"; // Muda
        }elseif($pegawai["kode_gol"] >= 41){
          $jenjang = "MDY"; // Madya
        }elseif($pegawai["kode_gol"] < 31){
          $jenjang = "FUN"; // gol II ke bawah
        }else{
          $jenjang = "PTM";
        }

        return $jenjang;
    }

    public function get_data_tpp($param){
        $CI = &get_instance();
        //----------=========----------------------------------------//
        // START - query untuk dapat list pegawainya di periode itu //
        //-------------------=========-----------------------------//
    
        //init nama temp table
        $name_temp_pegawai_jab = "temp_pegawai_jab".time();
        $name_temp_pegawai_pensiun = "temp_pegawai_pensiun".time();
        $name_temp_pegawai_gol = "temp_pegawai_gol".time();
        $name_temp_pegawai_aktif = "temp_pegawai_aktif".time();
        $name_temp_presensi_pegawai = "temp_presensi_pegawai".time();
        $name_temp_pegawai_out = "temp_pegawai_out".time();
    
    
       
        $where_q = "kode_instansi = '" . $param["kode_ukerja"] . "'";
        //$index = $this->input->post("order[0][column]");
        //$dir = $this->input->post("order[0][dir]");
        //sorting data pegawai
        //$order_by = " ORDER BY pns.kode_eselon,pns.kode_ukerja asc,pns.kode_jab asc, " . $index . " " . $dir;
        $order_by = " ORDER BY pns.kode_eselon,pns.kode_ukerja asc,pns.kode_jab asc ";
    
        if ($param["search"] != "") {
          $where_q .= " AND (nama LIKE \"%" . $param["search"] . "%\" OR nip LIKE \"%" . $param["search"] . "%\")";
          /* $CI->db->like("nama_lengkap", $search, "both");
          $CI->db->or_like("nip", $search, "both"); */
        }
    
        $filter_guru = 'UPPER(LEFT(r_jab.ket_jab, 4)) = "GURU" OR r_jab.ket_jab LIKE "% GURU%" OR r_jab.ket_jab LIKE "%GURU %" OR LEFT(r_jab.ket_jab, 16) = "PENGAWAS SEKOLAH" OR LEFT(r_jab.ket_jab,8) = "PENGAWAS" ';
    
        $filter_ukerja = "(m_ukerja.kode_instansi = '".$param["kode_ukerja"]."')";
        //$filter_ukerja = "( LEFT ( m_ukerja.unit_kepeg, 8 ) = '".$param["kode_ukerja"]."' OR m_ukerja.kode_instansi = '".$param["kode_ukerja"]."' )";
    
        //mulai query untuk presensi
        // $CI->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_pegawai_jab);
        // $CI->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_pegawai_gol);
        // $CI->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_pegawai_pensiun);
        // $CI->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_pegawai_aktif);
        // $CI->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_presensi_pegawai);
        $CI->db->query("CREATE TEMPORARY TABLE ".$name_temp_pegawai_jab." 
        (PRIMARY KEY pktemp (nip),
        INDEX idx_temp (nip),
        nip varchar(18),
        nama varchar(255),
        ket_ukerja varchar(255),
        ket_jab varchar(255)
        )");
    
        $CI->db->query("INSERT INTO ".$name_temp_pegawai_jab." SELECT r_jab.nip AS nip,m_pegawai.nama,r_jab.ket_ukerja,r_jab.ket_jab FROM r_jab 
        JOIN m_pegawai ON r_jab.nip = m_pegawai.nip
        JOIN m_ukerja ON r_jab.kode_ukerja = m_ukerja.kode_ukerja
        JOIN m_jab ON r_jab.kode_jab = m_jab.kode_jab AND r_jab.kode_ukerja = m_jab.kode_ukerja
        WHERE (
                  (UPPER(
                  LEFT ( r_jab.ket_jab, 4 )) = \"GURU\" 
                  OR r_jab.ket_jab LIKE \"% GURU%\" 
                  OR r_jab.ket_jab LIKE \"%GURU %\" 
                  OR LEFT ( r_jab.ket_jab, 16 ) = \"PENGAWAS SEKOLAH\" 
                  OR LEFT ( r_jab.ket_jab, 8 ) = \"PENGAWAS\" 
                  )
                  AND ".$filter_ukerja." 
                  AND (
                    m_pegawai.tgl_keluar IS NULL 
                  OR ( m_pegawai.tgl_keluar > '".$param["filter_thn"]."-".$param["filter_bln"]."-01' OR m_pegawai.s_aktif = \"-1\" ))
                  AND r_jab.tmt_jab <= '".$param["filter_thn"]."-".$param["filter_bln"]."-01')
         GROUP BY r_jab.nip");
        
         $CI->db->query("CREATE TEMPORARY TABLE ".$name_temp_pegawai_pensiun."
         (PRIMARY KEY pktemp (nip),
          INDEX idx_temp (nip),
          nip varchar(18),
          tgl_pensiun date
         )");
                
         $CI->db->query("INSERT INTO ".$name_temp_pegawai_pensiun." SELECT ".$name_temp_pegawai_jab.".nip,f_get_tgl_pensiun( m_pegawai.tgl_lahir, m_jab.jns_jab, m_pegawai.kode_gol, m_pegawai.kode_eselon)
         FROM ".$name_temp_pegawai_jab." JOIN m_pegawai ON m_pegawai.nip = ".$name_temp_pegawai_jab.".nip 
         JOIN m_jab ON m_pegawai.kode_ukerja = m_jab.kode_ukerja AND m_pegawai.kode_jab = m_jab.kode_jab"); 
         
         $CI->db->query("CREATE TEMPORARY TABLE ".$name_temp_pegawai_aktif."
         (PRIMARY KEY pktemp (nip),
          INDEX idx_temp (nip),
          nip varchar(18),
          tgl_pensiun date,
          nomor_jab bigint(20)
         )");
             
         $CI->db->query(
          "INSERT INTO ".$name_temp_pegawai_aktif." SELECT ".$name_temp_pegawai_pensiun.".nip as nip,".$name_temp_pegawai_pensiun.".tgl_pensiun as tgl_pensiun,f_get_jab_per_period(".$name_temp_pegawai_pensiun.".nip, '".$param["filter_thn"]."-".$param["filter_bln"]."-02') AS nomor_jab FROM ".$name_temp_pegawai_pensiun." WHERE ".$name_temp_pegawai_pensiun.".tgl_pensiun > '".$param["filter_thn"]."-".$param["filter_bln"]."-01'"
         );
    
         $CI->db->query(
          "CREATE TEMPORARY TABLE ".$name_temp_presensi_pegawai." 
          (PRIMARY KEY pktemp (nip,tahun,bulan),
           INDEX idx_temp (nip),
           id int(11),
           nip varchar(18),
           nama varchar(255),
           kode_gol varchar(5),
           kode_status varchar(1),
           kode_agama varchar(1),
           kode_jab varchar(20),
           kode_ukerja varchar(20),
           ket_jab varchar(100),
           ket_uorg varchar(200),
           ket_ukerja varchar(100),
           jns_jab varchar(6),
           kode_eselon varchar(2),
           tahun int(4),
           bulan int(2),
           terlambat int(11),
           pulang_cepat int(11),
           tidak_masuk int(11),
           tidak_apel int(11),
           lupa_absen int(11),
           potongan_persen decimal(5,2),
           potongan_persen_harian decimal(5,2),
           last_update timestamp,
           username_input varchar(255),
           input_time datetime
          )"
         );
          //tanggal maximum dibulan filter
          $periode_filter = $param["filter_thn"]."-".$param["filter_bln"]."-".date("t");
          $periode_filter_awal = $param["filter_thn"]."-".$param["filter_bln"]."-01";
    
          //f_get_gol_per_period(".$name_temp_pegawai_aktif.".nip,'".$periode_filter."') AS kode_gol,
    
          //query untuk mendapat list data pegawai
          $CI->db->query("INSERT INTO ".$name_temp_presensi_pegawai." SELECT 
          r_presensi.id as id,
          ".$name_temp_pegawai_aktif.".nip as nip,
          CONCAT_WS(IF(m_pegawai.gelar_dpn IS NOT NULL,CONCAT(m_pegawai.gelar_dpn,\",\"),\"\"),m_pegawai.nama,IF(m_pegawai.gelar_blk IS NOT NULL,CONCAT(\",\",m_pegawai.gelar_blk),\"\")) AS nama,
          f_get_gol_per_period(".$name_temp_pegawai_aktif.".nip,\"".$periode_filter_awal."\") AS kode_gol,
          m_pegawai.kode_status,
          m_pegawai.kode_agama,
          r_jab.kode_jab AS kode_jab,
          r_jab.kode_ukerja AS kode_ukerja,
          r_jab.ket_jab AS ket_jab,
          r_jab.ket_uorg AS ket_uorg,
          r_jab.ket_ukerja AS ket_ukerja,
          r_jab.jns_jab AS jns_jab,
          r_jab.kode_eselon AS kode_eselon,      
          r_presensi.tahun AS tahun,
          r_presensi.bulan AS bulan,
          r_presensi.terlambat AS terlambat,
          r_presensi.pulang_cepat AS pulang_cepat,
          r_presensi.tidak_masuk AS tidak_masuk,
          r_presensi.tidak_apel AS tidak_apel,
          r_presensi.lupa_absen AS lupa_absen,
          IFNULL(r_presensi.potongan_persen,'Data Tidak Ditemukan') AS potongan_persen,
          r_presensi.potongan_persen_harian AS potongan_persen_harian,
          r_presensi.last_update AS last_update,
          r_presensi.username_input AS username_input,
          r_presensi.input_time AS input_time
            FROM ".$name_temp_pegawai_aktif." LEFT JOIN 
            (
            SELECT * FROM progurinda_r_data_presensi WHERE tahun = ".$param["filter_thn"]." AND bulan = ".$param["filter_bln"]."
            ) AS r_presensi ON ".$name_temp_pegawai_aktif.".nip = r_presensi.nip
            LEFT JOIN m_pegawai ON ".$name_temp_pegawai_aktif.".nip = m_pegawai.nip
            LEFT JOIN r_jab ON ".$name_temp_pegawai_aktif.".nomor_jab = r_jab.nomor
            JOIN m_ukerja ON r_jab.kode_ukerja = m_ukerja.kode_ukerja
            WHERE (UPPER(
                    LEFT ( r_jab.ket_jab, 4 )) = \"GURU\" 
                    OR r_jab.ket_jab LIKE \"% GURU%\" 
                    OR r_jab.ket_jab LIKE \"%GURU %\" 
                    OR LEFT ( r_jab.ket_jab, 16 ) = \"PENGAWAS SEKOLAH\" 
                    OR LEFT ( r_jab.ket_jab, 8 ) = \"PENGAWAS\" 
                    )
                    AND ".$filter_ukerja."
          ");

          $CI->db->query("CREATE TEMPORARY TABLE ".$name_temp_pegawai_out." 
          (PRIMARY KEY pktemp (id),
          INDEX idx_temp (nip_out),
          id int(11),
          nip_out varchar(18),
          tmt_out varchar(255),
          keterangan_out varchar(50)
          )");

          $CI->db->query(
            "INSERT INTO ".$name_temp_pegawai_out." SELECT id,nip,tmt_out,keterangan_out FROM progurinda_pegawai_out WHERE progurinda_pegawai_out.tmt_out <= '".$periode_filter_awal."' AND (progurinda_pegawai_out.tmt_aktif_kembali IS NULL OR progurinda_pegawai_out.tmt_aktif_kembali = \"\" OR 
            progurinda_pegawai_out.tmt_aktif_kembali >= '".$periode_filter."'
            )"
          );
                    
          //$data["jml"] = $CI->db->query("SELECT * FROM ".$name_temp_presensi_pegawai)->num_rows();
          $list = $CI->db->query("SELECT *,m_gol.ket_gol AS ket_gol,m_gol.ket_gol_pppk AS ket_gol_pppk FROM ".$name_temp_presensi_pegawai." LEFT JOIN m_gol ON ".$name_temp_presensi_pegawai.".kode_gol = m_gol.kode_gol
          LEFT JOIN ".$name_temp_pegawai_out." ON ".$name_temp_presensi_pegawai.".nip = ".$name_temp_pegawai_out.".nip_out
          WHERE ".$name_temp_pegawai_out.".id IS NULL
          ORDER BY ".$name_temp_presensi_pegawai.".kode_eselon,".$name_temp_presensi_pegawai.".kode_ukerja asc,".$name_temp_presensi_pegawai.".kode_jab asc")->result_array();
          
          // echo $name_temp_pegawai_jab;
          // echo "<br>".$name_temp_pegawai_pensiun;
          // echo "<br>".$name_temp_pegawai_gol;
          // echo "<br>".$name_temp_pegawai_aktif;
          // echo "<br>".$name_temp_presensi_pegawai;
          $CI->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_pegawai_jab);
          $CI->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_pegawai_pensiun);
          $CI->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_pegawai_gol);
          $CI->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_pegawai_aktif);
          $CI->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_presensi_pegawai);          
          $CI->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_pegawai_out);
    
        //----------=========---------------------------------------//
       //   END - query untuk dapat list pegawainya di periode itu //
      //-----------------=--=========-----------------------------//
          
          $counter = 0;
          $max_jam_mengajar = 96;
          $bayar_penuh = false;
          $list_presensi = array();
          $list_capaian = array();
          //cek apakah ada pengecualian dimana dibayar penuh
          $check_bayar_penuh = $CI->db->where(["tahun" => $param["filter_thn"],"bulan" => $param["filter_bln"]])->get("progurinda_r_full_pay");
          if ($check_bayar_penuh->num_rows() > 0){
            $bayar_penuh = true;
          }else{
            //ambil data presensi 
            $list_presensi = $CI->db->where(
            "kode_ukerja LIKE '".$param["kode_ukerja"]."%' AND tahun = '".$param["filter_thn"]."' AND bulan = '".$param["filter_bln"]."'"
            )->get("progurinda_r_data_presensi")->result_array();
            $list_capaian = $CI->db->where(
            "kode_ukerja LIKE '".$param["kode_ukerja"]."' AND tahun = '".$param["filter_thn"]."' AND bulan = '".$param["filter_bln"]."'"
            )->get("progurinda_r_jurnal_mengajar")->result_array();
          }
          //loop lengkapi field2 nya
          foreach ($list as $key => $value) {
            $potongan_disiplin = 0;
            $capaian_produktivitas = 0;
            //cocokan data presensi
            if($bayar_penuh){
              $capaian_produktivitas = 1;
              $jam_mengajar = $max_jam_mengajar;
              $potongan_disiplin = 0;
            }else{
              foreach ($list_presensi as $key2 => $value2) {
                if ($value["nip"] == $value2["nip"]){
                  $potongan_disiplin = $value2["potongan_persen"];
                  break;
                }
              }
              //cocokan data capaian
              foreach ($list_capaian as $key3 => $value3) {
                if ($value["nip"] == $value3["nip"]){
                  $jam_mengajar = $value3["jam_mengajar"];
                  $capaian_produktivitas = $jam_mengajar / $max_jam_mengajar;
                  if ($capaian_produktivitas > 1){
                    $capaian_produktivitas = 1;
                  }
                  break;
                }
              }
            }
            //cari daftar tambahan tpp
            $q_list_tambahan_tpp = $CI->db->where("tmt_mulai <= '".$periode_filter_awal."' AND tmt_selesai >= '".$periode_filter_awal."'")->get("progurinda_tambahan_tpp");
            if($q_list_tambahan_tpp->num_rows() > 0){
              $list_tambahan_tpp = $q_list_tambahan_tpp->result_array();
            }else{
              $list_tambahan_tpp = false;
            }
            //tentukan nilai tpp berdasarkan golongan/jenjnag jabatan (ahli muda, ahli pertama, ahli madya) / tentukan pns/cpns atau pppk
            $basic_tpp = $this->get_basic_tpp($value,$list_tambahan_tpp);
            
            $list[$counter]["besaran_tpp"] = $basic_tpp["respons_nominal"];
            $list[$counter]["jenjang"] = $basic_tpp["jenjang"];
            //tentukan potongannya
            //potongan dari disiplin - START
            $list[$counter]["tpp_disiplin_kerja"] = (float)($list[$counter]["besaran_tpp"] * 40 / 100);
            $list[$counter]["total_potongan_disiplin"] =  ($bayar_penuh) ? 0 : $list[$counter]["tpp_disiplin_kerja"] * (float)$potongan_disiplin / 100;  
            $list[$counter]["penghasilan_tpp_disiplin"] = (float)$list[$counter]["tpp_disiplin_kerja"] - (float)$list[$counter]["total_potongan_disiplin"];
            //potongan dari disiplin - END
            
            //potongan dari jurnal mengajar - START
            $list[$counter]["tpp_produktivitas"] = (float)($list[$counter]["besaran_tpp"] * 60 / 100);
            $list[$counter]["capaian_produktivitas"] = (float)($capaian_produktivitas * 100);
            $list[$counter]["jam_mengajar"] = (float)($jam_mengajar);
            $list[$counter]["max_jam_mengajar"] = (float)($max_jam_mengajar);
            $list[$counter]["nilai_capaian"] = (float)($list[$counter]["tpp_produktivitas"] * $capaian_produktivitas);
            //potongan jurnal mengajar - END
            $list[$counter]["total_tpp_guru"] = $list[$counter]["nilai_capaian"] + $list[$counter]["penghasilan_tpp_disiplin"];
            //susun list untuk ditampilkan di front end
            $counter++;
        }
        return $list;
      }
}