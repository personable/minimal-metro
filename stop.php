<?php
  $pageTitle = "Minimal METRO - check the status of a stop";
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
    <div class="dialog">
      <h2 class="dialog__heading">Off the beaten path?</h2>
      <p>Enter any METRO STOP ID here to see what buses are on the way.</p>
      <div class="onboardingInput">
        <label for="am" class="onboardingInput__label">Stop ID</label>
        <input
          type="number"
          name="am"
          id="am"
          class="input onboardingInput__input"
          placeholder="e.g., 132"
          required
          autofocus
        />
        <span class="onboardingInput__background"></span>
      </div>
      <p>
        <button class="button button--pushy button--block button--large" type="submit">Submit</button>
      </p>
    </div>
  </form>
  <footer class="onboarding__footer">
    &copy;<?php echo date("Y"); ?> Personable Design.&nbsp;&nbsp;<a class="link--light" href="m&#97;ilto&#58;c&#37;6&#56;r&#105;s&#64;pe&#37;72so&#110;a&#37;62led&#101;s&#105;&#103;%6E&#46;co&#37;&#54;D">Contact me</a>&nbsp;with questions or problems.
  </footer>

</body>
</html>
