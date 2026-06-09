# Shortcode

Primary shortcode:

```text
[quickdonate_popup]
```

Backward-compatible aliases:

```text
[paystack_donation_popup]
[quickgive_donation_popup]
```

Behavior:

- Renders the donate button in place
- Opens a full-screen modal overlay
- Moves the modal overlay to `document.body` in JavaScript to avoid layout containment issues
- Supports multiple shortcode instances on one page
