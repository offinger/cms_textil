<link rel="stylesheet" type="text/css" href="/css/charts.css">

<?php $this->pageTitle = Yii::app()->name; ?>
<div class="jumbotron">


    <div class="container">
</div>
<a href="http://cms.local/" target="_blank"><button type="button" class="btn btn-info">Početna</button></a>
<a href="/proizvodi/admin"><button type="button" class="btn btn-default btn-circle btn-xxl">Proizvodi</button></a>
<a href="/modeli/admin"><button type="button" class="btn btn-primary btn-circle btn-xl">Modeli</button></a>
<a href="logout" target="_blank"><button type="button" class="btn btn-danger">Odjava</button></a>

</div>
<div id="panel-stats">
<legend> Statistika: </legend>
        <span class="label label-default">Broj proizvoda: <?php echo $brojProizvoda; ?></span>
        <span class="label label-primary">Broj modela: <?php echo $brojModela; ?></span>
</div>


<!-- real time -->

  <div class="Banner-auth" id="auth"></div>


<main>
  <section>
    <div class="Component Viewpicker" id="viewpicker"></div>
    <div class="Component Realtime" id="realtime">
      <h1 class="Realtime-content">
        Active Users:
        <span class="Realtime-value" id="active-users"></span>
      </h1>
    </div>
  </section>

  <section style="width:48%; min-height:480px;" class="Component Chart Chart--chartjs">
    <h3 class="Chart-title">This Week vs Last Week (Sessions)</h3>
    <div id="chart1"></div>
    <ol class="Legend" id="legend1"></ol>
  </section>

  <section style="width:48%; min-height:480px;" class="Component Chart Chart--chartjs">
    <h3 class="Chart-title">This Year vs Last Year (Sessions)</h3>
    <div id="chart2"></div>
    <ol class="Legend" id="legend2"></ol>
  </section>

  <section style="width:48%; min-height:480px;" class="Component Chart Chart--chartjs">
    <h3 class="Chart-title">Top Browsers</h3>
    <div id="chart3"></div>
    <ol class="Legend" id="legend3"></ol>
  </section>

  <section style="width:48%; min-height:480px;" class="Component Chart Chart--chartjs">
    <h3 class="Chart-title">Device Type</h3>
    <div id="chart4"></div>
    <ol class="Legend" id="legend4"></ol>
  </section>
</main>

<!-- This code snippet loads the Embed API. Do not modify! -->
<script>
(function(w,d,s,g,js,fjs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};
  js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load('analytics')};
}(window,document,'script'));
</script>

<!-- This demo uses the viewpicker component, which uses JavaScript promises.
The promise.js script below polyfills promises in older browsers that don't
support them. -->
<script src="assets/js/promise.js"></script>
<script src="assets/js/polymer.js"></script>
<script src="components/viewpicker.js"></script>

<!-- This demo uses the datepicker component -->
<script src="components/datepicker.js"></script>

<!-- The code for this demo requires chart.js to render the charts
and moment.js to do some date processing. It also uses JavaScript
promises, but since we're already loading a polyfill for that above,
we don't need to do it again here. -->
<script src="assets/js/chart.js"></script>
<script src="assets/js/moment.js"></script>

<!-- This demo uses the active-users component -->
<script src="components/active-users.js"></script>

<script>
gapi.analytics.ready(function() {

  /**
   * Authorize this user.
   */
  gapi.analytics.auth.authorize({
    container: 'auth',
    clientid: '79263804085-pk84nrtac6psa30al0bl4bu6etgnatqc.apps.googleusercontent.com',
  });

  /**
   * Add a callback to add the `is-authorized` class to the body
   * as soon as authorization is successful. This is used to help
   * style components.
   */
  gapi.analytics.auth.on('success', function() {
    document.body.classList.add('is-authorized');
    viewpicker.execute();
  });

  /**
   * Create a new Viewpicker instance to be rendered inside of an
   * element with the id "viewpicker".
   */
  var viewpicker = new gapi.analytics.ext.Viewpicker({
    container: 'viewpicker'
  });

  /**
   * Create a new ActiveUsers instance to be rendered inside of an
   * element with the id "active-users" and poll for changes every
   * five seconds.
   */
  var activeUsers = new gapi.analytics.ext.ActiveUsers({
    container: 'active-users',
    pollingInterval: 5
  });

  /**
   * This code adds/removes HTML classes to trigger CSS animations
   * when the active user counts go up or down.
   */
  var realtime = document.getElementById('realtime');
  realtime.addEventListener('animationend', removeAnimationClasses);
  realtime.addEventListener('webkitAnimationEnd', removeAnimationClasses);
  activeUsers.on('stop', removeAnimationClasses)
  activeUsers.on('change', function(data) {
    realtime.classList.add(data.direction);
  });
  function removeAnimationClasses() {
    realtime.classList.remove('increase');
    realtime.classList.remove('decrease');
  }

  /**
   * Update all of the components if the users changes the view.
   */
  viewpicker.on('change', function(data) {
    activeUsers.set(data).execute();
    drawWeek(data.ids);
    drawYear(data.ids);
    drawBrowserStats(data.ids);
    drawDeviceUsage(data.ids);
  });
});

