<?php
require_once __DIR__ . '/vendor/autoload.php';
use GeoIp2\Database\Reader;

$ip_address = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
$browser = htmlspecialchars($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown', ENT_QUOTES, 'UTF-8');
$remote_port = intval($_SERVER['REMOTE_PORT'] ?? 0);

// SAFE GEOIP
$country = "Unknown";
try {
    $reader = new Reader(__DIR__.'/GeoLite2-Country.mmdb');
    $record = $reader->country($ip_address);
    $country = $record->country->name ?? "Unknown";
} catch (Exception $e) {
    $country = "Unavailable";
}

$proxy_headers = [
    'HTTP_VIA','HTTP_X_FORWARDED_FOR','HTTP_FORWARDED_FOR','HTTP_X_FORWARDED',
    'HTTP_FORWARDED','HTTP_CLIENT_IP','HTTP_FORWARDED_FOR_IP','X_FORWARDED_FOR',
    'FORWARDED_FOR','X_FORWARDED','FORWARDED','CLIENT_IP','FORWARDED_FOR_IP',
    'HTTP_PROXY_CONNECTION'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your IP: <?php echo $ip_address; ?> • ip.PTM.ro</title>
    <link rel="stylesheet" href="style.css">

<script>
function copyToClipboard() {
    const content = document.getElementById('ipaddr').innerText;
    navigator.clipboard.writeText(content).then(() => {
        const msg = document.getElementById('copy-message');
        msg.classList.add('show');

        // Hide after 3 seconds
        setTimeout(() =>  msg.classList.remove('show'), 3000);
    });
}
function showResolution() {
    return window.innerWidth + " × " + window.innerHeight;
    }
function showRealResolution() {
    return screen.width + " × " + screen.height;
    }
function showPixelRatio() {
    return window.devicePixelRatio;
    }
</script>
</head>
<body>
    <div class="container">
        <h1>This is <span class="yellow"><?php echo htmlspecialchars($_SERVER['SERVER_NAME'], ENT_QUOTES, 'UTF-8'); ?></span></h1>

        <table>
            <tr>
                <td class="blue">IP Address</td>
                <td>
                    <span id="ipaddr"><?php echo $ip_address; ?></span>
<div id="copy-message" class="copy-message">Address copied to clipboard!</div>
                    <button onclick="copyToClipboard()">&#x2398;</button>
                </td>
            </tr>
            <tr><td class="blue">Browser</td><td><?php echo $browser; ?></td></tr>

            <?php foreach ($proxy_headers as $header): ?>
                <?php if (!empty($_SERVER[$header])): ?>
                <tr><td class="blue"><?php echo $header; ?></td><td><span class="red">Proxy detected!</span></td></tr>
                <?php endif; ?>
            <?php endforeach; ?>

            <tr><td class="blue">Remote Port</td><td><?php echo $remote_port; ?></td></tr>
            <tr><td class="blue">Country</td><td><?php echo htmlspecialchars($country, ENT_QUOTES, 'UTF-8'); ?></td></tr>
            <tr><td class="blue">Browser Resolution</td><td><script>document.write(showResolution());</script></td></tr>
            <tr><td class="blue">Screen Resolution</td><td><script>document.write(showRealResolution());</script></td></tr>
            <tr><td class="blue">Pixel Ratio</td><td><script>document.write(showPixelRatio().toFixed(2));</script>x</td></tr>
        </table>
    </div>

    <footer>
        This site runs on valid 
        <a href="https://validator.w3.org/check?uri=referer">HTML5</a> &amp; 
        <a href="https://jigsaw.w3.org/css-validator/check/referer">CSS3</a> • 
        <span class="blue">ip.ptm.ro</span> • 2014 - <?php echo date("Y"); ?> © All rights reserved
    </footer>
</body>
</html>
