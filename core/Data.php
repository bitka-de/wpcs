<?php

declare(strict_types=1);

/*
Diese Klasse ist dazu gedacht, das wiederholte Laden und Dekodieren von JSON-Dateien zu kapseln
und eine einfache Methode bereitzustellen, um die Daten als Array zu erhalten.  

Example usage:
$categories = Data::fromJsonFile(DATA_PATH . 'tags.json')->toArray();
$article = Data::fromJsonFile(DATA_PATH . 'article.json')->toArray();
*/

class Data
{
  private function __construct(private mixed $data) {}

  // Statische Methode zum Erstellen einer Instanz aus einer JSON-Datei
  public static function fromJsonFile(string $filePath): self
  {
    // Lade und dekodiere JSON-Datei
    if (!is_file($filePath)) throw new RuntimeException("File does not exist: $filePath");
    $content = file_get_contents($filePath);
    // Überprüfe, ob die Datei erfolgreich gelesen wurde
    if ($content === false) throw new RuntimeException("Could not read file: $filePath");
    // Dekodiere JSON-Inhalt
    $data = json_decode($content, true);
    // Überprüfe auf JSON-Dekodierungsfehler
    if (json_last_error() !== JSON_ERROR_NONE) throw new RuntimeException(
      sprintf("Could not decode JSON from file '%s': %s", $filePath, json_last_error_msg())
    );

    // Erstelle und gib eine neue Instanz zurück
    return new self($data);
  }

  // Gib die Daten als Array zurück
  public function toArray(): array
  {
    // Stelle sicher, dass die Daten ein Array sind
    if (!is_array($this->data) && $this->data !== null) throw new RuntimeException("Data is neither an array nor null");
    // Gib die Daten als Array zurück (null wird zu einem leeren Array)
    return ($this->data === null) ? [] : $this->data;
  }
}
