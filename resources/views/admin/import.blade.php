@extends('layouts.master')

@section('content')


    <div class="container-fluid">                    <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Centy Plus</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">SMS</a></li>
                        </ol>
                    </div>
                    <br>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Scrollable modal -->



        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
{{-- resources/views/import/sports.blade.php --}}
<div class="max-w-lg mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Import Sports Odds</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-500 text-green-800 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <form action="{{ route('import.sports.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".xlsx,.xls,.csv" class="block w-full border rounded p-2 mb-4">
        <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-3 rounded hover:bg-blue-700">
            Upload & Import
        </button>
    </form>
</div>
                    </div>
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->
    </div> <!-- container -->

@endsection


@section('scripts')
    @if(Session::has('formData'))
        <script>
            // Restore form data from session
            var formData = {!! json_encode(Session::get('formData')) !!};
            Object.keys(formData).forEach(function(key) {
                document.getElementById(key).value = formData[key];
            });
        </script>
    @endif
@endsection
