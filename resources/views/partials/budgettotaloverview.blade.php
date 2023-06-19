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
