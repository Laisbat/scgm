php -S 0.0.0.0:8080 -t public public/index.php

echo "# scgm" >> README.md
git init
git add README.md
git commit -m "first commit"
git remote add origin https://github.com/Laisbat/scgm.git
git push -u origin master
