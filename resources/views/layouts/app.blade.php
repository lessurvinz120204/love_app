<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Love App 💕</title>
    @laravelPWA
</head>
<body>
    @yield('content')
<div id="install-banner" style="display:none;position:fixed;bottom:20px;left:50%;transform:translateX(-50%);background:#e91e8c;color:#fff;padding:13px 28px;border-radius:24px;font-size:15px;box-shadow:0 4px 20px rgba(233,30,140,0.4);z-index:9999;cursor:pointer;white-space:nowrap;font-family:'Lato',sans-serif;">
    📲 Add to Home Screen
</div>

<script>
    let deferredPrompt;
    const banner = document.getElementById('install-banner');

    // Check if already installed (standalone mode)
    const isInstalled = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone;

    if (!isInstalled) {
        banner.style.display = 'block';

        window.addEventListener('beforeinstallprompt', e => {
            e.preventDefault();
            deferredPrompt = e;
        });

        banner.addEventListener('click', async () => {
            if (deferredPrompt) {
                banner.style.display = 'none';
                deferredPrompt.prompt();
                await deferredPrompt.userChoice;
                deferredPrompt = null;
            } else {
                alert('To install: tap the browser menu (⋮) → "Add to Home screen"');
            }
        });

        window.addEventListener('appinstalled', () => {
            banner.style.display = 'none';
        });
    }
</script>
</body>
</html>