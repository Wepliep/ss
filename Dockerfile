FROM php:8.1-fpm

# Nginx ve gerekli araçları yükle
RUN apt-get update && apt-get install -y nginx

# Çalışma dizinini ayarla
WORKDIR /var/www/html

# Proje dosyalarını kopyala
COPY . .

# Nginx yapılandırmasını kopyala
COPY nginx.conf /etc/nginx/sites-available/default

# PHP ve Nginx'in çalışması için izinleri ayarla
RUN chown -R www-data:www-data /var/www/html

# Portu dışarı aç
EXPOSE 80

# Nginx ve PHP-FPM'i başlat
CMD service nginx start && php-fpm