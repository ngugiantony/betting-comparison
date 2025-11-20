@extends('layouts.master')

@section('content')

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Centy Plus</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                            <li class="breadcrumb-item active">Guardian's Profile</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Guardian Profile</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-4 col-lg-5">
                <div class="card text-center">
                    <div class="card-body">
                        <img>
                        <h4 class="mb-0 mt-2">{{ $guardian->user->name }}</h4>
                        <p class="text-muted font-14">{{ $guardian->user->role }}</p>


                        <div class="text-start mt-3">

                            <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ms-2">
                                                   {{ $guardian->user->name }}</span></p>

                            <p class="text-muted mb-2 font-13"><strong>CentyPlus ID :</strong><span class="ms-2">
                                                    {{ $guardian->user->centy_plus_id  }}</span></p>

                            <p class="text-muted mb-2 font-13"><strong>Phone Number :</strong><span class="ms-2">
                                                    {{ $guardian->user->phone_number  }}</span></p>
                        </div>

                    </div> <!-- end card-body -->
                </div> <!-- end card -->



            </div> <!-- end col-->

            <div class="col-xl-8 col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#aboutme" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active">
                                    Students
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="aboutme">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-nowrap mb-0">
                                        <thead class="table-light">
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Centy ID</th>
                                            <th>School Name</th>
                                            <th>Education Level</th>
                                            <th>Account Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($students as $student)
                                        <tr>
                                            <td>{{ $student->user->name }}</td>
                                            <td>{{ $student->user->centy_plus_id }}</td>
                                            <td>{{ $student->school_name }} </td>
                                            <td>{{ $student->educationLevel->name }} </td>
                                            @if($student->account_status == 0)
                                            <td><span class="badge badge-danger-lighten">Inactive</span></td>
                                            @elseif($student->account_status == 1)
                                            <td><span class="badge badge-success-lighten">Active</span></td>
                                            @elseif($student->account_status == 2)
                                            <td><span class="badge badge-warning-lighten">Pending</span></td>
                                            @elseif($student->account_status == 3)
                                            <td><span class="badge badge-info-lighten">Suspended</span></td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div> <!-- end tab-pane -->
                            <!-- end about me section content -->


                        </div> <!-- end tab-content -->
                    </div> <!-- end card body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end row-->

    </div>
    <!-- container -->

@endsection
