<?php

namespace App\Livewire\Admin;

use App\Models\Coupon;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class CouponManager extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $editingId = null;

    // coupon fields
    public $code = '';

    public $discount_type = 'percentage'; // percent|fixed

    public $discount_value = null;

    public $usage_limit = null;

    public $expires_at = null; // YYYY-MM-DD or datetime

    public string $status = 'active';

    // modals
    public bool $showFormModal = false;

    public bool $showDeleteModal = false;

    public ?int $deleteId = null;

    protected $rules = [
        'code' => 'required|string|max:100|unique:coupons,code',
        'discount_type' => 'required|in:percentage,fixed',
        'discount_value' => 'required|numeric|min:0',
        'usage_limit' => 'nullable|integer|min:0',
        'expires_at' => 'nullable|date',
        'status' => 'required|in:active,inactive',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $coupons = Coupon::when($this->search, fn ($q) => $q->where('code', 'like', "%{$this->search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('livewire.admin.coupon-manager', compact('coupons'));
    }

    public function create()
    {
        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = true;
    }

    public function edit(int $id)
    {
        $coupon = Coupon::findOrFail($id);
        $this->editingId = $coupon->id;
        $this->code = $coupon->code;
        $this->discount_type = $coupon->discount_type;
        $this->discount_value = $coupon->discount_value;
        $this->usage_limit = $coupon->usage_limit;
        $this->expires_at = $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : null;
        $this->status = $coupon->status ? 'active' : 'inactive';
        $this->showFormModal = true;
    }

    public function save()
    {

        $rules = $this->rules;

        if ($this->editingId) {
            $rules['code'] = 'required|string|max:100|unique:coupons,code,'.$this->editingId;
        }

        $this->validate($rules);

        $data = [
            'code' => $this->code,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'usage_limit' => $this->usage_limit ?: null,
            'expires_at' => $this->expires_at ? Carbon::parse($this->expires_at)->toDateTimeString() : null,
            'status' => $this->status ? 'active' : 'inactive',
        ];

        if ($this->editingId) {
            Coupon::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Coupon updated.');
        } else {
            Coupon::create($data);
            session()->flash('success', 'Coupon created.');
        }

        $this->showFormModal = false;
        $this->resetForm();
    }

    public function confirmDelete(int $id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->deleteId) {
            Coupon::findOrFail($this->deleteId)->delete();
            session()->flash('success', 'Coupon deleted.');
        }

        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    private function resetForm()
    {
        $this->reset(['code', 'discount_type', 'discount_value', 'usage_limit', 'expires_at', 'status', 'editingId']);
    }
}
