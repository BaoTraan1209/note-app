@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="position-relative">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="m-0">Note</h2>
                        <div>
                            <h2>Title: {{ $titleNgoc ?? 'default' }}</h2>
                            <h2>Content: {{ $content ?? 'default' }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Content</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($notes as $key => $note)
                            <tr>
                                {{-- Tu dong tang tu 1 -> n --}}
{{--                                <td>{{ $loop->iteration }}</td>--}}

                                <td>{{ $notes->firstItem() + $key }}</td>
                                <td>{{$note['id']}}</td>
                                <td>{{ $note['title'] }}</td>
                                <td>{{ $note['note'] }}</td>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <x-pagination :data="$notes"/>
        </div>
    </div>
@endsection
