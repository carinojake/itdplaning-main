<x-app-layout>
    <x-slot:content>



    <div class="container-fluid">
        <div class="animated fadeIn">
          <!-- Widget Card number -->
          <div class="mb-3 row">
            <div class="col-sm-6 col-md-3 col-lg-2">
              <div class="card">
                <div class="card-body">
                  <div class="mb-4 text-medium-emphasis text-end">
                    <svg class="icon icon-xxl">
                      <use xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-building') }}"></use>
                    </svg>
                  </div>
                  <div class="fs-4 fw-semibold">{{ $projects }}</div><small class="text-medium-emphasis text-uppercase fw-semibold">งานประจำ</small>
                  <div class="mt-3 mb-0 progress progress-thin">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-3 col-lg-2">
              <div class="card">
                <div class="card-body">
                  <div class="mb-4 text-medium-emphasis text-end">
                    <svg class="icon icon-xxl">
                      <use xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-description') }}"></use>
                    </svg>
                  </div>
                  <div class="fs-4 fw-semibold">{{ $contracts }}</div><small class="text-medium-emphasis text-uppercase fw-semibold">สัญญา</small>
                  <div class="mt-3 mb-0 progress progress-thin">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-2">
              <div class="card">
                <div class="card-body">
                  <div class="mb-4 text-medium-emphasis text-end">
                    <svg class="icon icon-xxl">
                      <use xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}"></use>
                    </svg>
                  </div><div class="fs-4 fw-semibold">{{  Helper::millionFormat($budgets) }}</div><small class="text-medium-emphasis text-uppercase fw-semibold">งบประมาณ</small>

                  <div class="mt-3 mb-0 progress progress-thin">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div></div>


              <div class="col-sm-6 col-md-3 col-lg-2">
                  <div class="card">
                    <div class="card-body">
                      <div class="mb-4 text-medium-emphasis text-end">
                        <svg class="icon icon-xxl">
                          <use xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}"></use>
                        </svg>
                      </div><div class="fs-4 fw-semibold">{{  Helper::millionFormat($budgets) }}</div><small class="text-medium-emphasis text-uppercase fw-semibold">งบประมาณ</small>

                      <div class="mt-3 mb-0 progress progress-thin">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div></div>

                  <div class="col-sm-6 col-md-3 col-lg-2">
                      <div class="card">
                        <div class="card-body">
                          <div class="mb-4 text-medium-emphasis text-end">
                            <svg class="icon icon-xxl">
                              <use xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}"></use>
                            </svg>
                          </div><div class="fs-4 fw-semibold">{{ Helper::millionFormat ($coats) }} </div><small class="text-medium-emphasis text-uppercase fw-semibold">การใช้จ่าย</small>

                          <div class="mt-3 mb-0 progress progress-thin">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div></div>

                      <div class="col-sm-6 col-md-3 col-lg-2">
                          <div class="card">
                            <div class="card-body">
                              <div class="mb-4 text-medium-emphasis text-end">
                                <svg class="icon icon-xxl">
                                  <use xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}"></use>
                                </svg>
                              </div><div class="fs-4 fw-semibold">{{ Helper::millionFormat ($total_bu) }} </div><small class="text-medium-emphasis text-uppercase fw-semibold">คงเหลือ</small>

                              <div class="mt-3 mb-0 progress progress-thin">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                        </div>



                        <div class="mb-3 row"> </div>
                          <div class="col-sm-6 col-md-3 col-lg-2">
                            <div class="card">
                              <div class="card-body">
                                <div class="mb-4 text-medium-emphasis text-end">
                                  <svg class="icon icon-xxl">
                                    <use xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-laptop') }}"></use>
                                  </svg>
                                </div><div class="fs-4 fw-semibold">{{ Helper::millionFormat ($budgetsict) }} </div><small class="text-medium-emphasis text-uppercase fw-semibold">ict</small>

                                <div class="mt-3 mb-0 progress progress-thin">
                                  <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </div></div>



                            <div class="col-sm-6 col-md-3 col-lg-2">
                                <div class="card">
                                  <div class="card-body">
                                    <div class="mb-4 text-medium-emphasis text-end">
                                      <svg class="icon icon-xxl">
                                        <use xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-dollar') }}"></use>
                                      </svg>
                                    </div><div class="fs-4 fw-semibold">{{ Helper::millionFormat ($budgetsgov) }} </div><small class="text-medium-emphasis text-uppercase fw-semibold">งบดำเนินงาน</small>

                                    <div class="mt-3 mb-0 progress progress-thin">
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                  </div>
                                </div></div>

                                 <div class="col-sm-6 col-md-3 col-lg-2">
                          <div class="card">
                            <div class="card-body">
                              <div class="mb-4 text-medium-emphasis text-end">
                                <svg class="icon icon-xxl">
                                  <use xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-router') }}"></use>
                                </svg>
                              </div><div class="fs-4 fw-semibold">{{ Helper::millionFormat ($budgetsut) }} </div><small class="text-medium-emphasis text-uppercase fw-semibold">ค่าสาธารณูปโภค</small>

                              <div class="mt-3 mb-0 progress progress-thin">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div></div>




                          <div class="col-sm-6 col-md-3 col-lg-2">
                            <div class="card">
                              <div class="card-body">
                                <div class="mb-4 text-medium-emphasis text-end">
                                  <svg class="icon icon-xxl">
                                    <use xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}"></use>
                                  </svg>
                                </div><div class="fs-4 fw-semibold">{{ Helper::millionFormat ($coats_ict) }} </div><small class="text-medium-emphasis text-uppercase fw-semibold">ค่าใช้ict</small>

                                <div class="mt-3 mb-0 progress progress-thin">
                                  <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </div></div>


                            <div class="col-sm-6 col-md-3 col-lg-2">
                                <div class="card">
                                  <div class="card-body">
                                    <div class="mb-4 text-medium-emphasis text-end">
                                      <svg class="icon icon-xxl">
                                        <use xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}"></use>
                                      </svg>
                                    </div><div class="fs-4 fw-semibold">{{ Helper::millionFormat ($coats_gov) }} </div><small class="text-medium-emphasis text-uppercase fw-semibold">oe</small>

                                    <div class="mt-3 mb-0 progress progress-thin">
                                      <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                  </div>
                                </div></div>

                                 <div class="col-sm-6 col-md-3 col-lg-2">
                          <div class="card">
                            <div class="card-body">
                              <div class="mb-4 text-medium-emphasis text-end">
                                <svg class="icon icon-xxl">
                                  <use xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}"></use>
                                </svg>
                              </div><div class="fs-4 fw-semibold">{{ Helper::millionFormat ($coats_ut) }} </div><small class="text-medium-emphasis text-uppercase fw-semibold">utility bills</small>

                              <div class="mt-3 mb-0 progress progress-thin">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div></div>
         </div>
         <!-- End Widget Card number -->

          <!-- Widget Chart -->


          <div class="mb-3 row">
            <div class="col-sm-6 col-md-6 col-lg-6">
              <div class="card">
                <div class="card-body">
                  <div class="card-title fs-5 fw-semibold">แยกงานประจำ/โครงการ ตามปีงบประมาณ</div>
                  <div id="chart-task-div" class="chartdiv"></div>
                </div>
              </div>
          </div>


          <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="card">
              <div class="card-body">
                <div class="card-title fs-5 fw-semibold">แยก ค่าใช้จ่ายตามปีงบประมาณ</div>
                <div id="chart-d-div" class="chartdiv"></div>
              </div>
            </div>
          </div>
        </div>

