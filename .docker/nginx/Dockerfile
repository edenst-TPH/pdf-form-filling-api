FROM nginx:latest as base

FROM base as local
RUN echo "Local Environment"

# Copy self-signed certificates
COPY certs/nginx-selfsigned.crt /etc/nginx/ssl/nginx-selfsigned.crt
COPY certs/nginx-selfsigned.key /etc/nginx/ssl/nginx-selfsigned.key


FROM base as dev
RUN echo "Development Environment"

# Install certbot and request certificate
RUN apt -y install certbot
RUN certbot certonly --webroot -w /var/www/html -d 143.198.242.211.nip.io --email ekin.tertemiz@swisstph.ch --agree-tos
