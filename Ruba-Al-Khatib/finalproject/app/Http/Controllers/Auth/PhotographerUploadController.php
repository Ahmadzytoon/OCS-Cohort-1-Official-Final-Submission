<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotographerUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // 5MB
        ]);

        $path = $request->file('file')->store('photographers/portfolio', 'public');

        return response()->json([
            'ok' => true,
            'path' => $path,
            'url'  => asset('storage/' . $path),
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'path' => ['required', 'string'],
        ]);

        if (!str_starts_with($request->path, 'photographers/portfolio/')) {
            return response()->json(['ok' => false], 403);
        }

        Storage::disk('public')->delete($request->path);

        return response()->json(['ok' => true]);
    }

    public function uploadProfile(Request $request)
{
    $request->validate([
        'file' => ['required', 'image', 'max:5120'], // 5MB
    ]);

    $path = $request->file('file')->store('photographers/profile', 'public');

    return response()->json([
        'ok' => true,
        'path' => $path,
    ]);
}

public function destroyProfile(Request $request)
{
    $request->validate([
        'path' => ['required', 'string'],
    ]);

    Storage::disk('public')->delete($request->path);

    return response()->json(['ok' => true]);
}

}
