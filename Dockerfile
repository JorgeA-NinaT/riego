# Usar una imagen base de PHP con Apache
FROM php:8.1-apache

# Copiar todos los archivos del proyecto al directorio raíz del servidor web
COPY . /var/www/html/

# Dar permisos correctos al directorio
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto 80
EXPOSE 80
