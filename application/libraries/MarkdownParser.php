<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MarkdownParser {
    public function text($text) {
        // Standardize line breaks
        $text = str_replace(array("\r\n", "\r"), "\n", $text);
        
        // Convert headers
        $text = preg_replace('/^### (.*?)\n/m', '<h3>$1</h3>', $text);
        $text = preg_replace('/^## (.*?)\n/m', '<h2>$1</h2>', $text);
        $text = preg_replace('/^# (.*?)\n/m', '<h1>$1</h1>', $text);

        // Convert code blocks
        $text = preg_replace('/```(.*?)\n(.*?)```/s', '<pre><code>$2</code></pre>', $text);
        
        // Convert inline code
        $text = preg_replace('/`(.*?)`/', '<code>$1</code>', $text);

        // Convert bold
        $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);

        // Convert italic
        $text = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $text);

        // Convert lists
        $text = preg_replace('/^- (.*?)$/m', '<li>$1</li>', $text);
        $text = preg_replace('/((?:<li>.*<\/li>\n)+)/', '<ul>$1</ul>', $text);

        // Convert links
        $text = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2">$1</a>', $text);

        // Convert paragraphs
        $text = preg_replace('/\n\n(.*?)\n\n/', "\n\n<p>$1</p>\n\n", $text);
        
        // Clean up
        $text = trim($text);
        
        return $text;
    }
}