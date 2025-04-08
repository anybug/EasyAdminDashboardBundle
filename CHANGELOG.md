# 📝 CHANGELOG - EasyAdminDashboardBundle

## [3.0] - 2025-04-04

### ✅ Added
- Compatibilité testée et validée avec Symfony `6.4` et EasyAdmin `4.20+`.
- Ajout d'un système de layout propre (`layout.html.twig`) qui étend le layout d’EasyAdmin, permettant d’afficher un dashboard custom sans casser l’héritage.
- Gestion plus fine des blocs et items dans le dashboard via configuration YAML.
- Injection aisée de la configuration dans le DashboardController via le service `EasyAdminDashboard`.

### 🛠 Fixed
- Correction d’un bug critique : `EmptyNode cannot have children.` lié à une incompatibilité entre EasyAdmin et certaines versions de `symfony/twig-bridge`.
- Utilisation correcte des blocs Twig (`main`, `content_title`, `page_title`) attendus par EasyAdmin.
- Nettoyage du code `Configuration.php` et factorisation du `rootNode`.

### ⚠️ Requirements
- PHP >= 8.1
- Symfony ^6.4
- EasyAdmin >= 4.20
- `symfony/twig-bridge` >= 6.3 recommandé pour éviter les erreurs liées au layout

---

