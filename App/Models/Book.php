<?php

namespace App\Models;

use Framework\DB\Connection;
use Exception;

class Book
{
    public ?int $id = null;
    public string $name = '';
    public string $author = '';
    public string $genre = '';
    public string $format = '';
    public ?int $year = null;
    public float $price = 0.0;
    public int $number_availible = 0;
    public ?int $pages = null;
    public ?string $text = null;
    public ?string $sample_path = null;
    public ?string $cover_path = null;

    public function __construct(array $data = [])
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : null;
        $this->name = $data['name'] ?? '';
        $this->author = $data['author'] ?? '';
        $this->genre = $data['genre'] ?? '';
        $this->format = $data['format'] ?? '';
        $this->year = isset($data['year']) && $data['year'] !== null ? (int)$data['year'] : null;
        $this->price = isset($data['price']) ? (float)$data['price'] : 0.0;
        $this->number_availible = isset($data['number_availible']) ? (int)$data['number_availible'] : 0;
        $this->pages = isset($data['pages']) ? (int)$data['pages'] : null;
        $this->text = $data['text'] ?? null;
        $this->sample_path = $data['sample_path'] ?? null;
        $this->cover_path = $data['cover_path'] ?? null;
    }

    /**
     * Create a new book record and return Book instance
     * @param array $data
     * @return self
     * @throws Exception
     */
    public static function create(array $data): self
    {
        if (empty($data['name'])) {
            throw new Exception('Book name is required');
        }

        $conn = Connection::getInstance();
        $stmt = $conn->prepare(
            "INSERT INTO books (name, author, genre, format, year, price, number_availible, pages, text, sample_path, cover_path) VALUES (:name, :author, :genre, :format, :year, :price, :number_availible, :pages, :text, :sample_path, :cover_path)"
        );

        $params = [
            ':name' => $data['name'],
            ':author' => $data['author'] ?? '',
            ':genre' => $data['genre'] ?? '',
            ':format' => $data['format'] ?? '',
            ':year' => $data['year'] ?? null,
            ':price' => $data['price'] ?? 0,
            ':number_availible' => $data['number_availible'] ?? 0,
            ':pages' => $data['pages'] ?? null,
            ':text' => $data['text'] ?? null,
            ':sample_path' => $data['sample_path'] ?? null,
            ':cover_path' => $data['cover_path'] ?? null,
        ];

        $stmt->execute($params);
        $id = (int)$conn->lastInsertId();

        return new self(array_merge($data, ['id' => $id]));
    }

    public static function findById(int $id): ?self
    {
        $conn = Connection::getInstance();
        $stmt = $conn->prepare("SELECT * FROM books WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$row) return null;
        return new self($row);
    }

    public static function findByName(string $name): array
    {
        $conn = Connection::getInstance();
        $stmt = $conn->prepare("SELECT * FROM books WHERE name LIKE :name");
        $stmt->execute([':name' => "%" . $name . "%"]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $r) {
            $result[] = new self($r);
        }
        return $result;
    }

    public function update(array $data): void
    {
        if ($this->id === null) {
            throw new Exception('Cannot update book without id');
        }
        $conn = Connection::getInstance();
        $fields = [];
        $params = [':id' => $this->id];

        $allowed = ['name','author','genre','format','year','price','number_availible','pages','text','sample_path','cover_path'];
        foreach ($allowed as $f) {
            if (array_key_exists($f, $data)) {
                $fields[] = "{$f} = :{$f}";
                $params[":{$f}"] = $data[$f];
                $this->{$f} = $data[$f];
            }
        }

        if (empty($fields)) return;

        $sql = "UPDATE books SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
    }

    public function delete(): void
    {
        if ($this->id === null) {
            throw new Exception('Cannot delete book without id');
        }
        $conn = Connection::getInstance();
        $stmt = $conn->prepare("DELETE FROM books WHERE id = :id");
        $stmt->execute([':id' => $this->id]);
    }

    // Getters / setters

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function setName(string $v): void { $this->name = $v; }
    public function getAuthor(): string { return $this->author; }
    public function setAuthor(string $v): void { $this->author = $v; }
    public function getGenre(): string { return $this->genre; }
    public function setGenre(string $v): void { $this->genre = $v; }
    public function getFormat(): string { return $this->format; }
    public function setFormat(string $v): void { $this->format = $v; }
    public function getYear(): ?int { return $this->year; }
    public function setYear(?int $v): void { $this->year = $v; }
    public function getPrice(): float { return $this->price; }
    public function setPrice(float $v): void { $this->price = $v; }
    public function getNumberAvailible(): int { return $this->number_availible; }
    public function setNumberAvailible(int $v): void { $this->number_availible = $v; }
    public function getPages(): ?int { return $this->pages; }
    public function setPages(?int $v): void { $this->pages = $v; }
    public function getText(): ?string { return $this->text; }
    public function setText(?string $v): void { $this->text = $v; }
    public function getSamplePath(): ?string { return $this->sample_path; }
    public function setSamplePath(?string $v): void { $this->sample_path = $v; }
    public function getCoverPath(): ?string { return $this->cover_path; }
    public function setCoverPath(?string $v): void { $this->cover_path = $v; }

}

