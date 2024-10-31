@extends('admin.app')

@section('title', 'Services')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h6>Services</h6>
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <a href="#" class="btn bg-gradient-success" data-bs-toggle="modal" data-bs-target="#addService"><i
                                class="bi bi-plus-circle"></i><span class="text-capitalize ms-1">Add</span></a>
                    </div>
                    <div class="card-body px-5 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <x-admin.table id="datatable">
                                @slot('header')
                                    <tr>
                                        <x-admin.th>No</x-admin.th>
                                        <x-admin.th>Title</x-admin.th>
                                        <x-admin.th>Picture</x-admin.th>
                                        <x-admin.th>Description</x-admin.th>
                                        <x-admin.th>Action</x-admin.th>
                                    </tr>
                                @endslot
                                @foreach ($services as $item)
                                    <tr>
                                        <x-admin.td class="text-center">{{ $loop->iteration }}</x-admin.td>
                                        <x-admin.td class="text-center">{{ $item->title }}</x-admin.td>
                                        <x-admin.td class="text-center">
                                            <a href="{{ asset('dist/assets/img/services/' . $item->img) }}">
                                                <img src="{{ asset('dist/assets/img/services/' . $item->img) }}"
                                                    alt="{{ $item->title }}" style="max-width: 200px; max-height: 150px"
                                                    class="img-thumbnail">
                                            </a>
                                        </x-admin.td>
                                        <x-admin.td maxWidth="300px">
                                            {{-- {{ trim($item->informasi_ekskul) }} --}} {{ $item->description }}
                                        </x-admin.td>
                                        <x-admin.td>
                                            <a href="#" class="btn bg-gradient-info" data-bs-toggle="modal"
                                                data-bs-target="#editService{{ $item->id }}"><i
                                                    class="bi bi-pencil-fill"></i><span
                                                    class="text-capitalize ms-1">Edit</span></a>
                                            <a href="#" class="btn bg-gradient-danger" data-bs-toggle="modal"
                                                data-bs-target="#hapusService{{ $item->id }}"><i
                                                    class="bi bi-trash-fill"></i><span
                                                    class="text-capitalize ms-1">Delete</span></a>
                                        </x-admin.td>

                                        <!-- Modal Edit Service -->
                                        <div class="modal fade" id="editService{{ $item->id }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="editServiceLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="editServiceLabel">Edit Service</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form id="editServiceForm"
                                                        action="{{ route('service.update', $item->id) }}" method="post"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <x-admin.input type="text" placeholder="Title" label="Title"
                                                                name="title" value="{{ $item->title ?? '' }}" />
                                                            <div class="mb-3">
                                                                <label for="formFile" class="form-label">Last Photo</label>
                                                                <p class="text-center">
                                                                    <img src="{{ asset('dist/assets/img/services/' . $item->img) }}"
                                                                        alt="{{ $item->title }}"
                                                                        style="max-width: 200px; height: 150px"
                                                                        class="img-thumbnail">
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="formFile" class="form-label">New Photo</label>
                                                                <input class="form-control" type="file" id="formFile"
                                                                    name="img">
                                                            </div>
                                                            <label>Description</label>
                                                            <textarea class="form-control mb-3" name="description" id="info" cols="20" rows="10">{{ $item->description ?? '' }}</textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-success">Edit</button>
                                                            <button type="button" class="btn btn-sm btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Hapus Project -->
                                        <div class="modal fade" id="hapusService{{ $item->id }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="hapusServiceLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="hapusServiceLabel">Delete Service
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('dist/assets/img/bin.gif') }}" alt=""
                                                            class="img-fluid w-25">
                                                        <p>Are you sure?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="{{ route('service.destroy', $item->id) }}"
                                                            type="submit" class="btn btn-sm btn-danger">Delete</a>
                                                        <button type="button" class="btn btn-sm btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @endforeach
                            </x-admin.table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Service -->
    <div class="modal fade" id="addService" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addServiceLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addServiceLabel">Add Service</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addServiceForm" action="{{ route('service.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <x-admin.input type="text" placeholder="Title" label="Title" name="title" />
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Photo</label>
                            <input class="form-control" type="file" id="formFile" name="img">
                        </div>
                        <label>Description</label>
                        <textarea class="form-control mb-3" name="description" id="info" cols="20" rows="10"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- <script>
        document.getElementById('addEkskulForm').addEventListener('submit', function(event) {
            var textarea = document.getElementById('info');
            textarea.value = textarea.value.trim();
        });

        // Normalize whitespace in the edit form
        function setTextWithNormalizedWhitespace(textareaId, text) {
            const textarea = document.getElementById(textareaId);
            const normalizedText = text.replace(/\s+/g, ' ').trim(); // Replace multiple spaces with a single space and trim
            textarea.value = normalizedText;
        }

        // Use the correct ID for each instance of the edit form
        @foreach ($ekskul as $item)
            setTextWithNormalizedWhitespace('info{{ $item->id }}', '{{ trim($item->informasi_ekskul ?? '') }}');
        @endforeach
    </script> --}}
@endsection
