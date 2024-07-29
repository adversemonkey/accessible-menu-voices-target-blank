<?php
    /*
    Plugin Name: Wordpress Accessible Menu Voices Target Blank
    Plugin URI:
    Description: add a screen reader only description to menu items that open in a new tab
    Version: 1
    Author: Alessandro Monopoli
    Author URI:
    Disclaimer:
    Text Domain:
    License: GPLv2 or later
    */

    function AMVTB_add_description( $items, $args ) {
        $default_locale = substr(locale_get_default(), 0, 2);
        $srtext = '';

        if (!defined('AMVTB_SRTEXT')) {
            $aTranslations = array(
                'zh' => '（在新窗口中打开）',                          // Chinese (Simplified)
                'zh-tw' => '（在新窗口中打開）',                       // Chinese (Traditional)
                'da' => '(åbner i et nyt vindue)',                  // Danish
                'nl' => '(opent in een nieuw venster)',             // Dutch
                'en' => '(opens in a new window)',                  // English
                'fr' => '(ouvre une nouvelle fenêtre)',             // French
                'de' => '(öffnet ein neues Fenster)',               // German
                'it' => '(apre una nuova finestra)',                // Italian
                'ja' => '（新しいウィンドウが開きます）',                // Japanese
                'ru' => '(открывается в новом окне)',               // Russian
                'es' => '(abre una nueva ventana)',                 // Spanish
                'sq' => '(hapet në një dritare të re)',             // Albanian
                'ar' => '(يفتح في نافذة جديدة)',                    // Arabic
                'hy' => '(բացվում է նոր պատուհանում)',             // Armenian
                'az' => '(yeni pəncərədə açılır)',                  // Azerbaijani
                'eu' => '(leiho berri batean irekitzen da)',        // Basque
                'bn' => '(একটি নতুন উইন্ডোতে খোলে)',                    // Bengali
                'bs' => '(otvara se u novom prozoru)',              // Bosnian
                'bg' => '(отваря се в нов прозорец)',               // Bulgarian
                'ca' => '(s\'obre en una nova finestra)',           // Catalan
                'hr' => '(otvara se u novom prozoru)',              // Croatian
                'cs' => '(otevře se v novém okně)',                 // Czech
                'eo' => '(malfermas en nova fenestro)',             // Esperanto
                'et' => '(avaneb uues aknas)',                      // Estonian
                'fi' => '(avautuu uuteen ikkunaan)',                // Finnish
                'gl' => '(ábrese nunha nova xanela)',               // Galician
                'el' => '(ανοίγει σε νέο παράθυρο)',                // Greek
                'he' => '(נפתח בחלון חדש)',                         // Hebrew
                'hi' => '(एक नई विंडो में खुलता है)',                      // Hindi
                'hu' => '(új ablakban nyílik meg)',                 // Hungarian
                'is' => '(opnast í nýjum glugga)',                  // Icelandic
                'id' => '(terbuka di jendela baru)',                // Indonesian
                'ga' => '(osclaíonn i bhfuinneog nua)',             // Irish
                'ko' => '(새 창에서 열림)',                             // Korean
                'ku' => '(li penceriyeke nû vebike)',               // Kurdish
                'lv' => '(atveras jaunā logā)',                     // Latvian
                'lt' => '(atsidaro naujame lange)',                 // Lithuanian
                'mk' => '(се отвора во нов прозорец)',              // Macedonian
                'ms' => '(dibuka di tetingkap baru)',               // Malay
                'mt' => '(jinfeta f\'tieqa ġdida)',                 // Maltese
                'ro-md' => '(se deschide într-o fereastră nouă)',   // Moldavian
                'mn' => '(шинэ цонхонд нээгдэнэ)',                  // Mongolian
                'ne' => '(नयाँ विन्डोमा खुल्छ)',                           // Nepali
                'nb' => '(åpnes i et nytt vindu)',                  // Norwegian Bokmål
                'fa' => '(در یک پنجره جدید باز می‌شود)',             // Persian
                'pl' => '(otwiera się w nowym oknie)',              // Polish
                'pt-br' => '(abre em uma nova janela)',             // Portuguese (Brazil)
                'pt-pt' => '(abre numa nova janela)',               // Portuguese (Portugal)
                'pa' => '(ਨਵੀਂ ਵਿੰਡੋ ਵਿੱਚ ਖੁੱਲਦਾ ਹੈ)',                        // Punjabi
                'qu' => '(muskipa ñawpaq chawpipi willan)',         // Quechua
                'ro' => '(se deschide într-o fereastră nouă)',      // Romanian
                'sr' => '(отвара се у новом прозору)',              // Serbian
                'sk' => '(otvorí sa v novom okne)',                 // Slovak
                'sl' => '(odpre se v novem oknu)',                  // Slovenian
                'so' => '(waxaa ku furmaya daaqad cusub)',          // Somali
                'sv' => '(öppnas i ett nytt fönster)',              // Swedish
                'ta' => '(புதிய சாளரத்தில் திறக்கிறது)',                  // Tamil
                'th' => '(เปิดในหน้าต่างใหม่)',                         // Thai
                'tr' => '(yeni bir pencerede açılır)',              // Turkish
                'uk' => '(відкривається у новому вікні)',           // Ukrainian
                'ur' => '(نئی ونڈو میں کھلتا ہے)',                  // Urdu
                'uz' => '(yangi oynada ochiladi)',                  // Uzbek
                'vi' => '(mở ra trong một cửa sổ mới)',             // Vietnamese
                'cy' => '(yn agor mewn ffenestr newydd)',           // Welsh
                'yi' => '(עפענען אין אַ נייַ פֿענצטער)',               // Yiddish
                'zu' => '(kuvuleka efasiteleni elisha)'             // Zulu
            );

            if (defined('ICL_LANGUAGE_CODE')) {
                if (array_key_exists(ICL_LANGUAGE_CODE, $aTranslations)) $srtext = $aTranslations[ICL_LANGUAGE_CODE];
            }

            if (empty($srtext)) {
                $srtext = (array_key_exists($default_locale, $aTranslations)) ? $aTranslations[$default_locale] : __($aTranslations['en'],'AMVTB');
            }
        } else {
            if (defined('ICL_LANGUAGE_CODE')) {
                $srtext = __(AMVTB_SRTEXT,'AMVTB');
            } else {
                $srtext = AMVTB_SRTEXT;
            }
        }

        foreach ( $items as $k => $object ) {
            if ($object->target == "_blank") {
                $object->title = $object->title . ' <span class="sr-only AMVTB_sr-only">'.$srtext.'</span>';
            }
        }

        return $items;
    }
    add_filter( 'wp_nav_menu_objects', 'AMVTB_add_description', 10, 2 );

    function AMVTB_style() {
        wp_register_style( 'AMVTB-style', false );
        wp_enqueue_style( 'AMVTB-style' );
        $custom_css = ".AMVTB_sr-only{ position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border-width: 0; }";
        wp_add_inline_style( 'AMVTB-style', $custom_css );
    }
    add_action( 'wp_enqueue_scripts', 'AMVTB_style' );