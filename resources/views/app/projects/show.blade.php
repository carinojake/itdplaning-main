<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">

            <div class="animated fadeIn">
                <div class="row">
                    <!-- {!! 'ปีงบประมาณ ' .
                        $project->project_fiscal_year .
                        '<br>' .
                        Helper::projectsType($project->project_type) .
                        $project->project_name !!}-->
                    {{ Breadcrumbs::render('project.show', $project) }}

                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

                        <x-card title="">

                            <x-slot:toolbar>
                                <a href="{{ route('project.edit', $project->hashid) }}" class="btn btn-warning text-dark"
                                    target="_blank">แก้ไข {{ Helper::projectsType($project->project_type) }} </a>
                                <a href="{{ route('project.task.create', $project->hashid) }}"
                                    class="btn btn-success text-white" target="_blank">เพิ่มกิจกรรม</a>
                                <a href="{{ route('project.index') }}" class="btn btn-secondary">กลับ</a>
                            </x-slot:toolbar>



                            <div class="d-flex align-items-start">
                                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <button class="nav-link active " id="v-pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-home" type="button" role="tab"
                                        aria-controls="v-pills-home" aria-selected="true">ภาพรวมทั้งหมด
                                        <!--{{ Helper::projectsType($project->project_type) }}{{ $project->reguiar_id }}-->
                                    </button>
                                    @if ($project['budget_it_operating'] > 0)
                                        <button class="nav-link " id="v-pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-profile" type="button" role="tab"
                                            aria-controls="v-pills-profile" aria-selected="false">งบกลาง
                                            ICT</button>
                                    @endif
                                    @if ($project['budget_it_investment'] > 0)
                                        <button class="nav-link " id="v-pills-messages-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-messages" type="button" role="tab"
                                            aria-controls="v-pills-messages" aria-selected="false">งบดำเนินงาน</button>
                                    @endif
                                    @if ($project['budget_gov_utility'] > 0)
                                        <button class="nav-link " id="v-pills-settings-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-settings" type="button" role="tab"
                                            aria-controls="v-pills-settings"
                                            aria-selected="false">งบสาธารณูปโภค</button>
                                    @endif
                                </div>
                                <div class="tab-content" id="v-pills-tabContent">
                                    <!-- 1 งาน -->
                                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                        aria-labelledby="v-pills-home-tab">
                                        <div class="row">
                                            <div class="col">
                                                <!--งบประมาณ-->
                                                <div class="card">
                                                    <div class="card-body">

                                                        <button class="btn " style="width: 13rem;"
                                                            data-bs-toggle="collapse" href="#collapseExample"
                                                            role="button" aria-expanded="false"
                                                            aria-controls="collapseExample">
                                                            <div class="fs-4 fw-semibold">
                                                                {{ number_format($budget['total'], 2) }}
                                                            </div>

                                                            <small class="text-xl">
                                                                งบประมาณ
                                                            </small>
                                                        </button>


                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col">
                                                <!--คงเหลือ-->
                                                <div class="card  ">
                                                    <div class="card-body">
                                                        <button class="btn " style="width: 13rem;"
                                                            data-bs-toggle="collapse" href="#collapseExample2"
                                                            role="button" aria-expanded="false"
                                                            aria-controls="collapseExample">
                                                            @php
                                                                $tmp_class_bal = $budget['balance'] > 1000000 ? 'success' : 'danger';
                                                            @endphp
                                                            <div class="fs-4 fw-semibold text-success">
                                                                {{ number_format(floatval($budget['balance']), 2) }}
                                                            </div>

                                                            <small class="text-xl">ยอดงบประมาณคงเหลือทั้งหมด</small>
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end1 งาน -->
                                    <!-- 2 งาน -->
                                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                        aria-labelledby="v-pills-profile-tab">

                                        <div>
                                            <div class="row">

                                                <div class="col">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <button class="btn " style="width: 13rem;"
                                                                data-bs-toggle="collapse" href="#collapseExample1"
                                                                role="button" aria-expanded="false"
                                                                aria-controls="collapseExample1">
                                                                <div class="fs-4 fw-semibold">
                                                                    {{ number_format($project['budget_it_operating'], 2) }}
                                                                </div>
                                                                <small class="text-xl">
                                                                    งบประมาณ
                                                                </small>
                                                            </button>
                                                        </div>
                                                        <div class="collapse" id="collapseExample1">
                                                            <div class="card-body">

                                                                <button class="btn " style="width: 12rem;"
                                                                    style="color:   #06268e" data-bs-toggle="collapse"
                                                                    href="#collapseExample2" role="button"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <div class="fs-4 fw-semibold ">
                                                                        {{ number_format($ospa, 2) }}
                                                                    </div>
                                                                    <small class="text-xl">จำนวนเงิน แบบมี PA
                                                                    </small>
                                                                </button>
                                                            </div>
                                                            <div class="card-body">

                                                                <button class="btn " style="width: 12rem;"
                                                                    data-bs-toggle="collapse" href="#collapseExample2"
                                                                    role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <div class="fs-4 fw-semibold ">
                                                                        <!--จำนวนเงินแบบไม่มี PA-->{{ number_format($osa, 2) }}
                                                                    </div>
                                                                    <small class="text-xl">จำนวนเงิน แบบไม่มี PA
                                                                    </small>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>




                                                <div class="col">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <!--รอการเบิกจ่ายทั้งหมด 3-->
                                                            <button class="btn " style="width: 12rem;"
                                                                data-bs-toggle="collapse" href="#collapseExample3"
                                                                role="button" aria-expanded="false"
                                                                aria-controls="collapseExample">
                                                                <div class="fs-4 fw-semibold btn btn-warning">
                                                                    <!--รอการเบิกจ่ายทั้งหมด-->
                                                                    {{ number_format($ospa - $otpsa1 - ($otpsa2 - $osa), 2) }}
                                                                </div>
                                                                <div>
                                                                    <small class="text-xl">รอการเบิกจ่ายทั้งหมด</small>
                                                                </div>
                                                            </button>
                                                        </div>
                                                        <div class="collapse" id="collapseExample3">
                                                            <div class="card-body">

                                                                <button class="btn " style="width: 12rem;"
                                                                    data-bs-toggle="collapse" href="#collapseExample2"
                                                                    role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <div class="fs-4 fw-semibold text-pay">
                                                                        <!--การเบิกจ่าย PA -->
                                                                        {{ number_format($ospa - $otpsa1, 2) }}
                                                                    </div>
                                                                    <small class="text-xl">รอการเบิกจ่าย แบบมี PA
                                                                    </small>

                                                                </button>
                                                            </div>
                                                            <div class="card-body">

                                                                <button class="btn " style="width: 12rem;"
                                                                    data-bs-toggle="collapse" href="#collapseExample2"
                                                                    role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <div class="fs-4 fw-semibold text-pay">
                                                                        <!--การเบิกจ่าย PA -->
                                                                        {{ number_format($osa - $otpsa2, 2) }}
                                                                    </div>
                                                                    <small class="text-xl">รอการเบิกจ่าย แบบมีไม่ PA
                                                                    </small>

                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="card">
                                                        <div class="card-body ">
                                                            <button class="btn " style="width: 12rem;"
                                                                data-bs-toggle="collapse" href="#collapseExample2"
                                                                role="button" aria-expanded="false"
                                                                aria-controls="collapseExample">
                                                                <div class="fs-4 fw-semibold btn btn-primary">
                                                                    <!--รวมเบิกจ่ายทั้งหมด-->
                                                                    {{ number_format($otpsa1 + $otpsa2, 2) }}

                                                                </div>
                                                                <div>
                                                                    <small class="text-xl">รวมเบิกจ่ายทั้งหมด</small>
                                                                </div>
                                                            </button>

                                                        </div>
                                                        <div class="collapse" id="collapseExample2">
                                                            <div class="card-body">

                                                                <button class="btn " style="width: 12rem;"
                                                                    data-bs-toggle="collapse" href="#collapseExample2"
                                                                    role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <div class="fs-4 fw-semibold text-primary">
                                                                        {{ number_format($otpsa1, 2) }}
                                                                    </div>
                                                                    <small class="text-xl">การเบิกเงิน
                                                                        แบบมี PA
                                                                    </small>
                                                                </button>
                                                            </div>
                                                            <div class="card-body">

                                                                <button class="btn " style="width: 12rem;"
                                                                    data-bs-toggle="collapse" href="#collapseExample2"
                                                                    role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <div class="fs-4 fw-semibold text-primary">
                                                                        <!--จำนวนเงินแบบไม่มี PA-->{{ number_format($otpsa2, 2) }}
                                                                    </div>
                                                                    <small class="text-xl">การเบิกเงิน
                                                                        แบบไม่มี PA
                                                                    </small>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="col">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <!--ยอดงบประมาณคงเหลือทั้งหมด-->
                                                            <button class="btn " style="width: 12rem;"
                                                                data-bs-toggle="collapse" href="#collapseExample"
                                                                role="button" aria-expanded="false"
                                                                aria-controls="collapseExample">
                                                                <div class="fs-4 fw-semibold btn btn-success"
                                                                    style="btn btn-success">
                                                                    <!--ยอดงบประมาณคงเหลือทั้งหมด-->
                                                                    {{ number_format($project['budget_it_operating'] - ($ospa + $osa), 2) }}
                                                                </div>
                                                                <div>
                                                                    <small
                                                                        class="text-xl">ยอดงบประมาณคงเหลือทั้งหมด</small>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                    <!-- 2 งาน จบ-->
                                    <!-- 3 งาน -->



                                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                        aria-labelledby="v-pills-messages-tab">
                                        <!-- 3 งาน -->
                                        <!--งบประมาณ-->
                                        <div>
                                            <div class="row mb-3">

                                                <div class="col">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <button class="btn " style="width: 12rem;"
                                                                data-bs-toggle="collapse" href="#collapseExample1"
                                                                role="button" aria-expanded="false"
                                                                aria-controls="collapseExample1">
                                                                <div class="fs-4 fw-semibold">
                                                                    {{ number_format($project['budget_it_investment'], 2) }}
                                                                </div>
                                                                <div>
                                                                    <small class="text-xl">
                                                                        งบประมาณ
                                                                    </small>
                                                                </div>
                                                            </button>
                                                        </div>
                                                        <div class="collapse" id="collapseExample1">
                                                            <div class="card-body">

                                                                <button class="btn " data-bs-toggle="collapse"
                                                                    style="width: 12rem;" href="#collapseExample2"
                                                                    role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <div class="fs-4 fw-semibold">
                                                                        {{ number_format($ispa, 2) }}
                                                                    </div>
                                                                    <div>
                                                                        <small class="text-xl">จำนวนเงิน แบบมี
                                                                            PA
                                                                        </small>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                            <div class="card-body">

                                                                <button class="btn " style="width: 12rem;"
                                                                    data-bs-toggle="collapse" href="#collapseExample2"
                                                                    role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <div class="fs-4 fw-semibold">
                                                                        <!--จำนวนเงินแบบไม่มี PA-->{{ number_format($isa, 2) }}
                                                                    </div>
                                                                    <small class="text-xl ">จำนวนเงินแบบ ไม่มี PA
                                                                    </small>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <!--รอการเบิกจ่ายทั้งหมด 3-->
                                                            <button class="btn " style="width: 12rem;"
                                                                data-bs-toggle="collapse" href="#collapseExample3"
                                                                role="button" aria-expanded="false"
                                                                aria-controls="collapseExample">
                                                                <div class="fs-4 fw-semibold btn btn-warning">
                                                                    <!--รอการเบิกจ่ายทั้งหมด-->
                                                                    {{ number_format($ispa - $itpsa1 - ($itpsa2 - $isa), 2) }}
                                                                </div>
                                                                <div>
                                                                    <small
                                                                        class="text-xl ">รอการเบิกจ่ายทั้งหมด</small>
                                                                </div>

                                                            </button>
                                                        </div>

                                                        <div class="collapse" id="collapseExample3">
                                                            <div class="card-body ">

                                                                <button class="btn " style="width: 12rem;"
                                                                    data-bs-toggle="collapse" href="#collapseExample2"
                                                                    role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <div class="fs-4 fw-semibold text-pay">
                                                                        <!--การเบิกจ่าย PA -->
                                                                        {{ number_format($ispa - $itpsa1, 2) }}
                                                                    </div>
                                                                    <small class="text-xl ">รอการเบิกจ่าย
                                                                        แบบมี PA
                                                                    </small>

                                                                </button>
                                                            </div>




                                                            <div class="card-body">

                                                                <button class="btn " style="width: 12rem;"
                                                                    data-bs-toggle="collapse" href="#collapseExample2"
                                                                    role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <div class="fs-4 fw-semibold  text-pay">
                                                                        <!--การเบิกจ่าย PA -->
                                                                        {{ number_format($isa - $itpsa2, 2) }}
                                                                    </div>
                                                                    <div>
                                                                        <small class="text-xl ">รอการเบิกจ่าย
                                                                            แบบมีไม่ PA
                                                                        </small>
                                                                    </div>

                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <button class="btn " style="width: 12rem;"
                                                                data-bs-toggle="collapse" href="#collapseExample2"
                                                                role="button" aria-expanded="false"
                                                                aria-controls="collapseExample">
                                                                <div class="fs-4 fw-semibold   btn btn-primary">
                                                                    <!--รวมเบิกจ่ายทั้งหมด-->
                                                                    {{ number_format($itpsa1 + $itpsa2, 2) }}

                                                                </div>
                                                                <div>
                                                                    <small class="text-xl">รวมเบิกจ่ายทั้งหมด</small>
                                                                </div>
                                                            </button>
                                                        </div>
                                                        <div class="collapse" id="collapseExample2">
                                                            <div class="card-body">

                                                                <button class="btn " data-bs-toggle="collapse"
                                                                    style="width: 12rem;" href="#collapseExample2"
                                                                    role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <div class="fs-4 fw-semibold  text-primary">
                                                                        {{ number_format($itpsa1, 2) }}
                                                                    </div>
                                                                    <div>
                                                                        <small class="text-xl ">การเบิกเงิน แบบมี PA
                                                                        </small>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                            <div class="card-body">

                                                                <button class="btn "style="width: 12rem;"
                                                                    data-bs-toggle="collapse" href="#collapseExample2"
                                                                    role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <div class="fs-4 fw-semibold text-primary">
                                                                        <!--จำนวนเงินแบบไม่มี PA-->{{ number_format($itpsa2, 2) }}
                                                                    </div>
                                                                    <div>
                                                                        <small class="text-xl">การเบิกเงิน แบบไม่มี PA
                                                                        </small>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>




                                                <div class="col ">
                                                    <div class="card ">
                                                        <div class="card-body ">
                                                            <!--ยอดงบประมาณคงเหลือทั้งหมด-->
                                                            <button class="btn " style="width: 12rem;"
                                                                data-bs-toggle="collapse" href="#collapseExample"
                                                                role="button" aria-expanded="false"
                                                                aria-controls="collapseExample">
                                                                <div class="fs-4 fw-semibold btn btn-success">
                                                                    <!--ยอดงบประมาณคงเหลือทั้งหมด-->
                                                                    {{ number_format($project['budget_it_investment'] - ($ispa + $isa), 2) }}
                                                                </div>
                                                                <div>
                                                                    <small
                                                                        class="text-xl  ">ยอดงบประมาณคงเหลือทั้งหมด</small>
                                                                </div>
                                                            </button>
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
                                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                            aria-labelledby="v-pills-home-tab">
                                            <div>
                                                <div class="row">

                                                    <div class="col">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <button class="btn "style="width: 12rem;"
                                                                    data-bs-toggle="collapse" href="#collapseExample1"
                                                                    role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample1">
                                                                    <div class="fs-4 fw-semibold">
                                                                        {{ number_format($project['budget_gov_utility'], 2) }}
                                                                    </div>
                                                                    <div>
                                                                        <small class="text-xl">
                                                                            งบประมาณ
                                                                        </small>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                            <div class="collapse" id="collapseExample1">
                                                                <div class="card-body">

                                                                    <button class="btn " style="width: 12rem;"
                                                                        style="color:   #06268e"
                                                                        data-bs-toggle="collapse"
                                                                        href="#collapseExample2" role="button"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold">
                                                                            {{ number_format($utpcs, 2) }}
                                                                        </div>
                                                                        <div>
                                                                            <small class="text-xl">จำนวนเงิน แบบมี PA
                                                                            </small>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                                <div class="card-body">

                                                                    <button class="btn " style="width: 12rem;"
                                                                        data-bs-toggle="collapse"
                                                                        href="#collapseExample2" role="button"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold">
                                                                            <!--จำนวนเงินแบบไม่มี PA-->{{ number_format($utsc, 2) }}
                                                                        </div>
                                                                        <div>
                                                                            <small class="text-xl">จำนวนเงิน แบบไม่มี
                                                                                PA
                                                                            </small>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="col">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <!--รอการเบิกจ่ายทั้งหมด 3-->
                                                                <button class="btn " style="width: 12rem;"
                                                                    data-bs-toggle="collapse" href="#collapseExample3"
                                                                    role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <div class="fs-4 fw-semibold btn btn-warning">
                                                                        <!--รอการเบิกจ่ายทั้งหมด-->
                                                                        {{ number_format($utpcs - $utsc_pay_pa + ($utsc - $utsc_pay), 2) }}
                                                                    </div>
                                                                    <div>
                                                                        <small
                                                                            class="text-xl">รอการเบิกจ่ายทั้งหมด</small>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                            <div class="collapse" id="collapseExample3">
                                                                <div class="card-body">

                                                                    <button class="btn " style="width: 12rem;"
                                                                        data-bs-toggle="collapse"
                                                                        href="#collapseExample2" role="button"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold text-pay">
                                                                            <!--การเบิกจ่าย PA -->
                                                                            {{ number_format($utpcs - $utsc_pay_pa, 2) }}
                                                                        </div>
                                                                        <small class="text-xl">รอการเบิกจ่าย แบบมี
                                                                            PA</small>

                                                                    </button>
                                                                </div>
                                                                <div class="card-body">

                                                                    <button class="btn " style="width: 12rem;"
                                                                        data-bs-toggle="collapse"
                                                                        href="#collapseExample2" role="button"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold text-pay">
                                                                            <!--การเบิกจ่าย PA -->
                                                                            {{ number_format($utsc - $utsc_pay, 2) }}
                                                                        </div>
                                                                        <div>
                                                                            <small class="text-xl">รอการเบิกจ่าย ไม่แบบ
                                                                                PA</small>
                                                                        </div>

                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <button class="btn " style="width: 12rem;"
                                                                    data-bs-toggle="collapse" href="#collapseExample2"
                                                                    role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <div class="fs-4 fw-semibold btn btn-primary">
                                                                        <!--รวมเบิกจ่ายทั้งหมด-->
                                                                        {{ number_format($utsc_pay_pa + $utsc_pay, 2) }}

                                                                    </div>
                                                                    <div>
                                                                        <small class="text-xl">
                                                                            รวมเบิกจ่ายทั้งหมด</small>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                            <div class="collapse" id="collapseExample2">
                                                                <div class="card-body">

                                                                    <button class="btn " style="width: 12rem;"
                                                                        data-bs-toggle="collapse"
                                                                        href="#collapseExample2" role="button"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold text-primary">
                                                                            {{ number_format($utsc_pay_pa, 2) }}
                                                                        </div>
                                                                        <small class="text-xl">จำนวนเงิน แบบมี PA
                                                                        </small>
                                                                    </button>
                                                                </div>
                                                                <div class="card-body">

                                                                    <button class="btn "style="width: 12rem;"
                                                                        data-bs-toggle="collapse"
                                                                        href="#collapseExample2" role="button"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseExample">
                                                                        <div class="fs-4 fw-semibold text-primary">
                                                                            <!--จำนวนเงินแบบไม่มี PA-->{{ number_format($utsc_pay, 2) }}
                                                                        </div>
                                                                        <div>
                                                                            <small class="text-xl">จำนวนเงิน แบบไม่มี
                                                                                PA
                                                                            </small>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <!--ยอดงบประมาณคงเหลือทั้งหมด-->
                                                                <button class="btn "style="width: 12rem;"
                                                                    data-bs-toggle="collapse" href="#collapseExample"
                                                                    role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <div class="fs-4 fw-semibold btn btn-success">
                                                                        <!--ยอดงบประมาณคงเหลือทั้งหมด สาธารณูปโภค-->

                                                                        {{ number_format($project['budget_gov_utility'] - ($utsc_pay_pa + $utsc_pay), 2) }}

                                                                    </div>
                                                                    <div>
                                                                        <small
                                                                            class="text-xl">ยอดงบประมาณคงเหลือทั้งหมด</small>
                                                                    </div>
                                                                </button>
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





                            <div id="gantt_here" style='width:100%; height:50vh;'></div>

                            <table class="table">
                                <thead>
                                    <tr>
                                         <th width="50">ลำดับ</th>
                                        <th>กิจกรรม</th>
                                        <th>วันที่</th>
                                        <th width="200"> คำสั่ง</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->main_task as $index => $task)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <div>
                                                    {{ $task->task_name }} {!! $task->task_status == 2 ? '<span class="badge bg-info">ดำเนินการแล้วเสร็จ</span>' : '' !!}
                                                </div>
                                                @if ($task->contract->count() > 0)
                                                    <div class="mt-2">
                                                        <h6>สัญญา</h6>
                                                        @foreach ($task->contract as $contract)
                                                            <a href="{{ route('contract.show', ['contract' => $contract->hashid]) }}"><span class="badge bg-warning">{{ $contract->contract_number }}</span></a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                @if ($task->subtask->count() > 0)
                                                    <div class="mt-2">
                                                        <h6>รายการที่ใช้จ่าย</h6>
                                                        <ul>
                                                            @foreach ($task->subtask as $subtask)
                                                                <li>
                                                                    {{ $subtask->task_name }}

                                                                    @if ($subtask->contract->count() > 0)



                                                                        @foreach ($subtask->contract as $contract)




                                                                               <!-- Button trigger modal -->
                                                                               <button type="button"
                                                                               class="badge btn btn-success text-white "
                                                                        data-coreui-toggle="modal"
                                                                        data-coreui-target="#exampleModal{{ $contract->hashid }}">


                                                                         @if (($contract->contract_type == 4))
                                                                         {{ \Helper::contractType($contract->contract_type) }}"_"{{  strtolower($contract->contract_number)  }}
                                                                         @else
                                                                            สญ.ที่ {{  strtolower($contract->contract_number)  }}
                                                                         @endif
                                                                    </button>

                                                                    <!-- Modal -->
                                                                    <div class="modal fade"
                                                                        id="exampleModal{{ $contract->hashid }}"
                                                                        tabindex="-1"
                                                                        aria-labelledby="exampleModalLabel"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog modal-xl">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"
                                                                                        id="exampleModalLabel">
                                                                                        สัญญา
                                                                                        {{ $contract->contract_number }}
                                                                                    </h5>
                                                                                    <button type="button"
                                                                                        class="btn-close"
                                                                                        data-coreui-dismiss="modal"
                                                                                        aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">


                                                                                    {{--  --}}
                                                                                    <div class="container">
                                                                                        <div class="row">
                                                                                            <div class="col-sm">
                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-3">
                                                                                                        {{ __('สถานะสัญญา') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-9">
                                                                                                        <?php
                                                                                                        echo isset($contract) && $contract->contract_status == 2 ? '<span style="color:red;">ดำเนินการแล้วเสร็จ</span>' : '<span style="color:green;">อยู่ในระหว่างดำเนินการ</span>';
                                                                                                        ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-3">
                                                                                                        {{ __('เลขที่ สัญญา') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-9">
                                                                                                        {{ $contract->contract_number }}
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-3">
                                                                                                        {{ __('เลขที่ คู่ค้า') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-9">
                                                                                                        {{ $contract->contract_juristic_id }}
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-3">
                                                                                                        {{ __('เลขที่สั่งซื้อ') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-9">
                                                                                                        {{ $contract->contract_order_no }}
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-3">
                                                                                                        {{ __('ประเภท') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-9">
                                                                                                        {{ \Helper::contractType($contract->contract_type) }}
                                                                                                    </div>
                                                                                                </div>
                                                                                                {{-- <div class="row">
            <div class="col-3">{{ __('วิธีการได้มา') }}</div>
            <div class="col-9">
                {{ \Helper::contractAcquisition($contract->contract_acquisition) }}
            </div>
        </div> --}}
                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-3">
                                                                                                        {{ __('วันที่เริ่มสัญญา') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-9">
                                                                                                        {{ Helper::Date4(date('Y-m-d H:i:s', $contract->contract_start_date)) }}
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-3">
                                                                                                        {{ __('วันที่สิ้นสุดสัญญา') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-9">
                                                                                                        {{ Helper::Date4(date('Y-m-d H:i:s', $contract->contract_end_date)) }}
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-3">
                                                                                                        {{ __('จำนวนเดือน') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-3">
                                                                                                        {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse($contract->contract_end_date)) }}
                                                                                                        เดือน</div>
                                                                                                    <div
                                                                                                        class="col-3">
                                                                                                        {{ __('จำนวนวัน') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-3">
                                                                                                        {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse($contract->contract_end_date)) }}
                                                                                                        วัน</div>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-3">
                                                                                                        {{ __('ดำเนินการมาแล้ว') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-3">
                                                                                                        {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse()) }}
                                                                                                        เดือน</div>
                                                                                                    <div
                                                                                                        class="col-3">
                                                                                                        {{ __('ดำเนินการมาแล้ว') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-3">
                                                                                                        {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse()) }}
                                                                                                        วัน</div>
                                                                                                </div>

                                                                                                {{--   <div class="row">
            <div class="col-3">{{ __('เตือน เหลือเวลา') }}</div>
            <div class="col-9">
                <?php
                echo isset($duration_p) && $duration_p < 3 ? '<span style="color:red;">' . $duration_p . '</span>' : '<span style="color:rgb(5, 255, 5);">' . $duration_p . '</span>';
                ?> เดือน


            </div>
        </div> --}}


                                                                                            </div>
                                                                                            <div class="col-sm">
                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ __('หมายเหตุ') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ $contract->contract_projectplan }}
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ __('เลขที่ MM') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ $contract->contract_mm }}
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ __('จำนวนเงิน MM') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ $contract->contract_mm_bodget }}
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ __('เลขที่ PR') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ $contract->contract_pr }}
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ __('จำนวนเงิน PR') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ number_format($contract->contract_pr_budget) }}
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ __('เลขที่ PA') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ $contract->contract_pa }}
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ __('จำนวนเงิน PA') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ number_format($contract->contract_pa_budget) }}
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ __('จำนวนคงเหลือหลังเงิน PA') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ number_format($contract->contract_pr_budget - $contract->contract_pa_budget) }}
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div
                                                                                                    class="row">
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ __('จำนวนเงิน ที่ใช้จ่ายต่อปี') }}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-6">
                                                                                                        {{ number_format($contract->contract_peryear_pa_budget) }}
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    {{--  --}}
                                                                                </div>
                                                                                <div class="modal-footer">

                                                                                    <div>
                                                                                        <a href="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}" class="btn btn-primary btn-sm" target="_blank"><i class="cil-folder-open"></i></a>
                                                                                        <a href="{{ route('project.task.editsub', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}" class="btn btn-warning btn-sm" target="_blank"><i class="cil-cog"></i></a>
                                                                                        <form action="{{ route('project.task.destroy', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}" method="POST" style="display:inline">
                                                                                            @method('DELETE')
                                                                                            @csrf
                                                                                            <button class="btn btn-danger btn-sm"><i class="cil-trash"></i></button>
                                                                                        </form>
                                                                                    </div>



                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-coreui-dismiss="modal">Close</button>







                                                                                    </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif





                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s', $task->task_start_date)) }}</span>
                                                <span class="badge bg-primary">{{ \Helper::date4(date('Y-m-d H:i:s', $task->task_end_date)) }}</span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]) }}" class="btn btn-primary text-white" target="_blank"><i class="cil-folder-open"></i></a>
                                                <a href="{{ route('project.task.edit', ['project' => $project->hashid, 'task' => $task->hashid]) }}" class="btn btn-warning text-white" target="_blank"><i class="cil-cog"></i></a>
                                                <form action="{{ route('project.task.destroy', ['project' => $project->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-danger text-white"><i class="cil-trash"></i></button>
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

        <!--  <link href="{{ asset('css/styleitp.css') }}" rel="stylesheet"> -->
        <link rel="stylesheet" href="{{ asset('/vendors/dhtmlx/dhtmlxgantt.css') }}" type="text/css">


        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">


        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </x-slot:css>
    <x-slot:javascript>

        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> --}}
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="https://docs.dhtmlx.com/gantt/codebase/dhtmlxgantt.js?v=7.1.13"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>




        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const popoverEl = document.querySelectorAll('[data-coreui-toggle="popover"]');
                Array.from(popoverEl).forEach(function(el) {
                    new coreui.Popover(el);
                });
            });
        </script>




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
                columns: [{
                        name: "budget",
                        width: 120,
                        label: "งบประมาณ",
                        tree: true,
                        resize: true,
                        template: function(task) {
                            if (task.budget) {
                                return new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget);
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        name: "cost_pa",
                        width: 150,
                        label: "PA",
                        tree: true,
                        resize: true,
                        template: function(task) {



                            if (task.task_type == 1) {
                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost);
                            } else


                           if (task.cost_pa_1 > 0) {
                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost_pa_1) + '</span>';
                            }




                            else {
                                return '-';
                            }
                        }
                    },

                    {
                        name: "cost_no_pa",
                        width: 150,
                        label: "ไม่มี PA",
                        tree: true,
                        resize: true,
                        template: function(task) {
                            if (task.task_type == 2) {
                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost);
                            } else if (task.cost_no_pa_2 > 0) {
                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost_no_pa_2) + '</span>';
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        name: "-",
                        width: 100,
                        label: "รอการเบิกจ่าย",
                        tree: true,
                        resize: true,
                        template: function(task) {

                             if (task.total_cost > 0) {
                                return '<span class="text-warning">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.total_cost - task.total_pay) + '</span>';
                            }

                           else if (task.total_pay > 0) {
                                return '<span class="text-warning">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.total_cost - task.total_pay) + '</span>';
                            }

                            else if (task.task_total_pay > 0) {
                                let remainingCost = task.cost - task.task_total_pay;
                                if (remainingCost > 0) {
                                    return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                        style: 'currency',
                                        currency: 'THB'
                                    }).format(remainingCost) + '</span>';
                                }


                                else {
                                    return '-';
                                }
                            }

                            else if (task.task_type == 1) {
                                if (task.cost - task.pay > 0) {
                                    return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                        style: 'currency',
                                        currency: 'THB'
                                    }).format(task.cost - task.pay) + '</span>';
                                } else {
                                    return '-';
                                }
                            }

                            else if (task.task_type == 2) {
                                if (task.cost - task.pay > 0) {
                                    return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                        style: 'currency',
                                        currency: 'THB'
                                    }).format(task.cost - task.pay) + '</span>';
                                }
                                else {
                                    return '';
                                }}


                                else if (task.cost > 0) {
                                if (task.cost - task.pay ) {
                                    return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                        style: 'currency',
                                        currency: 'THB'
                                    }).format(task.cost - task.pay) + '</span>';
                                }
                                else {
                                    return '';
                                }}


                                else {
                                return '';
                            }
                        }
                    },
                    {
                        name: "pay",
                        width: 100,
                        label: "เบิกจ่ายแล้ว",
                        tree: true,
                        resize: true,
                        template: function(task) {
                            if (task.task_total_pay > 0) {
                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.task_total_pay) + '</span>';
                            } else if (task.task_type == 1 && task.pay > 0) {
                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.pay) + '</span>';
                            } else if (task.task_type == 2 && task.pay > 0) {
                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.pay) + '</span>';
                            } else if (task.total_pay > 0) {
                                return '<span style="color:#6010f6;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.total_pay) + '</span>';
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        name: "balance",
                        width: 100,
                        label: "คงเหลือ",
                        tree: true,
                        resize: true,
                        template: function(task) {
                            if (task.balance > 0) {
                                var tmp_class = task.balance < 0 ? 'red' : 'green';
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.balance) + '</span>';
                            } else if (task.balance == 0) {
                                return '-';
                            } else {
                                return '-';
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
                                width: 1,
                                height: 20
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
                    format: function(date) {
                        return parseInt(gantt.date.date_to_str("%Y")(date)) + 543;
                    },



                },
                {
                    unit: "month",
                    step: 2,
                    format: function(date) {
                        //const thaiMonthNames = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
                        const thaiMonthNames = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.",
                            "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
                        ];
                        const thaiYearNumber = parseInt(gantt.date.date_to_str("%Y")(date)) + 543;
                        const thaiMonthName = thaiMonthNames[date.getMonth()];
                        return thaiMonthName + " " + thaiYearNumber;
                    }
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
