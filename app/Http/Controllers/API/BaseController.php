<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BaseController extends Controller
{
    public function sendResponse($result, $message = 'successfully')
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];
        return response()->json($response, 200);
    }

    public function sendError($error, $errormessage = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error
        ];
        if (!empty($errormessage)) {
            $response['data'] = $errormessage;
        }
        return response()->json($response, 200);
    }
    public function saveimg($folder, $img, $oldimg = null, $title = null)
    {
        $nameImg = $folder . '_' . Str::random(30) . '.' . $img->getClientOriginalExtension();
        if ($title) {
            $nameImg = $folder . '_' . $title . '_' . Str::random(10) . '.' . $img->getClientOriginalExtension();
        }
        if ($oldimg) {
            // return 1;
            if (Storage::exists($oldimg)) {
                Storage::delete($oldimg);
            }
        }
        $path = $img->storeAs('public/gambar/' . $folder, $nameImg);
        return $path;
    }
}
