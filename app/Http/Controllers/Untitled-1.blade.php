
        <!-- xy2 -->
        <!-- Chart code -->
        <script>
            am5.ready(function() {
                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("chart-totalbot2-div");
                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);
                // Create chart
                // https://www.amcharts.com/docs/v5/charts/xy-chart/
                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: false,
                    panY: false,
                    wheelX: "panX",
                    wheelY: "zoomX",
                    layout: root.verticalLayout
                }));
                // Add legend
                // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
                var legend = chart.children.push(
                    am5.Legend.new(root, {
                        centerX: am5.p50,
                        x: am5.p50
                    })
                );
                var data = {!! $chart_data_xy !!}

              //  var data1 = {!! $taskcosttotals !!}
              //  var date2 = {!! $taskcosttotals2_json !!}
                //var date3 = {!! $taskconcosttotals !!}
                // Create axes
                // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                var xRenderer = am5xy.AxisRendererX.new(root, {
                    cellStartLocation: 0.1,
                    cellEndLocation: 0.9,
                    minGridDistance: 10
                });
                xRenderer.grid.template.set("location", 0.5);
                xRenderer.labels.template.setAll({
                    location: 0.5,
                    multiLocation: 0.5
                });
                var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                    categoryField: "task_pay_month",

                    renderer: xRenderer,
                    tooltip: am5.Tooltip.new(root, {}),
                }));
                xRenderer.grid.template.setAll({
                    location: 1
                })
                xAxis.data.setAll(data);
                var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    renderer: am5xy.AxisRendererY.new(root, {
                        strokeOpacity: 0.1,

                    })
                }));

//eee

                // Add series
                // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                function makeSeries(name, fieldName) {
                    var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                        name: name,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: fieldName,
                        categoryXField: "task_pay_month",
                    }));
                    series.columns.template.setAll({
                        tooltipText: "[bold]{name}[/]\n {categoryX}[/]\n:{valueY}",
                        width: am5.percent(100),
                        stacked: true,

                    });

                    let yRenderer = yAxis.get("renderer");
