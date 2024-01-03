<?php

function calculateReadingTime($htmlContent)
{
    $textContent = strip_tags($htmlContent); // Remove HTML tags
    $wordCount = str_word_count($textContent); // Count words in the text

    $averageReadingSpeedPerMinute = 180; // Average reading speed (words per minute)

    $readingTime = ceil($wordCount / $averageReadingSpeedPerMinute);

    return $readingTime;
}

// // Usage example
// $blogContent = $blog->content; // Assume this is your blog content from a rich text editor
// $readingTime = calculateReadingTime($blogContent);
// echo "Estimated reading time: {$readingTime} minute(s)";
