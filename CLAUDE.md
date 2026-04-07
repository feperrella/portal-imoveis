# UQBITZ Hub de Integração Imobiliária

## Plugin Info

- **Slug:** `uqbitz-hub-imoveis`
- **Prefix:** `uqbhi_` (functions, constants, options, CPT, taxonomies, admin slugs, ACF keys)
- **CPT:** `uqbhi_imovel`
- **Taxonomies:** `uqbhi_tipo`, `uqbhi_finalidade`, `uqbhi_cidadebairro`
- **REST namespace:** `uqbhi/v1`
- **Feed URL:** `rest_url('uqbhi/v1/feed')`

## Release Process

When bumping version and releasing a new version (e.g., X.Y.Z):

### 1. Bump version in all files

- `trunk/uqbitz-hub-imoveis.php` → header `Version: X.Y.Z`
- `trunk/uqbitz-hub-imoveis.php` → `define( 'UQBHI_VERSION', 'X.Y.Z' )`
- `trunk/readme.txt` → `Stable tag: X.Y.Z`

### 2. Update changelogs

- `trunk/CHANGELOG.md` — add `## [X.Y.Z] - YYYY-MM-DD` section
- `trunk/readme.txt` — add `= X.Y.Z =` entry under `== Changelog ==` and `== Upgrade Notice ==`

### 3. Copy trunk to tags

```bash
mkdir -p tags/X.Y.Z
cp trunk/* tags/X.Y.Z/
```

### 4. Commit, push, and tag

```bash
git add trunk/ tags/X.Y.Z/
git commit -m "release: vX.Y.Z — <short description>"
git push origin main
git tag vX.Y.Z
git push origin vX.Y.Z
```

### 5. Build the zip

The zip filename must be `uqbitz-hub-imoveis.zip` (**no version number**).
The root directory inside the zip must be `uqbitz-hub-imoveis/` (the plugin slug).

```bash
cd /tmp
rm -rf uqbitz-hub-imoveis uqbitz-hub-imoveis.zip
mkdir uqbitz-hub-imoveis
cp /path/to/tags/X.Y.Z/* uqbitz-hub-imoveis/
zip -r uqbitz-hub-imoveis.zip uqbitz-hub-imoveis/ -x "*.DS_Store"
```

### 6. Create GitHub release

```bash
gh release create vX.Y.Z /tmp/uqbitz-hub-imoveis.zip --title "vX.Y.Z" --notes "release notes here"
```

### 7. Upload to WordPress.org

Go to the WordPress.org plugin page and upload `uqbitz-hub-imoveis.zip`.
