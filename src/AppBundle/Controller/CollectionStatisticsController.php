<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;

class CollectionStatisticsController extends Controller
{
    /**
     * @Sensio\Template
     * @return array
     * @Sensio\Cache(expires="+1 hour", public=true)
     */
    public function dailyAction()
    {
        /** @var \Doctrine\CouchDB\CouchDBClient $dm */
        $conn = $this->get('doctrine_couchdb.client.default_connection');
        $settings = array(
          'title' => 'Daily',
          'body' => 'Count of items per day for last week.',
        );
        $query = $conn->createViewQuery('timeseries', 'published');

        $query->setStale('ok');
        $query->setLimit(7);
        $query->setDescending(true);
        $query->setReduce(true);
        $query->setGroup(true);
        $query->setGroupLevel(3);

        if ($query) {
            $date_key = 0;
            $format = 'M-d-Y';
            foreach ($query->execute() as $result) {
                $date = date($format, mktime(
                  isset($result['key'][$date_key + 3]) ? $result['key'][$date_key + 3] : 0,
                  isset($result['key'][$date_key + 4]) ? $result['key'][$date_key + 4] : 0,
                  isset($result['key'][$date_key + 5]) ? $result['key'][$date_key + 5] : 0,
                  isset($result['key'][$date_key + 1]) ? $result['key'][$date_key + 1] : 0,
                  isset($result['key'][$date_key + 2]) ? $result['key'][$date_key + 2] : 0,
                  isset($result['key'][$date_key]) ? $result['key'][$date_key] : 0
                ));
                if ($date_key > 0) {
                    $results[$result['key'][0]][$date] = $result['value'];
                } else {
                    $results[$date] = $result['value'];
                }
            }
        }

        return array(
          'query'     => $query,
          'results'   => $results,
          'settings'  => $settings,
        );
    }

    /**
     * @Sensio\Template("AppBundle:CollectionStatistics:daily.html.twig")
     *
     * @return array
     * @Sensio\Cache(expires="+1 hour", public=true)
     */
    public function hourlyAction()
    {
        /** @var \Doctrine\CouchDB\CouchDBClient $dm */
        $conn = $this->get('doctrine_couchdb.client.default_connection');
        $settings = array(
          'title' => 'Hourly',
          'body' => 'Count of items per hour for last 24 hours.',
        );
        $query = $conn->createViewQuery('timeseries', 'published');

        if ($query) {
            $query->setStale('ok');
            $query->setLimit(24);
            $query->setDescending(true);
            $query->setReduce(true);
            $query->setGroup(true);
            $query->setGroupLevel(4);

            $date_key = 0;
            $format = 'H:i';
            foreach ($query->execute() as $result) {
                $date = date($format, mktime(
                  isset($result['key'][$date_key + 3]) ? $result['key'][$date_key + 3] : 0,
                  isset($result['key'][$date_key + 4]) ? $result['key'][$date_key + 4] : 0,
                  isset($result['key'][$date_key + 5]) ? $result['key'][$date_key + 5] : 0,
                  isset($result['key'][$date_key + 1]) ? $result['key'][$date_key + 1] : 0,
                  isset($result['key'][$date_key + 2]) ? $result['key'][$date_key + 2] : 0,
                  isset($result['key'][$date_key]) ? $result['key'][$date_key] : 0
                ));
                if ($date_key > 0) {
                    $results[$result['key'][0]][$date] = $result['value'];
                } else {
                    $results[$date] = $result['value'];
                }
            }
        }

        return array(
          'query'     => $query,
          'results'   => $results,
          'settings'  => $settings,
        );
    }

    /**
     * @Sensio\Template
     * @return array
     */
    public function collectionAction()
    {
        $map = $this->container->getParameter('bangpound_castle.types');
        /** @var \Doctrine\CouchDB\CouchDBClient $dm */
        $conn = $this->get('doctrine_couchdb.client.default_connection');
        $settings = array(
          'title' => 'Collections',
          'body' => 'Count of items in each collection.',
        );
        $query = $conn->createViewQuery('collection', 'timeseries');
        $query->setGroup(true);
        $query->setStale('ok');

        $results = array();
        foreach ($query->execute() as $result) {
            $results[] = [
              'key' => $result['key'][0],
              'label' => isset($map[$result['key'][0]]) ? $map[$result['key'][0]] : $result['key'][0],
              'value' => $result['value'],
            ];
        }

        return array(
          'query'     => $query,
          'results'   => $results,
          'settings'  => $settings,
        );
    }

