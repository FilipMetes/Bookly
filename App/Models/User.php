<?php

namespace App\Models;

use Framework\Core\IIdentity;
use Framework\DB\Connection;
use Exception;

class User implements IIdentity
{
    public ?int $id = null;
    public string $name = '';
    public string $surname = '';
    public ?string $city = null;
    public ?string $PSC = null; // postal code
    public ?string $street = null;
    public string $e_mail = '';
    public string $password = '';
    public string $role = 'U'; // default role: U (user)

    public function __construct(array $data = [])
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : null;
        $this->name = $data['name'] ?? '';
        $this->surname = $data['surname'] ?? '';
        $this->city = $data['city'] ?? null;
        $this->PSC = $data['PSC'] ?? null;
        $this->street = $data['street'] ?? null;
        $this->e_mail = $data['e_mail'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->role = $data['role'] ?? 'U';
    }

    /**
     * Create a new user record (password will be hashed before storing)
     * Returns created User instance.
     * Throws Exception on DB error.
     */
    public static function create(array $data): self
    {
        if (empty($data['e_mail'])) {
            throw new Exception('Email is required');
        }
        if (empty($data['password'])) {
            throw new Exception('Password is required');
        }

        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $conn = Connection::getInstance();
        $stmt = $conn->prepare(
            "INSERT INTO users (name, surname, city, PSC, street, e_mail, password, role) VALUES (:name, :surname, :city, :psc, :street, :email, :password, :role)"
        );
        $params = [
            ':name' => $data['name'] ?? '',
            ':surname' => $data['surname'] ?? '',
            ':city' => $data['city'] ?? null,
            ':psc' => $data['PSC'] ?? null,
            ':street' => $data['street'] ?? null,
            ':email' => $data['e_mail'],
            ':password' => $hash,
            ':role' => $data['role'] ?? 'U'
        ];
        $stmt->execute($params);
        $id = (int)$conn->lastInsertId();
        return new self([
            'id' => $id,
            'name' => $params[':name'],
            'surname' => $params[':surname'],
            'city' => $params[':city'],
            'PSC' => $params[':psc'],
            'street' => $params[':street'],
            'e_mail' => $params[':email'],
            'password' => $hash,
            'role' => $params[':role']
        ]);
    }

    public static function findByEmail(string $email): ?self
    {
        $conn = Connection::getInstance();
        $stmt = $conn->prepare("SELECT id, name, surname, city, PSC, street, e_mail, password, role FROM users WHERE e_mail = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$row) return null;
        return new self([
            'id' => $row['id'],
            'name' => $row['name'],
            'surname' => $row['surname'],
            'city' => $row['city'],
            'PSC' => $row['PSC'],
            'street' => $row['street'],
            'e_mail' => $row['e_mail'],
            'password' => $row['password'],
            'role' => $row['role']
        ]);
    }

    public static function findById(int $id): ?self
    {
        $conn = Connection::getInstance();
        $stmt = $conn->prepare("SELECT id, name, surname, city, PSC, street, e_mail, password, role FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$row) return null;
        return new self([
            'id' => $row['id'],
            'name' => $row['name'],
            'surname' => $row['surname'],
            'city' => $row['city'],
            'PSC' => $row['PSC'],
            'street' => $row['street'],
            'e_mail' => $row['e_mail'],
            'password' => $row['password'],
            'role' => $row['role']
        ]);
    }

    /**
     * Verify a raw password against stored hash
     */
    public function verifyPassword(string $raw): bool
    {
        return password_verify($raw, $this->password);
    }

    // --- Getters and setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getPSC(): ?string
    {
        return $this->PSC;
    }

    public function setPSC(?string $PSC): void
    {
        $this->PSC = $PSC;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    public function getEmail(): string
    {
        return $this->e_mail;
    }

    public function setEmail(string $email): void
    {
        $this->e_mail = $email;
    }

    /**
     * Returns hashed password (do not expose raw password)
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set password (raw password will be hashed automatically)
     */
    public function setPassword(string $rawPassword): void
    {
        $this->password = password_hash($rawPassword, PASSWORD_DEFAULT);
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * Update user fields (simple partial update)
     */
    public function update(array $data): void
    {
        $conn = Connection::getInstance();
        $fields = [];
        $params = [':id' => $this->id];

        $allowed = ['name', 'surname', 'city', 'PSC', 'street', 'e_mail', 'role'];
        foreach ($allowed as $f) {
            if (array_key_exists($f, $data)) {
                $fields[] = "{$f} = :{$f}";
                $params[":{$f}"] = $data[$f];
                $this->{$f} = $data[$f];
            }
        }
        if (isset($data['password']) && $data['password'] !== '') {
            $fields[] = "password = :password";
            $params[':password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $this->password = $params[':password'];
        }

        if (empty($fields)) return;

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
    }
}
