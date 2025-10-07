<?php

declare(strict_types=1);

require_once __DIR__ . '/Data.php';
require_once __DIR__ . '/View.php';

function getHeaderMenu(): array
{
  return Data::fromJsonFile(DATA_PATH . 'header-menu.json')->toArray();
}

function getFooterMenu(): array
{
  return Data::fromJsonFile(DATA_PATH . 'footer-menu.json')->toArray();
}

function isLoggedin(): bool
{
  return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}


function editComponent($file): string
{
  if (!EDIT_MODE) return '';

  $componentPath = realpath($file);

  $needle = 'components' . DIRECTORY_SEPARATOR;
  $pos = stripos($componentPath, $needle);
  if ($pos !== false) {
    $componentPath = substr($componentPath, $pos + strlen($needle));
  } else {
    // Fallback: handle paths with forward slashes or return basename
    $alt = 'components/';
    $pos = stripos($componentPath, $alt);
    if ($pos !== false) {
      $componentPath = substr($componentPath, $pos + strlen($alt));
    } else {
      $componentPath = basename($componentPath);
    }
  }

  // Entferne Dateiendung (z.B. .php, .html) und behalte ggf. Verzeichnisse
  $componentPath = preg_replace('/\.[^\.\/\\\\]+$/', '', $componentPath);




  return '<div class="absolute top-4 right-4 bg-yellow-300 text-yellow-900 px-3 py-1 rounded shadow-md text-sm z-10"> <b class="uppercase">' . htmlspecialchars($componentPath) . '</b></div>';
}


/**
 * Liefert ein Array von Kategorien mit Feldern: name, slug, count.
 *
 * Parameter können entweder bereits dekodierte Arrays sein oder Pfade zu JSON-Dateien,
 * die mit json2array() geladen werden (wie in deinem Projekt).
 *
 * @param array|string $categoriesSource Array oder Pfad zu tags.json
 * @param array|string $articleSource    Array oder Pfad zu article.json
 * @return array<int, array{name:string, slug:string, count:int}>
 */
function getCategorySummary(array|string $categoriesSource, array|string $articleSource): array
{
  // Lade ggf. JSON-Dateien
  if (is_string($categoriesSource)) {
    $categories = is_file($categoriesSource) ? json2array($categoriesSource) : [];
  } else {
    $categories = $categoriesSource;
  }

  if (is_string($articleSource)) {
    $article = is_file($articleSource) ? json2array($articleSource) : [];
  } else {
    $article = $articleSource;
  }

  // Normalizer für Slug/Key
  $normalize = function ($v): string {
    if (is_array($v)) {
      $v = json_encode($v, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    return mb_strtolower(trim((string)$v));
  };

  // Posts robust extrahieren
  $getPosts = function ($article): array {
    foreach (['posts', 'articles', 'data'] as $k) {
      if (isset($article[$k]) && is_array($article[$k])) {
        return $article[$k];
      }
    }
    if (is_array($article) && array_values($article) === $article) {
      return $article;
    }
    return [];
  };

  $posts = $getPosts($article);

  // Zähle Kategorien (ein Post zählt pro Kategorie maximal 1x)
  $categoryCounts = [];

  foreach ($posts as $post) {
    if (!is_array($post)) {
      continue;
    }

    // mögliche Felder prüfen (bereich/area/section/category/categories)
    $raw = $post['bereich'] ?? $post['area'] ?? $post['section'] ?? $post['category'] ?? $post['categories'] ?? null;
    if ($raw === null) {
      continue;
    }

    $found = [];

    if (is_array($raw)) {
      array_walk_recursive($raw, function ($v) use (&$found, $normalize) {
        $s = $normalize($v);
        if ($s !== '') {
          $found[] = $s;
        }
      });
    } else {
      $parts = preg_split('/\s*,\s*/u', (string)$raw, -1, PREG_SPLIT_NO_EMPTY);
      foreach ($parts as $p) {
        $s = $normalize($p);
        if ($s !== '') {
          $found[] = $s;
        }
      }
    }

    foreach (array_unique($found) as $cat) {
      if ($cat === '') {
        continue;
      }
      $categoryCounts[$cat] = ($categoryCounts[$cat] ?? 0) + 1;
    }
  }

  // Ergebnis zusammenstellen: name, slug, count
  $result = [];
  foreach ($categories as $categoryKey => $tagsValue) {
    if (is_array($tagsValue) && array_key_exists('name', $tagsValue)) {
      $categoryName = $tagsValue['name'];
    } elseif (is_string($categoryKey)) {
      $categoryName = $categoryKey;
    } else {
      $categoryName = is_scalar($categoryKey) ? (string)$categoryKey : 'Uncategorized';
    }

    // Verwende vorhandenen Slug aus tags.json, falls vorhanden
    if (is_array($tagsValue) && isset($tagsValue['slug'])) {
      $slug = $tagsValue['slug'];
    } else {
      // Fallback: generiere Slug aus dem Namen
      $identifierSource = is_string($categoryKey) ? $categoryKey : $categoryName;
      $slug = $normalize($identifierSource);
    }

    // Suche die Anzahl mit dem normalisierten Namen (für die Zählung)
    $normalizedName = $normalize($categoryName);
    $count = (int)($categoryCounts[$normalizedName] ?? 0);

    $result[] = [
      'name' => $categoryName,
      'slug' => $slug,
      'count' => $count,
    ];
  }

  return $result;
}