/**
 * Execute a Google Analytics Core Reporting API query
 * and return a promise.
 * @param {Object} params The request parameters.
 * @return {Promise} A promise.
 */
function query(params) {
  return new Promise(function(resolve, reject) {
    var data = new gapi.analytics.report.Data({query: params});
    data.once('success', function(response) { resolve(response); })
        .once('error', function(response) { reject(response); })
        .execute();
  });
}

/**
 * Create a new canvas inside the specified element. Optionally control
 * how tall/wide it is. Any existing elements in will be destroyed.
 * @param {string} id The id attribute of the element to create the canvas in.
 * @param {number} opt_width The width of the canvas. Defaults to 500.
 * @param {number} opt_height The height of the canvas. Defaults to 300.
 * @return {RenderingContext} The 2D canvas context.
 */
function makeCanvas(id, opt_width, opt_height) {
  var container = document.getElementById(id);
  container.innerHTML = '';
  var canvas = document.createElement('canvas');
  var ctx = canvas.getContext('2d');
  canvas.width = opt_width || 500;
  canvas.height = opt_height || 300;
  container.appendChild(canvas);
  return ctx;
}

/**
 * Create a visual legend inside the specified element.
 * @param {string} id The id attribute of the element to create the legend in.
 * @param {Array.<Object>} items A list of labels and colors for the legend.
 */
function setLegend(id, items) {
  var legend = document.getElementById(id);
  legend.innerHTML = items.map(function(item) {
    return '<li><i style="background:' + item.color + '"></i>' +
        item.label + '</li>';
  }).join('');
}

/**
 * Draw the a chart.js line chart with data from the specified view that
 * overlays session data for the current week over session data for the
 * previous week.
 */
function drawWeek(ids) {

  // Adjust `now` to experiment with different days, for testing only...
  var now = moment() // .subtract('day', 2);

  var thisWeek = query({
    'ids': ids,
    'dimensions': 'ga:date,ga:nthDay',
    'metrics': 'ga:sessions',
    'start-date': moment(now).subtract('day', 1).day(0).format('YYYY-MM-DD'),
    'end-date': moment(now).format('YYYY-MM-DD')
  });

  var lastWeek = query({
    'ids': ids,
    'dimensions': 'ga:date,ga:nthDay',
    'metrics': 'ga:sessions',
    'start-date': moment(now).subtract('day', 1).day(0).subtract('week', 1)
        .format('YYYY-MM-DD'),
    'end-date': moment(now).subtract('day', 1).day(6).subtract('week', 1)
        .format('YYYY-MM-DD')
  });

  Promise.all([thisWeek, lastWeek]).then(function(results) {

    var data1 = results[0].rows.map(function(row) { return +row[2]; });
    var data2 = results[1].rows.map(function(row) { return +row[2]; });
    var labels = results[1].rows.map(function(row) { return +row[0]; });

    labels = labels.map(function(label) {
      return moment(label, 'YYYYMMDD').format('ddd');
    });

    var data = {
      labels : labels,
      datasets : [
        {
          fillColor : "rgba(220,220,220,0.5)",
          strokeColor : "rgba(220,220,220,1)",
          pointColor : "rgba(220,220,220,1)",
          pointStrokeColor : "#fff",
          data : data2
        },
        {
          fillColor : "rgba(151,187,205,0.5)",
          strokeColor : "rgba(151,187,205,1)",
          pointColor : "rgba(151,187,205,1)",
          pointStrokeColor : "#fff",
          data : data1
        }
      ]
    };

    new Chart(makeCanvas('chart1')).Line(data, {
      animationSteps: 60,
      animationEasing: 'easeInOutQuart'
    });

    setLegend('legend1', [
      {
        color: 'rgba(151,187,205,1)',
        label: 'This Week'
      },
      {
        color: 'rgba(220,220,220,1)',
        label: 'Last Week'
      }
    ]);
  });
}

