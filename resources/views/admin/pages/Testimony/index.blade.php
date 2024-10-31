@extends('admin.app')

@section('title', 'Testimonies')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h6>Testimonies</h6>
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <a href="#" class="btn bg-gradient-success" data-bs-toggle="modal"
                            data-bs-target="#addTestimony"><i class="bi bi-plus-circle"></i><span
                                class="text-capitalize ms-1">Add</span></a>
                    </div>
                    <div class="card-body px-5 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <x-admin.table id="datatable">
                                @slot('header')
                                    <tr>
                                        <x-admin.th>No</x-admin.th>
                                        <x-admin.th>Name</x-admin.th>
                                        <x-admin.th>Picture</x-admin.th>
                                        <x-admin.th>Title</x-admin.th>
                                        <x-admin.th>Comment</x-admin.th>
                                        <x-admin.th>Action</x-admin.th>
                                    </tr>
                                @endslot
                                @foreach ($testimonies as $item)
                                    <tr>
                                        <x-admin.td class="text-center">{{ $loop->iteration }}</x-admin.td>
                                        <x-admin.td class="text-center">{{ $item->name }}</x-admin.td>
                                        <x-admin.td class="text-center">
                                            <img src="{{ asset('dist/assets/img/comments/' . $item->img) }}"
                                                alt="{{ $item->title }}" style="max-width: 200px; max-height: 150px"
                                                class="img-thumbnail">
                                        </x-admin.td>
                                        <x-admin.td class="text-center">{{ $item->title }}</x-admin.td>
                                        <x-admin.td maxWidth="300px">
                                            {{ $item->comment }}
                                        </x-admin.td>
                                        <x-admin.td>
                                            <a href="#" class="btn bg-gradient-info" data-bs-toggle="modal"
                                                data-bs-target="#editTestimony{{ $item->id }}"><i
                                                    class="bi bi-pencil-fill"></i><span
                                                    class="text-capitalize ms-1">Edit</span></a>
                                            <a href="#" class="btn bg-gradient-danger" data-bs-toggle="modal"
                                                data-bs-target="#hapustestimony{{ $item->id }}"><i
                                                    class="bi bi-trash-fill"></i><span
                                                    class="text-capitalize ms-1">Delete</span></a>
                                        </x-admin.td>

                                        <!-- Modal Edit Testimony -->
                                        <div class="modal fade" id="editTestimony{{ $item->id }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="editTestimonyLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="editTestimonyLabel">Edit Testimony
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form id="editTestimonyForm"
                                                        action="{{ route('testimony.update', $item->id) }}" method="post"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <x-admin.input type="text" placeholder="Name" label="Name"
                                                                name="name" value="{{ $item->name ?? '' }}" />
                                                            <div class="mb-3">
                                                                <label for="formFile" class="form-label">Last Photo</label>
                                                                <p class="text-center">
                                                                    <img src="{{ asset('dist/assets/img/comments/' . $item->img) }}"
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
                                                            <x-admin.input type="text" placeholder="Title" label="Title"
                                                                name="title" value="{{ $item->title ?? '' }}" />
                                                            <label>Comment</label>
                                                            <textarea class="form-control mb-3" name="comment" id="info" cols="20" rows="10">{{ $item->comment ?? '' }}</textarea>
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

                                        <!-- Modal Hapus Testimony -->
                                        <div class="modal fade" id="hapustestimony{{ $item->id }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="hapustestimonyLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="hapustestimonyLabel">Delete
                                                            Testimony
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
                                                        <a href="{{ route('testimony.destroy', $item->id) }}"
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

    <!-- Modal Add Testimony -->
    <div class="modal fade" id="addTestimony" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addTestimonyLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addTestimonyLabel">Add Testimony</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addTestimonyForm" action="{{ route('testimony.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <x-admin.input type="text" placeholder="Name" label="Name" name="name" />
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Photo</label>
                            <input class="form-control" type="file" id="formFile" name="img">
                        </div>
                        <x-admin.input type="text" placeholder="Title" label="Title" name="title" />
                        <label>Comment</label>
                        <textarea class="form-control mb-3" name="comment" id="info" cols="20" rows="10"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
