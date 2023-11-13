<?php defined('BASEPATH') or exit('No direct script access allowed');

class Maintenance extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    private $myInt = 5; // Integer
    private $myFloat = 5.2; //Float
    private $myChar = "G"; //Character
    private $myString = "suksma"; //String
    private $myBool = true; //Boolean 


    public function index()
    {
        if (isset_nn_nes($this->session->userdata())) {
            $this->session->sess_destroy();
        }
        $sent_data = array();
        $data = array(
            'page_title' => "Login",
            'module' => "login",
            'view' => "vw_login",
            'data' => $sent_data,
            ''
        );
        echo Modules::run('layout/portal', $data);
    }

    /** fungsi recreate notif dari data attlog */
    public function create_notif_attlog()
    {
        echo "Inserting notif from ATTLOG : <br>";
        $list_attlog = $this->db->get('r_attlog')->result_array();
        $counter = 0;
        foreach ($list_attlog as $val) {
            $data_notif = array(
                "judul" => "Presensi",
                "isi"   => "Data Presensi anda pada " . tglFormat($val["scan_date"], "D, d M yyyy T") . " sudah masuk ke sistem",
                "nip"   => $val["pin"],
                "s_read" => 0,
                "timestamp" => date("Y-m-d H:i:s")
            );
            $this->db->insert("r_notif", $data_notif);
            $counter++;
        }
        echo "<br>Total data yang diinsert : " . $counter;
    }

    /* Fungsi untuk generate password user OPD */
    public function setup_password($table)
    {
        //list data user opd baru
        $user_baru = $this->db->get($table)->result_array();
        $counter = 0;
        $gagal = 0;
        $success = 0;
        foreach ($user_baru as $key => $value) {
            $data = array(
                "password" => encrypt_pwd($value["password"]),
                "salt" => micin(),
                "tgl_daftar" => date("Y-m-d H:i:s")
            );
            $counter++;
            if ($this->db->where("username = '" . $value["username"] . "'")->update($table, $data)) {
                echo "Setup password username : " . $value["username"] . " berhasil!";
                $success++;
            } else {
                echo "Setup password username : " . $value["username"] . " GAGAL!";
                $gagal++;
            }
        }
        echo "Total data Process : " . $counter . " Success: " . $success . " |  GAGAL : " . $gagal;
    }

    /* Fungsi untuk generate menu user OPD */
    public function setup_menu($user_acuan = "", $table = "")
    {
        //get menu dari user acuan
        $menu_acuan = $this->db->where("username = '" . $user_acuan . "'")->get("m_user_menu")->result_array();
        //list data user opd baru
        $user_baru = $this->db->where("username != '" . $user_acuan . "'")->get($table)->result_array();
        $counter = 0;
        $gagal = 0;
        $success = 0;
        foreach ($user_baru as $key => $value) {
            //clear menu dari user di m user menu
            $this->db->where("username = '" . $value["username"] . "'")->delete("m_user_menu");
            $menu_gagal = 0;
            foreach ($menu_acuan as $m) {
                $data_menu = $m;
                $data_menu["username"] = $value["username"];
                if ($this->db->insert("m_user_menu", $data_menu)) {
                    echo "user : " . $value["username"] . "insert Menu berhasil<br>";
                    $success++;
                } else {
                    echo "user : " . $value["username"] . "insert Menu Gagal<br>";
                    $menu_gagal++;
                }
            }
            if ($menu_gagal == 0) {
                echo "<br>setup menu user :" . $value["username"] . " BERHASIL!";
            } else {
                echo "<br>setup menu user :" . $value["username"] . " GAGAL! Menu gagal insert" . $menu_gagal;
            }
            $counter++;
        }
        echo "Total data Process : " . $counter . " Success: " . $success . " |  GAGAL : " . $gagal;
    }

    public function read_my_keyboard()
    {
        //get 3 commands from user
        for ($i = 0; $i < 3; $i++) {
            $line = readline("Command: ");
            readline_add_history($line);
        }

        //dump history
        print_r(readline_list_history());

        //dump variables
        print_r(readline_info());
    }
}
