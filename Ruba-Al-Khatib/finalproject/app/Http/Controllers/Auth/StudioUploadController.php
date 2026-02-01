<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudioUploadController extends Controller
{
    public function upload(Request $request)
    {
        // file name = "file"
        $request->validate([
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // 5MB لكل صورة
        ]);

        $path = $request->file('file')->store('studios/portfolio', 'public');

        return response()->json([
            'ok' => true,
            'path' => $path,
            'url' => asset('storage/' . $path),
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'path' => ['required', 'string'],
        ]);

        // حماية بسيطة: نخلي الحذف فقط داخل folder studios/portfolio
        if (!str_starts_with($request->path, 'studios/portfolio/')) {
            return response()->json(['ok' => false], 403);
        }

        Storage::disk('public')->delete($request->path);

        return response()->json(['ok' => true]);
    }
}
