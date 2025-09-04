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

    #[Rule('required')]
    public string $no_surat = '';

    #[Rule('required|date')]
    public string $tanggal = '';

    #[Rule('sometimes')]
    public ?int $kategori_id = null;

    #[Rule('nullable|mimes:pdf|max:10240')]
    public $file;

    public function mount(Arsip $arsip): void
    {
        $this->arsip = $arsip;
        $this->judul = $arsip->judul;
        $this->no_surat = $arsip->no_surat;
        $this->tanggal = Carbon::parse($arsip->tanggal)->format('Y-m-d\TH:i');
        $this->kategori_id = $arsip->kategori_id;
    }

    public function save(): void
    {
        // Validate
        $data = $this->validate();
        $this->arsip->update([
            'judul' => $this->judul,
            'no_surat' => $this->no_surat,
            'tanggal' => Carbon::parse($this->tanggal, 'Asia/Jakarta'),
            'kategori_id' => $this->kategori_id,
        ]);

        if ($this->file) {
            if ($this->arsip->file && Storage::disk('public')->exists(str_replace('/storage/', '', $this->arsip->file))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $this->arsip->file));
            }
            $url = $this->file->store('arsip', 'public');
            $this->arsip->update(['file' => "/storage/$url"]);
        }

        // You can toast and redirect to any route
        $this->success('Arsip updated with success.', redirectTo: '/surat');
    }

    public function with(): array
    {
        return [
            'kategori' => Kategori::all(),
        ];
    }
}; ?>

<div>
    <x-header title="Update Surat {{ $this->arsip->judul }}" separator />

    <x-form wire:submit="save">
        {{--  Basic section  --}}
        <div class="lg:grid grid-cols-5">
            <div class="col-span-2">
                <x-header title="Basic" subtitle="Basic info from arsip" size="text-2xl" />
            </div>
            <div class="col-span-3 grid gap-3">
                <x-input label="No Surat" wire:model="no_surat" />
                <x-input label="Judul Surat" wire:model="judul" />
                <x-datetime label="Tanggal" wire:model="tanggal" type="datetime-local" />
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
                <x-file label="File Surat" hint="Only PDF" wire:model="file" accept="application/pdf"></x-file>
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
