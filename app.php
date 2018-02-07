<?php
  ini_set("allow_url_fopen", 1);

  $timeJSON = file_get_contents('http://bustimeweb.smttracker.com/bustime/api/v3/gettime?key=EyiUrLB4xxVFXxepe26C983cE&format=json');
  $timeDATA = json_decode($timeJSON, true);
  $time = floatval(str_split((str_split($timeDATA['bustime-response']['tm'], 9)[1]), 2)[0]);
  $am = ($_GET['am'] ? $_GET['am'] : $_GET['pm']);
  $pm = ($_GET['pm'] ? $_GET['pm'] : $_GET['am']);
  $morning = ($time < 12 ? true : false);
  $stop = ($morning ? $am : $pm);

  $json = file_get_contents('http://bustimeweb.smttracker.com/bustime/api/v3/getpredictions?key=EyiUrLB4xxVFXxepe26C983cE&format=json&rtpidatafeed=Metro&stpid=' . $stop);
  // $json = file_get_contents('json/bus.json');
  $obj = json_decode($json, true);

  $feedError = ($obj === null ? true : false);
  $dataError = (!$feedError && $obj['bustime-response']['error'] ? true : false);
  $noErrors = (!$feedError && !$dataError ? true : false);

  $busCount = ($noErrors ? count($obj['bustime-response']['prd']) : null);
?>
<?php
  $pageTitle = 'Buses arriving at Metro Stop ' . $stop;
  $css = "app";
  include 'head.php';
