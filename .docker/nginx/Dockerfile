FROM nginx:latest as base

FROM base as local
RUN echo "Local Environment"

# Copy self-signed certificates
COPY certs/nginx-selfsigned.crt /etc/nginx/ssl/nginx-selfsigned.crt
COPY certs/nginx-selfsigned.key /etc/nginx/ssl/nginx-selfsigned.key


FROM base as dev
RUN echo "Development Environment"

# Install certbot and request certificate
RUN apt update
RUN apt install snapd -y
RUN snap install core
RUN apt-get remove certbot -y

RUN snap install --classic certbot
RUN ln -s /snap/bin/certbot /usr/bin/certbot

RUN certbot --nginx

# RUN certbot certonly --webroot -w /var/www/html -d 143.198.242.211.nip.io --email ekin.tertemiz@swisstph.ch --agree-tos

# RUN mkdir -p /etc/letsencrypt/ssl

# RUN cp -r -L /etc/letsencrypt/live/143.198.242.211.nip.io/fullchain.pem /etc/letsencrypt/ssl/
# RUN cp -r -L /etc/letsencrypt/live/143.198.242.211.nip.io/privkey.pem /etc/letsencrypt/ssl/

# RUN chown <nginx_user>:<nginx_group> /etc/letsencrypt/ssl/fullchain.pem
# RUN chown <nginx_user>:<nginx_group> /etc/letsencrypt/ssl/privkey.pem