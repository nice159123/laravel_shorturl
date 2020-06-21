<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    /**
     *  Api Get ShortUrl
     */
    public function get_url (ShortUrl $shortUrl) {
        return $this->responseSuccess($shortUrl->all());
    }

    /**
     *  Api Create ShortUrl
     */
    public function store_url (Request $request) {

        $datas = [
            'user_id' => auth()->user()->id ?? null,
            'code' => Str::random(5),
            'url' => $request->link,
            'password' => $request->password != null ? Hash::make($request->password) : null,
            'count' => 0,
            'status' => true
        ];

        if ($shorturl = ShortUrl::create($datas)) {
            return $this->responseSuccess(asset($shorturl->code));
        }

    }

    /**
     *
     */
    public function confirmPassword ($code) {
        $shortUrl = ShortUrl::where('code', $code)->firstOrFail();
        return view('confirmPassword', [
            'shorturl' => $shortUrl
        ]);
    }

    public function checkPassword (Request $request, $code) {
        $shortUrl = ShortUrl::where('code', $code)->firstOrFail();
        if (Hash::check($request->password, $shortUrl->password)) {
            return $this->redirectTo($shortUrl->code);
        } else {
            return redirect()->back()->with('error', 'รหัสผ่านไม่ถูกต้อง');
        }
    }

    /**
     *  Redirect To link....
     */
    public function redirectTo ($code) {
        $shortUrl = ShortUrl::where('code', $code)->firstOrFail();
        $shortUrl->count = $shortUrl->count + 1;
        $shortUrl->save();
        return redirect()->away($shortUrl->url);
    }

    /**
     *  Api Response Success
     */
    protected function responseSuccess($res)
    {
        return response()->json(["status" => true, "data" => $res], 200)
            ->header("Access-Control-Allow-Origin", "*")
            ->header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
    }

    /**
     *  Api Response Error
     */
    protected function responseError($message)
    {
        return response()->json(["status" => false, "message" => $message], 200)
            ->header("Access-Control-Allow-Origin", "*")
            ->header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
    }
}
