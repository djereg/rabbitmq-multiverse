import { Injectable, Logger } from "@nestjs/common";
import {
  OnMessageProcessing,
  MessageProcessingEvent,
  OnMessagePublishing,
  MessagePublishingEvent
} from "@djereg/nestjs-rabbitmq";

@Injectable()
export class AppService {

  private readonly logger: Logger;

  constructor() {
    this.logger = new Logger(this.constructor.name);
  }

  @OnMessagePublishing()
  messagePublishing({ headers }: MessagePublishingEvent) {
    const type = headers['X-Message-Type'];
    this.logger.log(`Message publishing { type: ${type} }`);
  }

  @OnMessageProcessing()
  messageReceived({ headers }: MessageProcessingEvent) {
    const type = headers['X-Message-Type'];
    this.logger.log(`Message received { type: ${type} }`);
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
}
