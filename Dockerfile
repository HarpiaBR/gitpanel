# estágio de compilação
FROM node:14-alpine3.15 as build-stage
RUN apk add --update --no-cache python2 py-pip
WORKDIR /app
COPY . .
RUN npm install
RUN npm run build --prod
COPY .htaccess dist/gitpanel/
COPY oauth.php dist/gitpanel/

# estágio de produção
FROM php:7.4.33-apache as production-stage
RUN a2enmod rewrite
COPY --from=build-stage /app/dist/gitpanel /var/www/html
