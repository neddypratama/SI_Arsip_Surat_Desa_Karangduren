<?php

use Livewire\Volt\Component;
use App\Models\Arsip;
use Mary\Traits\Toast;
use Livewire\Attributes\Rule;
use App\Models\Kategori;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;

new class extends Component {
    use Toast, WithFileUploads;

    public Arsip $arsip;

    #[Rule('required')]
    public string $judul = '';

    #[Rule('required|unique:arsips,no_surat')]
    public string $no_surat = '';

    #[Rule('required|date')]
    public string $tanggal = '';

    #[Rule('sometimes')]
    public ?int $kategori_id = null;

    #[Rule('mimes:pdf|max:10240')]
    public $file;

    public function mount(): void
    {
        $this->arsip = new Arsip();
    }

    public function save(): void
    {
        // Validate
        $data = $this->validate();
        // Pastikan tanggal tetap pakai timezone Jakarta
        $data['tanggal'] = Carbon::parse($this->tanggal, 'Asia/Jakarta');

        // Create arsip
        $arsip = Arsip::create($data);

        if ($this->file) {
            $url = $this->file->store('arsip', 'public');
            $arsip->update(['file' => "/storage/$url"]);
        }

        // You can toast and redirect to any route
        $this->success('Arsip created with success.', redirectTo: '/surat');
    }

    public function with(): array
    {
        return [
            'kategori' => Kategori::all(),
        ];
    }
}; ?>

<div>
    <x-header title="Pengarsipan Surat" separator />

    <x-form wire:submit="save">
        {{--  Basic section  --}}
        <div class="lg:grid grid-cols-5">
            <div class="col-span-2">
                <x-header title="Basic" subtitle="Basic info from arsip" size="text-2xl" />
            </div>
            <div class="col-span-3 grid gap-3">
                <x-input label="No Surat" wire:model="no_surat" />
                <x-input label="Judul Surat" wire:model="judul" />
                <x-datetime label="Tanggal" wire:model="tanggal" type="datetime-local"/>
            </div>
        </div>

        {{--  Details section --}}
        <hr class="my-5" />

        <div class="lg:grid grid-cols-5">
            <div class="col-span-2">
                <x-header title="Details" subtitle="More about the arsip" size="text-2xl" />
            </div>
            <div class="col-span-3 grid gap-3">
                <x-select label="Kategori Surat" wire:model="kategori_id" :options="$kategori" placeholder="---" />
                <x-file label="File Surat" hint="Only PDF" wire:model="file" accept="application/pdf" ></x-file>
            </div>
        </div>

        <x-slot:actions>
            <x-button label="Cancel" link="/surat" />
            {{-- The important thing here is `type="submit"` --}}
            {{-- The spinner property is nice! --}}
            <x-button label="Create" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
