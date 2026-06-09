=== QuickDonate ===
Contributors: saif2002
Tags: donations, fundraising, paystack, charity, payments
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Collect secure one-time donations with a clean popup checkout, donation logs, thank-you emails, and Paystack verification.

== Description ==

QuickDonate is a lightweight donation plugin for WordPress. It provides a shortcode-triggered popup, preset and custom donation amounts, donor email capture, server-side verification, donation logging, and optional thank-you emails.

The plugin is architected for future gateway expansion. Paystack is the first supported gateway and remains the only fully functional gateway in this release.

**External service disclosure:**
QuickDonate connects to Paystack to open checkout and verify completed transactions. Payment data required to process a donation is sent to Paystack. Site administrators must provide their own Paystack public and secret keys.

Paystack Terms of Service:
https://paystack.com/terms

Paystack Privacy Policy:
https://paystack.com/privacy

== Installation ==

1. Upload the `quickdonate` plugin folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the WordPress Plugins screen.
3. Open `QuickDonate` in the WordPress admin.
4. Configure your gateway keys, currency, donation amounts, and email settings.
5. Add `[quickdonate_popup]` to any page or post.

== Frequently Asked Questions ==

= What shortcode should I use? =

Use `[quickdonate_popup]`.

Legacy aliases `[paystack_donation_popup]` and `[quickgive_donation_popup]` still work for backward compatibility.

= Does QuickDonate support more than one gateway? =

The plugin is structured for multiple gateways, but this release only includes Paystack as a working gateway.

= Is payment verification done server-side? =

Yes. The transaction reference is verified on the server before a donation is marked as successful and before any thank-you email is sent.

= Does the plugin support preset and custom amounts? =

Yes. You can configure preset amounts and optionally allow donors to enter a custom amount.

= Does it work with Elementor layouts? =

Yes. The modal overlay is moved to `document.body` to avoid being trapped inside Elementor containers with overflow or transform stacking contexts.

== Changelog ==

= 1.2.0 =
* Renamed the plugin from QuickGive to QuickDonate.
* Added gateway abstraction with Paystack as the first supported gateway.
* Added the new `[quickdonate_popup]` shortcode.
* Kept backward-compatible support for `[paystack_donation_popup]` and `[quickgive_donation_popup]`.
* Redesigned the admin settings, overview, and donation log pages.
* Redesigned the frontend donation popup and button styles.
* Fixed Elementor modal containment by relocating overlays to `document.body`.
* Added gateway tracking to donation logs and summary views.

== Upgrade Notice ==

= 1.2.0 =
QuickDonate automatically migrates legacy settings from `quickgive_settings` and upgrades legacy donation tables where needed.