<div class="mb-3 row">

      <div class="card">
        <div class="card-body">
          <div class="card-title fs-5 fw-semibold">Project</div>

            <div id="gantt_here" style='width:100%; height:100vh;'></div>

        </div>

  </div>
</div>



 <!-- Widget Chart yaer -->


 <div class="mb-3 row">
    <div class="col-sm-6 col-md-6 col-lg-6">
      <div class="card">
        <div class="card-body">
          <div class="card-title fs-5 fw-semibold">งบประมาณ</div>
          <div id="chart-task-div" class="chartdiv"></div>
        </div>
      </div>
  </div>


  <div class="col-sm-6 col-md-6 col-lg-6">
    <div class="card">
      <div class="card-body">
        <div class="card-title fs-5 fw-semibold">งบประมาณ xx</div>
        <div id="chart-d-div" class="chartdiv"></div>
      </div>
    </div>
  </div>
</div>




        </div>





        <style>
        .chartdiv {
          width: 100%;
          height: 250px;
        }
      </style>




    </x-slot:content>

    <x-slot:css>
      <link rel="stylesheet" href="{{ asset('/vendors/dhtmlx/dhtmlxgantt.css') }}" type="text/css">
    </x-slot:css>
    <x-slot:javascript>
      <!-- Resources -->
      <script src="{{ asset('vendors/amcharts5/index.js') }}"></script>
      <script src="{{ asset('vendors/amcharts5/xy.js') }}"></script>
      <script src="{{ asset('vendors/amcharts5/percent.js') }}"></script>
      <script src="{{ asset('vendors/amcharts5/themes/Animated.js') }}"></script>
      <script src="//cdn.amcharts.com/lib/4/core.js"></script>
