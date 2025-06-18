<?php
//fungsi untuk mengecek pakah periode tpp sudah dikunci
function isFinal($kode_ukerja,$filter_thn,$filter_bln){
    $CI = &get_instance();
    if (!(isset_nn_nes($kode_ukerja) && isset_nn_nes($filter_thn) && isset_nn_nes($filter_bln))){
        $response["val"] = true;
        $response["error"] = true;
        $response["message"] = "Error : parameter tidak lengkap!";
    }else{
        //cek apakah ada record final untuk param tersebut
        $check_q = $CI->db->where(array("kode_ukerja" => $kode_ukerja,"bulan" => $filter_bln,"tahun" => $filter_thn))->get("progurinda_r_arsip_tpp")->num_rows();
        if ($check_q > 0){
            $response["val"] = true;
            $response["error"] = true;
            $response["message"] = "Error : Periode $filter_bln/$filter_thn sudah FINAL!";
        }else{
            $response["val"] = false;
            $response["error"] = false;
            $response["message"] = "Periode $filter_bln/$filter_thn BELUM FINAL!";
        }
    }
    return $response;
}