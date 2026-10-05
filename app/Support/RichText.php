<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

class RichText
{
    /** @var list<string> */
    private const ALLOWED_TAGS = ['p', 'br', 'h2', 'h3', 'h4', 'strong', 'b', 'em', 'i', 'u', 'ul', 'ol', 'li', 'blockquote', 'a'];

    public static function clean(string $html): string
    {
        $document = new DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="UTF-8"><div id="editor-root">'.$html.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);
        $root = $document->getElementById('editor-root');

        if (! $root instanceof DOMElement) {
            return '';
        }

        self::sanitizeChildren($root);
        $cleaned = '';

        foreach ($root->childNodes as $child) {
            $cleaned .= $document->saveHTML($child);
        }

        return trim($cleaned);
    }

    private static function sanitizeChildren(DOMNode $parent): void
    {
        foreach (iterator_to_array($parent->childNodes) as $child) {
            if ($child instanceof DOMElement) {
                $tag = strtolower($child->tagName);

                if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                    if (in_array($tag, ['script', 'style', 'iframe', 'object', 'svg', 'math'], true)) {
                        $parent->removeChild($child);
                    } else {
                        while ($child->firstChild !== null) {
                            $parent->insertBefore($child->firstChild, $child);
                        }

                        $parent->removeChild($child);
                    }

                    continue;
                }

                $href = $tag === 'a' ? $child->getAttribute('href') : '';

                foreach (iterator_to_array($child->attributes) as $attribute) {
                    $child->removeAttribute($attribute->name);
                }

                if ($tag === 'a') {
                    if (preg_match('/^(https?:\/\/|mailto:|tel:|#)/i', $href) === 1) {
                        $child->setAttribute('href', $href);
                        $child->setAttribute('rel', 'noopener noreferrer');
                    }
                }

                self::sanitizeChildren($child);
            } elseif ($child->nodeType !== XML_TEXT_NODE) {
                $parent->removeChild($child);
            }
        }
    }
}
