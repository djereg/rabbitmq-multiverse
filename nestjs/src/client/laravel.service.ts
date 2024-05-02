import { Injectable, Logger } from "@nestjs/common";
import { Client, InjectClient } from "@djereg/nestjs-rabbitmq";
import { DateTime } from "luxon";

@Injectable()
export class LaravelService {

  private readonly logger: Logger;

  constructor(
    @InjectClient("laravel")
    private readonly client: Client,
  ) {
    this.logger = new Logger(this.constructor.name);
  }

  async getName(): Promise<string> {
    this.logger.log("Calling Laravel service to get its name.");
    const startTime = DateTime.now();
    const name = await this.client.call<string>("getName", {}, { timeout: 5000 });
    const time = DateTime.now().diff(startTime).as("milliseconds");
    this.logger.log(`Received response in ${time}ms from Laravel service: ` + name);
    return name;
  }

  async getBestFriend(): Promise<string> {
    this.logger.log("Calling Laravel service to get its best friend.");
    const startTime = DateTime.now();
    const name = await this.client.call<string>("getBestFriend", {}, { timeout: 5000 });
    const time = DateTime.now().diff(startTime).as("milliseconds");
    this.logger.log(`Received response ${time}ms from Laravel service: ` + name);
    return name;
  }

  async chainCall(counter: number) {
    this.logger.log(`Making a chainCall to Laravel service { counter: ${counter} }`);
    const startTime = DateTime.now();
    const name = await this.client.call<string>("chainCall", { counter }, { timeout: 5000 });
    const time = DateTime.now().diff(startTime).as("milliseconds");
    this.logger.log(`Received response ${time}ms from Laravel service: ` + name);
    return name;
  }
}
