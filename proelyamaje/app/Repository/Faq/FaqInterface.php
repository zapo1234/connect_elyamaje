<?php

namespace App\Repository\Faq;

interface FaqInterface
{
    public function getAllFaqs();

    public function deleteQuestion($id);

    public function updateFaqs($data);

    public function insertQuestion($tab_insert);
}