<script src="//cdn.amcharts.com/lib/4/charts.js"></script>
      <script src="{{ asset('/vendors/dhtmlx/dhtmlxgantt.js') }}"></script>
      <!-- Chart code -->
      <script>
        am5.ready(function() {

          // Create root element
          // https://www.amcharts.com/docs/v5/getting-started/#Root_element
          var root = am5.Root.new("chart-project-div");

          root._logo.dispose();


          // Set themes
          // https://www.amcharts.com/docs/v5/concepts/themes/
          root.setThemes([
            am5themes_Animated.new(root)
          ]);


          // Create chart
          // https://www.amcharts.com/docs/v5/charts/xy-chart/
          var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX: true
          }));

          // Add cursor
          // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
          var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
          cursor.lineY.set("visible", false);


          // Create axes
          // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
          var xRenderer = am5xy.AxisRendererX.new(root, {
            minGridDistance: 30
          });
          xRenderer.labels.template.setAll({
            rotation: -90,
            centerY: am5.p50,
            centerX: am5.p100,
            paddingRight: 15
          });

          var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
            maxDeviation: 0.3,
            categoryField: "fiscal_year",
            renderer: xRenderer,
            tooltip: am5.Tooltip.new(root, {})
          }));

          var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            maxDeviation: 0.3,
            renderer: am5xy.AxisRendererY.new(root, {})
          }));


          // Create series
          // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
          var series = chart.series.push(am5xy.ColumnSeries.new(root, {
            name: "Series 1",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "total",
            sequencedInterpolation: true,
            categoryXField: "fiscal_year",
            tooltip: am5.Tooltip.new(root, {
              labelText: "{valueY}"
            })
          }));

          series.columns.template.setAll({
            cornerRadiusTL: 5,
            cornerRadiusTR: 5
          });
          series.columns.template.adapters.add("fill", function(fill, target) {
            return chart.get("colors").getIndex(series.columns.indexOf(target));
          });

          series.columns.template.adapters.add("stroke", function(stroke, target) {
            return chart.get("colors").getIndex(series.columns.indexOf(target));
          });


          // Set data
          var data = {!! $project_groupby_fiscal_years !!}

          xAxis.data.setAll(data);
          series.data.setAll(data);


          // Make stuff animate on load
          // https://www.amcharts.com/docs/v5/concepts/animations/
          series.appear(1000);
          chart.appear(1000, 100);

        }); // end am5.ready()
      </script>


      <script>
        am5.ready(function() {

          // Create root element
          // https://www.amcharts.com/docs/v5/getting-started/#Root_element
          var root = am5.Root.new("chart-contract-div");
          root._logo.dispose();


          // Set themes
          // https://www.amcharts.com/docs/v5/concepts/themes/
          root.setThemes([
            am5themes_Animated.new(root)
          ]);


          // Create chart
          // https://www.amcharts.com/docs/v5/charts/xy-chart/
          var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX: true
          }));

          // Add cursor
          // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
          var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
          cursor.lineY.set("visible", false);


          // Create axes
          // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
          var xRenderer = am5xy.AxisRendererX.new(root, {
            minGridDistance: 30
          });
          xRenderer.labels.template.setAll({
            rotation: -90,
            centerY: am5.p50,
            centerX: am5.p100,
            paddingRight: 15
          });

          var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
            maxDeviation: 0.3,
            categoryField: "fiscal_year",
            renderer: xRenderer,
            tooltip: am5.Tooltip.new(root, {})
          }));

          var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            maxDeviation: 0.3,
            renderer: am5xy.AxisRendererY.new(root, {})
          }));


          // Create series
          // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
          var series = chart.series.push(am5xy.ColumnSeries.new(root, {
            name: "Series 1",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "total",
            sequencedInterpolation: true,
            categoryXField: "fiscal_year",
            tooltip: am5.Tooltip.new(root, {
              labelText: "{valueY}"
            })
          }));

          series.columns.template.setAll({
            cornerRadiusTL: 5,
            cornerRadiusTR: 5
          });
          series.columns.template.adapters.add("fill", function(fill, target) {
            return chart.get("colors").getIndex(series.columns.indexOf(target));
          });

          series.columns.template.adapters.add("stroke", function(stroke, target) {
            return chart.get("colors").getIndex(series.columns.indexOf(target));
          });


          // Set data
          var data = {!! $contract_groupby_fiscal_years !!}

          xAxis.data.setAll(data);
          series.data.setAll(data);


          // Make stuff animate on load
          // https://www.amcharts.com/docs/v5/concepts/animations/
          series.appear(1000);
          chart.appear(1000, 100);

        }); // end am5.ready()
      </script>


  <script>
      am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chart-task-div");
        root._logo.dispose();


        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
          am5themes_Animated.new(root)
        ]);


        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
          panX: true,
          panY: true,
          wheelX: "panX",
          wheelY: "zoomX",
          pinchZoomX: true
        }));

        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
        cursor.lineY.set("visible", false);


        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xRenderer = am5xy.AxisRendererX.new(root, {
          minGridDistance: 30
        });
        xRenderer.labels.template.setAll({
          rotation: -90,
          centerY: am5.p50,
          centerX: am5.p100,
          paddingRight: 15
        });

        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
          maxDeviation: 0.3,
          categoryField: "fiscal_year",
          renderer: xRenderer,
          tooltip: am5.Tooltip.new(root, {})
        }));

        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
          maxDeviation: 0.3,
          renderer: am5xy.AxisRendererY.new(root, {})
        }));


        // Create series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
          name: "Series1",
          xAxis: xAxis,
          yAxis: yAxis,
          valueYField: "total",
          sequencedInterpolation: true,
          categoryXField: "fiscal_year",
          tooltip: am5.Tooltip.new(root, {
            labelText: "{valueY}"
          })
        }));

        series.columns.template.setAll({
          cornerRadiusTL: 5,
          cornerRadiusTR: 5
        });
        series.columns.template.adapters.add("fill", function(fill, target) {
          return chart.get("colors").getIndex(series.columns.indexOf(target));
        });

        series.columns.template.adapters.add("stroke", function(stroke, target) {
          return chart.get("colors").getIndex(series.columns.indexOf(target));
        });


        // Set data $project_groupby_reguiar   project_groupby_fiscal_years
        var data =  [{"fiscal_year":1,"total":50000.00},
        {"fiscal_year":2,"total":4200000.00},
        {"fiscal_year":3,"total":8770000.00},
        {"fiscal_year":4,"total":27085828.00},
        {"fiscal_year":5,"total":26500000.00},
        {"fiscal_year":6,"total":25000000.00},
        {"fiscal_year":7,"total":10500000.00},
        {"fiscal_year":8,"total":0.00},
        {"fiscal_year":9,"total":275000.00},
        {"fiscal_year":10,"total":275000.00},
        {"fiscal_year":11,"total":4476000.00}
        ,{"fiscal_year":12,"total":3000000.00}]

        xAxis.data.setAll(data);
        series.data.setAll(data);


        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear(1000);
        chart.appear(1000, 100);

      }); // end am5.ready()
    </script>

