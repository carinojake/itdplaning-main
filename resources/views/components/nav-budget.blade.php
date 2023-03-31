
    <!-- 1 งาน -->
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
                                            {{ number_format($budget['total'], 2) }}
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">งบประมาณ
                                        </small>
                                        <div class="progress progress-thin mt-3 mb-0">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
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
                                            {{ number_format($project['budget_it_operating'], 2) }}
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">งบกลาง ICT</small>
                                        <div class="progress progress-thin mt-3 mb-0">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
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
                                            <!--คงเหลือ-->
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">คงเหลือ</small>
                                        <div class="progress progress-thin mt-3 mb-0">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
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
                                            {{ number_format($budget['balance'], 2) }}
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">คงเหลือ
                                        </small>
                                        <div class="progress progress-thin mt-3 mb-0">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
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
                                            {{ number_format($project['budget_it_investment'], 2) }}
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">งบดำเนินงาน</small>
                                        <div class="progress progress-thin mt-3 mb-0">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
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
                                        <div class="fs-4 fw-semibold">
                                            {{ number_format($project['budget_it_investment']-($ispa + $isa), 2) }}

                                            <!--คงเหลือ-->
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">รอการเบิกจ่าย</small>
                                        <div class="progress progress-thin mt-3 mb-0">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
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
                                            {{ number_format($project['budget_gov_utility'], 2) }}
                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">งบดำเนินงาน</small>
                                        <div class="progress progress-thin mt-3 mb-0">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
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
                                            {{ number_format($project['budget_gov_utility'] - ($utsc+$utpcs), 2) }}
                                            <!--qw-->

                                        </div>

                                        <small class="text-medium-emphasis text-uppercase fw-semibold">คงเหลือ</small>
                                        <div class="progress progress-thin mt-3 mb-0">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
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
