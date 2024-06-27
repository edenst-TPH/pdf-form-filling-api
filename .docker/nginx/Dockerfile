FROM nginx:alpine as base

RUN apk update
RUN apk add nano bash

# Create directory that syncs certificate files from certbot container volume
RUN mkdir -p /etc/nginx/ssl/live/

# Copy entrypoint script
# COPY entrypoint-nginx.sh /usr/local/bin/entrypoint.sh

FROM base as dev
RUN echo "Development Environment"

# Copy self-signed certificates
COPY certs/nginx-selfsigned.crt /etc/nginx/ssl/nginx-selfsigned.crt
COPY certs/nginx-selfsigned.key /etc/nginx/ssl/nginx-selfsigned.key

FROM base as test
RUN echo "Testing Environment"

