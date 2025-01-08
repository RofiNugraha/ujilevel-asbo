<x-admin.sidebar>
</x-admin.sidebar>
<hr>
Create
<a href="{{ route('admin.layanan.create') }}" class="mb-4">
    <button type="button" class="btn text-white">Create</button>
</a>
<hr>
@foreach($layanan as $item)
Edit
<a href="{{ route('admin.layanan.edit', $item) }}" class="mb-4">
    <button class="btn btn-primary" type="button">Edit</button>
</a>
@endforeach