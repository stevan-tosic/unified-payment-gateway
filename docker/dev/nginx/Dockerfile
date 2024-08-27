FROM nginx:1.25.5-alpine

RUN apk --no-cache upgrade
# NGINX: remove default config
RUN rm -f /etc/nginx/conf.d/default.conf

# NGINX: configuration & vhost
COPY files/unified-payment-gateway.conf /etc/nginx/sites-enabled/default
COPY files/nginx.conf /etc/nginx/nginx.conf

# LOG
RUN mkdir -p /var/log/nginx && chown -fR nginx:nginx /var/log/nginx
