# Changelog

All notable changes to **QuickDonate** are documented in this file.

## [1.2.0] - 2026-06-09

### Changed

- Renamed the plugin identity from QuickGive to QuickDonate.
- Kept the bootstrap file name as `quickgive.php` so existing installs can update without losing activation.
- Standardized the text domain, slug, constants, hooks, and option name around `quickdonate`.
- Introduced a gateway abstraction so AJAX verification now routes through an active gateway class.
- Kept Paystack as the first and only fully implemented gateway.
- Reworked the admin UI for settings, overview, and donation logs with cleaner card-based layouts.
- Reworked the frontend popup and donate button styling.

### Added

- `QuickDonate_Gateway_Interface`
- `QuickDonate_Paystack_Gateway`
- New primary shortcode: `[quickdonate_popup]`
- Legacy shortcode compatibility for `[paystack_donation_popup]` and `[quickgive_donation_popup]`
- Gateway column in donation logs
- Average donation metric on the overview page
- Optional success and failure page redirects
- Bundled documentation in `docs/`

### Fixed

- Elementor modal containment by relocating overlays to `document.body`
- Full viewport overlay behavior with stronger fixed-position modal styles
- Legacy settings migration from `quickgive_settings`
- Legacy table migration from `quickgive_donations`

## [1.1.0] - 2026-04-13

- Added donor thank-you emails.
- Added admin overview cards and `amount_type` tracking.

## [1.0.0] - 2026-04-13

- Initial public release with Paystack checkout, AJAX verification, shortcode popup, and donation logging.
