@extends('admin.app')

@section('title', 'Skill')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h6>Skill</h6>
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <a href="#" class="btn bg-gradient-success" data-bs-toggle="modal" data-bs-target="#addSkill"><i
                                class="bi bi-plus-circle"></i><span class="text-capitalize ms-1">Add</span></a>
                    </div>
                    <div class="card-body px-5 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <x-admin.table id="datatable">
                                @slot('header')
                                    <tr>
                                        <x-admin.th>No</x-admin.th>
                                        <x-admin.th>Skill</x-admin.th>
                                        <x-admin.th>Action</x-admin.th>
                                    </tr>
                                @endslot
                                @foreach ($skills as $item)
                                    <tr>
                                        <x-admin.td class="text-center">{{ $loop->iteration }}</x-admin.td>
                                        <x-admin.td class="text-center">{{ $item->skill ?? '-' }}</x-admin.td>
                                        <x-admin.td class="text-center">
                                            <a href="#" class="btn bg-gradient-info" data-bs-toggle="modal"
                                                data-bs-target="#editSkill{{ $item->id }}"><i
                                                    class="bi bi-pencil-fill"></i><span
                                                    class="text-capitalize ms-1">Edit</span></a>
                                            <a href="#" class="btn bg-gradient-danger" data-bs-toggle="modal"
                                                data-bs-target="#hapusSkill{{ $item->id }}"><i
                                                    class="bi bi-trash-fill"></i><span
                                                    class="text-capitalize ms-1">Delete</span></a>
                                        </x-admin.td>

                                        <!-- Modal Edit Skill -->
                                        <div class="modal fade" id="editSkill{{ $item->id }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="editSkillLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="editSkillLabel">Edit Skill</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form id="editSkillForm" action="{{ route('skill.update', $item->id) }}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <x-admin.input type="text" placeholder="Skill" label="Skill"
                                                                name="skill" value="{{ $item->skill ?? '' }}" />
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

                                        <!-- Modal Hapus Skill -->
                                        <div class="modal fade" id="hapusSkill{{ $item->id }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="hapusSkillLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="hapusSkillLabel">Delete Skill
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
                                                        <a href="{{ route('skill.destroy', $item->id) }}" type="submit"
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

    <!-- Modal Add Skill -->
    <div class="modal fade" id="addSkill" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addSkillLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addSkillLabel">Add Skill</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addSkillForm" action="{{ route('skill.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <x-admin.input type="text" placeholder="Skill" label="Skill" name="skill" />
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
