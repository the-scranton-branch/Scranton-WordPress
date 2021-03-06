<?php

// Enable Redis on site creation
if (isset($_POST['environment'])) {
  $req = pantheon_curl('https://api.live.getpantheon.com/sites/self/settings', NULL, 8443);
  $meta = json_decode($req['body'], true);

  // Enable Redis
  if ($meta['allow_cacheserver'] != 1) {
    $req = pantheon_curl('https://api.live.getpantheon.com/sites/self/settings', '{"allow_cacheserver":true}', 8443, 'PUT');
  }
}

// Install from profile.
echo "Installing WordPress core...\n";
$title = ucwords(implode(" ", explode('-', $_ENV['PANTHEON_SITE_NAME'])));
$email = $_POST['user_email'];
system("wp core install --title='{$title}' --admin_user=superuser --admin_email='{$email}'");
echo "Installation complete.\n";