/**
 * Draw the a chart.js bar chart with data from the specified view that overlays
 * session data for the current year over session data for the previous year,
 * grouped by month.
 */
function drawYear(ids) {

  var thisYear = query({
    'ids': ids,
    'dimensions': 'ga:month,ga:nthMonth',
    'metrics': 'ga:sessions',
    'start-date': moment().date(1).month(0).format('YYYY-MM-DD'),
    'end-date': moment().date(1).subtract('day',1).format('YYYY-MM-DD')
  });

  var lastYear = query({
    'ids': ids,
    'dimensions': 'ga:month,ga:nthMonth',
    'metrics': 'ga:sessions',
    'start-date': moment().subtract('year',1).date(1).month(0).format('YYYY-MM-DD'),
    'end-date': moment().date(1).month(0).subtract('day',1).format('YYYY-MM-DD'),
  });

  Promise.all([thisYear, lastYear]).then(function(results) {
    var data1 = results[0].rows.map(function(row) { return +row[2]; });
    var data2 = results[1].rows.map(function(row) { return +row[2]; });
    var labels = ['Jan','Feb','Mar','Apr','May','Jun',
                  'Jul','Aug','Sep','Oct','Nov','Dec'];

    var data = {
      labels : labels,
      datasets : [
        {
          fillColor : "rgba(151,187,205,0.5)",
          strokeColor : "rgba(151,187,205,1)",
          data : data1
        },
        {
          fillColor : "rgba(220,220,220,0.5)",
          strokeColor : "rgba(220,220,220,1)",
          data : data2
        }
      ]
    };

    new Chart(makeCanvas('chart2')).Bar(data, {
      animationSteps: 60,
      animationEasing: 'easeInOutQuart'
    });

    setLegend('legend2', [
      {
        color: 'rgba(151,187,205,1)',
        label: 'This Year'
      },
      {
        color: 'rgba(220,220,220,1)',
        label: 'Last Year'
      }
    ]);

  });
}

/**
 * Draw the a chart.js doughnut chart with data from the specified view that
 * show the top 5 browsers over the past seven days.
 */
function drawBrowserStats(ids) {

  query({
    'ids': ids,
    'dimensions': 'ga:browser',
    'metrics': 'ga:sessions',
    'sort': '-ga:sessions',
    'max-results': 5
  })
  .then(function(response) {

    var data = [];
    var colors = ['#F7464A','#E2EAE9','#D4CCC5','#949FB1','#4D5360'].reverse();

    response.rows.forEach(function(row, i) {
      data.push({ value: +row[1], color: colors[i], label: row[0] });
    });

    new Chart(makeCanvas('chart3')).Doughnut(data, {
      animationSteps: 60,
      animationEasing: 'easeInOutQuart'
    });

    setLegend('legend3', data);
  });
}

/**
 * Draw the a chart.js polar area chart with data from the specified view that
 * compares sessions from mobile, desktop, and tablet over the past seven days.
 */
function drawDeviceUsage(ids) {
  query({
    'ids': ids,
    'dimensions': 'ga:deviceCategory',
    'metrics': 'ga:sessions',
  })
  .then(function(response) {

    var data = [];
    var colors = ['#F7464A','#E2EAE9','#D4CCC5','#949FB1','#4D5360'].reverse();

    response.rows.forEach(function(row, i) {
      data.push({
        label: row[0],
        value: +row[1],
        color: colors[i]
      });
    });

    new Chart(makeCanvas('chart4')).PolarArea(data, {
      animationSteps: 60,
      animationEasing: 'easeInOutQuart'
    });

    setLegend('legend4', data);
  });
}

function drawTopPages(ids) {
  query({
    'ids': 'ga:83509365',
    // 'ids': ids,
    'dimensions': 'ga:pagePath',
    'metrics': 'ga:pageviews,ga:uniquePageviews,ga:timeOnPage,ga:bounces,ga:entrances,ga:exits',
    'sort':'-ga:pageviews',
    'start-date': '2014-10-14',
    'end-date':'2014-10-28',
    'max-results':'10',
  })
}

</script>
<div style="clear:both;"></div>

<button onclick="drawTopPages();">Nikola</button>

<?php 

	// $data = 
	// $json_string = json_encode($data, JSON_PRETTY_PRINT);
 ?>


<!-- brisi odavde na dole -->