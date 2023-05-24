@props([
    'icon' => null,
    'title' => null,
    'toolbar' => null,
    'width' => 12,
    'jack' => null,
    'contract' => null

])

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

                                เดือน</div>
                            <div
                                class="col-3">
                                {{ __('จำนวนวัน') }}
                            </div>
                            <div
                                class="col-3">

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

                                เดือน</div>
                            <div
                                class="col-3">
                                {{ __('ดำเนินการมาแล้ว') }}
                            </div>
                            <div
                                class="col-3">

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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--  --}}
