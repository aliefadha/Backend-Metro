@extends('admin.app')

@section('title', 'Projects Done')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h6>Projects Done</h6>
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <a href="#" class="btn bg-gradient-success" data-bs-toggle="modal" data-bs-target="#addProject"><i
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
                                        <x-admin.th>Service</x-admin.th>
                                        <x-admin.th>Description</x-admin.th>
                                        <x-admin.th>Link Website</x-admin.th>
                                        <x-admin.th>Action</x-admin.th>
                                    </tr>
                                @endslot
                                @foreach ($projects as $item)
                                    <tr>
                                        <x-admin.td class="text-center">{{ $loop->iteration }}</x-admin.td>
                                        <x-admin.td class="text-center">{{ $item->title ?? '-' }}</x-admin.td>
                                        <x-admin.td class="text-center">
                                            <img src="{{ asset('dist/assets/img/projects/' . $item->img) }}"
                                                alt="{{ $item->title }}" style="max-width: 200px; max-height: 150px"
                                                class="img-thumbnail">
                                        </x-admin.td>
                                        <x-admin.td>
                                            <ul>
                                                @foreach ($item->rService as $service)
                                                    <li>{{ $service->title }}</li>
                                                @endforeach
                                            </ul>
                                        </x-admin.td>
                                        <x-admin.td maxWidth="300px">
                                            {{-- {{ trim($item->informasi_ekskul) }} --}} {{ $item->description ?? '' }}
                                        </x-admin.td>
                                        <x-admin.td class="text-center">
                                            <a href="{{ $item->link ?? '' }}" target="_blank">{{ $item->title ?? '' }}</a>
                                        </x-admin.td>
                                        <x-admin.td class="text-center">
                                            <a href="#" class="btn bg-gradient-info" data-bs-toggle="modal"
                                                data-bs-target="#editProject{{ $item->id }}"><i
                                                    class="bi bi-pencil-fill"></i><span
                                                    class="text-capitalize ms-1">Edit</span></a>
                                            <a href="#" class="btn bg-gradient-danger" data-bs-toggle="modal"
                                                data-bs-target="#hapusProject"><i class="bi bi-trash-fill"></i><span
                                                    class="text-capitalize ms-1">Delete</span></a>
                                        </x-admin.td>

                                        <!-- Modal Edit Project -->
                                        <div class="modal fade" id="editProject{{ $item->id }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="editProjectLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="editProjectLabel">Edit Project</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form id="editProjectForm"
                                                        action="{{ route('project.update', $item->id) }}" method="post"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <x-admin.input type="text" placeholder="Title" label="Title"
                                                                name="title" value="{{ $item->title }} " />
                                                            <div class="mb-3">
                                                                <label for="formFile" class="form-label">Last Photo</label>
                                                                <p class="text-center">
                                                                    <img src="{{ asset('dist/assets/img/projects/' . $item->img) }}"
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
                                                            <div class="mb-3">
                                                                <label>Service</label>
                                                                <select class="service" name="service[]" multiple="multiple"
                                                                    id="">
                                                                    @foreach ($services as $service)
                                                                        <option value="{{ $service->id }}"
                                                                            @if ($item->rService->contains('id', $service->id)) selected @endif>
                                                                            {{ $service->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <label>Description</label>
                                                            <textarea class="form-control mb-3" name="description" id="description" cols="10" rows="5">{{ $item->description ?? '' }}</textarea>

                                                            <x-admin.input type="link" placeholder="Link" label="Link"
                                                                name="link" value="{{ $item->link ?? '' }}" />

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
                                        <div class="modal fade" id="hapusProject" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="hapusProjectLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="hapusProjectLabel">Delete Project
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
                                                        <a href="{{ route('project.destroy', $item->id) }}"
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

    <!-- Modal Add Project -->
    <div class="modal fade" id="addProject" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addProjectLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addProjectLabel">Add Project</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addProjectForm" action="{{ route('project.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <x-admin.input type="text" placeholder="Title" label="Title" name="title" />
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Photo</label>
                            <input class="form-control" type="file" id="formFile" name="img">
                        </div>

                        <div class="mb-3">
                            <label>Service</label>
                            <select class="service" name="service[]" multiple="multiple" id="">
                                @foreach ($services as $item)
                                    <option class="small" value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label>Description</label>
                        <textarea class="form-control mb-3" name="description" id="description" cols="10" rows="5"></textarea>

                        <x-admin.input type="link" placeholder="Link" label="Link" name="link" />
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
