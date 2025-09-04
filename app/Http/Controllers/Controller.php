<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function respon($param = null, $msg = null, $status = null, $status_msg = null, $rows = null, $result = null)
    {
        $response['response'] = array(
            'status' => $status,
            'message' => $msg,
            'status_msg' => $status_msg,
        );
        $response['param'] = $param;
        $response['rows'] = $rows;
        $response['results'] = $result;

        return $response;
    }

    public function resSuccess($param = null, $status = null, $msg = null, $status_msg = null, $result = null)
    {
        $response['response'] = array(
            'status' => $status,
            'message' => $msg,
            'status_msg' => $status_msg,
        );
        $response['param'] = !empty($param) ? $param : '';
        // $response['rows'] = count($result) > 1 ? count($result) : $result->count();
        $response['results'] = $result;

        return response()->json($response, 200);
    }

    public function resSuccessOld($message = null, $data = null, $rows = null, $msg = null, $param = null)
    {
        $response = [
            'response' => [
                'status'  => true,
                'message' => 'Berhasil',
                'status_msg' => $msg ?? null
            ],
            'param' =>  $param ?? "",
            'rows'  =>  $rows ?? null,
            'results'    => $data ?? null
        ];
        return response()->json($response);
    }

    public function resError($status_msg = null, $message = null, $param = null, $code = 200)
    {
        $response['response'] = array(
            'status' => false,
            'message' => !empty($message) ? $message : 'Terjadi Kesalahan',
            'status_msg' => $status_msg,
        );
        $response['param'] = !empty($param) ? $param : '';
        $response['results'] = null;

        return response()->json($response, $code);
    }

    public function resErrorNew($message = null)
    {
        $response = [
            'response' => [
                'status'  => false,
                'message' => $message ?? null,
                'status_msg' => $message ?? null,
            ],
            'param' =>  "",
            'rows'  =>  null,
            'results'    => null
        ];
        return response()->json($response);
    }

    public function resErrorAuth($message = null, $result)
    {
        $response = [
            'response' => [
                'status'  => false,
                'message' => $message ?? null,
                'status_msg' => $message ?? null,
            ],
            'param' =>  "",
            'rows'  =>  null,
            'results'    => $result
        ];
        return response()->json($response);
    }

    public function resCatchError($message, $pesan = null)
    {
        $post = isset($message['param']) ? $message['param'] : '';
        $path = isset($message['path']) ? $message['path'] : '';
        //set error telegram
        $message = [
            'APP_NAME' => $_ENV['APP_NAME'],
            'message' => $message['error']->getMessage(),
            'file_name' => $message['error']->getFile(),
            'line' => $message['error']->getLine(),
            'param' => $post,
            'path' => $path,
        ];
        // $this->resTelegram(json_encode($message));
        $response = [
            'status' => false,
            'message' => 'Terjadi Kesalahan',
            'error' => $message,
        ];
        return response()->json($response);
    }

    public function resTelegram($message = 'halo ini message')
    {
        $room_id = [
            '1452004771', //araf
            '886665056', //ricky
            '456153430', //zamal
        ];
        foreach ($room_id as $key => $value) {
            $data = [
                'text' => $message,
                'chat_id' => $value
            ];
            /**your BOT */
            file_get_contents("https://api.telegram.org/bot1554794536:AAG9mjPjD4Wh8reGUA4LRlSZWdVgEuYU5Ds/sendMessage?" . http_build_query($data)); // @ApiSidoniRS_Bot
        }

        return $room_id;
    }

    public function resSuccessLogin($message = null, $data = null, $msg = null)
    {
        $response = [
            'response' => [
                'status'  => true,
                'message' => 'Berhasil',
                'status_msg' => $msg ?? null
            ],
            'results'    => $data ?? null
        ];
        return response()->json($response);
    }
}
