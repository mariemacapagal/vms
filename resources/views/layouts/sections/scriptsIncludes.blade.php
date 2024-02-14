<!-- laravel style -->
<script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ asset('assets/js/config.js') }}"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  var data = @json($data);
  var labels = data.map(item => item.visit_purpose);
  var counts = data.map(item => item.count);

  var ctx = document.getElementById('purposeChart').getContext('2d');
  var purposeChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
          labels: labels,
          datasets: [{
              data: counts,
              backgroundColor: [
                  '#ddf1e1', //amenities
                  '#fff2d6', //delivery
                  '#e1e8f8', //services
                  '#f9dfe1' //visiting
              ],
              borderColor: [
                  '#38ad52',
                  '#ffab00',
                  '#5b83da',
                  '#dc3545'
              ],
              borderWidth: 1
          }]
      },
      options: {
          responsive: true
      }
  });
</script>
