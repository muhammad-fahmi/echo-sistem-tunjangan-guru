<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "third_party/TCPDF/tcpdf.php";
class Tcpdf_lib extends TCPDF
{
    public function __construct($args)
    {
        parent::__construct(
            $args["orientation"],
            $args['unit'],
            $args['format'],
            $args['unicode'],
            $args['encoding'],
            $args['diskcache'],
            $args['pdfa']
        );
    }
}
