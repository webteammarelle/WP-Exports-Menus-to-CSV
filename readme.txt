=== Exports Menus to CSV ===
Contributors: Marelle
Tags: menus, csv, export, admin, tools
Requires at least: 6.5
Tested up to: 6.7
Stable tag: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Exports Menus to CSV is a simple plugin that exports all site menus to a CSV file with sanitized columns: menu_name, title, url, order, item_id, parent_id. Access is restricted to administrators.

== Description ==

Exports Menus to CSV adds a tool under the Tools menu in the WordPress admin area. Administrators can click the "Export" button to download a CSV file containing all menus and their items. This plugin is designed for developers and site administrators who need a quick way to export menu data.

Features:
* Exports all registered menus
* Outputs CSV with columns: menu_name, title, url, order, item_id, parent_id
* Restricts access to administrators
* Fully internationalized (includes a languages folder with English and French translations)

== Installation ==

1. Upload the `exports-menus-to-csv` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to **Tools > Export Menus** to access the export feature.

== Frequently Asked Questions ==

= Who can use this plugin? =
This plugin is restricted to administrators only.

= How do I export my menus? =
Simply navigate to **Tools > Export Menus** and click the "Export" button. The CSV file will be downloaded automatically.

== Screenshots ==

1. Admin page with the export button.

== Changelog ==

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.0 =
Initial release of Exports Menus to CSV.

== Localization ==

The plugin is fully internationalized. Translation files for English (en_US) and French (fr_FR) are available in the `languages` folder. The following files are included:
* languages/exports-menus-to-csv.pot
* languages/exports-menus-to-csv-en_US.po
* languages/exports-menus-to-csv-en_US.mo
* languages/exports-menus-to-csv-fr_FR.po
* languages/exports-menus-to-csv-fr_FR.mo
