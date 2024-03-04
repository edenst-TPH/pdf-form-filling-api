FROM nginx:alpine as base

FROM base as local
RUN echo "Local Environment"

# Copy self-signed certificates
COPY certs/nginx-selfsigned.crt /etc/nginx/ssl/nginx-selfsigned.crt
COPY certs/nginx-selfsigned.key /etc/nginx/ssl/nginx-selfsigned.key


FROM base as dev
RUN echo "Development Environment"

# Install certbot and request certificate
RUN apk add python3 python3-dev py3-pip build-base libressl-dev musl-dev libffi-dev rust cargo
RUN pip3 install pip --upgrade
RUN pip3 install certbot-nginx
RUN mkdir /etc/letsencrypt

RUN certbot --nginx -d 143.198.242.211.nip.io -d www.143.198.242.211.nip.io --email ekin.tertemiz@swisstph.ch --agree-tos


# RUN certbot certonly --webroot -w /var/www/html -d 143.198.242.211.nip.io --email ekin.tertemiz@swisstph.ch --agree-tos

# RUN mkdir -p /etc/letsencrypt/ssl

# RUN cp -r -L /etc/letsencrypt/live/143.198.242.211.nip.io/fullchain.pem /etc/letsencrypt/ssl/
# RUN cp -r -L /etc/letsencrypt/live/143.198.242.211.nip.io/privkey.pem /etc/letsencrypt/ssl/

# RUN chown <nginx_user>:<nginx_group> /etc/letsencrypt/ssl/fullchain.pem
# RUN chown <nginx_user>:<nginx_group> /etc/letsencrypt/ssl/privkey.pem