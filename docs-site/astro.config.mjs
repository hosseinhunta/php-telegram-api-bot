// @ts-check
import { defineConfig } from 'astro/config';
import starlight from '@astrojs/starlight';

// https://astro.build/config
export default defineConfig({
	integrations: [
		starlight({
			title: 'PHP Telegram Bot API Docs',
			social: {
				github: 'https://github.com/hosseinhunta/php-telegram-api-bot',
			},
			sidebar: [

			],
			defaultLocale: "en",
			locales: {
				en : {label: 'English', lang: 'en', dir: 'ltr'},
				fa : {label: 'فارسی', lang: 'fa', dir: 'rtl'},
			},
		}),
	],
});
