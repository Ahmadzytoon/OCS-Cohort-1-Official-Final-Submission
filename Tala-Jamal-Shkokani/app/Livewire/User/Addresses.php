<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class Addresses extends Component
{
    public $addresses;
    public $address_id;
    public $type = 'home';
    public $area;
    public $street_address;
    public $building_no;
    public $apartment_no;
    public $phone;
    public $is_default = false;

    public $showModal = false;

    protected function rules()
    {
        return [
            'type' => 'required',
            'area' => 'required',
            'street_address' => 'required',
            'phone' => ['required', 'regex:/^(07[789]\d{7})$/'],
        ];
    }

    protected $messages = [
        'phone.regex' => 'Phone number must be a valid Jordanian mobile (e.g., 079XXXXXXX).'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->loadAddresses();
    }

    public function loadAddresses()
    {
        $this->addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();
    }

    public function openModal($id = null)
    {
        $this->resetErrorBag();
        if ($id) {
            $address = UserAddress::findOrFail($id);
            $this->address_id = $address->id;
            $this->type = $address->type;
            $this->area = $address->area;
            $this->street_address = $address->street_address;
            $this->building_no = $address->building_no;
            $this->apartment_no = $address->apartment_no;
            $this->phone = $address->phone;
            $this->is_default = $address->is_default;
        } else {
            $this->reset(['address_id', 'type', 'area', 'street_address', 'building_no', 'apartment_no', 'phone', 'is_default']);
            $this->type = 'home';
        }
        $this->showModal = true;
        $this->dispatch('open-address-modal');
    }

    public function save()
    {
        $this->validate();

        if ($this->is_default) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        UserAddress::updateOrCreate(
            ['id' => $this->address_id],
            [
                'user_id' => Auth::id(),
                'type' => $this->type,
                'area' => $this->area,
                'street_address' => $this->street_address,
                'building_no' => $this->building_no,
                'apartment_no' => $this->apartment_no,
                'phone' => $this->phone,
                'is_default' => $this->is_default,
            ]
        );

        $this->showModal = false;
        $this->loadAddresses();
        $this->dispatch('close-address-modal');
        $this->dispatch('swal:success', [
            'title' => 'Success',
            'text' => 'Address saved successfully.',
            'icon' => 'success'
        ]);
    }

    public function delete($id)
    {
        UserAddress::where('id', $id)->where('user_id', Auth::id())->delete();
        $this->loadAddresses();
        $this->dispatch('swal:success', [
            'title' => 'Deleted',
            'text' => 'Address removed.',
            'icon' => 'success'
        ]);
    }

    public function setAsDefault($id)
    {
        Auth::user()->addresses()->update(['is_default' => false]);
        UserAddress::where('id', $id)->where('user_id', Auth::id())->update(['is_default' => true]);
        $this->loadAddresses();
    }

    public function render()
    {
        return view('livewire.user.addresses');
    }
}
