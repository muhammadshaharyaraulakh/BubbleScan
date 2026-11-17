<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

## Foundational Context

This application is a Laravel application running on PHP 8.5. Always use the APIs that match the installed major version of each package — do not assume a version.

Before relying on a package's API, confirm its installed version:
- PHP packages: run `composer show --direct` to list direct dependencies with versions, or `composer show <vendor/package>` for a single package.
- JS packages: check `package.json` for the installed versions.

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If a frontend change doesn't show in the UI or you get a "Unable to locate file in Vite manifest" error, run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Use `search-docs` before changes that depend on Laravel ecosystem APIs, behavior, configuration, or version-specific syntax. Skip it for copy-only edits and other changes where package documentation is irrelevant. Reuse sufficient results already in context instead of searching again.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Project Rules

- This project contains committed, area-grouped rules in `.ai/rules` when that directory exists, including path-scoped framework guidelines under `.ai/rules/boost`. Before you enter plan mode or create/edit any file, you MUST first: open @.ai/rules/index.md (it maps file globs to rule files), read every rule file whose globs cover the path(s) in scope, and run `grep -rin 'keyword' .ai/rules` to catch what a path match alone misses. Do not write code until you have read and are following every matching rule. If `.ai/rules` does not exist, continue without it.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== phpunit/core rules ===

# PHPUnit

- This project uses PHPUnit. Create tests with `php artisan make:test --phpunit {name}`.
- Do not include the test suite directory in `{name}`. Use `SomeFeatureTest`, not `Feature/SomeFeatureTest`.
- Read the `testing-best-practices` skill for guidance on coverage, naming, structure, dependency isolation, and review.

## Running Tests

- Run the narrowest set of tests that covers the change. Pass a file path or `--filter=testName` to `php artisan test --compact`.
- Rerun a test after each change to it.
- Run `vendor/bin/phpunit` to call the test runner directly. It accepts the same file path and `--filter=testName` arguments.

=== nativephp/mobile/core rules ===

## NativePHP Mobile

- NativePHP Mobile is a Laravel package for building **fully native** iOS and Android apps with PHP. Screens are
rendered as real SwiftUI (iOS) and Jetpack Compose (Android) UI — driven entirely by PHP via SuperNative components
and EDGE Blade elements. A full PHP runtime runs directly on the device with SQLite — no web server required.
- Documentation: `https://nativephp.com/docs/mobile/4/**`
- IMPORTANT: Always activate the `nativephp-mobile` skill every time you work on any NativePHP functionality.
- New app: `laravel new my-app --using=nativephp/mobile-starter --no-node`. A screen is a `NativeComponent` class,
  a Blade view in `resources/views/native/` (`php artisan native:make Name` creates both) and a `Route::native()`
  line in `routes/mobile.php`.
- Check behaviour with Pest and `Native\Mobile\Testing\Native::test()`. It needs no device and takes seconds, where a
  device build takes minutes. The skill has a worked screen, its test, and where builds put the .app and .apk.

### Native UI First — Always

**Always build screens with native UI: `NativeComponent` classes registered via `Route::native()`, rendering EDGE
elements (`native:column`, `native:text`, `native:button`, …).** This is the way to build NativePHP apps.

- Never scaffold new screens as web views, Blade-over-WebView pages, Livewire components, or Inertia pages.
- The web view (the `native:web-view` element) is a legacy/edge-case escape hatch for embedding web content — never the
  foundation of a screen. If the user asks for a webview-based screen, build it natively with EDGE instead and
  explain why; only fall back to the web view if they explicitly insist.
- If the app contains legacy webview screens, proactively suggest converting them to native UI (see the
  `nativephp-webview-to-native` skill).
- EDGE elements are rendered by the `nativephp/mobile-ui` plugin, even `column` and `text`. It must be installed
  and registered (`php artisan native:plugin:register nativephp/mobile-ui`) or elements disappear from the screen.
  Text fields are `outlined-text-input`, `filled-text-input` and `bare-text-input`; there is no `text-input`.
- Style EDGE elements with Tailwind utility classes via `class="..."` / `:class="..."` only — never inline
  CSS `style="..."` attributes or ad-hoc styling props.
