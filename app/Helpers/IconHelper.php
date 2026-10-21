<?php
// ========================================================
// IconHelper - SVG Icons Vectoriales Minimalistas
// Florería Tulisol
// Sustituye emojis para una estética profesional y humana
// ========================================================

class IconHelper {
    public static function render(string $name, int $size = 18, string $class = ''): string {
        $attrs = 'width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather-icon ' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '" style="display:inline-block; vertical-align:middle;"';

        switch ($name) {
            case 'cart':
            case 'bag':
                return '<svg ' . $attrs . '><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>';

            case 'whatsapp':
                return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="currentColor" class="feather-icon ' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '" style="display:inline-block; vertical-align:middle;"><path d="M17.472 14.382c-.301-.15-1.78-.879-2.056-.98-.276-.1-.476-.15-.677.15-.2.301-.777.98-.953 1.18-.175.201-.351.226-.652.075s-1.272-.469-2.423-1.496c-.896-.798-1.501-1.784-1.677-2.085-.175-.301-.019-.464.132-.614.135-.135.301-.351.451-.527.151-.176.201-.301.302-.502.1-.201.05-.376-.025-.527s-.677-1.631-.928-2.234c-.244-.587-.492-.507-.677-.517-.175-.009-.376-.011-.577-.011s-.527.075-.803.376c-.276.301-1.053 1.029-1.053 2.509 0 1.48 1.079 2.909 1.229 3.109.15.201 2.122 3.24 5.141 4.544.718.31 1.279.496 1.716.635.721.23 1.377.197 1.896.12.578-.087 1.78-.727 2.031-1.43.251-.703.251-1.305.176-1.43-.075-.126-.276-.201-.577-.352z"/><path d="M12 2C6.477 2 2 6.477 2 12c0 1.891.526 3.662 1.442 5.18L2 22l4.981-1.307A9.957 9.957 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.143c-1.637 0-3.159-.49-4.437-1.332l-.318-.21-2.955.775.789-2.88-.23-.366A8.106 8.106 0 0 1 3.857 12c0-4.49 3.653-8.143 8.143-8.143s8.143 3.653 8.143 8.143-3.653 8.143-8.143 8.143z"/></svg>';

            case 'truck':
            case 'delivery':
                return '<svg ' . $attrs . '><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>';

            case 'card':
            case 'payment':
                return '<svg ' . $attrs . '><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>';

            case 'mail':
            case 'letter':
                return '<svg ' . $attrs . '><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>';

            case 'pin':
            case 'location':
                return '<svg ' . $attrs . '><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>';

            case 'phone':
                return '<svg ' . $attrs . '><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>';

            case 'clock':
            case 'schedule':
                return '<svg ' . $attrs . '><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>';

            case 'check':
                return '<svg ' . $attrs . '><polyline points="20 6 9 17 4 12"></polyline></svg>';

            case 'alert':
                return '<svg ' . $attrs . '><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>';

            case 'close':
            case 'x':
                return '<svg ' . $attrs . '><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';

            case 'eye':
                return '<svg ' . $attrs . '><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';

            case 'edit':
                return '<svg ' . $attrs . '><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>';

            case 'trash':
                return '<svg ' . $attrs . '><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>';

            case 'plus':
                return '<svg ' . $attrs . '><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>';

            case 'search':
                return '<svg ' . $attrs . '><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>';

            case 'user':
                return '<svg ' . $attrs . '><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>';

            case 'lock':
                return '<svg ' . $attrs . '><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>';

            case 'settings':
            case 'gear':
                return '<svg ' . $attrs . '><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>';

            case 'palette':
                return '<svg ' . $attrs . '><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.93 0 1.65-.75 1.65-1.69 0-.44-.18-.83-.44-1.12a1.64 1.64 0 0 1 1.23-2.8h2c3.05 0 5.56-2.5 5.56-5.55C21.97 6.01 17.46 2 12 2z"></path><circle cx="6.5" cy="11.5" r="1.5"></circle><circle cx="9.5" cy="7.5" r="1.5"></circle><circle cx="14.5" cy="7.5" r="1.5"></circle><circle cx="17.5" cy="11.5" r="1.5"></circle></svg>';

            case 'package':
            case 'box':
                return '<svg ' . $attrs . '><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>';

            case 'menu':
                return '<svg ' . $attrs . '><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>';

            case 'arrow-right':
                return '<svg ' . $attrs . '><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>';

            case 'arrow-left':
                return '<svg ' . $attrs . '><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>';

            case 'refresh':
                return '<svg ' . $attrs . '><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>';

            case 'star':
                return '<svg ' . $attrs . '><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>';

            case 'instagram':
                return '<svg ' . $attrs . '><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>';

            case 'facebook':
                return '<svg ' . $attrs . '><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>';

            case 'tiktok':
                return '<svg ' . $attrs . '><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg>';

            case 'logout':
                return '<svg ' . $attrs . '><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>';

            case 'sparkles':
            case 'flower':
                return '<svg ' . $attrs . '><path d="M12 2l2.4 7.4L22 12l-7.6 2.6L12 22l-2.4-7.4L2 12l7.6-2.6z"></path></svg>';

            case 'dashboard':
                return '<svg ' . $attrs . '><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>';

            case 'tag':
                return '<svg ' . $attrs . '><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>';

            case 'money':
            case 'dollar':
                return '<svg ' . $attrs . '><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>';

            case 'image':
            case 'photo':
                return '<svg ' . $attrs . '><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>';

            case 'globe':
                return '<svg ' . $attrs . '><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>';

            case 'zap':
                return '<svg ' . $attrs . '><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>';

            case 'message':
            case 'chat':
                return '<svg ' . $attrs . '><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>';

            case 'book':
                return '<svg ' . $attrs . '><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>';

            case 'bouquet':
                return '<svg ' . $attrs . '><circle cx="12" cy="6" r="3"></circle><circle cx="6.5" cy="10.5" r="2.5"></circle><circle cx="17.5" cy="10.5" r="2.5"></circle><path d="M12 9v6"></path><path d="M9 21l3-6 3 6"></path><path d="M8 15c1.5 1 2.5 2 4 2s2.5-1 4-2"></path></svg>';

            case 'gift':
                return '<svg ' . $attrs . '><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>';

            case 'crown':
                return '<svg ' . $attrs . '><path d="M2 18h20l-1.5-11-5.5 4.5L12 4l-4.5 7.5L2 7z"></path><path d="M2 21h20"></path></svg>';

            case 'sun':
                return '<svg ' . $attrs . '><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>';

            case 'dove':
                return '<svg ' . $attrs . '><path d="M12 4c-4 1-7 4-8 8 2-1 4-1 6 0-1 2-1 4 0 6 1-2 3-3 5-3 4 0 7-3 7-7-3 0-6-2-8-4h-2z"></path><circle cx="15.5" cy="9.5" r="0.5"></circle></svg>';

            case 'heart':
                return '<svg ' . $attrs . '><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>';

            case 'balloon':
                return '<svg ' . $attrs . '><ellipse cx="12" cy="8" rx="6" ry="7"></ellipse><path d="M12 15v2"></path><path d="M12 17c-1 1-2 2-2 3"></path><path d="M10.5 15.5h3l-1.5 2z"></path></svg>';

            case 'grid':
                return '<svg ' . $attrs . '><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>';

            case 'arrow-up':
                return '<svg ' . $attrs . '><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>';

            case 'arrow-down':
                return '<svg ' . $attrs . '><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>';

            default:
                return '';
        }
    }
}
