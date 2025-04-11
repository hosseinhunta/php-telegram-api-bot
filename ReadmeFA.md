<p align="center">
  <img src="/docs/static/img/logo.png" alt="Telegram Bot API - PHP SDK Banner">
</p>

<p align="center">
  <a href="https://packagist.org/packages/irazasyed/telegram-bot-sdk"><img src="https://img.shields.io/packagist/dt/hosseinhunta/php-telegram-api-bot.svg" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/irazasyed/telegram-bot-sdk"><img src="https://img.shields.io/packagist/v/hosseinhunta/php-telegram-api-bot.svg" alt="Latest Stable Version"></a>
  <a href="https://t.me/php_telegram_api_bot"><img src="https://img.shields.io/badge/Telegram-Join%20Group-blue" alt="Telegram Group"></a>
  <a href="https://github.com/hosseinhunta/php-telegram-api-bot"><img src="https://img.shields.io/github/stars/hosseinhunta/php-telegram-api-bot?style=social" alt="GitHub Stars"></a>
  <a href="https://github.com/hosseinhunta/php-telegram-api-bot/blob/main/LICENSE"><img src="https://img.shields.io/github/license/hosseinhunta/php-telegram-api-bot" alt="License"></a>
  <a href="https://github.com/hosseinhunta/php-telegram-api-bot"><img src="https://img.shields.io/badge/Open%20Source-Yes-brightgreen" alt="Open Source"></a>
  <a href="https://github.com/hosseinhunta/php-telegram-api-bot/graphs/contributors"><img src="https://img.shields.io/github/contributors/hosseinhunta/php-telegram-api-bot" alt="Contributors"></a>
</p>

<div dir="rtl">

## کتابخانه Telegram Bot API - PHP SDK (بتا)

این یه کتابخانه PHP برای کار با API ربات‌های تلگرامه که طراحی شده تا ساختن ربات‌های تلگرامی رو به ساده‌ترین و لذت‌بخش‌ترین شکل ممکن تبدیل کنه! فرقی نمی‌کنه تازه‌کار باشی یا یه برنامه‌نویس حرفه‌ای، این کتابخانه با تمرکز روی سادگی، امنیت و کارایی ساخته شده. پر از امکاناته، کلی مثال داره و از همه مهم‌تر، یه مستندات کامل و دقیق داره که بهت نشون می‌ده چقدر راحت می‌تونی با PHP یه ربات تلگرامی بسازی.

ما خیلی تلاش کردیم تا این کتابخانه به یه ابزار عالی برای هر کسی که می‌خواد ربات تلگرامی بسازه تبدیل بشه. این کتابخانه سبک، امن و بهینه‌ست و برای استفاده‌های واقعی طراحی شده، پس می‌تونی به‌جای درگیر شدن با کدهای پیچیده، روی ساختن رباتت تمرکز کنی.

---

### متدهای پشتیبانی‌شده API تلگرام

این کتابخانه در حال حاضر **همه** متدهای API ربات تلگرام رو پشتیبانی می‌کنه! یه جدول ساده برات آماده کردم:

</div>

| متد              | پشتیبانی‌شده |
|------------------|--------------|
| `sendMessage`    | ✅           |
| `getMe`          | ✅           |
| `sendPhoto`      | ✅           |
| `sendAudio`      | ✅           |
| `sendDocument`   | ✅           |
| `sendVideo`      | ✅           |
| `sendAnimation`  | ✅           |
| `sendVoice`      | ✅           |
| `sendVideoNote`  | ✅           |
| `sendMediaGroup` | ✅           |
| `getUpdates`     | ✅           |
| `setWebhook`     | ✅           |
| `deleteWebhook`  | ✅           |
| `getChat`        | ✅           |
| `getChatMember`  | ✅           |
| `answerCallbackQuery` | ✅      |
| ...و بقیه متدها! | ✅           |

<div dir="rtl">
بله، درست دیدی—**همه متدها**ی API تلگرام توی این کتابخانه پشتیبانی می‌شن! 🎉

---

