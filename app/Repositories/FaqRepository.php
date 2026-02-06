<?php

declare(strict_types=1);

namespace App\Repositories;

final class FaqRepository extends BaseRepository
{
    public function all(): array
    {
        $sql = 'SELECT f.id, f.question, f.answer, c.name AS category
            FROM faqs f LEFT JOIN faq_categories c ON c.id = f.category_id
            ORDER BY f.id DESC';
        $stmt = $this->pdo()->query($sql);
        return $stmt->fetchAll() ?: [];
    }

    public function categories(): array
    {
        $stmt = $this->pdo()->query('SELECT * FROM faq_categories ORDER BY name');
        return $stmt->fetchAll() ?: [];
    }

    public function create(int $categoryId, string $question, string $answer): void
    {
        $stmt = $this->pdo()->prepare('INSERT INTO faqs (category_id, question, answer) VALUES (:category_id, :question, :answer)');
        $stmt->execute([
            'category_id' => $categoryId,
            'question' => $question,
            'answer' => $answer,
        ]);
    }
}
