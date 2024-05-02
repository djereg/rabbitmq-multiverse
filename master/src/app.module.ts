import { Module } from "@nestjs/common";
import { AppService } from "./app.service";
import { AppScheduler } from "./app.scheduler";
import { ScheduleModule } from "@nestjs/schedule";
import { RabbitMQModule } from "@djereg/nestjs-rabbitmq";
import { LaravelService } from "./client/laravel.service";
import { SymfonyService } from "./client/symfony.service";
import { NestJSService } from "./client/nestjs.service";

@Module({
  imports: [
    ScheduleModule.forRoot(),
    RabbitMQModule.forRoot({
      clients: [{
        queue: "symfony",
      }, {
        queue: "laravel",
      }, {
        queue: "nestjs",
      }]
    }),
  ],
  providers: [
    AppService,
    AppScheduler,
    LaravelService,
    SymfonyService,
    NestJSService,
  ]
})
export class AppModule {
  //
}
