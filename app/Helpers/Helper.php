<?php

namespace App\Helpers;

use Carbon\Carbon;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Helper
{
    static function generateTimeSlots()
    {
        $return = [];
        $start = (new Carbon())->setTime(8, 0);
        $stop = (new Carbon())->setTime(22, 0);
        while ($start->lte($stop)){
            $return[$start->format('H:i:s')] = $start->format('H:i');
            $start->addMinutes(30);
        }

        return $return;
    }

    static function strPluralSpanish($word)
    {
        $vocales = ["a", "e", "i", "o", "u", "A", "E", "I", "O", "U"];
        if (ends_with($word, $vocales)) {
            return $word . 's';
        } else {
            return $word . 'es';
        }
    }

    static function strSingularSpanish($word)
    {
        if (ends_with($word, 'es') && !ends_with($word, "tes")) {
            return substr($word, 0, -2);
        } elseif (ends_with($word, 's')) {
            return substr($word, 0, -1);
        } else {
            return $word;
        }
    }

    /**
     * Recibe una variable del tipo float y la convierte en un string con formato de dinero.
     *
     * @param float $value
     *
     * @return float Expresión float convertida a float
     * @throws InvalidArgumentException Lanza una excepción si el parametro no es un float valido
     */
    static function tm($value, $decimals = 2)
    {
        return number_format((float)$value, $decimals, ',', '.');
    }

    /**
     * Recibe un string con formato de dinero ejemplo: 12.000.000,31
     * y retorna una variable del tipo float del numero recibido.
     *
     * @param string $value
     *
     * @return float Numero convertido a float
     */
    static function tf($value)
    {
        if ($value == "") {
            return 0;
        }
        //ya es un float!!!!!!
        if (!str_contains($value, ',')) {
            return $value;
        }
        $value = str_replace('.', '', $value);

        return ((float)str_replace(',', '.', $value));
    }

    public static function getListaMeses()
    {
        $arr = [];
        for ($i = 1; $i <= 12; $i++) {
            $arr[$i] = static::monthToS($i);
        }

        return $arr;
    }

    static function monthToS($numero)
    {
        return trans('meses.' . $numero);
    }

    public static function getRandomColor()
    {
        $arr = [
            'red',
            'blue',
            'green',
            'yellow'
        ];

        return $arr[array_rand($arr, 1)];
    }

    public static function getRandomIcon()
    {
        $arr = [
            'fa-adjust',
            'fa-adn',
            'fa-align-center',
            'fa-align-justify',
            'fa-align-left',
            'fa-align-right',
            'fa-ambulance',
            'fa-anchor',
            'fa-android',
            'fa-angellist',
            'fa-angle-double-down',
            'fa-angle-double-left',
            'fa-angle-double-right',
            'fa-angle-double-up',
            'fa-angle-down',
            'fa-angle-left',
            'fa-angle-right',
            'fa-angle-up',
            'fa-apple',
            'fa-archive',
            'fa-area-chart',
            'fa-arrow-circle-down',
            'fa-arrow-circle-left',
            'fa-arrow-circle-o-down',
            'fa-arrow-circle-o-left',
            'fa-arrow-circle-o-right',
            'fa-arrow-circle-o-up',
            'fa-arrow-circle-right',
            'fa-arrow-circle-up',
            'fa-arrow-down',
            'fa-arrow-left',
            'fa-arrow-right',
            'fa-arrow-up',
            'fa-arrows',
            'fa-arrows-alt',
            'fa-arrows-h',
            'fa-arrows-v',
            'fa-asterisk',
            'fa-at',
            'fa-backward',
            'fa-ban',
            'fa-bar-chart',
            'fa-barcode',
            'fa-bars',
            'fa-bed',
            'fa-beer',
            'fa-behance',
            'fa-behance-square',
            'fa-bell',
            'fa-bell-o',
            'fa-bell-slash',
            'fa-bell-slash-o',
            'fa-bicycle',
            'fa-binoculars',
            'fa-birthday-cake',
            'fa-bitbucket',
            'fa-bitbucket-square',
            'fa-bold',
            'fa-bolt',
            'fa-bomb',
            'fa-book',
            'fa-bookmark',
            'fa-bookmark-o',
            'fa-briefcase',
            'fa-btc',
            'fa-bug',
            'fa-building',
            'fa-building-o',
            'fa-bullhorn',
            'fa-bullseye',
            'fa-bus',
            'fa-buysellads',
            'fa-calculator',
            'fa-calendar',
            'fa-calendar-o',
            'fa-camera',
            'fa-camera-retro',
            'fa-car',
            'fa-caret-down',
            'fa-caret-left',
            'fa-caret-right',
            'fa-caret-square-o-down',
            'fa-caret-square-o-left',
            'fa-caret-square-o-right',
            'fa-caret-square-o-up',
            'fa-caret-up',
            'fa-cart-arrow-down',
            'fa-cart-plus',
            'fa-cc',
            'fa-cc-amex',
            'fa-cc-discover',
            'fa-cc-mastercard',
            'fa-cc-paypal',
            'fa-cc-stripe',
            'fa-cc-visa',
            'fa-certificate',
            'fa-chain-broken',
            'fa-check',
            'fa-check-circle',
            'fa-check-circle-o',
            'fa-check-square',
            'fa-check-square-o',
            'fa-chevron-circle-down',
            'fa-chevron-circle-left',
            'fa-chevron-circle-right',
            'fa-chevron-circle-up',
            'fa-chevron-down',
            'fa-chevron-left',
            'fa-chevron-right',
            'fa-chevron-up',
            'fa-child',
            'fa-circle',
            'fa-circle-o',
            'fa-circle-o-notch',
            'fa-circle-thin',
            'fa-clipboard',
            'fa-clock-o',
            'fa-cloud',
            'fa-cloud-download',
            'fa-cloud-upload',
            'fa-code',
            'fa-code-fork',
            'fa-codepen',
            'fa-coffee',
            'fa-cog',
            'fa-cogs',
            'fa-columns',
            'fa-comment',
            'fa-comment-o',
            'fa-comments',
            'fa-comments-o',
            'fa-compass',
            'fa-compress',
            'fa-connectdevelop',
            'fa-copyright',
            'fa-credit-card',
            'fa-crop',
            'fa-crosshairs',
            'fa-css3',
            'fa-cube',
            'fa-cubes',
            'fa-cutlery',
            'fa-dashcube',
            'fa-database',
            'fa-delicious',
            'fa-desktop',
            'fa-deviantart',
            'fa-diamond',
            'fa-digg',
            'fa-dot-circle-o',
            'fa-download',
            'fa-dribbble',
            'fa-dropbox',
            'fa-drupal',
            'fa-eject',
            'fa-ellipsis-h',
            'fa-ellipsis-v',
            'fa-empire',
            'fa-envelope',
            'fa-envelope-o',
            'fa-envelope-square',
            'fa-eraser',
            'fa-eur',
            'fa-exchange',
            'fa-exclamation',
            'fa-exclamation-circle',
            'fa-exclamation-triangle',
            'fa-expand',
            'fa-external-link',
            'fa-external-link-square',
            'fa-eye',
            'fa-eye-slash',
            'fa-eyedropper',
            'fa-facebook',
            'fa-facebook-official',
            'fa-facebook-square',
            'fa-fast-backward',
            'fa-fast-forward',
            'fa-fax',
            'fa-female',
            'fa-fighter-jet',
            'fa-file',
            'fa-file-archive-o',
            'fa-file-audio-o',
            'fa-file-code-o',
            'fa-file-excel-o',
            'fa-file-image-o',
            'fa-file-o',
            'fa-file-pdf-o',
            'fa-file-powerpoint-o',
            'fa-file-text',
            'fa-file-text-o',
            'fa-file-video-o',
            'fa-file-word-o',
            'fa-files-o',
            'fa-film',
            'fa-filter',
            'fa-fire',
            'fa-fire-extinguisher',
            'fa-flag',
            'fa-flag-checkered',
            'fa-flag-o',
            'fa-flask',
            'fa-flickr',
            'fa-floppy-o',
            'fa-folder',
            'fa-folder-o',
            'fa-folder-open',
            'fa-folder-open-o',
            'fa-font',
            'fa-forumbee',
            'fa-forward',
            'fa-foursquare',
            'fa-frown-o',
            'fa-futbol-o',
            'fa-gamepad',
            'fa-gavel',
            'fa-gbp',
            'fa-gift',
            'fa-git',
            'fa-git-square',
            'fa-github',
            'fa-github-alt',
            'fa-github-square',
            'fa-glass',
            'fa-globe',
            'fa-google',
            'fa-google-plus',
            'fa-google-plus-square',
            'fa-google-wallet',
            'fa-graduation-cap',
            'fa-gratipay',
            'fa-h-square',
            'fa-hacker-news',
            'fa-hand-o-down',
            'fa-hand-o-left',
            'fa-hand-o-right',
            'fa-hand-o-up',
            'fa-hdd-o',
            'fa-header',
            'fa-headphones',
            'fa-heart',
            'fa-heart-o',
            'fa-heartbeat',
            'fa-history',
            'fa-home',
            'fa-hospital-o',
            'fa-html5',
            'fa-ils',
            'fa-inbox',
            'fa-indent',
            'fa-info',
            'fa-info-circle',
            'fa-inr',
            'fa-instagram',
            'fa-ioxhost',
            'fa-italic',
            'fa-joomla',
            'fa-jpy',
            'fa-jsfiddle',
            'fa-key',
            'fa-keyboard-o',
            'fa-krw',
            'fa-language',
            'fa-laptop',
            'fa-lastfm',
            'fa-lastfm-square',
            'fa-leaf',
            'fa-leanpub',
            'fa-lemon-o',
            'fa-level-down',
            'fa-level-up',
            'fa-life-ring',
            'fa-lightbulb-o',
            'fa-line-chart',
            'fa-link',
            'fa-linkedin',
            'fa-linkedin-square',
            'fa-linux',
            'fa-list',
            'fa-list-alt',
            'fa-list-ol',
            'fa-list-ul',
            'fa-location-arrow',
            'fa-lock',
            'fa-long-arrow-down',
            'fa-long-arrow-left',
            'fa-long-arrow-right',
            'fa-long-arrow-up',
            'fa-magic',
            'fa-magnet',
            'fa-male',
            'fa-map-marker',
            'fa-mars',
            'fa-mars-double',
            'fa-mars-stroke',
            'fa-mars-stroke-h',
            'fa-mars-stroke-v',
            'fa-maxcdn',
            'fa-meanpath',
            'fa-medium',
            'fa-medkit',
            'fa-meh-o',
            'fa-mercury',
            'fa-microphone',
            'fa-microphone-slash',
            'fa-minus',
            'fa-minus-circle',
            'fa-minus-square',
            'fa-minus-square-o',
            'fa-mobile',
            'fa-money',
            'fa-moon-o',
            'fa-motorcycle',
            'fa-music',
            'fa-neuter',
            'fa-newspaper-o',
            'fa-openid',
            'fa-outdent',
            'fa-pagelines',
            'fa-paint-brush',
            'fa-paper-plane',
            'fa-paper-plane-o',
            'fa-paperclip',
            'fa-paragraph',
            'fa-pause',
            'fa-paw',
            'fa-paypal',
            'fa-pencil',
            'fa-pencil-square',
            'fa-pencil-square-o',
            'fa-phone',
            'fa-phone-square',
            'fa-picture-o',
            'fa-pie-chart',
            'fa-pied-piper',
            'fa-pied-piper-alt',
            'fa-pinterest',
            'fa-pinterest-p',
            'fa-pinterest-square',
            'fa-plane',
            'fa-play',
            'fa-play-circle',
            'fa-play-circle-o',
            'fa-plug',
            'fa-plus',
            'fa-plus-circle',
            'fa-plus-square',
            'fa-plus-square-o',
            'fa-power-off',
            'fa-print',
            'fa-puzzle-piece',
            'fa-qq',
            'fa-qrcode',
            'fa-question',
            'fa-question-circle',
            'fa-quote-left',
            'fa-quote-right',
            'fa-random',
            'fa-rebel',
            'fa-recycle',
            'fa-reddit',
            'fa-reddit-square',
            'fa-refresh',
            'fa-renren',
            'fa-repeat',
            'fa-reply',
            'fa-reply-all',
            'fa-retweet',
            'fa-road',
            'fa-rocket',
            'fa-rss',
            'fa-rss-square',
            'fa-rub',
            'fa-scissors',
            'fa-search',
            'fa-search-minus',
            'fa-search-plus',
            'fa-sellsy',
            'fa-server',
            'fa-share',
            'fa-share-alt',
            'fa-share-alt-square',
            'fa-share-square',
            'fa-share-square-o',
            'fa-shield',
            'fa-ship',
            'fa-shirtsinbulk',
            'fa-shopping-cart',
            'fa-sign-in',
            'fa-sign-out',
            'fa-signal',
            'fa-simplybuilt',
            'fa-sitemap',
            'fa-skyatlas',
            'fa-skype',
            'fa-slack',
            'fa-sliders',
            'fa-slideshare',
            'fa-smile-o',
            'fa-sort',
            'fa-sort-alpha-asc',
            'fa-sort-alpha-desc',
            'fa-sort-amount-asc',
            'fa-sort-amount-desc',
            'fa-sort-asc',
            'fa-sort-desc',
            'fa-sort-numeric-asc',
            'fa-sort-numeric-desc',
            'fa-soundcloud',
            'fa-space-shuttle',
            'fa-spinner',
            'fa-spoon',
            'fa-spotify',
            'fa-square',
            'fa-square-o',
            'fa-stack-exchange',
            'fa-stack-overflow',
            'fa-star',
            'fa-star-half',
            'fa-star-half-o',
            'fa-star-o',
            'fa-steam',
            'fa-steam-square',
            'fa-step-backward',
            'fa-step-forward',
            'fa-stethoscope',
            'fa-stop',
            'fa-street-view',
            'fa-strikethrough',
            'fa-stumbleupon',
            'fa-stumbleupon-circle',
            'fa-subscript',
            'fa-subway',
            'fa-suitcase',
            'fa-sun-o',
            'fa-superscript',
            'fa-table',
            'fa-tablet',
            'fa-tachometer',
            'fa-tag',
            'fa-tags',
            'fa-tasks',
            'fa-taxi',
            'fa-tencent-weibo',
            'fa-terminal',
            'fa-text-height',
            'fa-text-width',
            'fa-th',
            'fa-th-large',
            'fa-th-list',
            'fa-thumb-tack',
            'fa-thumbs-down',
            'fa-thumbs-o-down',
            'fa-thumbs-o-up',
            'fa-thumbs-up',
            'fa-ticket',
            'fa-times',
            'fa-times-circle',
            'fa-times-circle-o',
            'fa-tint',
            'fa-toggle-off',
            'fa-toggle-on',
            'fa-train',
            'fa-transgender',
            'fa-transgender-alt',
            'fa-trash',
            'fa-trash-o',
            'fa-tree',
            'fa-trello',
            'fa-trophy',
            'fa-truck',
            'fa-try',
            'fa-tty',
            'fa-tumblr',
            'fa-tumblr-square',
            'fa-twitch',
            'fa-twitter',
            'fa-twitter-square',
            'fa-umbrella',
            'fa-underline',
            'fa-undo',
            'fa-university',
            'fa-unlock',
            'fa-unlock-alt',
            'fa-upload',
            'fa-usd',
            'fa-user',
            'fa-user-md',
            'fa-user-plus',
            'fa-user-secret',
            'fa-user-times',
            'fa-users',
            'fa-venus',
            'fa-venus-double',
            'fa-venus-mars',
            'fa-viacoin',
            'fa-video-camera',
            'fa-vimeo-square',
            'fa-vine',
            'fa-vk',
            'fa-volume-down',
            'fa-volume-off',
            'fa-volume-up',
            'fa-weibo',
            'fa-weixin',
            'fa-whatsapp',
            'fa-wheelchair',
            'fa-wifi',
            'fa-windows',
            'fa-wordpress',
            'fa-wrench',
            'fa-xing',
            'fa-xing-square',
            'fa-yahoo',
            'fa-yelp',
            'fa-youtube',
            'fa-youtube-play',
            'fa-youtube-square',
        ];

        return $arr[array_rand($arr, 1)];
    }

    public static function getTiempoString()
    {
        $hour = Carbon::now()->hour;
        if ($hour <= 6 || $hour >= 20) {
            return "noche";
        } elseif ($hour < 16) {
            return "dia";
        } else {
            return "atardecer";
        }
    }

    public static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    static function uploadFileToStorage(UploadedFile $file, $diskName = null)
    {
        $disk = Storage::disk($diskName);
        $today = Carbon::now()->format('Y/m/d/');
        $fileName = str_slug(str_replace('.'.$file->getClientOriginalExtension(), '', $file->getClientOriginalName()));
        while ($disk->exists($today . $fileName)) {
            $fileName = rand(0, 9) . $fileName;
        }
        $fileName = $today . $fileName.'.'.$file->getClientOriginalExtension();
        $disk->put($fileName, file_get_contents($file->getRealPath()));
        return $fileName;
    }
}
