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
        if (strpos($pegawai["ket_jab"],"Guru")){
            $guru = true;
        }elseif(strpos($pegawai["ket_jab"],"Pengawas Sekolah")){
            $pengawas = true;
        }
        
        $nominal = array(
            "guru" => array(
                "PNS" => array(
                    "PTM" => 1100000, //1.100.000,
                    "MDA" => 1200000, //1.200.000
                    "MDY" => 1300000, //1.300.000
                    "FUN" => 1050000, //1.050.000
                ),
                "PPPK" => array(
                    "PTM" => 1000000 //1.000.000
                )
            ),
            "pengawas" => array(
                "PNS" => array(
                    "MDY" => 1300000 //1.300.000
                ),
                "PPPK" => array(
                    "MDY" => 0
                )
            ) 
        );

        if ($guru){
            if($pegawai["kode_status"] <= 2){
                //PNS/CPNS
                $respons_nominal = $nominal["guru"]["PNS"][$pegawai["jenjang"]];
            }else{
                //PPPK
                $respons_nominal = $nominal["guru"]["PPPK"][$pegawai["jenjang"]];
            }
        }elseif($pengawas){
            if($pegawai["kode_status"] <= 2){
                //PNS/CPNS
                $respons_nominal = $nominal["pengawas"]["PNS"][$pegawai["jenjang"]];
            }else{
                //PPPK
                $respons_nominal = $nominal["pengawas"]["PPPK"][$pegawai["jenjang"]];
            }
        }

        return $respons_nominal;
    }
}