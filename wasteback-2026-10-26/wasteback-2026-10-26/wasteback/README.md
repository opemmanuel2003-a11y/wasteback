# WasteBack

A digital waste buyback and reverse logistics platform for incentive-driven urban sanitation and scrap aggregation in Kampala Metropolitan.

HEROES BBC GROUP ITPD project: Nakigudde Margret, Mirembe Allen, Naluwaga Jazirah, Nampala Tunisha Ivy, Opio Emmanuel.

Built with Laravel 12, PHP 8.2 and MySQL (XAMPP). No Node or Vite build step is needed: styles and scripts are plain files in `public/css` and `public/js`.

## What it does

| Role | Can do |
| --- | --- |
| Household (seller) | Register, list materials with weights, see an instant price quote, book a doorstep pickup, cancel it, track pickups, see the wallet and withdraw to MTN or Airtel (simulated). |
| Field agent | See assigned pickups, weigh each material on site, confirm the collection. Confirming pays the household wallet automatically. |
| Administrator | Dashboard with daily kilograms and B2B stock levels, dispatch pickups to agents, manage users and agents, set prices and bulk thresholds, record bulk dispatches to recycling plants, view the full transaction log and contact messages. |

The rules live in `app/Services/Buyback.php`: price is locked at booking, payment uses the verified weight, a collection and its wallet credit happen in one database transaction, withdrawals cannot exceed the balance, and bulk dispatches cannot exceed stock.

## Setting it up on XAMPP

1. Start Apache and MySQL in the XAMPP control panel.
2. In phpMyAdmin create a database called `wasteback` (utf8mb4).
3. In the project folder:

```
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

4. Open http://127.0.0.1:8000

`php artisan migrate:fresh --seed` resets the demo data at any time.

If you prefer phpMyAdmin, import `database/wasteback.sql` into the `wasteback` database instead of running `migrate --seed`.

## Demo accounts

All demo accounts use the password `password`.

| Role | Email |
| --- | --- |
| Household | household@wasteback.ug |
| Field agent | agent@wasteback.ug |
| Administrator | admin@wasteback.ug |

## Tests

Create an empty MySQL database called `wasteback_test`, then run `php artisan test`. The tests open every page for every role, check role isolation, and walk a pickup from booking to payment, withdrawal and bulk dispatch.

## Images

Every photo is linked from images.unsplash.com, not stored in the project. The photo ids are listed in `config/site.php` under `images`, and the `img()` helper in `app/helpers.php` builds the sized URL. The site needs an internet connection to show the pictures.

## Things to change before a real launch

- Contact phone, email and address in `config/site.php` are placeholders.
- Testimonials on the home page are sample quotes, not real customers.
- Mobile money payouts are simulated. No MTN MoMo or Airtel Money API is called.
