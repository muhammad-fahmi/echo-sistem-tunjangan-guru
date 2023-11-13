<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
  <div class="col-md-5 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Dashboard</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Home</a>
      </li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </div>
  <div class="col-md-7 col-12 align-self-center d-none d-md-block">
    <div class="d-flex mt-2 justify-content-end">
      <!-- <div class="d-flex me-3 ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>THIS MONTH</small></h6>
                    <h4 class="mt-0 text-info">$58,356</h4>
                </div>
                <div class="spark-chart">
                    <div id="monthchart"></div>
                </div>
            </div>
            <div class="d-flex ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>LAST MONTH</small></h6>
                    <h4 class="mt-0 text-primary">$48,356</h4>
                </div>
                <div class="spark-chart">
                    <div id="lastmonthchart"></div>
                </div>
            </div> -->
    </div>
  </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
  <!-- Row -->
  <div class="row">
    <!-- Column -->

    <div class="col-12 col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="d-flex flex-wrap">
                <div>
                  <h3 class="card-title">Overview Charts</h3>
                </div>
                <div class="ms-auto">
                  <ul class="list-inline">

                    <!-- <li class="list-inline-item px-2">
                      <h6 class="text-success">
                        <i class="fa fa-circle font-10 me-2"></i>Ample
                      </h6>
                    </li>

                    <li class="list-inline-item px-2">
                      <h6 class="text-info">
                        <i class="fa fa-circle font-10 me-2"></i>Pixel
                      </h6>
                    </li> -->

                  </ul>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card">
                <div class="border-bottom title-part-padding">
                  <h4 class="card-title mb-0">IKU</h4>
                </div>
                <div class="card-body">
                  <div id="barChartIKU"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="d-flex flex-wrap">
                <div>
                  <h3 class="card-title">Overview Charts</h3>
                </div>
                <div class="ms-auto">
                  <ul class="list-inline">

                    <!-- <li class="list-inline-item px-2">
                      <h6 class="text-success">
                        <i class="fa fa-circle font-10 me-2"></i>Ample
                      </h6>
                    </li>

                    <li class="list-inline-item px-2">
                      <h6 class="text-info">
                        <i class="fa fa-circle font-10 me-2"></i>Pixel
                      </h6>
                    </li> -->

                  </ul>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card">
                <div class="border-bottom title-part-padding">
                  <h4 class="card-title mb-0">Realisasi</h4>
                </div>
                <div class="card-body">
                  <div id="colChartRealisasi"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- Row -->

</div>

<script>
  var options = {
    series: [{
      data: [1.2, 70, 85, 77, 99.50, 95]
    }],
    chart: {
      type: 'bar',
      height: 350
    },
    animations: {
      // Enable animation on initial load
      enabled: true,
      // Choose the easing function for the animation (optional)
      easing: 'easeinout',
      // Set the speed of the animation in milliseconds (optional)
      speed: 500, // 1 second
      // Animate the data series on initial load (optional)
      animateGradually: {
        enabled: true,
        delay: 250, // Delay between each data series animation
      },
    },
    plotOptions: {
      bar: {
        borderRadius: 4,
        horizontal: true,
      }
    },
    dataLabels: {
      enabled: false
    },
    xaxis: {
      categories: ['Indeks Pencemaran', 'Perlindungan dan Pengelolaan Lingkungan Hidup (Rasio)', 'Ruang terbuka hijau publik yang dikelola (%)', 'Sampah yang terkelola (%)', 'Ketaatan Usaha/Kegiatan dalam pengelolaan limbah B3 (%)', 'Nilai LKJiP (%)'],
    }
  };

  var chart = new ApexCharts(document.querySelector("#barChartIKU"), options);
  // chart.render();

  function formatRupiah(number) {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0 // You can change this to specify the number of decimal places
    }).format(number);
  }

  var options2 = {
    series: [{
      name: 'Pagu',
      data: [1250, 558, 995, 852, 4200, 850, 788, 5000, 425, 899, 3205, 1073]
    }, {
      name: 'Realisasi',
      data: [850, 500, 795, 830, 1280, 800, 700, 1206, 420, 809, 1200, 1000]
    }, ],
    chart: {
      type: 'bar',
      height: 350
    },
    animations: {
      // Enable animation on initial load
      enabled: true,
      // Choose the easing function for the animation (optional)
      easing: 'easeinout',
      // Set the speed of the animation in milliseconds (optional)
      speed: 500, // 1 second
      // Animate the data series on initial load (optional)
      animateGradually: {
        enabled: true,
        delay: 250, // Delay between each data series animation
      },
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '55%',
        endingShape: 'rounded'
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
    },
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
    },
    yaxis: {
      title: {
        text: 'Rp (Juta)'
      }
    },
    fill: {
      opacity: 1
    },
    tooltip: {
      y: {
        formatter: function(val) {
          return "" + formatRupiah(val) + " Juta"
        }
      }
    }
  };

  var chart2 = new ApexCharts(document.querySelector("#colChartRealisasi"), options2);
  // chart2.render();

  setTimeout(() => {
    chart.render();
    chart2.render();
  }, 250);
</script>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->