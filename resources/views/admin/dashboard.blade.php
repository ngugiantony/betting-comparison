@extends('layouts.master')

@section('content')


<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
         <div class="col-lg-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12" style="background: rgb(102, 2, 72);border-radius:15px;padding:30px">
                            <h5 class=" fw-normal mt-0 text-truncate text-white text-center" title="Booked Revenue">Customers</h5>
{{--                            <h3 class="my-2 py-1">ksh {{ $organization_revenue }}</h3>--}}
                            <p class="mb-0 text-muted text-center">
                                <span class=" me-2 text-white text-center"><i class="mdi mdi-arrow-up-bold"></i> 9000</span>
                            </p>
                        </div>
                     
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

          <div class="col-lg-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12" style="background: rgb(41, 136, 6);border-radius:15px;padding:30px">
                            <h5 class=" fw-normal mt-0 text-truncate text-white text-center" title="Booked Revenue">Bookies</h5>
{{--                            <h3 class="my-2 py-1">ksh {{ $organization_revenue }}</h3>--}}
                            <p class="mb-0 text-muted text-center">
                                <span class=" me-2 text-white text-center"><i class="mdi mdi-arrow-up-bold"></i> 9</span>
                            </p>
                        </div>
                     
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

       

        <div class="col-lg-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12" style="background: red;border-radius:15px;padding:30px">
                            <h5 class=" fw-normal mt-0 text-truncate text-white text-center" title="Booked Revenue">Revenue</h5>
{{--                            <h3 class="my-2 py-1">ksh {{ $organization_revenue }}</h3>--}}
                            <p class="mb-0 text-muted text-center">
                                <span class=" me-2 text-white text-center"><i class="mdi mdi-arrow-up-bold"></i> $39K</span>
                            </p>
                        </div>
                     
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <div class="odds-table mt-4">
      <h5 class="mb-3">Today’s Matches</h5>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Match</th>
              <th>Bookie</th>
              <th>1</th>
              <th>X</th>
              <th>2</th>
              <th>Last Updated</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Arsenal vs Chelsea</td>
              <td><span class="badge-bookie">Unibet</span></td>
              <td>2.10</td>
              <td>3.40</td>
              <td>3.60</td>
              <td>1 min ago</td>
            </tr>
            <tr>
              <td>Man City vs Liverpool</td>
              <td><span class="badge-bookie">Bwin</span></td>
              <td>1.95</td>
              <td>3.70</td>
              <td>4.10</td>
              <td>3 mins ago</td>
            </tr>
            <tr>
              <td>Tottenham vs Aston Villa</td>
              <td><span class="badge-bookie">Netbet</span></td>
              <td>2.25</td>
              <td>3.50</td>
              <td>3.20</td>
              <td>5 mins ago</td>
            </tr>
            <tr>
              <td>Brighton vs Wolves</td>
              <td><span class="badge-bookie">Vbet</span></td>
              <td>2.40</td>
              <td>3.20</td>
              <td>2.95</td>
              <td>10 mins ago</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<style>
    .odds-table {
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .odds-table table {
      width: 100%;
    }
    .odds-table thead {
      background: #2563eb;
      color: #fff;
    }
    .badge-bookie {
      background: #e5e7eb;
      color: #111;
      font-size: 0.8rem;
      padding: 5px 10px;
      border-radius: 5px;
    }
</style>

</div>

@endsection
