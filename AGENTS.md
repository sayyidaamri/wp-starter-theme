# Rules for AI agents building on wp-starter-theme

This repo is a template for dynamic WordPress themes. A build prompt names a **mode** (Clone or Own version) and one or more **reference repos** (static HTML/CSS/JS sites under github.com/sayyidaamri).

## Always
1. Create a new repo from this template and rename the theme (`style.css` header, text domain `starter`, function prefix `starter_`, folder name).
2. Clone every reference repo and read its real markup, CSS and JS first.
3. Keep this structure:
   - **CPTs, taxonomies, custom fields, seed content** → `inc/config.php` only. Registration, meta boxes, REST and `wp starter seed` follow automatically.
   - **Site-wide copy** (hero, contact, CTA, social) → `inc/customizer.php` schema; read with `starter_opt( 'key', 'fallback' )`.
   - **Each reference section** → one file in `template-parts/sections/`, called from a template with `starter_section( 'name', $args )`.
   - **Repeating items** (services, team, projects, FAQ, testimonials) → a CPT, queried with `WP_Query`; never hard-code lists.
   - **Design tokens** → `:root` in `assets/css/main.css` (copy the reference variables first); extra CSS/JS as new files enqueued in `inc/enqueue.php`.
   - **Layouts**: `front-page.php` (section order), `page.php`, `single.php` / `single-{cpt}.php`, `index.php` / `archive-{cpt}.php`.
4. No hard-coded copy in templates: every visible string comes from the Customizer, a CPT, post content, or a translatable fallback (`__()`).
5. Escape all output (`esc_html`, `esc_url`, `esc_attr`, `wp_kses_post`) and sanitize all input.
6. Run `php -l` on every PHP file. If WordPress is available, activate the theme, run `wp starter seed`, and check the front page, an archive and a single entry.
7. Log every asset in `ASSETS.md`. Deliver a zipped theme plus install steps (WordPress cannot run on Vercel).

## Mode: Clone
- Rebuild the reference site 1:1 as a WordPress theme: **same layout, sections, motion, copy, images, video, audio and pages**.
- Copy the reference assets into `assets/` and put the reference copy into seed content and Customizer defaults, so the activated theme matches the reference exactly.
- Change only the technical structure. Do not redesign, rename or rewrite anything.

## Mode: Own version
- Build an original theme from the brief, reusing each reference repo's structure and engine for its role.
- Replace the reference identity: brand, copy, logo, images, locations, prices.
- Assets: photos from Unsplash, video from Pexels or Mixkit, sound from Mixkit, Freesound (CC0) or Pixabay. Sound never autoplays and has a visible toggle.
- Note in the README which patterns came from which reference repo.
