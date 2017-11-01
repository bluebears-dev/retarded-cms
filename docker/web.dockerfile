FROM nginx:1.13.6

ADD ./docker/vhost.conf /etc/nginx/conf.d/default.conf