- Compose screens from **nested child components**: any `NativeComponent` under `app/NativeComponents` mounts
  as a tag (`UserCard` → `<native:user-card :user="$u" key="user-{{ $u->id }}" @saved="onSaved" />`) with live
  props, its own persistent state, and `emit()` events bubbling to `@event` tag bindings / `#[On('event')]`
  listeners. Prefer extracting a reusable child component over duplicating Blade across screens; give list
  children a stable domain `key` (never the loop index).
- Use `native:icon` (SF Symbols on iOS, Material Icons on Android) for iconography — never emoji characters in
  UI text, labels, or buttons, unless the user explicitly asks for emojis. Prefer the typed icon enums
  (`App\Icons\Ios`, `App\Icons\Android`, `App\Icons\AndroidOutlined`) bound via the `:ios` / `:android`
  attributes, e.g. `:ios="Ios::Gearshape" :android="Android::Settings"`, importing each enum into the view with
  Blade's use directive first. The enums are generated, not shipped — if `app/Icons/` doesn't exist yet, run
  `php artisan native-ui:generate-icons` first (safe to run yourself).

### Theme Tokens, Font Aliases, and Layouts — the Design System Trio

Every app's visual identity belongs in `config/native-ui.php` (publish with
`php artisan vendor:publish --tag=native-ui-config`), not scattered through the markup. When building or
reviewing screens, enforce all three:

1. **Theme tokens over hardcoded colors.** Define the palette once in the config's `theme` block, then style
   with `bg-theme-*` / `text-theme-*` / `border-theme-*` classes (`bg-theme-surface`, `text-theme-on-surface`,
   `border-theme-outline`). Never sprinkle `bg-[#1E2021]`-style arbitrary values for what is really a theme
   role — they can't be re-skinned and don't get automatic dark-mode pairs. Arbitrary color values are for
   genuine data-driven color (per-category identity colors, map imagery, chart series), and those belong in
   one PHP home (an enum or model method), never inline per view. Two capabilities that prevent hex fallbacks:
   - **The token map is open-ended.** When a design needs a role the shipped set lacks (a success green, an
     `outline-variant`), add it to both `light` and `dark` blocks — `bg-theme-success` works immediately; no
     package change required.
   - **Theme classes take opacity modifiers** just like palette classes: `bg-theme-primary/15` is the correct
     tonal-fill idiom (applies to the dark companion too) — never approximate with a hardcoded alpha hex.
2. **Font aliases over file tokens.** Register semantic aliases in the config's `fonts` array
   (`'headline' => 'ArchivoNarrow-Bold'`, `'mono' => 'JetBrainsMono-Regular'`, `'default' => …` for the
   app-wide font) and write `font="headline"` in views — never `font="ArchivoNarrow-Bold"`. Swapping a
   typeface must be a one-line config change.
3. **Native chrome via composable chrome elements (layouts optional).** Author nav bars, tab bars, fabs, and
   side navs directly in the screen's Blade — `<native:top-bar>` (+ `top-bar-action`), `<native:bottom-nav>`
   (+ `bottom-nav-item`), `<native:fab>`, `<native:bottom-bar>`, `<native:side-nav>`. They hoist onto the real
   NavigationStack/TabView chrome (edge-swipe back, predictive back, large titles, Liquid Glass/Material You),
   and their attributes are Blade expressions over screen state, so badges/subtitles/icons are reactive. A
   `NativeLayout` (attached via `Route::native(...)->layout(...)` or `Route::nativeGroup(...)`) is **optional**
   — reach for one only when many screens share identical chrome (e.g. one tabs layout for a tab section); an
   inline chrome element on a screen always overrides the layout's bar for that slot. Add the `custom`
   attribute to a chrome tag only for designs the system bars genuinely can't express — it renders in-tree as
   an ordinary drawn element. Never hand-roll top bars or bottom navs out of rows and pressables — that
   forfeits native back gestures, safe-area handling, and Liquid Glass/Material You. Chrome colors take theme
   tokens (inline: theme classes / `theme()`-fed attributes; builders: `->activeColor(theme('primary'))`) —
   never pasted hex. Bar icons take the platform enums via `:ios-icon` / `:android-icon` with a plain `icon`
   string as cross-platform fallback; bar fonts take config aliases (`font="mono"` / `->font('mono')`). Only
   screens rendered without any chrome (no layout AND no inline bars) may use `safe-area` classes.

