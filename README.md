<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre o projeto

Um pequeno e sucinto projeto desenvolvido em laravel para consumir tópicos no Apache Kafka.

## Requerimentos

Para rodar este projeto você deve ter instalado o docker e docker-compose.

## Instalação

Rode o comando para buildar a imagem do php e subir os serviços da aplicação.

OBS: O projeto laravel ficará disponivel na porta 8086 do seu localhsot. Certifique-se que sua porta esteja disponível.
OBS2: Dentro do arquivo docker-compose.yml estão os argumentos de usuário e UID para configurar o composer.
```
docker-compose build && docker-compose up -d 
```

Agora dentro do container do laravel você precisa instalar as dependências e rodar as migrations de teste. Para isso entre no terminal do container:

```
docker exec -it laravel-test-app bash
cp .env.example .env && composer install && php artisan migrate && php artisan db:seed
```
Estre projeto foi configurado para usar o banco de dados postgres. Após rodar as migrations e o seed, existe um endpoint simples que lista os clientes cadastrados para testar a conexão com o banco de dados.

http://localhost:8086/api/customers

## Criação tópico no kafka

Agora precisamos criar o tópico que será consumido pela aplicação. Para isso entre no terminal do container do kafka e rode o comando:

```
docker exec -it laravel-test_kafka_1 bash
kafka-topics --create --bootstrap-server localhost:29092 --partitions 3 --replication-factor 1 --topic topico-2
```
Note que coloquei 3 repartições para o tópico. Fique a vontade para mudar caso queira ou precise.

OBS: Caso precise mudar o nome do tópico, vai precisar mudar o nome no código igualmente.

## Kafka send e kafka consumer

Para mandar mensagens para o tópico foi criada uma rota GET no path /kafka-send. Será disparado uma mensgem automáticamente.
Poderia ser um POST mandando no body a mensagem que precise, mas está assim apenas por exemplo.

http://localhost:8086/kafka-send

Para consumir essa mensagem foi criado um consumer que fica escutando o mesmo tópico. Para isso rode o comando (dentro do container do laravel):

```
php artisan kafka:consumer
```

Esse processo irá printar no terminal o body da mensagem, apenas como exemplo.

## Encerrar processos

Você pode facilmente parar os serviços do docker com o comando
```
docker-compose down && docker rmi laravel-test
```
