<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Progurinda_lib
{
    //mencari nilai basic TPP guru/pengawas sekolah
    public function get_basic_tpp($pegawai){
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
                    "MDY" => 1300000, //1.300.000
                    "XX"  => 0
                ),
                "PPPK" => array(
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
        $respons["respons_nominal"] = $respons_nominal;
        $respons["jenjang"] = $jenjang;
        return $respons;
    }

    function get_jenjang($pegawai){
        //cek jenjang jabatan
        $jenjang = "XX";
        if (strpos(strtoupper($pegawai["ket_jab"]),"PERTAMA") !== false){
            $jenjang = "PTM";
        }elseif(strpos(strtoupper($pegawai["ket_jab"]),"MUDA") !== false){
            $jenjang = "MDA";
        }elseif(strpos(strtoupper($pegawai["ket_jab"]),"MADYA") !== false){
            $jenjang = "MDY";
        }elseif(strpos(strtoupper($pegawai["ket_jab"]),"GURU") !== false){
            $jenjang = "FUN";
        }

        return $jenjang;
    }
}