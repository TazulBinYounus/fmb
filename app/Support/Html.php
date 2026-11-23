<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

/**
 * Whitelist HTML sanitiser for rich-text fields edited in the admin panel.
 * Keeps basic formatting, links and images; removes scripts, styles, event handlers
 * and javascript:/data: URLs.
 */
class Html
{
    private const ALLOWED_TAGS = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'h2', 'h3', 'h4', 'h5', 'ul', 'ol', 'li',
        'a', 'blockquote', 'img', 'table', 'thead', 'tbody', 'tr', 'th', 'td', 'hr', 'span', 'div',
    ];

    private const ALLOWED_ATTRIBUTES = [
        'a' => ['href', 'title', 'target', 'rel'],
        'img' => ['src', 'alt', 'title', 'width', 'height'],
        'td' => ['colspan', 'rowspan'],
        'th' => ['colspan', 'rowspan'],
    ];

    public static function clean(?string $html): ?string
    {
        if ($html === null || trim($html) === '') {
            return null;
        }

        $doc = new DOMDocument;
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="utf-8"?><div id="__root">'.$html.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $root = $doc->getElementById('__root');
        if (! $root) {
            return strip_tags($html);
        }
        self::walk($root);

        $out = '';
        foreach ($root->childNodes as $child) {
            $out .= $doc->saveHTML($child);
        }

        return trim($out);
    }

    private static function walk(DOMNode $node): void
    {
        // Iterate over a static copy because children may be removed/unwrapped.
        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child->nodeType === XML_COMMENT_NODE) {
                $node->removeChild($child);

                continue;
            }
            if (! $child instanceof DOMElement) {
                continue;
            }

            $tag = strtolower($child->tagName);
            if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed', 'form', 'input', 'button', 'textarea', 'select', 'meta', 'link'], true)) {
                $node->removeChild($child);

                continue;
            }

            self::walk($child);

            if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                // Unknown tag: keep its text/children, drop the tag itself.
                while ($child->firstChild) {
                    $node->insertBefore($child->firstChild, $child);
                }
                $node->removeChild($child);

                continue;
            }

            $allowed = self::ALLOWED_ATTRIBUTES[$tag] ?? [];
            foreach (iterator_to_array($child->attributes) as $attr) {
                $name = strtolower($attr->name);
                $value = trim($attr->value);
                $isUrl = in_array($name, ['href', 'src'], true);
                if (! in_array($name, $allowed, true)
                    || ($isUrl && ! preg_match('~^(https?:|mailto:|tel:|/|#|[a-z0-9])~i', $value))
                    || ($isUrl && preg_match('~^\s*(javascript|data|vbscript):~i', $value))) {
                    $child->removeAttribute($attr->name);
                }
            }
            if ($tag === 'a' && $child->getAttribute('target') === '_blank') {
                $child->setAttribute('rel', 'noopener');
            }
        }
    }
}
