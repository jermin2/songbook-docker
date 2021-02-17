docker run --name myadmin --network docker_default -d --link songbook_db:db -p 8080:80 phpmyadmin/phpmyadmin
