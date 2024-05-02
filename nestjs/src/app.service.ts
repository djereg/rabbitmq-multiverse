import { Injectable, Logger } from "@nestjs/common";
import {
  OnMessageEvent,
  RemoteProcedure,
  OnMessageProcessing,
  MessageProcessedEvent,
  OnMessagePublishing,
  MessagePublishingEvent,
  EventEmitter, MessageProcessingEvent, OnMessageProcessed
} from "@djereg/nestjs-rabbitmq";
import { LaravelService } from "./client/laravel.service";
import { SymfonyService } from "./client/symfony.service";
import { random } from "lodash";

@Injectable()
export class AppService {

  private readonly logger: Logger;

  constructor(
    private readonly laravel: LaravelService,
    private readonly symfony: SymfonyService,
    private readonly emitter: EventEmitter,
  ) {
    this.logger = new Logger(this.constructor.name);
  }

  @OnMessagePublishing()
  messagePublishing({ headers }: MessagePublishingEvent) {
    const type = headers['X-Message-Type'];
    this.logger.log(`Message publishing { type: ${type} }`);
  }

  @OnMessageProcessing()
  messageProcessing({ headers }: MessageProcessingEvent) {
    const type = headers['X-Message-Type'];
    this.logger.log(`Message processing { type: ${type} }`);
  }

  @OnMessageProcessed()
  messageProcessed({ headers }: MessageProcessedEvent) {
    const type = headers['X-Message-Type'];
    this.logger.log(`Message processed { type: ${type} }`);
  }

  @OnMessagePublishing()
  setAppName({ headers }: MessagePublishingEvent) {
    this.logger.log(`Adding X-App-Name custom header to the message.`);
    headers['X-App-Name'] = 'Master';
  }

  @OnMessageProcessing()
  getAppName({ headers }: MessageProcessingEvent) {
    const name = headers['X-App-Name'];
    this.logger.log(`Reading X-App-Name custom header from the message { appName: ${name} }`);
  }

  @RemoteProcedure()
  public getName(): string {
    this.logger.log(`Handling getName RPC service call`);
    return "NestJS";
  }

  @RemoteProcedure()
  public async getBestFriend(): Promise<string> {
    this.logger.log(`Handling getBestFriend RPC service call`);

    const name = random(0, 1, false)
      ? await this.laravel.getName()
      : await this.symfony.getName();

    this.logger.log(`My best friend's name: ${name}`);

    return name;
  }

  @RemoteProcedure()
  public async chainCall({ counter }): Promise<string> {
    this.logger.log(`Handling chainCall RPC service call { counter: ${counter} }`);

    if (counter <= 0) {
      return "NestJS";
    }

    const response = random(0, 1, false)
      ? await this.laravel.chainCall(counter - 1)
      : await this.symfony.chainCall(counter - 1);

    return 'NestJS, ' + response;
  }

  @OnMessageEvent('user.created')
  public async onUserCreated({ id }) {
    this.logger.log(`Event [user.created] received { id: ${id} }`);
  }

  @OnMessageEvent('user.updated')
  public async onUserUpdated({ id }) {
    this.logger.log(`Event [user.updated] received { id: ${id} }`);
  }

  @OnMessageEvent('order.created')
  public async onOrderCreated({ id }) {
    this.logger.log(`Event [order.created] received { id: ${id} }`);

    this.logger.log('Publishing [order.updated] event');
    await this.emitter.emit('order.updated', { id });
  }

  @OnMessageEvent('order.updated')
  public async onOrderUpdated({ id }) {
    this.logger.log(`Event [order.updated] received { id: ${id} }`);
  }

  @OnMessageEvent('user.created', { async: true })
  public async onUserCreatedAsync1({ id }) {
    this.logger.log(`Event [user.created] received { id: ${id} } @ Async1`);
  }

  @OnMessageEvent('user.created', { async: true })
  public async onUserCreatedAsync2({ id }) {
    this.logger.log(`Event [user.created] received { id: ${id} } @ Async2`);
    throw new Error('Error Async2');
  }

  @OnMessageEvent('user.created', { async: true, nextTick: true })
  public async onUserCreatedNextTick1({ id }) {
    this.logger.log(`Event [user.created] received { id: ${id} } @ NextTick1`);
    throw new Error('Error NextTick1');
  }

  @OnMessageEvent('user.created', { async: true, nextTick: true })
  public async onUserCreatedNextTick2({ id }) {
    this.logger.log(`Event [user.created] received { id: ${id} } @ NextTick2`);
  }
}