<script>
    am5.ready(function() {

      // Create root element
      // https://www.amcharts.com/docs/v5/getting-started/#Root_element
      var root = am5.Root.new("chart-d-div");
      root._logo.dispose();


      // Set themes
      // https://www.amcharts.com/docs/v5/concepts/themes/
      root.setThemes([
        am5themes_Animated.new(root)
      ]);


      // Create chart
      // https://www.amcharts.com/docs/v5/charts/xy-chart/
      var chart = root.container.children.push(am5xy.XYChart.new(root, {
        panX: true,
        panY: true,
        wheelX: "panX",
        wheelY: "zoomX",
        pinchZoomX: true
      }));

      // Add cursor
      // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
      var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
      cursor.lineY.set("visible", false);


      // Create axes
      // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
      var xRenderer = am5xy.AxisRendererX.new(root, {
        minGridDistance: 30
      });
      xRenderer.labels.template.setAll({
        rotation: -90,
        centerY: am5.p50,
        centerX: am5.p100,
        paddingRight: 15
      });

      var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
        maxDeviation: 0.3,
        categoryField: "fiscal_year",
        renderer: xRenderer,
        tooltip: am5.Tooltip.new(root, {})
      }));

      var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        maxDeviation: 0.3,
        renderer: am5xy.AxisRendererY.new(root, {})
      }));


      // Create series
      // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
      var series = chart.series.push(am5xy.ColumnSeries.new(root, {
        name: "Series1",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "total",
        sequencedInterpolation: true,
        categoryXField: "fiscal_year",
        tooltip: am5.Tooltip.new(root, {
          labelText: "{valueY}"
        })
      }));

      series.columns.template.setAll({
        cornerRadiusTL: 5,
        cornerRadiusTR: 5
      });
      series.columns.template.adapters.add("fill", function(fill, target) {
        return chart.get("colors").getIndex(series.columns.indexOf(target));
      });

      series.columns.template.adapters.add("stroke", function(stroke, target) {
        return chart.get("colors").getIndex(series.columns.indexOf(target));
      });


      // Set data $project_groupby_reguiar   project_groupby_fiscal_years
      var data =  [{"fiscal_year":1,"total":0.00},
        {"fiscal_year":2,"total":0.00},
        {"fiscal_year":3,"total":0.00},
        {"fiscal_year":4,"total":11433592.00},
        {"fiscal_year":5,"total":0.00},
        {"fiscal_year":6,"total":10250000.00},
        {"fiscal_year":7,"total":0.00},
        {"fiscal_year":8,"total":0.00},
        {"fiscal_year":9,"total":0.00},
        {"fiscal_year":10,"total":0.00},
        {"fiscal_year":11,"total":0.00}
        ,{"fiscal_year":12,"total":0.00}]
      xAxis.data.setAll(data);
      series.data.setAll(data);


      // Make stuff animate on load
      // https://www.amcharts.com/docs/v5/concepts/animations/
      series.appear(1000);
      chart.appear(1000, 100);

    }); // end am5.ready()
  </script>


