# Walk Safe (Because "escort service" sounds too bad)

## What is "*Walk Safe*"?
"*Walk Safe*" is a web application which allows you to find people (other
users) in the close area who are willing to take a walk or more with you so
you can feel safe and do not need to be afraid of random strangers in the
dark street corner. In order to be safe the users need to verify them. Fake
profiles or/and bad people have to stay out so they can not offer theyre
"services" to innocent people needing help.

At this time this is only an idea of how it could work. The future will show
weather this plan is able to grow or not. Because this is open source and
the community is asked for contribution we also would like to discuss the
concept.


## How to run it
Currently I am running the application in a development system on my
raspberry pi (*Raspbian in combination with a simple apache2 (PHP) server
and PostgreSQL database*).
In case you are interested in running it on your own system you simply
install the apache server supporting php and a postgresql database. As you
can see in the names of the directories in the root directory of the project
there is a directory for the public htdocs files and a directory which
should stay out of the public webspace because it contains the configuration
and PHP classes. In the serveronly directory you will find a SQL script
which creates the tables in your database (*It is standard SQL so you should
be able to use your favorite database system*). If you want to use another
database system than PostgreSQL you have to change the used database driver
for PDO in the DSN string in the `DatabaseManager` class. After setting up
the database you configure the whole thing in the following two files which
should be self explaining:

 * /serveronly/server.json
 * /serveronly/var/database.json


## Configuration

### server.json
The server.json file contains general information about the server like the
impressum data for legal stuff. It is a simple JSON file having the
following keys:

| Key                  | Description                                         |
|----------------------|-----------------------------------------------------|
| sitetitle            | Title of the application in your instance           |
| fqdn                 | Fully qualified domain name                         |
| systemaddress        | E-Mail address which should be used to send E-Mails |
| copyright            | Copyright (*You can use my or your own name*)       |
| responsible          | This should be your name as system administrator    |
| impressum_personname | Person name in the impressum                        |
| impressum_street     | Street name in the impressum                        |
| impressum_city       | City name in the impressum                          |
| impressum_email      | E-Mail address in the impressum                     |


### database.json
The database.json file contains all information about the used database.
Keep in mind that this file contains the database users password. This is
why you should set the filemode to 600 and the owner to your webservers user.
It should contain the following data:

| Key      | Description                                         |
|----------|-----------------------------------------------------|
| host     | Hostname or IP address of the database system       |
| port     | Port to use (*PostgreSQL: 5432; MySQL: 3306*)       |
| dbname   | Name of the database on the server                  |
| username | Name of the database user                           |
| password | Password of the database user                       |


## Author
At this time I am the only authorwhich will change in future I hope.

 * Marius Timmer [timmer@mariustimmer.no-ip.org](mailto:timmer@mariustimmer.no-ip.org)

