# Your IP Address
Script to show user's IP Address and other public details which the browser sends.

### Prerequisites

```
# apt install composer
# cd /path/to/your/webserver/directory/
# composer init
# composer require geoip2/geoip2
```
Install [this package](https://github.com/maxmind/geoipupdate): `geoipupdate` on your server.

## Published details
### IP Address  
Your publicly visible IP Address
### Proxy (only if detected)  
Will show a warning if you are behind a proxy
### Browser  
Full browser signature
### Remote Port  
The port used for current connection
### Country  
Best guess country (via GeoIP database)
### Window Resolution  
Oh, well... This is actually the ***worst*** part, because there is no _real_ method of detecting the actual display resolution, so we try to guess it using the browser's data.
### Screen (Browser) Resolution  
The actual browser window size.
### Pixel Ratio  
Just a horrible thing which is (probably) never accurate, especially on mobile devices.

See this in action at [https://ip.ptm.ro/](https://ip.ptm.ro/).
