# Searchline for WooCommerce

Production-focused WooCommerce integration for the Iranian Searchline inquiry service.

## Features
- HPOS-safe WooCommerce CRUD for order data.
- Declarative registry for all documented synchronous inquiry families plus asynchronous validation and OTP authentication.
- Defensive API response normalization and configurable endpoint groups.
- Classic checkout and Checkout Block field registration.
- Persian/Arabic digit normalization and Iranian national ID, mobile, card, postal and IMEI validators.
- Admin inquiry execution and order-level status.
- REST callback foundation and WordPress privacy hooks.
- Extensible filters/actions and GPL-2.0-or-later licensing.

## External services
The plugin sends only the parameters required by enabled inquiries to the Searchline endpoint configured by the merchant. Depending on the selected inquiry, this can include national ID, birth date, mobile, landline, postal code, card/Sheba, IMEI, IP/location and related values. Data is transmitted only when an enabled inquiry is triggered. The merchant is responsible for consent, lawful processing, retention and regulatory compliance.

## Development
Use Composer for development dependencies. Run PHPUnit, PHPCS and PHPStan before release.

## License
GPL-2.0-or-later.
