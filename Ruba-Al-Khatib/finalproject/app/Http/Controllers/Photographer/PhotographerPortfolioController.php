<?php
namespace App\Http\Controllers\Photographer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Photographer;
use App\Models\PhotographerPortfolio;
use App\Models\User;


class PhotographerPortfolioController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $photographer = Photographer::where('user_id', $user->id)->firstOrFail();

        $items = PhotographerPortfolio::where('photographer_id', $photographer->id)
            ->orderByDesc('id')
            ->get()
            -> groupBy('category');

        return view('photographer.portfolio.index', compact('items'));
    }
    public function store(Request $request)
{
    $request->validate([
        'category' => ['required', 'string', 'max:50'],
        'images' => ['required', 'array', 'min:1'],
        'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
    ]);

    $user = Auth::user();
    $photographer = Photographer::where('user_id', $user->id)->firstOrFail();

    // ✅ LIMIT CHECK قبل الرفع
    $limit = $user->featureValue('portfolio_limit', null); // null = unlimited

    if (!is_null($limit)) {
        $current  = PhotographerPortfolio::where('photographer_id', $photographer->id)->count();
        $incoming = count($request->file('images'));

        if (($current + $incoming) > (int)$limit) {
            return back()->with(
                'error',
                "You can upload up to {$limit} photos only. You currently have {$current}. Upgrade your plan."
            );
        }
    }

    foreach ($request->file('images') as $image) {
        $ext  = $image->getClientOriginalExtension();
        $name = 'portfolio/' . $photographer->id . '/' . Str::uuid() . '.' . $ext;

        Storage::disk('public')->put($name, file_get_contents($image));

        PhotographerPortfolio::create([
            'photographer_id' => $photographer->id,
            'image_path' => $name,
            'category' => $request->category,
        ]);
    }

    return redirect()->back()->with('success', 'Photos uploaded successfully!');
}





    public function show(User $photographer)
    {
        abort_unless(
            ($photographer->account_type ?? null) === 'photographer' &&
            (($photographer->status ?? 'pending') === 'approved'),
            404
        );

        // ✅ profile row (photographers table)
        $profile = $photographer->photographerProfile;

        // ✅ portfolio items (photographer_portfolio)
        $portfolio = $photographer->portfolioItems()
            ->latest()
            ->take(60)
            ->get();

        return view('main.photographer-profile', compact('photographer', 'profile', 'portfolio'));
    }



public function destroy($id)
{
    $user = Auth::user();
    $photographer = Photographer::where('user_id', $user->id)->firstOrFail();

    $photo = PhotographerPortfolio::where('id', $id)
        ->where('photographer_id', $photographer->id)
        ->firstOrFail();

    if ($photo->image_path && Storage::disk('public')->exists($photo->image_path)) {
        Storage::disk('public')->delete($photo->image_path);
    }

    $photo->delete();

    return redirect()->back()->with('success', 'Photo deleted.');
}

}
