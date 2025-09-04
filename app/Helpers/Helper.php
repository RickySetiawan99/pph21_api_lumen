<?php

namespace App\Helpers;

use App\Models\Promo\Promo;

class Helper
{
    public static function test()
    {
        return 'test';
    }

    // set custom result
    public static function setResults($data)
    {
        if($data['status'] == true) {
            $arrData = [
                'res_status'     => true,
                'msg'            => $data['message'],
                'status_msg'     => 'Success',
                'result'         => $data['data'],
            ];
        }else{
            $arrData = [
                'res_status'     => false,
                'msg'            => $data['message'],
                'status_msg'     => 'Failed',
                'result'         => NULL,
            ];
        }

        return $arrData;
    }

    // set custom result repository
    public static function setResultsRepository($data)
    {
        if(count($data) > 0) {
            $result = [
                'status'    => true,
                'message'   => 'Berhasil Mendapatkan Data',
                'data'      => $data,
            ];
        }else{
            $result = [
                'status'    => false,
                'message'   => 'Data tidak ditemukan',
            ];
        }

        return $result;
    }

    public static function get_ip_user(){
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }
}
