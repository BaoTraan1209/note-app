@extends('layouts.app')
@section('content')
    <div class="">
        <form id="create-reward" action="{{ route('notes.store') }}"
              method="POST" enctype="multipart/form-data" class="p-3 rounded shadow-sm bg-light">
            @csrf
            <div class="row">
                {{-- CỘT 1 --}}
                <div class="col-md-6">
                    {{-- Title --}}
                    <div class="form-group mb-3">
                        <label for="title" class="form-label">Title Note</label>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>

                    {{-- Content --}}
                    <div class="form-group mb-3">
                        <label for="content" class="form-label">Content Note</label>
                        <input type="text" name="content" id="content" class="form-control">
                    </div>
                </div>
            </div>

            {{-- BUTTON --}}
            <div class="d-flex justify-content-start mt-4">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="mdi mdi-content-save"></i>
                    <span class="ms-1">Thêm note</span>
                </button>
            </div>
        </form>
    </div>
@endsection
