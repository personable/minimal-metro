<?php
  $pageTitle = "Minimal METRO - a Portland, Maine, METRO Bus Tracker";
  $css = "onboard";
  include 'head.php';
?>
<body>
  <header class="onboarding__header">
    <h1 class="onboarding__headline">
      <span class="visuallyhidden">Minimal METRO</span>
      <?php include('svg/logo.svg'); ?>
    </h1>
  </header>
  <form action="app.php" method="GET" class="onboarding__form">
    <ol class="onboardingList">
      <li class="onboardingListItem">
        <div class="onboardingListItem__layout">
          <div class="onboardingSMTT" aria-hidden="true">
            <div class="onboardingSMTT__logo">
              <?php include 'svg/smtt.svg'; ?>
            </div>
            <div class="onboardingSMTT__stopID">
              <span class="onboardingSMTT__stopIDtext">Stop ID</span>
              <span class="onboardingSMTT__stopIDnumber">1234</span>
            </div>
          </div>
          <p>Every METRO stop has a unique <strong>SMTT STOP ID</strong>. Get the STOP IDs for the stops you wait at in the AM and PM.</p>
        </div>
      </li>
      <li class="onboardingListItem">
        <div class="onboardingListItem__layout">
          <p>Enter them below:</p>
          <div class="onboardingInput">
            <label for="am" class="onboardingInput__label">AM Stop ID</label>
            <input
              type="number"
              name="am"
              id="am"
              class="input onboardingInput__input"
              placeholder="e.g., 132"
              required
            />
            <span class="onboardingInput__background"></span>
          </div>
          <div class="onboardingInput">
            <label for="pm" class="onboardingInput__label">PM Stop ID</label>
            <input
              type="number"
              name="pm"
              id="pm"
              class="input onboardingInput__input"
              placeholder="e.g., 132"
              required
            />
            <span class="onboardingInput__background"></span>
          </div>
        </div>
      </li>
      <li class="onboardingListItem">
        <div class="onboardingListItem__layout">
          <p>
            <span class="onboardingPhone" aria-hidden="true">
              <span class="onboardingPhone__layout">
                <?php include 'svg/sample-screen.svg'; ?>
              </span>
            </span>
          </p>
          <p>
            Get a page that displays the buses expected right now at the stops you use. <strong>Bookmark it for one-click access!</strong>
          </p>
          <p>
            <button class="button button--pushy button--block button--large" type="submit">Submit</button>
          </p>
        </div>
      </li>
    </ol>
  </form>
  <footer class="onboarding__footer">
    &copy;<?php echo date("Y"); ?> Personable Design&nbsp;&nbsp;|&nbsp;&nbsp;
    <a class="link--light" href="m&#97;ilto&#58;c&#37;6&#56;r&#105;s&#64;pe&#37;72so&#110;a&#37;62led&#101;s&#105;&#103;%6E&#46;co&#37;&#54;D">Contact me</a>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a class="link--light" href="https://github.com/personable/minimal-metro">Github</a>
  </footer>
</body>
</html>
