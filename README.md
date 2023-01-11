Nest-Extended
=============

I AM NO LONGER MAINTAINING THIS REPOSITORY. It was one of the first projects I wrote and published to github on my own and and surprised be the amount of people that ended up using it, messaging me about it, etc. Thank you!

Also, note that since I started this, Nest has started an official Developer program. You might be better served using the official APIs than this project relyin gon the unofficial Nest API.

Introduction
-------------
Collect, monitor, and act on extended data from Nest Learning Thermostats.

Currently, Nest-Extended relies on the unofficial Nest API (https://github.com/gboudreau/nest-api/) to gather data before creating graphs with flot (https://github.com/flot/flot).

Additionally, Nest-Extended uses a modified version of a Humidity Control script from http://mbritten.x10.mx/ to adjust humidity relative to the external temperature.

If you can think of ways to improve this project, please free to let me know or submit a pull request!

Installation
-------------
To install you'll need a webserver running PHP and MySQL. Additionally, you'll need to know how to add cron jobs.

1. Git-Clone or Copy the files from this project into a file on your server.
2. Create a MySQL database on your server called 'nest'. You can import the structure of this database from the 'nestdb.sql.gz' file in the resources folder.
3. Edit the config.php in the resources folder to provide the credentials for your Nest account, your MySQL database, your Weather Underground API, set your time zone, and whether you want Nest-Extend to try and control your humidity level. You can sign up for a Weather Underground API key at http://www.wunderground.com/weather/api/?apiref=c133a2be0b541640
4. Create a cron job for nest-get-data.php?datatype=current to run at a regular interval. I use 5 minutes. Others use 10.
5. Create a cron job for nest-get-data.php?datatype=daily to run once per day. I usually run this at noon.
6. You're done! Enjoy your new graphs.

![Example Plot](/example.png)
