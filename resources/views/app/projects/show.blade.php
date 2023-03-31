<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <x-card title="{{ $project->project_name }}">
                            <x-slot:toolbar>
                                <a href="{{ route('project.edit', $project->hashid) }}"
                                    class="btn btn-warning text-white">Edit</a>
                                <a href="{{ route('project.task.create', $project->hashid) }}"
                                    class="btn btn-success text-white">Add Task</a>
                                <a href="{{ route('project.index') }}" class="btn btn-secondary">Back</a>
                            </x-slot:toolbar>
                            <div class="d-flex align-items-start">
                                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">

                                    <button class="nav-link active "  id="v-pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-home" type="button" role="tab"
                                        aria-controls="v-pills-home" aria-selected="true">งาน{{ $project->project_id }} </button>
                                        @if ($project['budget_it_operating'] > 0)
                                    <button class="nav-link" style="color:   #d51649"  id="v-pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-profile" type="button" role="tab"
                                        aria-controls="v-pills-profile" aria-selected="false">งบกลาง ICT</button>

                                        @endif
                                        @if ($project['budget_it_investment'] > 0)
                                    <button class="nav-link" style="color:   #39b70b" id="v-pills-messages-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-messages" type="button" role="tab"
                                        aria-controls="v-pills-messages" aria-selected="false">งบดำเนินงาน</button>
                                        @endif
                                        @if ($project['budget_gov_utility'] > 0)

                                    <button class="nav-link" style="color:   #ff9409"id="v-pills-settings-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-settings" type="button" role="tab"
                                        aria-controls="v-pills-settings" aria-selected="false">งบสาธารณูปโภค</button>
                                        @endif
                                </div>
                                <div class="tab-content" id="v-pills-tabContent">
                                    <!-- 1 งาน -->
                                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                        aria-labelledby="v-pills-home-tab">
                                        <div class="row">
                                            <div class="col">
                                                <!--งบประมาณ-->
                                                <div class="container">
                                                    <div>
                                                        <div>
                                                            <div class="card">
                                                                <div class="card-body">

                                                                    <button class="btn " data-bs-toggle="collapse"
                                                                        href="#collapseExample2" role="button"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold">
                                                                            {{ number_format($budget['total'], 2) }}
                                                                        </div>

                                                                        <small
                                                                            class="text-medium-emphasis text-uppercase fw-semibold">งบประมาณ
                                                                        </small>
                                                                              <!--          <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <!--เบิกจ่าย--> <!--1.1.2-->
                                                <div class="container">
                                                    <div >
                                                        <div>
                                                            <div class="card">
                                                                <div class="card-body">

                                                                    <button class="btn " data-bs-toggle="collapse"
                                                                        href="#collapseExample2" role="button"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold text-success">
                                                                            {{ number_format($budget['balance'], 2) }}
                                                                        </div>

                                                                        <small
                                                                            class="text-medium-emphasis text-uppercase fw-semibold">คงเหลือ</small>
                                                                          <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- end1 งาน -->
                                    <!-- 2 งาน -->
                                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                        aria-labelledby="v-pills-profile-tab">
 <!-- 2 งาน -->

    <!-- 2 งาน -->
    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <div class="row">
            <div class="col">
                <!--งบประมาณ-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">

                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold">
                                            {{ number_format($ospa) }}

                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">จำนวนเงินแบบมี PA
                                        </small>
                                         <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <!--เบิกจ่าย--> <!--1.1.2-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">

                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold" style="color:   #05ba1a">
                                            <!--การเบิกจ่าย PA -->  {{ number_format($otpsa1) }}
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold" >การเบิกจ่าย PA</small>
                                         <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                    </button>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col">
                <!--คงเหลือ-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold" style="color:   #ba0505">
                                            <!--รอการเบิกจ่าย pa-->  {{ number_format($ospa-$otpsa1) }}
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">รอการเบิกจ่าย PA</small>
                                         <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row"><!-- 1.2-->
            <div class="col">
                <!--คงเหลือ-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">

                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold">
                                      <!--จำนวนเงินแบบไม่มี PA-->{{ number_format( ($utsc), 2) }}
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">จำนวนเงินแบบไม่มี PA
                                        </small>
                                         <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <!--เบิกจ่าย--> <!-- 1.2.2-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">

                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold">
                                            <!--การเบิกเงิน ไม่มี PA--> {{ number_format( ($utsc_pay), 2) }}
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">การเบิกเงิน ไม่มี PA</small>
                                         <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col">
                <!--รอการเบิกจ่าย-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">

                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold" style="color:   #ba0505">


                                            <!--คงเหลือ-->   {{ number_format( ($utsc-$utsc_pay), 2) }}
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">รอการเบิกจ่าย ไม่มี PA</small>
                                         <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--ont-->
            <div class="col">
                <!--คงเหลือ-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--ont-->
        <div class="row"><!-- 1.3-->
            <div class="col">
                <!--คงเหลือ-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <div>

                                    </div>
                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold">
                                            <!--qw-->
                                        </div>
                                        <small class="text-medium-emphasis text-uppercase fw-semibold">
                                        </small>

                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <!--เบิกจ่าย--> <!-- 1.3.2-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <div>

                                    </div>
                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold" style="color:   #ba0505">
                                            <!--รวมเบิกจ่ายทั้งหมด-->    <!--รอการเบิกจ่าย pa-->  {{ number_format($ospa-$otpsa1) }}
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">รวมเบิกจ่ายทั้งหมด</small>
                                         <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <!--รอการเบิกจ่าย-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <div>

                                    </div>
                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold">


                                            <!--รอการเบิกจ่ายทั้งหมด-->

                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">รอการเบิกจ่ายทั้งหมด</small>
                                         <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>








 <!-- 2 งาน จบ-->
                                    </div>
                                    <!-- 3 งาน -->
                                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                        aria-labelledby="v-pills-messages-tab">
                                         <!-- 3 งาน -->
                                         <div class="row">
                                            <div class="col">
                                                <!--งบประมาณ-->
                                                <div class="container">
                                                    <div>
                                                        <div>
                                                            <div class="card">
                                                                <div class="card-body">

                                                                    <button class="btn " style="color:   #06268e" data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold" >
                                                                            {{number_format($ispa,2)}}
                                                                        </div>

                                                                        <small class="text-medium-emphasis text-uppercase fw-semibold" >จำนวนเงินแบบมี PA
                                                                        </small>
                                                                           <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <!--เบิกจ่าย--> <!--1.1.2-->
                                                <div class="container">
                                                    <div>
                                                        <div>
                                                            <div class="card">
                                                                <div class="card-body">

                                                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold" style="color:   #05ba1a">
                                                                            <!--การเบิกจ่าย PA --> {{number_format($itpsa1,2)}}
                                                                        </div>

                                                                        <small class="text-medium-emphasis text-uppercase fw-semibold">การเบิกจ่าย PA</small>
                                                                           <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <!--คงเหลือ-->
                                                <div class="container">
                                                    <div>
                                                        <div>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold" style="color:   #ba0505">
                                                                            <!--รอการเบิกจ่าย pa--> {{number_format($ispa-$itpsa1,2)}}
                                                                        </div>

                                                                        <small class="text-medium-emphasis text-uppercase fw-semibold">รอการเบิกจ่าย PA </small>
                                                                           <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"><!-- 1.2-->
                                            <div class="col">
                                                <!--คงเหลือ-->
                                                <div class="container">
                                                    <div>
                                                        <div>
                                                            <div class="card">
                                                                <div class="card-body">

                                                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold" style="color:   #72a008">
                                                                      <!--จำนวนเงินแบบไม่มี PA-->{{number_format($isa,2)}}
                                                                        </div>

                                                                        <small class="text-medium-emphasis text-uppercase fw-semibold">จำนวนเงินแบบ ไม่มี PA
                                                                        </small>
                                                                           <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <!--เบิกจ่าย--> <!-- 1.2.2-->
                                                <div class="container">
                                                    <div>
                                                        <div>
                                                            <div class="card">
                                                                <div class="card-body">

                                                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold" style="color:   #05ba1a">
                                                                            <!--การเบิกเงิน ไม่มี PA--> {{number_format($itpsa2,2)}}
                                                                        </div>

                                                                        <small class="text-medium-emphasis text-uppercase fw-semibold">การเบิกจ่าย ไม่มี PA </small>
                                                                           <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col">
                                                <!--รอการเบิกจ่าย-->
                                                <div class="container">
                                                    <div>
                                                        <div>
                                                            <div class="card">
                                                                <div class="card-body">

                                                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold" style="color:   #ba0505">


                                                                            <!--คงเหลือ-->  {{number_format($itpsa2-$isa,2)}}
                                                                        </div>

                                                                        <small class="text-medium-emphasis text-uppercase fw-semibold">รอการเบิกจ่าย ไม่มี PA</small>
                                                                           <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--ont-->
                                            <div class="col">
                                                <!--คงเหลือ-->
                                                <div class="container">
                                                    <div>
                                                        <div>
                                                            <div class="card">
                                                                <div class="card-body">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--ont-->
                                        <div class="row"><!-- 1.3-->
                                            <div class="col">
                                                <!--คงเหลือ-->
                                                <div class="container">
                                                    <div>
                                                        <div>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div>

                                                                    </div>
                                                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold">
                                                                            <!--qw-->
                                                                        </div>
                                                                        <small class="text-medium-emphasis text-uppercase fw-semibold">
                                                                        </small>

                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <!--เบิกจ่าย--> <!-- 1.3.2-->
                                                <div class="container">
                                                    <div>
                                                        <div>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div>

                                                                    </div>
                                                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold" style="color:   #0a4ac1" >
                                                                            <!--รวมเบิกจ่ายทั้งหมด-->  {{number_format(($itpsa1+$itpsa2),2)}}

                                                                        </div>

                                                                        <small class="text-medium-emphasis text-uppercase fw-semibold" style="text-decoration-line: underline;">รวมเบิกจ่ายทั้งหมด</small>
                                                                           <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <!--รอการเบิกจ่าย-->
                                                <div class="container">
                                                    <div>
                                                        <div>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div>

                                                                    </div>
                                                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold"   style="color:   #c1bd0a"  style="text-decoration-line: underline;">


                                                                            <!--รอการเบิกจ่ายทั้งหมด-->  {{number_format(($ispa-$itpsa1)-($itpsa2-$isa),2)}}

                                                                        </div>

                                                                        <small class="text-medium-emphasis text-uppercase fw-semibold" style="text-decoration-line: underline;">รอการเบิกจ่ายทั้งหมด</small>
                                                                           <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <!--รอการเบิกจ่าย PP-->
                                                <div class="container">
                                                    <div>
                                                        <div>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div>

                                                                    </div>
                                                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold" style="color:   #06ea11">


                                                                            <!--รอการเบิกจ่ายทั้งหมด-->  {{ number_format($project['budget_it_investment']-($ispa + $isa), 2) }}

                                                                        </div>

                                                                        <small class="text-medium-emphasis text-uppercase fw-semibold" style="text-decoration-line: underline;" >ยอดงบประเมิน คงเหลือทังหมด</small>
                                                                           <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
















 <!-- end3 งาน -->
                                    </div>
                                    <!-- 4 งาน -->
                                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                                        aria-labelledby="v-pills-settings-tab">
                                    <!-- ------------------------- -->


    <!-- 4 งาน -->
    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <div class="row">
            <div class="col">
                <!--งบประมาณ-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">

                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold">

                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">จำนวนเงินแบบมี PA
                                        </small>
                                         <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <!--เบิกจ่าย--> <!--1.1.2-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">

                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold">
                                            <!--การเบิกจ่าย PA -->
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">การเบิกจ่าย PA</small>
                                         <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                    </button>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col">
                <!--คงเหลือ-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold">
                                            <!--รอการเบิกจ่าย pa-->
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">รอการเบิกจ่าย PA</small>
                                         <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row"><!-- 1.2-->
            <div class="col">
                <!--คงเหลือ-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">

                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold">
                                      <!--จำนวนเงินแบบไม่มี PA-->{{ number_format( ($utsc), 2) }}
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">จำนวนเงินแบบไม่มี PA
                                        </small>
                                         <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <!--เบิกจ่าย--> <!-- 1.2.2-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">

                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold">
                                            <!--การเบิกเงิน ไม่มี PA--> {{ number_format( ($utsc_pay), 2) }}
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">การเบิกเงิน ไม่มี PA</small>
                                         <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col">
                <!--รอการเบิกจ่าย-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">

                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold" style="color:   #ba0505">


                                            <!--คงเหลือ-->   {{ number_format( ($utsc-$utsc_pay), 2) }}
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">รอการเบิกจ่าย ไม่มี PA</small>
                                         <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--ont-->
            <div class="col">
                <!--คงเหลือ-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--ont-->
        <div class="row"><!-- 1.3-->
            <div class="col">
                <!--คงเหลือ-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <div>

                                    </div>
                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold">
                                            <!--qw-->
                                        </div>
                                        <small class="text-medium-emphasis text-uppercase fw-semibold">
                                        </small>

                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <!--เบิกจ่าย--> <!-- 1.3.2-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <div>

                                    </div>
                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold">
                                            <!--รวมเบิกจ่ายทั้งหมด-->{{ number_format( ($utsc_pay), 2) }}
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">รวมเบิกจ่ายทั้งหมด</small>
                                         <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <!--รอการเบิกจ่าย-->
                <div class="container">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <div>

                                    </div>
                                    <button class="btn " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="fs-4 fw-semibold">


                                            <!--รอการเบิกจ่ายทั้งหมด-->

                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">รอการเบิกจ่ายทั้งหมด</small>
                                         <!--    <div class="progress progress-thin mt-3 mb-0">
                                                                            <div class="progress-bar bg-primary"
                                                                                role="progressbar" style="width: 25%"
                                                                                aria-valuenow="25" aria-valuemin="0"
                                                                                aria-valuemax="100"></div>
                                                                        </div> -->
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                                    <!-- ------------------------- -->
                                    </div>



                                    <!-- nav end -->
                                </div>
                            </div>





                            <div id="gantt_here" style='width:100%; height:100vh;'></div>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Task Name</th>
                                        <th>Date</th>
                                        <th width="200"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->main_task as $task)
                                        <tr>
                                            <td></td>
                                            <td>
                                                {{ $task->task_name }} {!! $task->task_status == 2 ? '<span class="badge bg-info">ดำเนินการแล้วเสร็จ</span>' : '' !!}
                                                @if ($task->contract->count() > 0)
                                                    {{-- <span class="badge bg-warning">{{ $task->contract->count() }} สัญญา</span> --}}
                                                    @foreach ($task->contract as $contract)
                                                        <a
                                                            href="{{ route('contract.show', ['contract' => $contract->hashid]) }}"><span
                                                                class="badge bg-warning">{{ $contract->contract_number }}</span></a>
                                                    @endforeach
                                                @endif
                                                @if ($task->subtask->count() > 0)
                                                    <h6>Sub task</h6>
                                                    <ul>
                                                        @foreach ($task->subtask as $subtask)
                                                            <li>
                                                                {{ $subtask->task_name }}
                                                                <span
                                                                    class="badge bg-primary">{{ \Helper::date($subtask->task_start_date) }}</span>
                                                                <span
                                                                    class="badge bg-primary">{{ \Helper::date($subtask->task_end_date) }}</span>
                                                                @if ($subtask->contract->count() > 0)
                                                                    {{-- <span class="badge bg-warning">{{ $subtask->contract->count() }} สัญญา</span> --}}
                                                                    @foreach ($subtask->contract as $contract)
                                                                        <a
                                                                            href="{{ route('contract.show', ['contract' => $contract->hashid]) }}"><span
                                                                                class="badge bg-warning">{{ $contract->contract_number }}</span></a>
                                                                    @endforeach
                                                                @endif
                                                                <a href="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}"
                                                                    class="btn-sm btn btn-primary text-white"><i
                                                                        class="cil-folder-open "></i></a>
                                                                <a href="{{ route('project.task.edit', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}"
                                                                    class="btn-sm btn btn-warning text-white"> <i
                                                                        class="cil-cog"></i> </a>
                                                                <form
                                                                    action="{{ route('project.task.destroy', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}"
                                                                    method="POST" style="display:inline">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button class="btn-sm btn btn-danger text-white"><i
                                                                            class="cil-trash"></i></button>
                                                                </form>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-primary">{{ \Helper::date($task->task_start_date) }}</span>
                                                -
                                                <span
                                                    class="badge bg-primary">{{ \Helper::date($task->task_end_date) }}</span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
                                                    class="btn btn-primary text-white"><i
                                                        class="cil-folder-open "></i></a>
                                                <a href="{{ route('project.task.edit', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
                                                    class="btn btn-warning text-white"> <i class="cil-cog"></i> </a>
                                                <form
                                                    action="{{ route('project.task.destroy', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
                                                    method="POST" style="display:inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-danger text-white"><i
                                                            class="cil-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </x-card>
                    </div>
                </div>
            </div>
        </div>



    </x-slot:content>
    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
    <x-slot:css>

        <link href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css" rel="stylesheet">



        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">


        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
            rel="stylesheet" />
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </x-slot:css>
    <x-slot:javascript>

        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> --}}
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="https://docs.dhtmlx.com/gantt/codebase/dhtmlxgantt.js?v=7.1.13"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            gantt.plugins({
                marker: true,
                fullscreen: true,
                critical_path: true,
                // auto_scheduling: true,
                tooltip: true,
                // undo: true
            });

            //Marker
            var date_to_str = gantt.date.date_to_str(gantt.config.task_date);
            var today = new Date();
            gantt.addMarker({
                start_date: today,
                css: "today",
                text: "Today",
                title: "Today: " + date_to_str(today)
            });

            //Template
            var leftGridColumns = {
                columns: [


                    {
                        name: "text",
                        width: 300,
                        label: "โครงการ/งานประจำ",
                        tree: true,
                        resize: true,
                        template(task) {
                            if (gantt.getState().selected_task == task.id) {
                                return "<b>" + task.text + "</b>";
                            } else {
                                return task.text;
                            };
                        }
                    },
                    //{name:"start_date", label:"Start time", align: "center" },
                    // {name:"owner", width: 200, label:"Owner", template:function(task){
                    //   return task.owner}
                    // }
                ]
            };
            var rightGridColumns = {
                columns: [

                    {
                        name: "budget",
                        width: 120,
                        label: "งบประมาณ",
                        tree: true,
                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                            if (task.budget) {
                                return new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget);
                            } else {
                                return '';
                            }
                        }

                    },

                    {
                        name: "cost",
                        width: 150,
                        label: "PA",
                        tree: true,
                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                            if (task.task_type == 1) {
                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost) + '</span>';


                            } else {


                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost_pa_1) + '</span>';
                            }

                        }
                    },
                    {
                        name: "cost",
                        width: 150,
                        label: "ไม่มี PA",
                        tree: true,
                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                            if (task.task_type == 2) {
                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost) + '</span>';
                            } else {


                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost_pa_2) + '</span>';
                            }

                        }
                    },
                    {
                        name: "pay",
                        width: 100,
                        label: "การเบิกจ่าย",
                        tree: true,

                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                            if (task.task_type == 1) {
                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.pay) + '</span>';
                            } else if (task.task_type == 2) {
                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.pay) + '</span>';
                            } else {

                                return '<span style="color:#6010f6;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.total_pay) + '</span>';




                            }
                        }
                    },
                    {



                        name: "-",
                        width: 100,
                        label: "รอการเบิกจ่าย",
                        tree: true,

                        template: function(task) {
                            if (task.total_pay > 0) {
                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost_pa - task.total_pay) + '</span>';
                            } else if (task.pay) {
                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost - task.pay) + '</span>';
                            } else if (task.cost_disbursement) {
                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost_disbursement - task.total_pay) + '</span>';
                            } {

                                return '<span style="color:#6010f6;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost_pa) + '</span>';




                            }
                        }
                    },

                    {
                        name: "balance",
                        width: 100,
                        label: "คงเหลือ",
                        tree: true,

                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                            if (task.balance > 0) {
                                var tmp_class = task.balance < 1000000 ? 'red' : 'green';
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.balance) + '</span>';
                            } else if (task.balance = 0) {
                                return '-';
                            } else




                            {

                                return '';
                            }
                        }
                    }
                ]
            };

            gantt.templates.tooltip_text = function(start, end, task) {
                var budget_gov = task.budget_gov ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_gov) : '';
                var budget_it = task.budget_it ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_it) : '';
                var budget = task.budget ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget) : '';
                var budget_gov_operating = task.budget_gov_operating ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_gov_operating) : '';
                var budget_gov_investment = task.budget_gov_investment ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_gov_investment) : '';
                var budget_gov_utility = task.budget_gov_utility ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_gov_utility) : '';
                var budget_it_operating = task.budget_it_operating ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_it_operating) : '';
                var budget_it_investment = task.budget_it_investment ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_it_investment) : '';
                var cost = task.cost ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.cost) : '';

                var html = '<b>โครงการ/งาน:</b> ' + task.text + '<br/>';
                html += task.owner ? '<b>เจ้าของ:</b> ' + task.owner + '<br/>' : '';

                if (budget) {
                    html += '<table class="table table-sm " style="font-size:9px">';
                    html += '<tr class="text-center align-middle">\
                                                <td colspan="3">เงินงบประมาณ<br>(งบประมาณขอรัฐบาล)</td>\
                                                <td colspan="2">งบกลาง IT</td>\
                                                <td rowspan="2">รวมทั้งหมด<br>(เงินงบประมาณ+งบกลาง)</td>\
                                              </tr>';
                    html += '<tr>\
                                                <td>งบดำเนินงาน<br>(ค่าใช้สอยต่างๆ)</td>\
                                                <td>งบลงทุน IT<br>(ครุภัณฑ์ต่างๆ)</td>\
                                                <td>ค่าสาธารณูปโภค</td>\
                                                <td>งบดำเนินงาน<br>(ค่าใช้สอยต่างๆ)</td>\
                                                <td>งบลงทุน<br>(ครุภัณฑ์ต่างๆ)</td>\
                                              </tr>';
                    if (task.type == 'task') {
                        html += '<tr class="text-end">\
                                                <td>-' + budget_gov_operating + '</td>\
                                                <td>' + budget_gov_investment + '</td>\
                                                <td>' + budget_gov_utility + '</td>\
                                                <td>' + budget_it_operating + '</td>\
                                                <td>' + budget_it_investment + '</td>\
                                                <td class="text-success">' + budget + '</td>\
                                              </tr>';
                    } else {
                        html += '<tr class="text-end">\
                                                <td>' + budget_gov_operating + '</td>\
                                                <td>' + budget_gov_investment + '</td>\
                                                <td>' + budget_gov_utility + '</td>\
                                                <td>' + budget_it_operating + '</td>\
                                                <td>' + budget_it_investment + '</td>\
                                                <td class="text-success">' + budget + '</td>\
                                              </tr>';
                    }
                    html += '</table>';
                }

                if (task.cost) {
                    html += '<b>ค่าใช้จ่าย:</b> <span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                        style: 'currency',
                        currency: 'THB'
                    }).format(task.cost) + '</span><br/>';
                }
                if (task.balance) {
                    var tmp_class = task.balance > 0 ? 'green' : 'red';
                    html += '<b>คงเหลือ:</b> <span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                        style: 'currency',
                        currency: 'THB'
                    }).format(task.balance) + '</span><br/>';
                }

                return html;
            };

            gantt.ext.fullscreen.getFullscreenElement = function() {
                return document.querySelector("#gantt_here");
            };
            //Config
            gantt.config.date_format = "%Y-%m-%d";
            gantt.config.drag_links = false;
            gantt.config.drag_move = false;
            gantt.config.drag_progress = false;
            gantt.config.drag_resize = false;
            gantt.config.grid_resize = true;
            gantt.config.layout = {
                css: "gantt_container",
                rows: [{
                        cols: [{
                                view: "grid",
                                width: 600,
                                scrollX: "scrollHor",
                                scrollY: "scrollVer",
                                config: leftGridColumns
                            },
                            {
                                resizer: true,
                                width: 1
                            },
                            {
                                view: "timeline",
                                scrollX: "scrollHor",
                                scrollY: "scrollVer"
                            },
                            {
                                resizer: true,
                                width: 1
                            },
                            {
                                view: "grid",
                                width: 500,
                                bind: "task",
                                scrollY: "scrollVer",
                                config: rightGridColumns
                            },
                            {
                                view: "scrollbar",
                                id: "scrollVer"
                            }
                        ]

                    },
                    {
                        view: "scrollbar",
                        id: "scrollHor",
                        height: 20
                    }
                ]
            };
            gantt.config.readonly = true;
            gantt.config.scales = [{
                    unit: "year",
                    step: 1,
                    format: "%Y"
                },
                {
                    unit: "month",
                    step: 2,
                    format: "%M, %Y"
                },
                // {unit: "day", step: 3, format: "%D %M, %Y"},
            ];
            //ganttModules.zoom.setZoom("months");

            gantt.init("gantt_here");
            gantt.parse({
                data: {!! $gantt !!}
            });
        </script>
    </x-slot:javascript>
</x-app-layout>
