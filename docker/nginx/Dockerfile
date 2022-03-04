FROM nginx:alpine

RUN  add-apt-repository ppa:certbot/certbot
RUN  apt-get update
RUN  apt-get install python-certbot-nginx

COPY conf.d/site.conf /etc/nginx/conf.d/

RUN rm /etc/nginx/conf.d/default.conf

EXPOSE 80
