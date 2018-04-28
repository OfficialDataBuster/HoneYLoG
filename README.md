# HoneYLoG
Shitty honeypot repo; Made by my friend Amp ([@LulzAmp](https://github.com/LulzAmp)) and originally found on LulzSec's website; 
**Warning:** actually, really shitty. I tried to start it off as a small logger, it got out of hands. Might add E-Mail Support soon (if I get bored again). Follow [@LulzAmp](https://github/LulzAmp/HoneYLoG/)'s version for updates.


1. [Configure .htaccess](https://github.com/OfficialDataBuster/HoneYLoG/blob/master/.htaccess#L2) (set the path to the full path to your .htpassword)
2. [Configure CloudFlare](https://github.com/OfficialDataBuster/HoneYLoG/blob/master/index.php#L2)
3. [Configure Users](https://github.com/OfficialDataBuster/HoneYLoG/blob/master/honeylog.php#L12-L14) ( use [PASSWORD_BCRYPT](https://bcrypt-generator.com) to hash your passwords.)
4. You're done; have fun.

Optional: 5. remove [the following lines of code](https://github.com/OfficialDataBuster/HoneYLoG/blob/master/.htaccess#L1-L6) from .htaccess and remove .htpasswd completely, so dumbasses won't give up on the login.
```apacheconf
# setup htpasswd
AuthUserFile /full/path/to/.htpasswd
AuthType Basic
# put whatever bullshit you want here instead of "Restricted Area"
AuthName "Restricted Area"
Require valid-user
```

> .htpassword contains **root:toor** by default.