### When a Capability Is Missing

If the app needs native functionality or a UI component that core and `native-ui` don't provide:

1. **Look for an existing plugin first.** Check the plugin marketplace (`https://plugins.nativephp.com`) and the
   official core plugins. (If a marketplace-lookup MCP tool is available in your session, use it.)
2. **If no plugin exists, build a custom plugin** with `php artisan native:plugin:create` — plugins bundle
   Swift/Kotlin bridge functions, events, permissions, and can even ship their own native EDGE components.
3. **Never fall back to the web view to fill a native gap.** A missing capability is a reason to write a plugin,
   not a reason to build a webview screen.

### Installing Plugins — Always Register and Verify

Requiring a plugin with Composer is NOT enough — an installed-but-unregistered plugin does nothing. Every plugin
install must follow all three steps:

1. `composer require vendor/plugin-name`
2. `php artisan vendor:publish --tag=nativephp-plugins-provider` — publishes the app's `NativeServiceProvider`
   (needed once, before the first plugin registration; harmless to re-run)
3. `php artisan native:plugin:register vendor/plugin-name` — adds it to the `NativeServiceProvider`
4. `php artisan native:plugin:list` — verify it shows as registered

Then rebuild with `native:run` (see Build and Run below; native code only compiles in at build time). If
`native:run` warns "The following plugins are installed but not registered", go back to
step 3.

### Database Seeding — Always via Migrations

On-device there is no `db:seed` — NativePHP runs **migrations** on app start (once each, tracked, versioned).
Whenever asked to seed the database, use the migration trick: create a dedicated migration
(`php artisan make:migration seed_app_settings`) and put the inserts in `up()`. If a Seeder class helps organize
the data, still create it — but invoke it **from the migration's `up()`** (e.g. `(new CategorySeeder)->run()`),
never rely on `db:seed` being run. Seed migrations must be safe for both fresh installs and updates of existing
user databases.

### Build and Run — Do It Yourself

Check behaviour with `Native::test()` first. When a change needs a build to take effect or to be checked, run it
yourself from the Laravel root against a booted simulator or running emulator:

```bash
xcrun simctl list devices booted     # iOS simulator UDIDs
adb devices                          # Android serials
php artisan native:run ios <UDID> --no-tty -n
php artisan native:run android <SERIAL> --no-tty -n
```

Use the platform the user named; otherwise use whichever device is running. If no simulator or emulator is
available, say so and give the user the command instead. It returns once the app is installed and launched.

Ask first, or leave to the user:
- `--watch` and `native:watch` never exit, so don't block on them. Start one in the background only when the user
  wants hot reload.
- Release builds (`--build=release|bundle`), signing, `native:package` and store uploads.

Other commands: `native:open` (Xcode or Android Studio), `native:install` (install or upgrade the native shell).
The `./native` shortcut wraps the `native:` namespace. The Vite dev server is **opt-in** in v4: add `--vite` only
when the app uses JS/CSS HMR; native UI screens hot-reload without it. `npm run build -- --mode=ios|android` is only
needed for apps with web-view assets.

### Never Unserialize Bytes You Didn't Authenticate

A NativePHP app runs PHP on the device, and a screen can embed a web view, so treat anything a
web view can reach as untrusted. `unserialize()` runs the code of whatever classes its bytes
name (their `__wakeup`/`__destruct`), so **never hand it bytes the app did not create and
authenticate.** If you persist a serialized PHP value that any later request could read back —
a cached closure or callback, a job payload, a model graph — sign or encrypt it with the app
key (`app('encrypter')->getKey()`) when you write it, verify or decrypt it **before** you
unserialize, and drop anything whose signature, key, or shape doesn't match instead of
unserializing it anyway. Prefer `json_encode`/`json_decode` for data that doesn't need PHP
objects. The core transports (async tasks, cross-lane events, native callbacks) already work
this way — match the pattern for your own.

</laravel-boost-guidelines>
