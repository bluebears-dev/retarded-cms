FROM mysql:5.7

ENV MYSQL_DATABASE=laravel \
    MYSQL_ROOT_PASSWORD=secret

ADD schema.sql /docker-entrypoint-initdb.d
