<header class="site-header">
  <a class="logo" href="/index.php">SoleSwap 👟</a>
  <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="hoofdmenu">☰ Menu</button>
  <nav id="hoofdmenu" class="site-nav" aria-label="Hoofdnavigatie">
    <a href="/index.php">Home</a>
    <a href="/schoenen.php">Schoenen bekijken</a>
    <?php if (isIngelogd()): ?>
      <a href="/schoen-toevoegen.php">Schoenen verkopen</a>
      <a href="/dashboard.php">Dashboard</a>
      <form class="inline-form" method="post" action="/logout.php">
        <input type="hidden" name="csrf_token" value="<?= veilig(csrfToken()) ?>">
        <button class="nav-logout" type="submit">Uitloggen</button>
      </form>
    <?php else: ?>
      <a href="/login.php">Inloggen</a>
    <?php endif; ?>
  </nav>
</header>
