@extends('admin.app')

@section('title', 'Our Team')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h6>Our Team</h6>
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <a href="#" class="btn bg-gradient-success" data-bs-toggle="modal" data-bs-target="#addTeam"><i
                                class="bi bi-plus-circle"></i><span class="text-capitalize ms-1">Add</span></a>
                    </div>
                    <div class="card-body px-5 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <x-admin.table id="datatable">
                                @slot('header')
                                    <tr>
                                        <x-admin.th>No</x-admin.th>
                                        <x-admin.th>Name</x-admin.th>
                                        <x-admin.th>Picture</x-admin.th>
                                        <x-admin.th>Skill</x-admin.th>
                                        <x-admin.th>Action</x-admin.th>
                                    </tr>
                                @endslot
                                @foreach ($teams as $item)
                                    <tr>
                                        <x-admin.td class="text-center">{{ $loop->iteration }}</x-admin.td>
                                        <x-admin.td class="text-center">{{ $item->name ?? '' }}</x-admin.td>
                                        <x-admin.td class="text-center">
                                            <img src="{{ asset('dist/assets/img/teams/' . $item->img) }}"
                                                alt="{{ $item->title }}" style="max-width: 200px; max-height: 150px"
                                                class="img-thumbnail">
                                        </x-admin.td>
                                        <x-admin.td>
                                            <ul>
                                                @foreach ($item->rSkill as $skill)
                                                    <li>{{ $skill->skill }}</li>
                                                @endforeach
                                            </ul>
                                        </x-admin.td>
                                        <x-admin.td>
                                            <a href="#" class="btn bg-gradient-info" data-bs-toggle="modal"
                                                data-bs-target="#editTeam{{ $item->id }}"><i
                                                    class="bi bi-pencil-fill"></i><span
                                                    class="text-capitalize ms-1">Edit</span></a>
                                            <a href="#" class="btn bg-gradient-danger" data-bs-toggle="modal"
                                                data-bs-target="#hapusTeam{{ $item->id }}"><i
                                                    class="bi bi-trash-fill"></i><span
                                                    class="text-capitalize ms-1">Delete</span></a>
                                        </x-admin.td>

                                        <!-- Modal Edit Team -->
                                        <div class="modal fade" id="editTeam{{ $item->id }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="editTeamLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="editTeamLabel">Edit Our Team</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form id="editTeamForm" action="{{ route('team.update', $item->id) }}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <x-admin.input type="text" placeholder="Name" label="Name"
                                                                name="name" value="{{ $item->name }}" />
                                                            <div class="mb-3">
                                                                <label for="formFile" class="form-label">Last Photo</label>
                                                                <p class="text-center">
                                                                    <img src="{{ asset('dist/assets/img/teams/' . $item->img) }}"
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
                                                                <label>Skill</label>
                                                                <select class="service" name="skill[]" multiple="multiple"
                                                                    id="">
                                                                    @foreach ($skills as $skill)
                                                                        <option value="{{ $skill->id }}"
                                                                            @if ($item->rSkill->contains('id', $skill->id)) selected @endif>
                                                                            {{ $skill->skill }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
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

                                        <!-- Modal Hapus Team -->
                                        <div class="modal fade" id="hapusTeam{{ $item->id }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="hapusTeamLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="hapusTeamLabel">Delete Our Team
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
                                                        <a href="{{ route('team.destroy', $item->id) }}" type="submit"
                                                            class="btn btn-sm btn-danger">Delete</a>
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

    <!-- Modal Add Team -->
    <div class="modal fade" id="addTeam" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addTeamLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addTeamLabel">Add Our Team</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addTeamForm" action="{{ route('team.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <x-admin.input type="text" placeholder="Name" label="Name" name="name" />
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Photo</label>
                            <input class="form-control" type="file" id="formFile" name="img">
                        </div>

                        <div class="mb-3">
                            <label>Skill</label>
                            <select class="service" name="skill[]" multiple="multiple" id="">
                                @foreach ($skills as $item)
                                    <option class="small" value="{{ $item->id }}">{{ $item->skill }}</option>
                                @endforeach
                            </select>
                        </div>
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