?>
<?php
  if ($feedError) {
    echo '<body class="body--error"><section class="dialog dialog--error">
      <h2><span class="icon icon--error icon--large icon--dialog-heading">';
    include('svg/error.svg');
    echo '</span>The Metro\'s not talking to us</h2>
    <p>Sorry! The Southern Maine Transit Tracker isn\'t responding to our request for bus info right now.</p></section>';
  } elseif ($dataError) {
    echo '<body class="body--error">';

    if ($obj['bustime-response']['error'][0]['msg'] === 'No data found for parameter') {
      echo '<section class="dialog dialog--error">
              <h2 class="dialog__heading"><span class="icon icon--error icon--large icon--dialog-heading">';
      include('svg/error.svg');
      echo '</span>Awkward. ' . $stop . ' is not a valid STOP ID.</h2>
              <p>
                <a class="button button--large" href="stop.php">Try again?</a>
              </p>
              <p>
                To find your STOP ID, look for the purple SMTT sign at every METRO bus stop. You can also use
                the <a href="http://bustimeweb.smttracker.com/bustime/map/displaymap.jsp">SMTT map</a>.
              </p>
            </section>';
    } elseif ($obj['bustime-response']['error'][0]['msg'] === 'No arrival times') {
      echo '<section class="dialog dialog--error">
              <h2 class="dialog__heading"><span class="icon icon--error icon--large icon--dialog-heading">';
      include('svg/error.svg');
      echo '</span>Dang. No buses approaching Stop ' . $stop . '.</h2>
              <p>
                <button class="button button--large" type="button" onClick="window.location.reload(true)">
                  <span class="icon icon--light">';
                  include('svg/refresh.svg');
                  echo '</span>&nbsp;
                  Refresh this page
                </button>
              </p>
              <p>
                This route is still in service for the day, <strong>but no buses are approaching your stop within the next 30 minutes</strong>.
              </p>
              <p><a href="http://gpmetrobus.net/">Check the schedule</a> | <a href="stop.php">Check another stop number</a></p>
            </section>';
    } elseif ($obj['bustime-response']['error'][0]['msg'] === 'No service scheduled') {
      echo '<section class="dialog dialog--error">
              <h2 class="dialog__heading"><span class="icon icon--error icon--large icon--dialog-heading">';
      include('svg/error.svg');
      echo '</span>No shirt, no shoes, no bus service</h2>
              <p><strong>Looks like service is over for the day for your stop.</strong></p>
              <p>If this doesn\'t seem right, <a href="http://gpmetrobus.net/">check the schedule</a> to confirm.</p>
              <p>Or <a href="stop.php">check another stop number</a>.</p>
            </section>';
    } else {
      echo '<section class="dialog dialog--error">
              <h2 class="dialog__heading"><span class="icon icon--error icon--large icon--dialog-heading">';
      include('svg/error.svg');
      echo '</span>Well, shoot.</h2>
              <p>
                <strong>We\'re getting an error message from the METRO/SMTT data feed.</strong>
              </p>
              <p>
                This is likely caused by an outage or problem with the SMTT servers that kindly provide us with free bus tracking info.
                In the meantime, please <a href="http://gpmetrobus.net/">check the schedule</a> to see when your bus is supposed to arrive.
                You know, like you did every day before 2016 :)
              </p>
            </section>';
    }
  } else {
    if ($busCount < 2) {
      echo '<body class="body--singleBus">';
    } else {
      echo '<body>';
    }
    $stopName = $obj['bustime-response']['prd'][0]['stpnm'];
    echo
      '<header class="appHeader"><span class="appHeader__icon">';
        if ($morning) {
          include('svg/bus-am.svg');
        } else {
          include('svg/bus-pm.svg');
        }
    echo
        '</span>
        <h2 class="appHeader__heading" title="' . $stopName . '">' . $stopName . '</h2>
        <div class="appHeader__actions">
          <button class="button" type="button" title="Refresh this page" onClick="window.location.reload(true)">
            <span class="visuallyhidden">Refresh this page</span>
            <span class="icon icon--light icon--small" aria-hidden="true">';
              include('svg/refresh.svg');
            echo '</span>
          </button>
          <a href="stop.php" class="button" title="Check another stop ID">
            <span class="visuallyhidden">Check another stop ID</span>
            <span class="icon icon--light icon--small" aria-hidden="true">';
              include('svg/add.svg');
            echo '</span>
          </a>
        </div>
      </header>';
    echo '<ol class="buses">';
    for($i=0; $i<count($obj['bustime-response']['prd']); $i++) {
      $prediction = $obj['bustime-response']['prd'][$i]['prdctdn'];

      $minutesString = "minutes";
      if ($prediction === "1") {
        $minutesString = "minute";
      } elseif ($prediction === "DUE") {
        $minutesString = "Better run!";
      }

      $predictionString = $prediction;
      if ($prediction < 10 && $prediction !== "DUE") {
        $predictionString = '0' . $prediction;
      }

      $delay = $obj['bustime-response']['prd'][$i]['dly'];
      $delayString = $delay ? '<span class="bus__delay">Reporting a delay</span>' : null;

      $panicLevel = "high";
      if ($delay) {
        $panicLevel = "delayed";
      } elseif ($prediction > 4 && $prediction < 10) {
        $panicLevel = "medium";
      } elseif ($prediction > 9) {
        $panicLevel = "low";
      }

      $destination = $obj['bustime-response']['prd'][$i]['des'];
      $direction = $obj['bustime-response']['prd'][$i]['rtdir'];
      $route = $obj['bustime-response']['prd'][$i]['rt'];

      $screenreaderString = '' . $direction . ' route ' . $route . ' bus will arrive at ' . $stopName . ' in ' . $prediction . ' ' . $minutesString;
      if ($prediction === "DUE") {
        $screenreaderString = '' . $direction . ' route ' . $route . ' bus is arriving at ' . $stopName . ' right now! Hurry!';
      }
      echo '<li class="bus bus--' . $panicLevel . 'Panic">
              <span class="visuallyhidden">' . $screenreaderString . '</span>'
              . $delayString .
              '<span class="bus__layout" aria-hidden="true">
                <span class="busPrediction">
                  <span class="busPrediction__number">' . $predictionString . '</span>
                  <span class="busPrediction__unit">' . $minutesString . '</span>
                </span>
                <span class="busDetailsLayout">
                  <span class="busDetails" aria-hidden="true">
                    <span class="busDetails__destination">
                    <span class="busDetails__ticker changesTextColor">'. $direction . ' ' . $destination . '</span>
                  </span>
                  <span class="busDetails__route">
                    <span class="busDetails__route-number">'. $route . '</span>
                  </span>
                  <span class="busDetails__lights">' . $time . '</span>
                </span>
              </span>
            </li>';
    }
    echo '</ol>';

    $timeOfDay = "AM";
    $oppositeTimeShorthand = "PM";
    $oppositeTimeLonghand = "afternoon";

    if (!$morning) {
      $timeOfDay = "PM";
      $oppositeTimeShorthand = "AM";
      $oppositeTimeLonghand = "morning";
    }

    echo '<section class="overlay" id="nag">
      <div class="overlay__content">
        <h3>Add this page to your phone\'s Home Screen, so it\'s always available with a single tap</h3>
        <p>It\'s the <strong>' . $timeOfDay . '</strong>, so we\'re showing you buses for <strong>' . $stopName . '</strong>. In the ' . $oppositeTimeLonghand . ', this
        page will automatically switch to your <strong>' . $oppositeTimeShorthand . '</strong> stop.</p>
        <div>
          <button class="button button--large" id="nagDismissButton" type="button" onClick="setNag()">
            OK, sounds peachy
          </button>
        </div>
      </div>
    </section>
    <script src="script.js"></script>';
  }
?>
</body>
</html>
