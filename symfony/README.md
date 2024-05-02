# RabbitMQ Multiverse

This repository contains a simple example of a RabbitMQ multiverse. It consists of a master service that sends messages to three different services: NestJS,
Laravel, and Symfony.

Each framework has its own package which add support for RabbitMQ and utilizes the Framework's own features like Events, Queues, Workers, etc.
Using this packages you can easily integrate RabbitMQ into your application as a communication layer between services.

| Framework | Package                                                               |
|-----------|-----------------------------------------------------------------------|
| Laravel   | [djereg/laravel-rabbitmq](https://github.com/djereg/laravel-rabbitmq) |
| Symfony   | [djereg/symfony-rabbitmq](https://github.com/djereg/symfony-rabbitmq) |
| NestJS    | [@djereg/nestjs-rabbitmq](https://github.com/djereg/nestjs-rabbitmq)  |

To see the example in action, you need to have Docker and Docker Compose installed on your machine.
Clone the repository and navigate to the root directory of the project.

## Setup

To start the services, you need to make the scripts executable. Just run the following command or prefix the scripts below with `bash` or `sh`.

```bash
chmod +x setup.sh start.sh master.sh nestjs.sh laravel.sh symfony.sh
```

To set up the services, run the following command which will build the container images and install the dependencies required for each service:

```bash
./setup.sh
```

## Start the services

To start all services at once, run the following command. The script starts 3 instances of each service and the master service. You will see the logs of each
service in the console.

```bash
./start.sh
```

Or you can see the logs of each service separately by running the following commands.
Each command will start 3 instances of the service, except for the master. The master service will start only one instance.

```bash
./nestjs.sh
```

```bash
./laravel.sh
```

```bash
./symfony.sh
```

```bash
./master.sh
```

The started services will communicate with each other through RabbitMQ.

The master service will send messages to the other services every 10 seconds,
and each service will process the messages and log the details to the console.
The master service emits events or calls remote procedures on the other services.
These services react to the events or respond to the remote procedure calls.

The example is very simple but demonstrates how you can communicate between services written in different frameworks or programming languages through a message
queue.
