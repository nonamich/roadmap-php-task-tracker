FROM php:8.2-cli

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /usr/src/task-cli
WORKDIR /usr/src/task-cli

RUN composer install


ENTRYPOINT [ "./bin/cli" ]
