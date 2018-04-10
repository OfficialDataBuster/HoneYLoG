# HoneYLoG
Shitty honeypot repo; Originally made by my friend Amp (he's GitHubless) and found on LulzSec's website; 
**Warning:** actually, really shitty. I tried to keep start it off as a small logger, it got out of hands. Might add E-Mail Support soon (if I get bored again).


1. Configure htaccess.txt (set your full path to .htpassword)
2. Rename htaccess.txt to .htaccess; Rename htpasswd.txt to .htpasswd
3. Configure CloudFlare (at the top of index.php)
4. Configure Users (honeylog.php: line 13; use [PASSWORD_BCRYPT](https://bcrypt-generator.com) to hash your passwords.)
4. You're done; have fun.

Optional: 6. remove .htaccess and .htpasswd, so dumbasses won't give up on the login.

> .htpassword contains **root:toor**, **admin:admin**, **Admin:admin**, **'or 1=1 /\*:'or 1=1 /*** & **'OR 1=1 /\*:'OR 1=1 /*** by default.
