import { platformBrowserDynamic } from '@angular/platform-browser-dynamic';
import { AppModule } from './FeedMe.module';

const platform = platformBrowserDynamic();

platform.bootstrapModule(AppModule);