<script>
    am5.ready(function() {

      // Create root element
      // https://www.amcharts.com/docs/v5/getting-started/#Root_element
      var root = am5.Root.new("chart-d-div");
      root._logo.dispose();


      // Set themes
      // https://www.amcharts.com/docs/v5/concepts/themes/
      root.setThemes([
        am5themes_Animated.new(root)
      ]);


      // Create chart
      // https://www.amcharts.com/docs/v5/charts/xy-chart/
      var chart = root.container.children.push(am5xy.XYChart.new(root, {
        panX: true,
        panY: true,
        wheelX: "panX",
        wheelY: "zoomX",
        pinchZoomX: true
      }));

      // Add cursor
      // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
      var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
      cursor.lineY.set("visible", false);


      // Create axes
      // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
      var xRenderer = am5xy.AxisRendererX.new(root, {
        minGridDistance: 30
      });
      xRenderer.labels.template.setAll({
        rotation: -90,
        centerY: am5.p50,
        centerX: am5.p100,
        paddingRight: 15
      });

      var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
        maxDeviation: 0.3,
        categoryField: "fiscal_year",
        renderer: xRenderer,
        tooltip: am5.Tooltip.new(root, {})
      }));

      var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        maxDeviation: 0.3,
        renderer: am5xy.AxisRendererY.new(root, {})
      }));


      // Create series
      // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
      var series = chart.series.push(am5xy.ColumnSeries.new(root, {
        name: "Series1",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "total",
        sequencedInterpolation: true,
        categoryXField: "fiscal_year",
        tooltip: am5.Tooltip.new(root, {
          labelText: "{valueY}"
        })
      }));

      series.columns.template.setAll({
        cornerRadiusTL: 5,
        cornerRadiusTR: 5
      });
      series.columns.template.adapters.add("fill", function(fill, target) {
        return chart.get("colors").getIndex(series.columns.indexOf(target));
      });

      series.columns.template.adapters.add("stroke", function(stroke, target) {
        return chart.get("colors").getIndex(series.columns.indexOf(target));
      });


      // Set data $project_groupby_reguiar   project_groupby_fiscal_years
      var data =  [!! $taskcosttotal !!]

      xAxis.data.setAll(data);
      series.data.setAll(data);


      // Make stuff animate on load
      // https://www.amcharts.com/docs/v5/concepts/animations/
      series.appear(1000);
      chart.appear(1000, 100);

    }); // end am5.ready()
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
          columns: [{
              name: "",
              width: 60,
              resize: false,
              template: function(task) {
                return "<span class='gantt_grid_wbs'>" + gantt.getWBSCode(task) + "</span>"
              }
            },



            {
              name: "text",
              width: 50,
              label: "ปี",
              template: function(task) {
                  if (task.project_fiscal_year) {
                  return new Intl.NumberFormat (
                      'th-TH', {

                    useGrouping: false
                  }
                  ).format(task.project_fiscal_year);
                } else {
                  return '';
                }

              }
            },
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
              width: 100,
              label: "งบประมาณ",
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
              width: 100,
              label: "ใช้จ่ายแล้ว",
              template: function(task) {
                //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                if (task.cost) {
                  return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                  }).format(task.cost) + '</span>';
                } else {
                  return '';
                }
              }
            },
            {
              name: "balance",
              width: 100,
              label: "คงเหลือ",
              template: function(task) {
                //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                if (task.balance) {
                  var tmp_class = task.balance > 0 ? 'green' : 'red';
                  return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                  }).format(task.balance) + '</span>';
                } else {
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
            html += '<tr class="text-end">\
                                      <td>' + budget_gov_operating + '</td>\
                                      <td>' + budget_gov_investment + '</td>\
                                      <td>' + budget_gov_utility + '</td>\
                                      <td>' + budget_it_operating + '</td>\
                                      <td>' + budget_it_investment + '</td>\
                                      <td class="text-success">' + budget + '</td>\
                                    </tr>';
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
                  width: 500,
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
                  width: 300,
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
