import { Module } from "@nestjs/common";
import { AppService } from "./app.service";
import { ScheduleModule } from "@nestjs/schedule";
import { RabbitMQModule } from "@djereg/nestjs-rabbitmq";
import { LaravelService } from "./client/laravel.service";
import { SymfonyService } from "./client/symfony.service";

@Module({
  imports: [
    ScheduleModule.forRoot(),
    RabbitMQModule.forRoot({
      clients: [{
        queue: "symfony",
      }, {
        queue: "laravel",
      }]
    }),
  ],
  providers: [
    AppService,
    LaravelService,
    SymfonyService,
  ]
})
export class AppModule {
  //
}