### مستندات

می‌خوای بیشتر بدونی؟ مستندات مفصل ما رو به دو زبان ببین:

- [مستندات فارسی](https://hosseinhunta.github.io/php-telegram-api-bot/fa)
- [English Documentation](https://hosseinhunta.github.io/php-telegram-api-bot/en)

مستندات همه‌چیز رو بهت توضیح می‌ده—از نصب گرفته تا استفاده پیشرفته—با کلی مثال که بتونی سریع شروع کنی.

---

### کارهایی که قراره اضافه بشن (TODO)

داریم سخت کار می‌کنیم تا این کتابخانه رو بهتر کنیم! اینا چیزایی هستن که قراره به‌زودی اضافه بشن:

- ساخت یه سیستم مدیریت دستورات (Command) و رویدادها (Event Handler) برای مدیریت بهتر ربات.
- بهینه‌سازی بخش مدیریت به‌روزرسانی‌ها (Update Handler) برای عملکرد بهتر.
- افزایش امنیت و پایداری کد.
- تکمیل و بهبود مستندات.
- به‌روزرسانی کتابخانه برای پشتیبانی از نسخه 8.3 API ربات تلگرام.
- پشتیبانی از انواع داده‌های پیچیده‌تر.
- اضافه کردن Middleware برای مدیریت پیشرفته درخواست‌ها.
- بهبود مدیریت وب‌هوک با قابلیت‌های پیشرفته.
- اضافه کردن ابزارهای دیباگ پیشرفته‌تر (مثلاً دامپ مستقیم درخواست‌ها و پاسخ‌ها).
- پیاده‌سازی تست‌های واحد (Unit Tests) و یکپارچگی (Integration Tests) گسترده برای تضمین پایداری.
- امکان اضافه کردن پلاگین برای قابلیت‌های بیشتر.
- بهینه‌سازی بیشتر عملکرد برای ربات‌های بزرگ.
- اضافه کردن کش برای Inline Queryها تا تعداد درخواست‌ها به API کمتر بشه.
- ساخت یه سیستم محدودکننده نرخ (Rate Limiter) برای مدیریت محدودیت‌های API تلگرام.
- پشتیبانی از مدیریت چند ربات توی یه نمونه (Multi-Bot Management).

منتظر این به‌روزرسانی‌ها باش، چون قراره این کتابخانه رو به سطح بالاتری ببریم! 🚀

---

### ربات‌های جذاب ساخته‌شده با Telegram Bot SDK!

اگه با این کتابخونه یه ربات تلگرامی باحال ساختی، بهمون بگو تا اینجا معرفیش کنیم! به‌زودی یه لیست از ربات‌های جذاب ساخته‌شده توسط کاربرا رو می‌ذاریم.

---

### اطلاعات بیشتر

اگه مشکلی داری، پیشنهادی داری یا سوالی برات پیش اومده، لطفاً از [سیستم پیگیری مسائل](https://github.com/hosseinhunta/php-telegram-api-bot/issues) استفاده کن.

---

### مشارکت

ممنون که به فکر مشارکت توی این پروژه هستی! لطفاً قبل از ارسال هرگونه درخواست کشیدن (Pull Request)، [راهنمای مشارکت](https://github.com/hosseinhunta/php-telegram-api-bot/blob/main/CONTRIBUTING.md) رو مطالعه کن.

---

### سلب مسئولیت

این کتابخونه فعلاً توی نسخه بتا قرار داره و با اینکه ما تمام تلاشمون رو کردیم تا بدون مشکل کار کنه، ممکنه باگ یا رفتارهای غیرمنتظره‌ای داشته باشه. استفاده ازش به عهده خودته و اگه مشکلی دیدی، خوشحال می‌شیم گزارشش کنی.

---

### لایسنس

این پروژه تحت [لایسنس MIT](https://github.com/yourusername/telegram-bot-sdk/blob/main/LICENSE) منتشر شده—می‌تونی آزادانه ازش استفاده کنی، تغییرش بدی و پخشش کنی!

---

</div>