<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * upload file related to project and its tasks generally
     */
    public function store(Request $request)
    {
        $file = $request->file('file');

        $filename = uniqid() . '.' . $file->getClientOriginalExtension();

        Storage::putFileAs('public/images', $file, $filename);

        $url = url(Storage::url('public/images/' . $filename));

        return response()->json([
            'location' =>  $url
        ]);
    }
}
