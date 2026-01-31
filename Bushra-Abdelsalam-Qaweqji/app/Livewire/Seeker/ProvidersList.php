<?php

namespace App\Livewire\Seeker;

use App\Models\ProviderProfile;
use App\Models\ProviderService;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class ProvidersList extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    public string $zip_code = '';
    public string $service = 'all';
    public string $rating_min = '';
    public string $price_sort = '';
    public int $page = 1;
    
    protected array $queryString = [
        'zip_code' => ['except' => ''],
        'service' => ['except' => 'all'],
        'rating_min' => ['except' => ''],
        'price_sort' => ['except' => ''],
        'page' => ['except' => 1],

        ];
        

    public function updated($propertyName): void
    {
        if (in_array($propertyName, ['zip_code', 'service', 'rating_min', 'price_sort'], true)) {
            $this->resetPage();
        }
    }

    public function resetFilters(): void
    {
        $this->zip_code = '';
        $this->service = 'all';
        $this->rating_min = '';
        $this->price_sort = '';

        $this->resetPage();
    }

    private function query(): Builder
    {
        $zip = trim($this->zip_code);
        $service = $this->service;
        $ratingMin = trim((string) $this->rating_min);
        $ratingMinInt = $ratingMin !== '' ? (int) $ratingMin : null;

        $q = ProviderProfile::query()
            ->whereHas('user', function (Builder $u) {
                $u->where('role', User::ROLE_PROVIDER)->where('status', User::STATUS_ACTIVE);
            })
            ->whereHas('services')
            ->when($zip !== '', fn (Builder $q) => $q->where('zip_code', 'like', "{$zip}%"))
            ->when($service !== 'all', function (Builder $q) use ($service) {
                $q->whereHas('services.category', function (Builder $c) use ($service) {
                    $c->where('code', $service);
                });
            })
            ->when($ratingMinInt !== null, fn (Builder $q) => $q->where('avg_rating', '>=', $ratingMinInt))
            ->addSelect([
                'min_rate' => ProviderService::query()
                    ->selectRaw('MIN(hourly_rate)')
                    ->whereColumn('provider_user_id', 'provider_profiles.user_id')
                    ,
            ])
            ->with([
                'user:id,name',
                'services:id,provider_user_id,service_category_id,hourly_rate',
                'services.category:id,code,name',
            ]);

        if ($this->price_sort === 'low_high') {
            $q->orderBy('min_rate');
        } elseif ($this->price_sort === 'high_low') {
            $q->orderByDesc('min_rate');
        } else {
            $q->orderByDesc('avg_rating')->orderBy('min_rate');
        }

        return $q;
    }

    public function render()
    {
        $providers = $this->query()->paginate(12);

        $providers->getCollection()->transform(function ($provider) {
            $profileImage = $provider->profile_image;
            $profilePath = $profileImage
                ? (str_contains($profileImage, '/') ? $profileImage : 'provider-avatars/' . $profileImage)
                : null;

            if ($profilePath && Storage::disk('public')->exists($profilePath)) {
                $provider->profile_image_url = asset('storage/' . $profilePath);
            } else {
                $provider->profile_image_url = asset('seeker/img/images.jpg');
            }

            return $provider;
        });

        return view('livewire.seeker.providers-list', [
            'providers' => $providers,
        ]);
    }
}