yRenderer.ticks.template.setAll({
  minPosition: 0.0,
  maxPosition: 1.1,
  visible: true
});
yRenderer.labels.template.setAll({
  minPosition: 0.0,
  maxPosition: 1.1
});

                    series.data.setAll(data);
                    // Make stuff animate on load
                    // https://www.amcharts.com/docs/v5/concepts/animations/
                    series.appear();
                    series.bullets.push(function() {
                        return am5.Bullet.new(root, {
                            locationY: 1 ,
                            sprite: am5.Label.new(root, {
                                text: "{valueY}",
                                populateText: true,
                               // fill: root.interfaceColors.get("alternativeText"),
                                centerY: 0,
                                centerX: am5.p50,
                                populateText: true
                            })
                        });
                    });
                    legend.data.push(series);
                };
                //  makeSeries("การใช้จ่ายประมาณ", "total_cost");
              makeSeries("ค่าใช้จ่ายเดือน", "total_cost");

            }); // end am5.ready()
        </script>







                <script>
                /**
                 * ---------------------------------------
                 * This demo was created using amCharts 5.
                 *
                 * For more information visit:
                 * https://www.amcharts.com/
                 *
                 * Documentation is available at:
                 * https://www.amcharts.com/docs/v5/
                 * ---------------------------------------
                 */

                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("");

                // Set themes
                    // https://www.amcharts.com/docs/v5/concepts/themes/
                    root.setThemes([
                        am5themes_Animated.new(root)
                    ]);

                    // Create chart
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
                    var chart = root.container.children.push(am5percent.PieChart.new(root, {

                    }));

                    // Create series
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
                    var series = chart.series.push(am5percent.PieSeries.new(root, {


                        valueField: "value"
                    }));





                    // Set up adapters for variable slice radius
                    // https://www.amcharts.com/docs/v5/concepts/settings/adapters/

                    // Set data
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
                    series.data.setAll([{
                    value: {{ $budgets-($otpsa1 + $otpsa2+$itpsa1 + $itpsa2+$utsc_pay_pa+$utsc_pay) }},
                    category: "คงเหลือ:" + {{ number_format(($budgets-($otpsa1 + $otpsa2+$itpsa1 + $itpsa2+$utsc_pay_pa+$utsc_pay) ) / $budgets * 100, 4) }} + "%"
                },
                {
                    value: {{($otpsa1 + $otpsa2+$itpsa1 + $itpsa2+$utsc_pay_pa+$utsc_pay) }},
                    category: "เบิกจ่ายทั้งหมด :" + {{ number_format(($otpsa1 + $otpsa2+$itpsa1 + $itpsa2+$utsc_pay_pa+$utsc_pay) / $budgets * 100, 4) }} + "%" + "\nงบกลาง ICT :" + {{ number_format(($otpsa1 + $otpsa2) / $budgets * 100, 4) }} + "%" + "\nงบดำเนินงาน :" + {{ number_format(($itpsa1 + $itpsa2) / $budgets * 100, 4) }} + "%" + "\nงบสาธารณูปโภค :" + {{ number_format(($utsc_pay_pa+$utsc_pay) / $budgets * 100, 4) }} + "%"
                }]);

                series.labels.template.setAll({
                text: "{category}",
                textType: "circular",
                inside: true,
                radius: 10
                });

                    // Create legend
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/



                    legend.data.setAll(series.dataItems);

                    // Play initial series animation
                    // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
                    series.appear(1000, 100);

                // end am5.ready()

                </script>


                <script>
                /**
                 * ---------------------------------------
                 * This demo was created using amCharts 5.
                 *
                 * For more information visit:
                 * https://www.amcharts.com/
                 *
                 * Documentation is available at:
                 * https://www.amcharts.com/docs/v5/
                 * ---------------------------------------
                 */

                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("");

                // Set themes
                    // https://www.amcharts.com/docs/v5/concepts/themes/
                    root.setThemes([
                        am5themes_Animated.new(root)
                    ]);

                    // Create chart
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
                    var chart = root.container.children.push(am5percent.PieChart.new(root, {
                        layout: root.verticalLayout
                    }));

                    // Create series
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
                    var series = chart.series.push(am5percent.PieSeries.new(root, {


                        valueField: "value",
                        categoryField: "category"
                    }));





                    // Set up adapters for variable slice radius
                    // https://www.amcharts.com/docs/v5/concepts/settings/adapters/

                    // Set data
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
                    series.data.setAll([{
                value: {{ $budgetscentralict-($otpsa1 + $otpsa2) }},
                category: "คงเหลือ"
                }, {
                value: {{($otpsa1 + $otpsa2) }},
                category: "เบิกจ่ายทั้งหมด"
                }
                ]);
                series.slices.template.setAll({
                fillOpacity: 0.5,
                fill: am5.color(0xf60b0b),
                strokeWidth: 2
                });
                    // Create legend
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
                    var legend = chart.children.push(am5.Legend.new(root, {
                        centerX: am5.p50,
                        x: am5.p50,
                        marginTop: 15,
                        marginBottom: 15
                    }));

                    legend.data.setAll(series.dataItems);

                    // Play initial series animation
                    // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
                    series.appear(1000, 100);

                // end am5.ready()

                </script>

                <script>
                    // Create root element
                    var root = am5.Root.new("");

                // Set themes
                    // https://www.amcharts.com/docs/v5/concepts/themes/
                    root.setThemes([
                        am5themes_Animated.new(root)
                    ]);

                    // Create chart
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
                    var chart = root.container.children.push(am5percent.PieChart.new(root, {
                        layout: root.verticalLayout
                    }));

                    // Create series
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
                    var series = chart.series.push(am5percent.PieSeries.new(root, {


                        valueField: "value",
                        categoryField: "category"
                    }));





                    // Set up adapters for variable slice radius
                    // https://www.amcharts.com/docs/v5/concepts/settings/adapters/

                    // Set data
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
                    series.data.setAll([{
                value: {{ $budgetsinvestment-($itpsa1 + $itpsa2) }},
                category: "คงเหลือ"
                }, {
                value: {{($itpsa1 + $itpsa2) }},
                category: "เบิกจ่ายทั้งหมด"
                }
                ]);



                    // Create legend
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
                    var legend = chart.children.push(am5.Legend.new(root, {
                        centerX: am5.p50,
                        x: am5.p50,
                        marginTop: 15,
                        marginBottom: 15,

                    }));

                    legend.data.setAll(series.dataItems);

                    // Play initial series animation
                    // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
                    series.appear(1000, 100);

                // end am5.ready()
                </script>



                <script>
                /**
                 * ---------------------------------------
                 * This demo was created using amCharts 5.
                 *
                 * For more information visit:
                 * https://www.amcharts.com/
                 *
                 * Documentation is available at:
                 * https://www.amcharts.com/docs/v5/
                 * ---------------------------------------
                 */

                // Create root and chart
                var root = am5.Root.new("");
                pieSeries.slices.template.fill = am5core.color("green");
                // Set themes
                    // https://www.amcharts.com/docs/v5/concepts/themes/
                    root.setThemes([
                        am5themes_Animated.new(root)
                    ]);

                    // Create chart
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
                    var chart = root.container.children.push(am5percent.PieChart.new(root, {
                        layout: root.verticalLayout
                    }));

                    // Create series
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
                    var series = chart.series.push(am5percent.PieSeries.new(root, {


                        valueField: "value",
                        categoryField: "category"
                    }));





                    // Set up adapters for variable slice radius
                    // https://www.amcharts.com/docs/v5/concepts/settings/adapters/

                    // Set data
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
                    series.data.setAll([{
                value: {{ $budgetsut-($utsc_pay_pa+$utsc_pay) }},
                category: "คงเหลือ",
                color: am5core.color("green")
                }, {
                value: {{($utsc_pay_pa+$utsc_pay) }},
                category: "เบิกจ่ายทั้งหมด"
                }
                ]);

                    // Create legend
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
                    var legend = chart.children.push(am5.Legend.new(root, {
                        centerX: am5.p50,
                        x: am5.p50,
                        marginTop: 15,
                        marginBottom: 15
                    }));

                    legend.data.setAll(series.dataItems);

                    // Play initial series animation
                    // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
                    series.appear(1000, 100);

                // end am5.ready()



                </script>

                <script>

                    /**
                     * ---------------------------------------
                     * This demo was created using amCharts 4.
                     *
                     * For more information visit:
                     * https://www.amcharts.com/
                     *
                     * Documentation is available at:
                     * https://www.amcharts.com/docs/v4/
                     * ---------------------------------------
                     */

                    // Create chart instance
                    var chart = am4core.create("c1", am4charts.PieChart);

                    // Add data
                    chart.data = [{
                    "country": "คงเหลือ",
                    "litres":  {{ $budgets-($otpsa1 + $otpsa2+$itpsa1 + $itpsa2+$utsc_pay_pa+$utsc_pay)}},
                    "color": am4core.color("#198754")
                    }, {
                    "country": " :เบิกจ่ายทั้งหมด"  + "\n"+{{ number_format(($otpsa1 + $otpsa2) / $budgets * 100, 4) }} + "%"+" :งบกลาง ICT :"  + "\n" + {{ number_format(($itpsa1 + $itpsa2) / $budgets * 100, 4) }} + "%" + " :งบดำเนินงาน" + "\n" + {{ number_format(($utsc_pay_pa+$utsc_pay) / $budgets * 100, 4) }} + "%" +"  :งบสาธารณูปโภค",



                    "litres":  {{($otpsa1 + $otpsa2+$itpsa1 + $itpsa2+$utsc_pay_pa+$utsc_pay) }},
                    "color": am4core.color("#0d6efd")
                    }, ];

                    // Add and configure Series
                    var pieSeries = chart.series.push(new am4charts.PieSeries());
                    pieSeries.dataFields.value = "litres";
                    pieSeries.dataFields.category = "country";
                    pieSeries.slices.template.propertyFields.fill = "color";

                    pieSeries.labels.template.text = "{value.percent.formatNumber('#.00')}% {category}";
                    </script>




                <script>

                /**
                 * ---------------------------------------
                 * This demo was created using amCharts 4.
                 *
                 * For more information visit:
                 * https://www.amcharts.com/
                 *
                 * Documentation is available at:
                 * https://www.amcharts.com/docs/v4/
                 * ---------------------------------------
                 */

                // Create chart instance
                var chart = am4core.create("c2", am4charts.PieChart);

                // Add data
                chart.data = [{
                "country": "คงเหลือ",
                "litres":  {{ $budgetscentralict-($otpsa1 + $otpsa2) }},
                "color": am4core.color("#198754")
                }, {
                "country": "เบิกจ่ายทั้งหมด",
                "litres":  {{($otpsa1 + $otpsa2) }},
                "color": am4core.color("#0d6efd")
                }, ];

                // Add and configure Series
                var pieSeries = chart.series.push(new am4charts.PieSeries());
                pieSeries.dataFields.value = "litres";
                pieSeries.dataFields.category = "country";
                pieSeries.slices.template.propertyFields.fill = "color";
                pieSeries.labels.template.text = "{value.percent.formatNumber('#.00')}% {category}";
                //chart.legend = new am4charts.Legend();
                </script>

                <script>

                    /**
                     * ---------------------------------------
                     * This demo was created using amCharts 4.
                     *
                     * For more information visit:
                     * https://www.amcharts.com/
                     *
                     * Documentation is available at:
                     * https://www.amcharts.com/docs/v4/
                     * ---------------------------------------
                     */

                    // Create chart instance
                    var chart = am4core.create("c3", am4charts.PieChart);

                    // Add data
                    chart.data = [{
                    "country": "คงเหลือ",
                    "litres":  {{ $budgetsinvestment-($itpsa1 + $itpsa2) }},
                    "color": am4core.color("#198754")
                    }, {
                    "country": "เบิกจ่ายทั้งหมด",
                    "litres":  {{($itpsa1 + $itpsa2) }},
                    "color": am4core.color("#0d6efd")
                    }, ];

                    // Add and configure Series
                    var pieSeries = chart.series.push(new am4charts.PieSeries());
                    pieSeries.dataFields.value = "litres";
                    pieSeries.dataFields.category = "country";
                    pieSeries.slices.template.propertyFields.fill = "color";
                    pieSeries.labels.template.text = "{value.percent.formatNumber('#.00')}% {category}";
                //  chart.legend = new am4charts.Legend();
                    </script>


                <script>

                    /**
                     * ---------------------------------------
                     * This demo was created using amCharts 4.
                     *
                     * For more information visit:
                     * https://www.amcharts.com/
                     *
                     * Documentation is available at:
                     * https://www.amcharts.com/docs/v4/
                     * ---------------------------------------
                     */

                    // Create chart instance
                    var chart = am4core.create("c4", am4charts.PieChart);

                    // Add data
                    chart.data = [{
                    "country": "คงเหลือ",
                    "litres":  {{ $budgetsut-($utsc_pay_pa+$utsc_pay) }},

                    "color": am4core.color("#198754")
                    }, {
                    "country": "เบิกจ่ายทั้งหมด",
                    "litres":  {{($utsc_pay_pa+$utsc_pay) }},
                    "color": am4core.color("#0d6efd")
                    }, ];

                    // Add and configure Series
                    var pieSeries = chart.series.push(new am4charts.PieSeries());
                    pieSeries.dataFields.value = "litres";
                    pieSeries.dataFields.category = "country";
                    pieSeries.slices.template.propertyFields.fill = "color";
                    pieSeries.labels.template.text = "{value.percent.formatNumber('#.00')}% {category}";
                // chart.legend = new am4charts.Legend();
                    </script>