    /**
     * @Sensio\Template("AppBundle:CollectionStatistics:language.html.twig")
     * @return array
     */
    public function languageAction()
    {
        /** @var \Doctrine\CouchDB\CouchDBClient $dm */
        $conn = $this->get('doctrine_couchdb.client.default_connection');
        $start = new \DateTime('-1 month');
        $end = new \DateTime();
        $settings = array(
          'title' => 'Languages',
          'body' => 'Collected from '.$start->format('n M').' to '.$end->format('n M'),
        );
        $query = $conn->createViewQuery('tags', 'lang');
        $query->setGroup(true);
        $query->setStale('ok');
        $query->setGroupLevel(1);

        $map = $this->languagesArrayAction();

        $results = array();
        foreach ($query->execute() as $result) {
            $results[] = [
              'key' => $result['key'],
              'label' => isset($map[$result['key']]) ? $map[$result['key']] : $result['key'],
              'value' => $result['value'],
            ];
        }

        return array(
          'query'     => $query,
          'results'   => $results,
          'settings'  => $settings,
        );
    }

    /**
     * @Sensio\Template
     * @Sensio\ParamConverter("start", options={"format": "Y-m-d"})
     * @Sensio\ParamConverter("end", options={"format": "Y-m-d"})
     * @return array
     */
    public function topTagAction(\DateTime $start, \DateTime $end, $title, $body = '')
    {
        /** @var \Doctrine\CouchDB\CouchDBClient $dm */
        $conn = $this->get('doctrine_couchdb.client.default_connection');
        $settings = array(
          'title' => $title,
          'body' => $body,
        );

        $startKey = array((int) $start->format('Y'), (int) $start->format('m'), (int) $start->format('d'));
        $endKey = array((int) $end->format('Y'), (int) $end->format('m'), (int) $end->format('d'));

        /**
         * @var \Doctrine\CouchDB\View\Query $query
         */
        $query = $conn->createViewQuery('tags', 'timeseries');
        $query->setStale('ok');
        $query->setLimit(10);
        $query->setGroup(true);
        $query->setGroupLevel(6);
        $query->setStartKey($startKey);
        $query->setEndKey($endKey);
        $query->setDescending(true);

        $results = array();

        foreach ($query->execute() as $result) {
            $results[$result['key'][5]] = $result['value'];
        }


        return array(
          'query'     => $query,
          'results'   => $results,
          'settings'  => $settings,
        );
    }

