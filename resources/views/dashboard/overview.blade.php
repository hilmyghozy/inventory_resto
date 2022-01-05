@extends('dashboard.layout')

@section('page title','Dashboard')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body mt-2">
                            <p class="col-md-12 d-none" id="nama_nama" value="">{{implode("-",$data1)}}</p>
                            <p class="col-md-12 d-none" id="total_total" value="">{{implode("-",$data2)}}</p>
                            <form action="">
                            <div class="col-md-12 row">
                                <div class="col-md-3">
                                    <label for="validationDefault01">Date From</label>
                                    <input type="date" class="form-control" id="validationDefault01" name="from" value="{{$from!= null ? $from : date('2021-05-01')}}" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="validationDefault02">Date To</label>
                                    <input type="date" class="form-control" id="validationDefault02" name="to" value="{{$to!= null ? $to :date('Y-m-d')}}" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="validationDefault03">Group By</label>
                                    <select name="group_by" id="validationDefault03" class="form-control">
                                        <option value="store" {{$group_by == 'store' ? 'selected' : null}} >Store</option>
                                        <option value="item" {{$group_by == 'item' ? 'selected' : null}}>Product Item</option>
                                    </select>
                                </div>
                                <div class="col-md-3 text-right">
                                    <button id="btn-search" class="btn btn-primary col-md-6" style="height: 40px;margin-top:28px">Search &nbsp; &nbsp; <i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            </form>
                            <div class="col-md-10 row">
                                <div class="col-md-5 mt-5 mx-auto">
                                    <canvas id="chart-area" width="100" height="100"></canvas>
                                </div>

                                <div class="col-md-5 mt-5 mx-auto">
                                    <canvas id="chart-line" width="200" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const loading = '<i class="fas fa-spinner fa-pulse"></i>';

        let iStartDate = moment().subtract(7,'days').format('YYYY-MM-DD');
        let iEndDate = moment().add(7,'days').format('YYYY-MM-DD');
        const iRange = $('#dateRange');
        iRange.daterangepicker({
            startDate: moment().subtract(7,'days').format('DD-MM-YYYY'),
            endDate: moment().add(7,'days').format('DD-MM-YYYY'),
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
        iRange.on('apply.daterangepicker', function(ev, picker) {
            iStartDate = picker.startDate.format('YYYY-MM-DD');
            iEndDate = picker.endDate.format('YYYY-MM-DD');
            reloadChart(iStartDate, iEndDate);
        });

        function reloadChart(startDate,endDate) {
            $.ajax({
                url: '{{ url('overview/list') }}',
                method: 'post',
                data: {
                    start_date: startDate,
                    end_date: endDate
                },
                success: function (response) {
                    // console.log(response);
                    let data = JSON.parse(response);
                    spChart.updateSeries([{
                        data: data.sales_prospect
                    }]);

                    grChart.updateSeries([{
                        data: data.booking_gr
                    }]);

                    bpChart.updateSeries([{
                        data: data.bp_estimation
                    }]);
                }
            })
        }

        $(document).ready(function () {
            // reloadChart(iStartDate, iEndDate);
        })
    </script>

<script>
// $(document).on("click","#btn-search",function(){
    var nama_nama = $('#nama_nama').text();
    var total_total = $('#total_total').text();
    var ar_nama = nama_nama.split("-");
    var ar_total = total_total.split("-");
    console.log(ar_nama)
    console.log(ar_total)
    var from = $('#validationDefault01').val();
    var to = $('#validationDefault02').val();
    var group_by = $('#validationDefault03').val();

    
    window.chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)',
        pink : '#eca3f5',
        brown : '#433520',
        cream : '#fde8cd'
    };
    var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
    };

    var config = [];
    var config2 = [];

    

    // $.each(datanama, function(i) {
    //     console.log(datanama[i]);
    // });

    

    config = {
        type: 'pie',
        data: {
            datasets: [{
                data: ar_total,
                backgroundColor: [
                    window.chartColors.red,
                    window.chartColors.orange,
                    window.chartColors.yellow,
                    window.chartColors.green,
                    window.chartColors.blue,
                    window.chartColors.purple,
                    window.chartColors.grey,
                    window.chartColors.pink,
                    window.chartColors.brown,
                    window.chartColors.cream
                ],
                label: 'Dataset 1'
            }],
            labels: ar_nama
        },
        options: {
            responsive: true
        }
    };

    console.log(config)

    config2 = {
        type: 'bar',
        data: {
            datasets: [{
                data: ar_total,
                backgroundColor: [
                    window.chartColors.red,
                    window.chartColors.orange,
                    window.chartColors.yellow,
                    window.chartColors.green,
                    window.chartColors.blue,
                    window.chartColors.purple,
                    window.chartColors.grey,
                    window.chartColors.pink,
                    window.chartColors.brown,
                    window.chartColors.cream
                ],
                label: 'Total Penjualan'
            }],
            labels: ar_nama
        },
        options: {
            responsive: true
        }
    };

    window.onload = function() {
        var ctx = document.getElementById('chart-area').getContext('2d');
        var ctx2 = document.getElementById('chart-line').getContext('2d');
        window.myPie = new Chart(ctx, config);
        window.myPie = new Chart(ctx2, config2);
    };

    

    // var colorNames = Object.keys(window.chartColors);
    // document.getElementById('addDataset').addEventListener('click', function() {
    //     var newDataset = {
    //         backgroundColor: [],
    //         data: [],
    //         label: 'New dataset ' + config.data.datasets.length,
    //     };

    //     for (var index = 0; index < config.data.labels.length; ++index) {
    //         newDataset.data.push(randomScalingFactor());

    //         var colorName = colorNames[index % colorNames.length];
    //         var newColor = window.chartColors[colorName];
    //         newDataset.backgroundColor.push(newColor);
    //     }

    //     config.data.datasets.push(newDataset);
    //     window.myPie.update();
    // });
// });

</script>
@endsection
