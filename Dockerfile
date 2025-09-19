# Dockerfile (lưu ở root)
FROM php:8.2-apache

# Cài extension nếu cần (ví dụ: zip, pdo_mysql). Xoá/ chỉnh tùy nhu cầu.
RUN apt-get update && apt-get install -y \
    zip unzip libzip-dev \
  && docker-php-ext-install pdo_mysql mysqli \
  && rm -rf /var/lib/apt/lists/*

# Copy code vào thư mục web của Apache
COPY . /var/www/html/

# Tùy chọn: set owner / quyền trên linux servers
RUN chown -R www-data:www-data /var/www/html \
  && find /var/www/html -type d -exec chmod 755 {} \; \
  && find /var/www/html -type f -exec chmod 644 {} \;

# Expose (không bắt buộc, Render autodetect port nhưng tốt để khai báo)
EXPOSE 80

# Start Apache (image cung cấp script apache2-foreground)
CMD ["apache2-foreground"]
