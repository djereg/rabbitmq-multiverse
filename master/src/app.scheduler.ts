import { Cron } from "@nestjs/schedule";
import { Injectable, Logger } from "@nestjs/common";
import { EventEmitter } from "@djereg/nestjs-rabbitmq";
import { LaravelService } from "./client/laravel.service";
import { SymfonyService } from "./client/symfony.service";
import { random } from "lodash";
import { NestJSService } from "./client/nestjs.service";

@Injectable()
export class AppScheduler {

  private readonly logger: Logger;

  constructor(
    private readonly laravel: LaravelService,
    private readonly symfony: SymfonyService,
    private readonly nestjs: NestJSService,
    private readonly emitter: EventEmitter,
  ) {
    this.logger = new Logger(this.constructor.name);
  }

  @Cron("*/10 * * * * *")
  async run() {

    this.logger.log('############################################');
    this.logger.log('# Scheduler');
    this.logger.log('############################################');

    const aaa = [
      async () => {
        this.logger.log('Getting name of Laravel service.');
        const name = await this.laravel.getName();
        this.logger.log('The Laravel service returned its name: ' + name);
      },
      async () => {
        this.logger.log('Getting name of Symfony service.');
        const name = await this.symfony.getName();
        this.logger.log('The Symfony service returned its name: ' + name);
      },
      async () => {
        this.logger.log('Getting name of NestJS service.');
        const name = await this.nestjs.getName();
        this.logger.log('The NestJS service returned its name: ' + name);
      },
      async () => {
        this.logger.log("Getting best friend of Symfony service.");
        const name = await this.symfony.getBestFriend();
        this.logger.log('The Symfony service named its best friend: ' + name);
      },
      async () => {
        this.logger.log("Getting best friend of Laravel service.");
        const name = await this.laravel.getBestFriend();
        this.logger.log('The Laravel service named its best friend: ' + name);
      },
      async () => {
        this.logger.log("Getting best friend of NestJS service.");
        const name = await this.nestjs.getBestFriend();
        this.logger.log('The NestJS service named its best friend: ' + name);
      },
      async () => {
        this.logger.log('Emitting user.created event.');
        await this.emitter.emit('user.created', { id: random(1, 1000, false) });
        this.logger.log('The event has been emitted.');
      },
      async () => {
        this.logger.log('Emitting user.updated event.');
        await this.emitter.emit('user.updated', { id: random(1, 1000, false) });
        this.logger.log('The event has been emitted.');
      },
      async () => {
        this.logger.log('Emitting order.created event.');
        await this.emitter.emit('order.created', { id: random(1, 1000, false) });
        this.logger.log('The event has been emitted.');
      },
      async () => {
        this.logger.log('Emitting order.updated event.');
        await this.emitter.emit('order.updated', { id: random(1, 1000, false) });
        this.logger.log('The event has been emitted.');
      },
      async () => {
        this.logger.log('Making a chainCall to a random service.');
        const fn = [
          (x) => this.laravel.chainCall(x),
          (x) => this.symfony.chainCall(x),
          (x) => this.nestjs.chainCall(x),
        ];
        const index = random(0, fn.length - 1, false);
        const response = await fn[index](4);
        this.logger.log('The service returned: ' + response);
      },
    ];

    const index = random(0, aaa.length - 1, false);
    await aaa[index]();
  }
}
