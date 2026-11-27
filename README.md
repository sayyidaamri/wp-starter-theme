# wp-starter-theme

Lean, dynamic classic WordPress theme for production builds. Use it as a **GitHub template**, then port a reference design into it (rules in `AGENTS.md`).

Built as a slimmed-down alternative to heavier boilerplates such as [WP Rig](https://github.com/wprig/wprig) and [Sage](https://github.com/roots/sage): no build step, no Composer, plain PHP templates that any WordPress host can run.

## What makes it fast to build on

- **One config file for content types.** Add a CPT, its taxonomies, fields and demo entries in `inc/config.php`; registration, REST, admin meta box and seeding follow automatically.
- **Site-wide copy in the Customizer.** Hero, contact, CTA and social links live under *Appearance → Customize → Site options* and are read with `starter_opt()`.
- **Sections as template parts.** `front-page.php` is just an ordered list of `starter_section()` calls.
- **WP-CLI seed.** `wp starter seed` creates Home/About/Contact, sets the front page, builds the primary menu and adds demo CPT entries.
- **ACF-ready.** Field groups save to `/acf-json` if you prefer ACF; meta keys stay the same.
- Organization JSON-LD (skipped when Yoast or Rank Math is active), accessible header and mobile menu, reveal-on-scroll that respects reduced motion.

## Install

1. Download the repo as a zip (or `git clone` into `wp-content/themes/`).
2. *Appearance → Themes → Add New → Upload*, then activate.
3. Optional: `wp starter seed` for demo content.
4. Fill *Appearance → Customize → Site options* and set menus under *Appearance → Menus*.

Local development: [LocalWP](https://localwp.com), [wp-env](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/) or [DDEV](https://ddev.com).

## Structure

```
style.css               Theme header
functions.php           Loads inc/*
inc/
  config.php            CPTs, taxonomies, fields, seed content  ← edit this
  post-types.php        Registers CPTs + taxonomies from config
  meta.php              register_post_meta + native meta box + ACF JSON paths
  customizer.php        Site options schema (hero, contact, CTA, social)
  helpers.php           starter_opt(), starter_field(), starter_section(), starter_whatsapp_url()
  enqueue.php           CSS/JS with filemtime cache busting
  setup.php             Theme supports, menus, image sizes
  schema.php            Organization JSON-LD
  cli.php               wp starter seed
template-parts/
  sections/             hero, cpt-grid, testimonials, cta
  content/card.php      Card for any post type
front-page.php, page.php, single.php, index.php, 404.php, header.php, footer.php
assets/css/main.css     Tokens + styles
assets/js/main.js       Header, mobile menu, reveal
theme.json              Editor palette and fonts
acf-json/               ACF field groups (if used)
```

## Tech suggestions for a real production site

- **Hosting**: managed WordPress (Kinsta, WP Engine, Cloudways, SiteGround) with staging; or Hostinger for small budgets.
- **SEO**: Rank Math or Yoast for sitemaps and meta; the theme's own schema switches off automatically.
- **Forms**: Fluent Forms or Gravity Forms, with SMTP (WP Mail SMTP).
- **Performance**: a page cache (LiteSpeed Cache, WP Rocket), image optimisation (ShortPixel, Imagify) and a CDN.
- **Page builder**: if the client wants Elementor, keep CPTs and Customizer options from this theme and build page layouts in Elementor on top.
- **Deployment**: GitHub Actions or WP Pusher to deploy the theme from the repo.
