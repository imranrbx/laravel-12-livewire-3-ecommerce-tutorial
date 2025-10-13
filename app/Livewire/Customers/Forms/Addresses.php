<?php

namespace App\Livewire\Customers\Forms;

use App\Models\Address;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.store')]
class Addresses extends Component
{
    public ?Address $address = null;

    #[Validate('required|string|max:255')]
    public string $full_name = '';

    #[Validate('nullable|string|max:50')]
    public string $phone = '';

    #[Validate('required|string|max:255')]
    public string $street = '';

    #[Validate('required|string|max:100')]
    public string $city = '';

    #[Validate('nullable|string|max:100')]
    public string $state = '';

    #[Validate('required|string|max:100')]
    public string $country = '';

    #[Validate('nullable|string|max:20')]
    public string $postal_code = '';

    public function mount($id = null): void
    {
        if ($id) {
            $this->address = Address::where('user_id', auth()->id())->findOrFail($id);
            $this->fill($this->address->toArray());
        }
    }

    public function save(): void
    {
        $data = $this->validated();

        if ($this->address) {
            $this->address->update($data);
        } else {
            Address::create(array_merge($data, ['user_id' => auth()->id()]));
        }

        session()->flash('success', 'Address saved');
        $this->redirect(route('customer.addresses'));
    }

    public function render()
    {
        return view('livewire.customers.forms.addresses');
    }
}