    public function languagesArrayAction()
    {
        return array(
          'aa' => 'Afar',
          'ab' => 'Abkhaz',
          'ae' => 'Avestan',
          'af' => 'Afrikaans',
          'ak' => 'Akan',
          'am' => 'Amharic',
          'an' => 'Aragonese',
          'ar' => 'Arabic',
          'as' => 'Assamese',
          'av' => 'Avaric',
          'ay' => 'Aymara',
          'az' => 'Azerbaijani',
          'ba' => 'Bashkir',
          'be' => 'Belarusian',
          'bg' => 'Bulgarian',
          'bh' => 'Bihari',
          'bi' => 'Bislama',
          'bm' => 'Bambara',
          'bn' => 'Bengali',
          'bo' => 'Tibetan Standard, Tibetan, Central',
          'br' => 'Breton',
          'bs' => 'Bosnian',
          'ca' => 'Catalan; Valencian',
          'ce' => 'Chechen',
          'ch' => 'Chamorro',
          'co' => 'Corsican',
          'cr' => 'Cree',
          'cs' => 'Czech',
          'cu' => 'Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic',
          'cv' => 'Chuvash',
          'cy' => 'Welsh',
          'da' => 'Danish',
          'de' => 'German',
          'dv' => 'Divehi; Dhivehi; Maldivian;',
          'dz' => 'Dzongkha',
          'ee' => 'Ewe',
          'el' => 'Greek, Modern',
          'en' => 'English',
          'eo' => 'Esperanto',
          'es' => 'Spanish; Castilian',
          'et' => 'Estonian',
          'eu' => 'Basque',
          'fa' => 'Persian',
          'ff' => 'Fula; Fulah; Pulaar; Pular',
          'fi' => 'Finnish',
          'fj' => 'Fijian',
          'fo' => 'Faroese',
          'fr' => 'French',
          'fy' => 'Western Frisian',
          'ga' => 'Irish',
          'gd' => 'Scottish Gaelic; Gaelic',
          'gl' => 'Galician',
          'gn' => 'GuaranÃ­',
          'gu' => 'Gujarati',
          'gv' => 'Manx',
          'ha' => 'Hausa',
          'he' => 'Hebrew (modern)',
          'hi' => 'Hindi',
          'ho' => 'Hiri Motu',
          'hr' => 'Croatian',
          'ht' => 'Haitian; Haitian Creole',
          'hu' => 'Hungarian',
          'hy' => 'Armenian',
          'hz' => 'Herero',
          'ia' => 'Interlingua',
          'id' => 'Indonesian',
          'ie' => 'Interlingue',
          'ig' => 'Igbo',
          'ii' => 'Nuosu',
          'ik' => 'Inupiaq',
          'io' => 'Ido',
          'is' => 'Icelandic',
          'it' => 'Italian',
          'iu' => 'Inuktitut',
          'ja' => 'Japanese (ja)',
          'jv' => 'Javanese (jv)',
          'ka' => 'Georgian',
          'kg' => 'Kongo',
          'ki' => 'Kikuyu, Gikuyu',
          'kj' => 'Kwanyama, Kuanyama',
          'kk' => 'Kazakh',
          'kl' => 'Kalaallisut, Greenlandic',
          'km' => 'Khmer',
          'kn' => 'Kannada',
          'ko' => 'Korean',
          'kr' => 'Kanuri',
          'ks' => 'Kashmiri',
          'ku' => 'Kurdish',
          'kv' => 'Komi',
          'kw' => 'Cornish',
          'ky' => 'Kirghiz, Kyrgyz',
          'la' => 'Latin',
          'lb' => 'Luxembourgish, Letzeburgesch',
          'lg' => 'Luganda',
          'li' => 'Limburgish, Limburgan, Limburger',
          'ln' => 'Lingala',
          'lo' => 'Lao',
          'lt' => 'Lithuanian',
          'lu' => 'Luba-Katanga',
          'lv' => 'Latvian',
          'mg' => 'Malagasy',
          'mh' => 'Marshallese',
          'mi' => 'Maori',
          'mk' => 'Macedonian',
          'ml' => 'Malayalam',
          'mn' => 'Mongolian',
          'mr' => 'Marathi',
          'ms' => 'Malay',
          'mt' => 'Maltese',
          'my' => 'Burmese',
          'na' => 'Nauru',
          'nb' => 'Norwegian Bokmål',
          'nd' => 'North Ndebele',
          'ne' => 'Nepali',
          'ng' => 'Ndonga',
          'nl' => 'Dutch',
          'nn' => 'Norwegian Nynorsk',
          'no' => 'Norwegian',
          'nr' => 'South Ndebele',
          'nv' => 'Navajo, Navaho',
          'ny' => 'Chichewa; Chewa; Nyanja',
          'oc' => 'Occitan',
          'oj' => 'Ojibwe, Ojibwa',
          'om' => 'Oromo',
          'or' => 'Oriya',
          'os' => 'Ossetian, Ossetic',
          'pa' => 'Panjabi, Punjabi',
          'pi' => 'Pali',
          'pl' => 'Polish',
          'ps' => 'Pashto, Pushto',
          'pt' => 'Portuguese',
          'qu' => 'Quechua',
          'rm' => 'Romansh',
          'rn' => 'Kirundi',
          'ro' => 'Romanian, Moldavian, Moldovan',
          'ru' => 'Russian',
          'rw' => 'Kinyarwanda',
          'sa' => 'Sanskrit',
          'sc' => 'Sardinian',
          'sd' => 'Sindhi',
          'se' => 'Northern Sami',
          'sg' => 'Sango',
          'si' => 'Sinhala, Sinhalese',
          'sk' => 'Slovak',
          'sl' => 'Slovene',
          'sm' => 'Samoan',
          'sn' => 'Shona',
          'so' => 'Somali',
          'sq' => 'Albanian',
          'sr' => 'Serbian',
          'ss' => 'Swati',
          'st' => 'Southern Sotho',
          'su' => 'Sundanese',
          'sv' => 'Swedish',
          'sw' => 'Swahili',
          'ta' => 'Tamil',
          'te' => 'Telugu',
          'tg' => 'Tajik',
          'th' => 'Thai',
          'ti' => 'Tigrinya',
          'tk' => 'Turkmen',
          'tl' => 'Tagalog',
          'tn' => 'Tswana',
          'to' => 'Tonga (Tonga Islands)',
          'tr' => 'Turkish',
          'ts' => 'Tsonga',
          'tt' => 'Tatar',
          'tw' => 'Twi',
          'ty' => 'Tahitian',
          'ug' => 'Uighur, Uyghur',
          'uk' => 'Ukrainian',
          'ur' => 'Urdu',
          'uz' => 'Uzbek',
          've' => 'Venda',
          'vi' => 'Vietnamese',
          'vo' => 'Volapük',
          'wa' => 'Walloon',
          'wo' => 'Wolof',
          'xh' => 'Xhosa',
          'yi' => 'Yiddish',
          'yo' => 'Yoruba',
          'za' => 'Zhuang, Chuang',
          'zh' => 'Chinese',
          'zu' => 'Zulu',
        );
    }
}
