<?php

namespace App\Helpers\Classes;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use GuzzleHttp\TransferStats;
use GuzzleHttp\RequestOptions;
use IvoPetkov\HTML5DOMDocument;
use Illuminate\Support\Facades\Cache;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;

class SEOAnalyzer
{
    private $client = null;
    private $stopWords = [
        //NL
        'we', 'en', 'van', 'een', 'je', 'bij', 'voor', 'het', 'met', 'kan', 'dat', 'in', 'is',  'de', 'of', 'kunnen', 'door', 'alle', 'ons', 'gaan', 'leuke', 'op', 'nu', 'daarnaast',
        'dit',  'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't',  'u', 'v', 'w', 'x', 'y', 'z', 'terecht', 'de', 'la', 'get', 'aan',
        'wij', 'hoe',  'touch', 'enkele', 'te', 'om', 'ook', 'die', 'niet', 'manier', 'naar', 'ontmoet', 'heb', 'deze', 'nog', 'al', 'zijn', 'wel', '-', 'wat', 'wordt',

        //EN
        'able', 'about', 'above', 'abroad', 'according', 'accordingly', 'across', 'actually', 'after', 'afterwards', 'again', 'against', 'ago', 'ahead', 'ain\'t', 'all', 'allow',
        'allows', 'almost', 'alone', 'along', 'alongside', 'already', 'also', 'although', 'always', 'am', 'amid', 'amidst', 'among', 'amongst', 'an', 'and', 'another', 'any', 'anybody',
        'anyhow', 'anyone', 'anything', 'anyway', 'anyways', 'anywhere', 'apart', 'appear', 'appreciate', 'appropriate', 'are', 'aren\'t', 'around', 'as', 'aside', 'ask', 'asking',
        'associated', 'at', 'available', 'away', 'awfully', 'back', 'backward', 'backwards', 'be', 'became', 'because', 'become', 'becomes', 'becoming', 'been', 'before', 'beforehand',
        'begin', 'behind', 'being', 'believe', 'below', 'beside', 'besides', 'best', 'better', 'between', 'beyond', 'both', 'brief', 'but', 'by', 'came', 'can', 'cannot', 'cant', 'can\'t',
        'caption', 'cause', 'causes', 'certain', 'certainly', 'changes', 'clearly', 'c\'mon', 'come', 'comes', 'concerning', 'consequently', 'consider', 'considering', 'contain', 'containing',
        'contains', 'corresponding', 'could', 'couldn\'t', 'course', 'currently', 'dare', 'daren\'t', 'definitely', 'described', 'despite', 'does', 'doesn\'t', 'doing', 'done', 'don\'t',
        'did', 'didn\'t', 'different', 'directly', 'do', 'down', 'downwards', 'during', 'each', 'eight', 'eighty', 'either', 'else', 'elsewhere', 'end', 'ending', 'enough', 'entirely',
        'especially', 'etc', 'even', 'ever', 'evermore', 'every', 'everybody', 'everyone', 'everything', 'everywhere', 'ex', 'exactly', 'example', 'except', 'fairly', 'far', 'farther',
        'few', 'fewer', 'fifth', 'first', 'five', 'followed', 'following', 'follows', 'for', 'found', 'four', 'from', 'forever', 'former', 'formerly', 'forth', 'forward', 'further',
        'furthermore', 'get', 'gets', 'getting', 'given', 'gives', 'go', 'gotten', 'greetings', 'goes', 'going', 'gone', 'got', 'had', 'hadn\'t', 'half', 'happens', 'hardly', 'has',
        'hasn\'t', 'have', 'haven\'t', 'having', 'he', 'he\'d', 'he\'ll', 'hello', 'help', 'hence', 'her', 'here', 'hereafter', 'hereby', 'herein', 'here\'s', 'hereupon', 'hers',
        'herself', 'he\'s', 'hi', 'him', 'himself', 'his', 'hither', 'hopefully', 'how', 'however', 'hudred', 'i\'d', 'if', 'ignored', 'i\'ll', 'i\'m', 'immediate', 'in', 'inc.',
        'indeed', 'indicate', 'indicated', 'indicates', 'inner', 'inside', 'instead', 'into', 'inward', 'is', 'isn\'t', 'it', 'it\'d', 'it\'ll', 'its', 'it\'s', 'itself', 'i\'ve',
        'just', 'keep', 'keeps', 'kept', 'know', 'known', 'knows', 'last', 'lately', 'later', 'latter', 'latterly', 'least', 'less', 'lest', 'let', 'let\'s', 'like', 'liked', 'likely',
        'likewise', 'little', 'look', 'looking', 'looks', 'low', 'lower', 'made', 'mainly', 'make', 'makes', 'many', 'may', 'maybe', 'mayn\'t', 'me', 'mean', 'meantime', 'meanwhile',
        'merely', 'might', 'mine', 'minus', 'miss', 'more', 'moreover', 'most', 'mostly', 'mr', 'mrs', 'much', 'must', 'mustn\'t', 'my', 'myself', 'name', 'namely', 'near', 'nearly',
        'necessary', 'ne', 'needn\'t', 'needs', 'neither', 'never', 'neverf', 'neverless', 'nevertheless', 'new', 'next', 'nine', 'ninety', 'no', 'nobody', 'non', 'none', 'nonetheless',
        'nor', 'normally', 'not', 'nothing', 'notwithstanding', 'novel', 'now', 'nowhere', 'obviously', 'of', 'off', 'often', 'oh', 'ok', 'okay', 'old', 'on', 'once', 'one', 'ones',
        'one\'s', 'only', 'onto', 'opposite', 'or', 'other', 'others', 'otherwise', 'ought', 'oughtn\'t', 'our', 'ours', 'ourselves', 'out', 'outside', 'over', 'overall', 'own',
        'particular', 'particularly', 'past', 'per', 'perhaps', 'placed', 'please', 'plus', 'possible', 'presumably', 'probably', 'provided', 'provides', 'que', 'quite', 'rather',
        'really', 'reasonably', 'recent', 'recently', 'regarding', 'regardless', 'regards', 'relatively', 'respectively', 'right', 'round', 'said', 'same', 'saw', 'say', 'saying',
        'says', 'second', 'secondly', 'see', 'seeing', 'seem', 'seemed', 'seeming', 'seems', 'seen', 'self', 'selves', 'sensible', 'sent', 'serious', 'seriously', 'seven', 'several',
        'shall', 'shan\'t', 'she', 'she\'d', 'she\'ll', 'she\'s', 'should', 'shouldn\'t', 'since', 'six', 'so', 'some', 'somebody', 'someday', 'somehow', 'someone', 'something', 'sometime',
        'sometimes', 'somewhat', 'somewhere', 'soon', 'sorry', 'specified', 'specify', 'specifying', 'still', 'sub', 'such', 'sure', 'take', 'taken', 'taking', 'tell', 'tends', 'than', 'thank',
        'thanks', 'thanx', 'that', 'that\'ll', 'thats', 'that\'s', 'that\'ve', 'the', 'their', 'theirs', 'them', 'themselves', 'then', 'thence', 'there', 'thereafter', 'thereby', 'there\'d',
        'therefore', 'therein', 'there\'ll', 'there\'re', 'theres', 'there\'s', 'thereupon', 'there\'ve', 'these', 'they', 'they\'d', 'they\'ll', 'they\'re', 'they\'ve', 'thing', 'things',
        'think', 'third', 'thirty', 'this', 'thorough', 'thoroughly', 'those', 'though', 'three', 'through', 'throughout', 'thru', 'thus', 'till', 'to', 'together', 'too', 'took', 'toward',
        'towards', 'tried', 'tries', 'truly', 'try', 'trying', 'twice', 'two', 'under', 'underneath', 'undoing', 'unfortunately', 'unless', 'unlike', 'unlikely', 'until', 'unto', 'up', 'upon',
        'upwards', 'us', 'use', 'used', 'useful', 'uses', 'using', 'usually', 'value', 'various', 'versus', 'very', 'via', 'vs', 'vs.', 'want', 'wants', 'was', 'wasn\'t', 'way', 'we', 'we\'d',
        'welcome', 'well', 'we\'ll', 'went', 'were', 'we\'re', 'weren\'t', 'we\'ve', 'what', 'whatever', 'what\'ll', 'what\'s', 'what\'ve', 'when', 'whence', 'whenever', 'where', 'whereafter',
        'whereas', 'whereby', 'wherein', 'where\'s', 'whereupon', 'wherever', 'whether', 'which', 'whichever', 'while', 'whilst', 'whither', 'who', 'who\'d', 'whoever', 'whole', 'who\'ll', 'whom',
        'whomever', 'who\'s', 'whose', 'why', 'will', 'willing', 'wish', 'with', 'within', 'without', 'wonder', 'won\'t', 'would', 'wouldn\'t', 'yes', 'yet', 'you', 'you\'d', 'you\'ll', 'your',
        'you\'re', 'yours', 'yourself', 'yourselves', 'you\'ve', 'zero', '|', '&nbsp;', 'nbsp', '&amp;', 'amp', 'menu', 'version',

        //FA
        'آباد', 'آخ', 'آخر', 'آخرها', 'آخه', 'آدمهاست', 'آرام', 'آرام آرام', 'آره', 'آری', 'آزادانه', 'آسان', 'آسیب پذیرند', 'آشنایند', 'آشکارا', 'آقا', 'آقای', 'آقایان', 'آمد', 'آمدن', 'آمده', 'آمرانه',
        'آن', 'آن گاه', 'آنان', 'آنانی', 'آنجا', 'آنرا', 'آنطور', 'آنقدر', 'آنها', 'آنهاست', 'آنچنان', 'آنچنان که', 'آنچه', 'آنکه', 'آنگاه', 'آن‌ها', 'آهان', 'آهای', 'آور', 'آورد', 'آوردن', 'آورده', 'آوه',
        'آی', 'آیا', 'آید', 'آیند', 'ا', 'اتفاقا', 'اثرِ', 'اجراست', 'احتراما', 'احتمالا', 'احیاناً', 'اخیر', 'اخیراً', 'اری', 'از', 'از آن پس', 'از جمله', 'ازاین رو', 'ازجمله', 'ازش', 'اساسا', 'اساساً', 'است',
        'اسلامی اند', 'اش', 'اشتباها', 'اشکارا', 'اصلا', 'اصلاً', 'اصولا', 'اصولاً', 'اعلام', 'اغلب', 'افزود', 'افسوس', 'اقل', 'اقلیت', 'الا', 'الان', 'البته', 'البتّه', 'الهی', 'الی', 'ام', 'اما', 'امروز', 'امروزه',
        'تعمدا', 'تقریبا', 'تقریباً', 'تلویحا', 'تلویحاً', 'تمام', 'تمام قد', 'تماما', 'تمامشان', 'تمامی', 'تند تند', 'تنها', 'تو', 'توؤماً', 'توان', 'تواند', 'توانست', 'توانستم', 'توانستن', 'توانستند', 'توانسته',
        'و', 'در', 'به', 'از', 'كه', 'مي', 'اين', 'است', 'را', 'با', 'هاي', 'براي', 'آن', 'يك', 'شود', 'شده', 'خود', 'ها', 'كرد', 'شد', 'اي', 'تا', 'كند', 'بر', 'بود', 'گفت', 'نيز', 'وي', 'هم', 'كنند',
        'دارد', 'ما', 'كرده', 'يا', 'اما', 'بايد', 'دو', 'اند', 'هر', 'خواهد', 'او', 'مورد', 'آنها', 'باشد', 'ديگر', 'مردم', 'نمي', 'بين', 'پيش', 'پس', 'اگر',
        'همه', 'صورت', 'يكي', 'هستند', 'بي', 'من', 'دهد', 'هزار', 'نيست', 'استفاده', 'داد', 'داشته', 'راه', 'داشت', 'چه', 'همچنين', 'كردند', 'داده', 'بوده', 'دارند', 'همين', 'ميليون', 'سوي', 'شوند',
        'بيشتر', 'بسيار', 'روي', 'گرفته', 'هايي', 'تواند', 'اول', 'نام', 'هيچ', 'چند', 'جديد', 'بيش', 'شدن', 'كردن', 'كنيم', 'نشان', 'حتي', 'اينكه', 'ولی', 'توسط', 'چنين', 'برخي', 'نه', 'ديروز', 'دوم',
        'درباره', 'بعد', 'مختلف', 'گيرد', 'شما', 'گفته', 'آنان', 'بار', 'طور', 'گرفت', 'دهند', 'گذاري', 'بسياري', 'طي', 'بودند', 'ميليارد', 'بدون', 'تمام', 'كل', 'تر  براساس', 'شدند', 'ترين', 'امروز',
        'باشند', 'ندارد', 'چون', 'قابل', 'گويد', 'ديگري', 'همان', 'خواهند', 'قبل', 'آمده', 'اكنون', 'تحت', 'طريق', 'گيري', 'جاي', 'هنوز', 'چرا', 'البته', 'كنيد', 'سازي', 'سوم', 'كنم', 'بلكه', 'زير',
        'توانند', 'ضمن', 'فقط', 'بودن', 'حق', 'آيد', 'وقتي', 'اش', 'يابد', 'نخستين', 'مقابل', 'خدمات', 'امسال', 'تاكنون', 'مانند', 'تازه', 'آورد', 'فكر', 'آنچه', 'نخست', 'نشده', 'شايد', 'چهار', 'جريان',
        'پنج', 'ساخته', 'زيرا', 'نزديك', 'برداري', 'كسي', 'ريزي', 'رفت', 'گردد', 'مثل', 'آمد', 'ام', 'بهترين', 'دانست', 'كمتر', 'دادن', 'تمامي', 'جلوگيري', 'بيشتري', 'ايم', 'ناشي', 'چيزي', 'آنكه', 'بالا',
        'بنابراين', 'ايشان', 'بعضي', 'دادند', 'داشتند', 'برخوردار', 'نخواهد', 'هنگام', 'نبايد', 'غير', 'نبود', 'ديده', 'وگو', 'داريم', 'چگونه', 'بندي', 'خواست', 'فوق', 'ده', 'نوعي', 'هستيم', 'ديگران', 'همچنان',
        'سراسر', 'ندارند', 'گروهي', 'سعي', 'روزهاي', 'آنجا', 'يكديگر', 'كردم', 'بيست', 'بروز', 'سپس', 'رفته', 'آورده', 'نمايد', 'باشيم', 'گويند', 'زياد', 'خويش', 'همواره', 'گذاشته', 'شش  نداشته', 'شناسي', 'خواهيم',
        'آباد', 'داشتن', 'نظير', 'همچون', 'باره', 'نكرده', 'شان', 'سابق', 'هفت', 'دانند', 'جايي', 'بی', 'جز', 'زیرِ', 'رویِ', 'سریِ', 'تویِ', 'جلویِ', 'پیشِ', 'عقبِ', 'بالایِ', 'خارجِ', 'وسطِ', 'بیرونِ', 'سویِ', 'کنارِ',
        'پاعینِ', 'نزدِ', 'نزدیکِ', 'دنبالِ', 'حدودِ', 'برابرِ', 'طبقِ', 'مانندِ', 'ضدِّ', 'هنگامِ', 'برایِ', 'مثلِ', 'بارة', 'اثرِ', 'تولِ', 'علّتِ', 'سمتِ', 'عنوانِ', 'قصدِ', 'روب', 'جدا', 'کی', 'که', 'چیست', 'هست', 'کجا',
        'کجاست', 'کَی', 'چطور', 'کدام', 'آیا', 'مگر', 'چندین', 'یک', 'چیزی', 'دیگر', 'کسی', 'بعری', 'هیچ', 'چیز', 'جا', 'کس', 'هرگز', 'یا', 'تنها', 'بلکه', 'خیاه', 'بله', 'بلی', 'آره', 'آری', 'مرسی', 'البتّه',
        'لطفاً', 'ّه', 'انکه', 'وقتیکه', 'همین', 'پیش', 'مدّتی', 'هنگامی', 'مان', 'تان', 'تر', 'های', 'باما',
    ];

    private $baseUrl;
    private $domainUrl;
    private $domainname;
    private $redirects = false;
    private $loadtime = 0;
    private $pagesize = 0;
    private $server = null;
    private $encoding = null;
    private $language = null;
    private $pageData = null;
    private $http2 = false;
    private $hsts = false;

    public function __construct($client = null)
    {
        if (null === $client) {
            $this->client = new Client([
                'curl' => guzzleMozCurlOptions(),
                'timeout'  => 10.0,
                'headers'  => [
                    'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                ],
                'verify' => true,
                RequestOptions::ALLOW_REDIRECTS => [
                    'max'             => 10,        // allow at most 10 redirects.
                    'strict'          => true,      // use "strict" RFC compliant redirects.
                    'referer'         => true,      // add a Referer header
                    'protocols'       => ['http', 'https'],
                    'track_redirects' => true,
                ],
            ]);
        } else {
            $this->client = $client;
        }
    }

    public function CheckSSL()
    {
        return new CheckSSL([$this->domainUrl]);
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getUrl()
    {
        return $this->baseUrl;
    }

    public function addStopWords($words)
    {
        $this->stopWords = array_merge($this->stopWords, $words);
    }

    public function setStopWords($words)
    {
        $this->stopWords = $words;
    }

    public function analyze($url, $content = null)
    {
        
        $this->baseUrl = parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST) . '/' . ltrim(parse_url($url, PHP_URL_PATH), '/');
        $this->domainUrl = parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST);
        $this->domainname = parse_url($url, PHP_URL_HOST);

        if ($content === null) {
            $content = $this->getPageContent($url);
            
        }

        // search all plain emails in html.
        $plainEmails = $this->plainTextEmail($content);
        // $analytics = false;
        // if (preg_match("/\bua-\d{4,9}-\d{1,4}\b/i", $content, $matches)) {
        //     $analytics = $matches[0] ?? false;
        // }
        
        $doctype = false;
        if (preg_match("#<!DOCTYPE[ ]+([^ ][^>]+[^ />]+)[ /]*>#i", $content, $matches)) {
            $doctype = $matches[0] ?? false;
        }
        $document = $this->parseHtml($content);
        $contentsize = mb_strlen($content, '8bit');
        $domSize = count($document->getElementsByTagName('*'));

        $headNode = $document->getElementsByTagName('head')->item(0);
        $titleTagCount = count($headNode->getElementsByTagName('title'));
       
        $titleNode = $headNode->querySelector('title');
        $title = null;
        if ($titleNode !== null) {
            $title = $this->getTextContent($titleNode->outerHTML);
        }

        $description = null;
        $descriptionTagCount = 0;
        $metaNodes = $headNode->querySelectorAll('meta');
        foreach ($metaNodes as $node) {
            $attributes = $node->getAttributes();
            if (isset($attributes['name']) && isset($attributes['content']) && strtolower($attributes['name']) === 'description') {
                $description = $attributes['content'];
                $descriptionTagCount++;
            }
        }

        $htmlNodes = $document->querySelectorAll('html');
        foreach ($htmlNodes as $node) {
            $attributes = $node->getAttributes();
            if (isset($attributes['lang'])) {
                $this->language = $attributes['lang'];
            }
        }

        $canonical = '';
        $canonicaltag='';
        $linkNodes = $document->querySelectorAll('link');
        foreach ($linkNodes as $node) {
            $attributes = $node->getAttributes();
            if (isset($attributes['rel']) && isset($attributes['href']) && $attributes['rel'] === 'canonical') {
                $canonical = $attributes['href'];
                $canonicaltag=$attributes['rel'];;
            }
        }

        //Full page result
        $usableSource = $content;
        $usableText = $this->getTextContent($usableSource);

        $htmlTxtRatio = 0;
        if (strlen($usableSource) > 0) {
            $htmlTxtRatio = strlen($usableText) / strlen($usableSource) * 100;
        }
        
        $directorybrowsering = false;
        if ($this->isDirectoryBrowsingEnabled($url) == true) {
        $directorybrowsering = true;
          } else {
            $directorybrowsering = false;
        }

        $fullPageResult = [
            'codeToTxtRatio' => [
                'total_length' => strlen($usableSource),
                'text_length'  => strlen($usableText),
                'ratio'        => $htmlTxtRatio,
            ],
            'word_count'       => $this->countWords($usableText),
            'keywords'         => $this->findKeywords($usableText),
            'longTailKeywords' => $this->getLongTailKeywords($usableText, 4, 2),
            'headers'          => $this->doHeaderResult($document),
            'links'            => $this->doLinkResult($document),
            'images'           => $this->doImageResult($document,$url),
        ];

 
        $CheckSSL = $this->CheckSSL()->check();
        $favicon = $this->getFavicon($headNode,$url);
        $viewport = $this->getViewport($headNode);
        $noindex = $this->checkNoIndex($headNode);
        $charset = $this->getCharset($headNode);
        $structuredData = $this->doStructuredData($document);
        $imageFormats = $this->checkImageFormats($document, $content,$url);
        $httpRequests = $this->countHttpRequests($document,$url);
        $unsafeCOLinks = $this->unsafeCrossOriginLinks($document);
        $social = $this->getSocialMediaLinks($document);
        $mixedContent = $this->searchMixedContent($document);
        $deferJs = $this->deferJavaScript($document);
        $inlineCss = $this->doInlineCSS($document);
        $depricatedtTags = $this->doDeprecatedTags($document);
        $nestedTables = $this->doNestedTablesTest($document);
        $framesets = $this->doFramesetTest($document);
        $hasNotfoundPage = $this->checkNotfoundPage();
        $sitemaps = $this->checkRobotsAndSitemap();
        
        $spfRecord = $this->doSpfCheck();
          
        // $media = $this->mediaquery($url,$document);
        $refresh = $this->getRefresh($headNode);
        // $minifycss = $this->minifycss($document,$url);
        // $minifyjs = $this->minifyjs($document,$url);
        // $imgcaching = $this->imgcaching($document,$url);
        $sitecaching = $this->sitecaching($url);
        $largestcontent = $this->largestcontent($document);
        $flashobj = $this->flashobject($document);
        $googlesiteverification = $this->hasGoogleSiteVerification($document,$url);
        // $getPageSpeedInsights = $this->getPageSpeedInsights($url);
        //  $errosinconsole = $this->errorinconsole($url);
        $savebrowsering = $this->isSafeBrowsing($url);
        $analytics = $this->hasGoogleAnalytics($url);
        // $cdnusage = $this->cdnUsage($document,$url);
       
        $this->pageData = [
            'url'                   => $url,
            'canonical'             => $canonical,
            'canonicaltag'          => $canonicaltag,
            'refreshtag'            => $refresh,
            // 'cssminification'       => $minifycss,
            // 'jsminification'        => $minifyjs,
            // 'imgcaching'            => $imgcaching,
            'sitecaching'            => $sitecaching,
            'largestcontent'            => $largestcontent,
            // 'imgmeta'  => $imgcaching['imgmeta'],
            // 'cdnusage' => $cdnusage,
            'directorybrowsering'    =>   $directorybrowsering,
            // 'jsexecution'        => $getPageSpeedInsights['jsexecution'],
            // 'cls'               => $getPageSpeedInsights['cls'],
            // 'lcp'               => $getPageSpeedInsights['largest-contentful-paint'],
            // 'renderblocking'               => $getPageSpeedInsights['render-blocking-resources'],
            // 'errosinconsole'    => $errosinconsole,
            'savebrowsering' => $savebrowsering,
            // 'mediaquery'            => $media,
            'flashobject'           => $flashobj,
            'baseUrl'               => $this->baseUrl,
            'domainUrl'             => $this->domainUrl,
            'domainname'            => $this->domainname,
            'redirects'             => $this->redirects,
            'doctype'               => $doctype,
            'charset'               => $charset,
            'ssl'                   => $CheckSSL,
            'http2'                 => $this->http2,
            'hsts'                  => $this->hsts,
            'spfRecord'             => $spfRecord,
            'title'                 => $title,
            'googlesiteverification' => $googlesiteverification,
            'titleTagCount'         => $titleTagCount,
            'description'           => $description,
            'descriptionTagCount'   => $descriptionTagCount,
            'language'              => $this->language,
            'loadtime'              => round($this->loadtime, 2),
            'analytics'             => $analytics,
            'server'                => $this->server,
            'encoding'              => $this->encoding,
            'pagesize'              => $this->pagesize,
            'contentsize'           => $contentsize,
            'imageFormats'          => $imageFormats,
            'structuredData'        => $structuredData,
            'viewport'              => $viewport,
            'noindex'               => $noindex,
            'has_404'               => $hasNotfoundPage,
            'mixedContent'          => $mixedContent,
            'sitemaps'              => $sitemaps,
            'favicon'               => $favicon,
            'domsize'               => $domSize,
            'deferJs'               => $deferJs,
            'social'                => $social,
            'plainEmails'           => $plainEmails,
            'httpRequests'          => $httpRequests,
            'unsafeCOLinks'         => $unsafeCOLinks,
            'depricatedtTags'       => $depricatedtTags,
            'nestedTables'          => $nestedTables,
            'framesets'             => $framesets,
            'inlineCss'             => $inlineCss,
            'full_page'             => $fullPageResult,
            
            // 'main_text'             => $this->doMainTextAnalysis($document),
        ];

        return $this;
    }

  
    private function minifycss($document,$baseurl, $lines_per_file = 10)
    {
        $minify = null;
        $css_files = 0;
        $csslinks= [];
        $unminimized_css_files = 0;
        $minimized_css_files = 0;
        $unminimized_css_links = [];
        $minimized_css_links = [];
        
        foreach ($document->getElementsByTagName('link') as $node) {
            if (preg_match('/\bstylesheet\b/', $node->getAttribute('rel'))) {
                 $minify = $this->fixUrl($node->getAttribute('href'));
                 if (preg_match("/cdn/i", $minify)) {
            
            $replacedString = preg_replace('#' . preg_quote($baseurl) . 'cdn#', 'https://cdn', $minify);
            
                 array_push($csslinks, $replacedString);
                $css_files++;
                } else {
     
                 array_push($csslinks, $minify);
                $css_files++;
   
}
            }

        }
        
        
         foreach( $csslinks as $css_file ) {
        $linecount = 0;
// Set the URL of the HTTPS endpoint to check
$url = $css_file;

// Send an HTTP HEAD request to the URL to retrieve the response headers
$headers = get_headers($url, 1);

// Check if the HTTPS endpoint returns a 404 error
if (strpos($headers[0], '404 Not Found') !== false) {

    
    
} else {
       // "Open" the CSS file
       
        if ($this->isMinified($url)) {
       $minimized_css_files++;
            array_push( $minimized_css_links ,$css_file);
} else {
    $unminimized_css_files++;
            array_push( $unminimized_css_links ,$css_file);
}


      
}
    }
    
    
    $cssWithCaching = array();
$cssWithoutCaching = array();

foreach ($csslinks as $cssUrl) {
  if ($this->isCachingEnabled($cssUrl)) {
    $cssWithCaching[] = $cssUrl;
  } else {
    $cssWithoutCaching[] = $cssUrl;
  }
}
 
        
        return [
            'totalcssfiles' => $css_files,
            'totalcsslinks' => $csslinks,
            'minimizedcssfiles' => $minimized_css_files,
            'minimizedcsslinks' =>  $minimized_css_links,
              'unminimizedcssfiles' => $unminimized_css_files,
            'unminimizedcsslinks' =>  $unminimized_css_links,
            'cache' => $cssWithCaching,
            'notcache' => $cssWithoutCaching,

        ];
        
    }
    
    private function largestcontent($document)
    {
      
//  $html = $document->getElementsByTagName('div') ;

// Find all the div elements in the webpage
// $divs =$document->getElementsByTagName('div');

// Initialize variables to store the largest div element and its size
$largestDiv = '';
$largestDivSize = 0;

// Iterate over all the div elements and find the largest one
foreach ($document->getElementsByTagName('p') as $div){
    
    $divSize =$this->countWords($this->getTextContent($div));
    if ($divSize > $largestDivSize) {
    $largestDiv = $this->getTextContent($div);
    $largestDivSize = $divSize;
  }
    // $largestDivSize = $this->countWords($this->getTextContent($div));
    // array_push($largestDiv,$this->getTextContent($div));

}
        return [
            'largestDiv' => $largestDiv,
            'largestDivSize' => $largestDivSize,
        ];
        
    }
    
    private function imgcaching($document,$baseurl)
    {
        $minify = null;
        $img_files = 0;
        $imglinks= [];
        $imgmeta = false;
        
        foreach ($document->getElementsByTagName('img') as $node) {
            if (!empty($node->getAttribute('src'))) {
                 $minify = $this->fixUrl($node->getAttribute('src'));
             if (preg_match("/cdn/i", $minify)) {
            
            $replacedString = preg_replace('#' . preg_quote($baseurl) . 'cdn#', 'https://cdn', $minify);
                array_push($imglinks, $replacedString);
                $img_files++;
                } else {
      array_push($imglinks, $minify);
                $img_files++;
   
}
                // $totalRequests++;
             
            }
        }

    $imgWithCaching = array();
$imgWithoutCaching = array();

foreach ($imglinks as $imgUrl) {
  if ($this->isCachingEnabled($imgUrl)) {
    $imgWithCaching[] = $imgUrl;
  } else {
    $imgWithoutCaching[] = $imgUrl;
  }
}
$pattern = "/\.jpg$/i";
$linecount =0; $lines_per_file = 11;
foreach ($imglinks  as $imageUrl) {
 
if (preg_match($pattern, $imageUrl)) {
$imageData = exif_read_data($imageUrl);}
elseif(preg_match("/\.svg$/i", $imageUrl) ){
$imageData = null;
}
else{
    $imageData = getimagesize($imageUrl);
}
if(is_array($imageData)){
$size = sizeof($imageData);
if($size > 10){
    $imgmeta = true;
      }
    }

}
 
        
        return [
            'totalimgfiles' => $img_files,
            'totalimglinks' => $imglinks,
            'imgmeta'       => $imgmeta,
            'cache' => $imgWithCaching,
            'notcache' => $imgWithoutCaching,

        ];
        
    }
    
    private function sitecaching($url)
    {
      
    
    $Caching ;


  if ($this->isCachingEnabled($url)) {
    $Caching = true;
  } else {
    $Caching= false;
  }

 
        
        return $Caching;
        
    }
    
    private  function isCachingEnabled($url)
    {
  $headers = get_headers($url, 1);
  return isset($headers['Cache-Control']) || isset($headers['Expires']);
}

    private function flashobject($document)
    {
         $flashobject = [];
         
      
        foreach ($document->getElementsByTagName('object') as $node) {
            if ($node->getAttribute('src')) {
                $obj = $node->getAttribute('src');
                array_push($flashobject,$obj);
            }
        }
        
        foreach ($document->getElementsByTagName('embed') as $node) {
            if ($node->getAttribute('src')) {
                $obj = $node->getAttribute('src');
                array_push($flashobject,$obj);
            }
        }

        return $flashobject;
        
    }
    
    private function minifyjs($document,$baseurl, $lines_per_file = 10)
    {
        $minify = null;
        $js_files = 0;
        $jslinks= [];
        $unminimized_js_files = 0;
        $minimized_js_files = 0;
        $unminimized_js_links = [];
        $minimized_js_links = [];
        
        foreach ($document->getElementsByTagName('script') as $node) {
            if ($node->getAttribute('src')) {
              $minify = $this->fixUrl($node->getAttribute('src'));
                if (preg_match("/cdn/i", $minify)) {
            
            $replacedString = preg_replace('#' . preg_quote($baseurl) . 'cdn#', 'https://cdn', $minify);
              array_push($jslinks, $replacedString);
                $js_files++;
                } else {
         array_push($jslinks, $minify);
                $js_files++;
   
}
               
            }
        }
            
        
        
         foreach( $jslinks as $js_file ) {
        $linecount = 0;

// Set the URL of the HTTPS endpoint to check
$url = $js_file;

// Send an HTTP HEAD request to the URL to retrieve the response headers
$headers = get_headers($url, 1);

// Check if the HTTPS endpoint returns a 404 error
if (strpos($headers[0], '404 Not Found') !== false) {

    
    
} else {
        // "Open" the js file
      
        
    if ($this->isMinified($url)) {
      $minimized_js_files++;
            array_push( $minimized_js_links ,$js_file);
} else {
     $unminimized_js_files++;
            array_push( $unminimized_js_links ,$js_file);
}
      
}

  
    }
        
        
    $jsWithCaching = array();
$jsWithoutCaching = array();

foreach ($jslinks as $jsUrl) {
  if ($this->isCachingEnabled($jsUrl)) {
    $jsWithCaching[] = $jsUrl;
  } else {
    $jsWithoutCaching[] = $jsUrl;
  }
}
        return [
            'totaljsfiles' => $js_files,
            'totaljslinks' => $jslinks,
            'minimizedjsfiles' => $minimized_js_files,
            'minimizedjslinks' =>  $minimized_js_links,
              'unminimizedjsfiles' => $unminimized_js_files,
            'unminimizedjslinks' =>  $unminimized_js_links,
             'cache' => $jsWithCaching,
            'notcache' => $jsWithoutCaching,
        ];
        
    }
    
    private function doMainTextAnalysis($document)
    {
        //Usable Node result
        $nodes = $this->parseHtmlIntoBlocks($document);
        $node = null;
        if ($nodes !== null) {
            $node = $this->getWebsiteUsabelNode($nodes);
            if (isset($node['node'])) {
                $node = $node['node'];
                $usableSource = $node->outerHTML;
                $usableText = $this->getTextContent($usableSource);
            } else {
                $node = null;
            }
        }

        if (empty($node)) {
            $node = $document->querySelector('body');
            if ($node === null) {
                $node = $document->querySelector('html');
            }
            if ($node !== null) {
                $usableSource = $node->outerHTML;
                $usableText = $this->getTextContent($usableSource);
            } else {
                $usableSource = '';
                $usableText = '';
            }
        }

        $htmlTxtRatio = 0;
        if (strlen($usableSource) > 0) {
            $htmlTxtRatio = strlen($usableText) / strlen($usableSource) * 100;
        }

        $mainTxtResult = [
            'text'           => $usableText,
            'codeToTxtRatio' => [
                'total_length' => strlen($usableSource),
                'text_length'  => strlen($usableText),
                'ratio'        => $htmlTxtRatio,
            ],
            'word_count'       => $this->countWords($usableText),
            'keywords'         => $this->findKeywords($usableText),
            'longTailKeywords' => $this->getLongTailKeywords($usableText),
            'headers'          => $node !== null ? $this->doHeaderResult($node) : null,
            'links'            => $node !== null ? $this->doLinkResult($node) : null,
            'images'           => $node !== null ? $this->doImageResult($node,$url) : null,
        ];

        return $mainTxtResult;
    }

    public function report()
    {
        if ($this->pageData) {
            $this->pageData['title']  = $this->textTest($this->pageData['title'], config('artisan.seo.page_title_min'), config('artisan.seo.page_title_max'), $this->pageData['titleTagCount']);
            $this->pageData['description']       = $this->textTest($this->pageData['description'], config('artisan.seo.meta_description_min'), 200, $this->pageData['descriptionTagCount']);
            $this->pageData['domsize'] = ['passed' => $this->pageData['domsize'] < 1500 ? true : false, 'domsize' => $this->pageData['domsize']];

            $this->pageData['tests'] = [
                'title' => ['status' => $this->pageData['title']['passed'], 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'description' => ['status' => $this->pageData['description']['passed'], 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'heading' => ['status' => $this->headingTest($this->pageData['full_page']['headers']), 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'keywords' => ['status' => count($this->pageData['full_page']['keywords']) > 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                '404page' => ['status' => $this->pageData['has_404']['has_notfound'], 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'images' => ['status' => ($this->pageData['full_page']['images']['count'] -  $this->pageData['full_page']['images']['count_alt'] == 0) ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'links' => ['status' => $this->pageData['full_page']['links']['internal'] < config('artisan.seo.link_count') ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'language' => ['status' => $this->pageData['language'] != null ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'favicon' => ['status' => $this->pageData['favicon']  != null ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'directorybrowsering' => ['status' => $this->pageData['directorybrowsering']  == false ? true : false, 'priority' => "1", 'label' => "high", 'type' => "others"],
                'savebrowsering' => ['status' => $this->pageData['savebrowsering']  == true ? true : false, 'priority' => "1", 'label' => "high", 'type' => "security"],
                // 'cdnusage' => ['status' =>  empty($this->pageData['cdnusage'] )  ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                'domsize' => ['status' => $this->pageData['domsize']['domsize'] < config('artisan.seo.dom_size') ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                'loadtime' => ['status' => $this->pageData['loadtime'] < config('artisan.seo.load_time') ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                'pagesize' => ['status' => $this->pageData['pagesize'] < config('artisan.seo.page_size') ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                'imageFormats' => ['status' => (count($this->pageData['imageFormats']) ?? 0) == 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                'text_compression' => ['status' => count($this->pageData['encoding']) > 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                'deferJs' => ['status' => count($this->pageData['deferJs']) == 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "others"],
                'httpRequests' => ['status' => $this->pageData['httpRequests']['total_requests'] <= config('artisan.seo.http_requests_limit') ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                'mixedContent' => ['status' => ($this->pageData['mixedContent']['total_requests'] ?? 0) < config('artisan.seo.http_requests_limit') ? true : false, 'priority' => "1", 'label' => "high", 'type' => "security"],
                'ssl' => ['status' => $this->pageData['ssl']['is_valid'], 'priority' => "1", 'label' => "high", 'type' => "security"],
                'plainEmails' => ['status' => count($this->pageData['plainEmails']) > 0 ? false : true, 'priority' => "1", 'label' => "high", 'type' => "security"],
                'httpsEncryption' => ['status' => $this->pageData['ssl']['is_valid'], 'priority' => "1", 'label' => "high", 'type' => "security"],
                'serverSignature' => ['status' => count($this->pageData['server']) <= 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "security"],
                'coLinks' => ['status' => count($this->pageData['unsafeCOLinks'])  <= 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "security"],
                'http2' => ['status' => $this->pageData['http2'], 'priority' => "1", 'label' => "high", 'type' => "security"],
                'hsts' => ['status' => $this->pageData['hsts'], 'priority' => "1", 'label' => "high", 'type' => "security"],
                'flashobject' => ['status' => count($this->pageData['flashobject']) <= 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                'socialTags' => ['status' => (count($this->pageData['structuredData']['og'] ?? []) == 0 || count($this->pageData['structuredData']['twitter'] ?? []) == 0) ? false : true, 'priority' => "1", 'label' => "high", 'type' => "others"],
                'structuredData' => ['status' => count($this->pageData['structuredData']['schema'] ?? []) != 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "others"],
                'viewPort' => ['status' => $this->pageData['viewport']  != null ? true : false, 'priority' => "1", 'label' => "high", 'type' => "others"],
                'charset' => ['status' => $this->pageData['charset']  != null ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'sitemap' => ['status' => count($this->pageData['sitemaps']['sitemaps'] ?? []) != 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'social' => ['status' => count($this->pageData['social']) != 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'contentlength' => ['status' => $this->pageData['full_page']['word_count'] >= config('artisan.seo.content_length') ? true : false, 'priority' => "1", 'label' => "high", 'type' => "others"],
                'inlineCss' => ['status' => count($this->pageData['inlineCss']) == 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                // 'cssminification' => ['status' => count($this->pageData['cssminification']) == 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                // 'jsminification' => ['status' => count($this->pageData['jsminification'])  == 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                // 'imgcaching' => ['status' => count($this->pageData['imgcaching'])  == 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                // 'sitecaching' => ['status' => $this->pageData['sitecaching']  == 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                'depHtml' => ['status' => $this->pageData['depricatedtTags']['total'] == 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'keywords_usage' => ['status' => $this->keywordUsage($this->pageData['full_page']['keywords'])['status'], 'data' => $this->keywordUsage($this->pageData['full_page']['keywords'])['data'], 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'keywords_usage_long' => ['status' => $this->keywordUsage($this->pageData['full_page']['longTailKeywords'])['status'], 'data' => $this->keywordUsageLong($this->pageData['full_page']['longTailKeywords'])['data'], 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'doctype' => ['status' => $this->pageData['doctype'] != null ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                // 'jsexecution' => ['status' => $this->pageData['jsexecution']['score'] == 1 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "others"],
                // 'cls' => ['status' => $this->pageData['cls']['score'] > 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                // 'lcp' => ['status' => $this->pageData['lcp'][0]['score'] > 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                // 'renderblocking' => ['status' => $this->pageData['renderblocking']['score'] != 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                // 'errosinconsole' => ['status' => $this->pageData['errosinconsole']['score'] == 1 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "others"],
                'nestedTables' => ['status' => $this->pageData['nestedTables'] == 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                'framesets' => ['status' => $this->pageData['framesets'] == 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                'canonical' => ['status' => $this->pageData['canonical'] != null ? true : false, 'priority' => "1", 'label' => "high", 'type' => "others"],
                'canonicaltag' => ['status' => $this->pageData['canonicaltag'] != null ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                // 'imgmeta' => ['status' => $this->pageData['imgmeta'] == false ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                'refreshtag' => ['status' => $this->pageData['refreshtag'] == null ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'has_robots_txt' => ['status' => $this->pageData['sitemaps']['has_robots_txt'], 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'nofollow' => ['status' => $this->pageData['full_page']['links']['nofollow'] == 0 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'noindex' => ['status' => empty($this->pageData['noindex']) ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'spfRecord' => ['status' => $this->pageData['spfRecord'] != false ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'analytics' => ['status' => !empty($this->pageData['analytics']) ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'googlesiteverification' => ['status' => !empty($this->pageData['googlesiteverification']) ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                'redirects' => ['status' => count($this->pageData['redirects']) <= 1 ? true : false, 'priority' => "1", 'label' => "high", 'type' => "performance"],
                'is_disallowed' => ['status' => count($this->pageData['sitemaps']['disallowed']) <= 0 ? true : false, 'message' => $this->checkDisallowedMessage(), 'priority' => "1", 'label' => "medium", 'type' => "others"],
                'friendly' => ['status' => $this->pageData['full_page']['links']['friendly'] == 0  ? true : false, 'priority' => "1", 'label' => "high", 'type' => "seo"],
                // 'mediaquery' => ['status' => $this->pageData['mediaquery'] != null ? true : false, 'priority' => "1", 'label' => "high", 'type' => "others"],
            ];

            $this->pageData['test_count'] = $this->countTest($this->pageData['tests'])['total'];
            // $this->pageData['high_test_count'] = $this->countTest($this->pageData['tests'])['high'];
          
            $this->pageData['count_section'] = $this->countTest($this->pageData['tests'])['count_section'];
            $this->pageData['score'] = $this->countTest($this->pageData['tests'])['score'];
        }

        return $this;
    }

    public function get()
    {
        return $this->pageData;
    }

    public function checkDisallowedMessage()
    {
        $message = "";
        if ($this->pageData['sitemaps']['has_robots_txt'] === true) {
            if (count($this->pageData['sitemaps']['disallow_rules']) > 0) {
                $message = __('seo.isdisallowedPassed');
            } else {
                $message = __('seo.isdisallowedFailed');
            }
        } else {
            $message = __('seo.disallowedNoRobot');
        }
        return $message;
    }
    
    private function getRefresh($headNode)
    {
        $Refresh = null;
        foreach ($headNode->getElementsByTagName('meta') as $node) {
            if ($node->getAttribute('http-equiv') == 'refresh') {
                $Refresh = $node->getAttribute('content');
            }
        }

        return $Refresh;
    }
    
    private function doSpfCheck()
    {
        $r = dns_get_record($this->domainname, DNS_TXT);
      if(!empty($r)){
if (preg_match('/v=spf/i',$r[0]['txt'])) {
   return $r[0]??false;
}}
else{
    return false;
}


    }

    private function keywordUsage($keywords)
    {
        $keywords_data = [];

        foreach ($keywords as $key => $keyword) {
            $header_check = false;
            foreach ($this->pageData['full_page']['headers']['tags'] as $headers) {
                if (in_array($key, array_keys($headers['keywords']))) {
                    $header_check = true;
                }
            }
            $keywords_data[$key]['count'] = $keyword;
            $keywords_data[$key]['headers'] = $header_check;
            $keywords_data[$key]['title'] = (in_array($key, array_keys($this->pageData['title']['keywords']))) ? true : false;
            $keywords_data[$key]['description'] = (in_array($key, array_keys($this->pageData['description']['keywords']))) ? true : false;
        }

        $sum = array_sum(array_map(fn ($item) => $item['headers'], $keywords_data))
            + array_sum(array_map(fn ($item) => $item['title'], $keywords_data))
            + array_sum(array_map(fn ($item) => $item['description'], $keywords_data));

        return [
            'data' => $keywords_data,
            'status' => count($keywords_data) > 0 && (($sum / count($keywords_data)) * 100) > 10 ? true : false,
        ];
    }

    private function keywordUsageLong($keywords)
    {
        $keywords_data = [];

        foreach ($keywords as $key => $keyword) {
            $header_check = false;
            foreach ($this->pageData['full_page']['headers']['tags'] as $headers) {
                if (in_array($key, array_keys($headers['longTailKeywords']))) {
                    $header_check = true;
                }
            }
            $keywords_data[$key]['count'] = $keyword;
            $keywords_data[$key]['headers'] = $header_check;
            $keywords_data[$key]['title'] = (in_array($key, array_keys($this->pageData['title']['longTailKeywords']))) ? true : false;
            $keywords_data[$key]['description'] = (in_array($key, array_keys($this->pageData['description']['longTailKeywords']))) ? true : false;
        }
        $sum = array_sum(array_map(fn ($item) => $item['headers'], $keywords_data))
            + array_sum(array_map(fn ($item) => $item['title'], $keywords_data))
            + array_sum(array_map(fn ($item) => $item['description'], $keywords_data));

        return [
            'data' => $keywords_data,
            'status' => count($keywords_data) > 0 && (($sum / count($keywords_data)) * 100) > 50 ? true : false,
        ];
    }

    private function countTest($tests)
    {
        $total = sizeof($tests);
        $passed = 0;
        $failed = 0;
        $high  = 0;
        $medium  = 0;
        $low  = 0;
        $high_passed  = 0;
        $medium_passed  = 0;
        $low_passed  = 0;
         $high_failed  = 0;
        $medium_failed  = 0;
        $low_failed  = 0;
        $total_score = 0;
        $high_total_score = 0;
        $medium_total_score = 0;
        $low_total_score = 0;
        $high_score = 3;
        $low_score = 1;
        $medium_score = 2;

        $count_section = [];
        $count_section['seo']['total'] = 0;
        $count_section['performance']['total'] = 0;
        $count_section['security']['total'] = 0;
        $count_section['others']['total'] = 0;

        $count_section['seo']['failed'] = 0;
        $count_section['performance']['failed'] = 0;
        $count_section['security']['failed'] = 0;
        $count_section['others']['failed'] = 0;
        
        $count_section['seo']['warning'] = 0;
        $count_section['performance']['warning'] = 0;
        $count_section['security']['warning'] = 0;
        $count_section['others']['warning'] = 0;
      

        foreach ($tests as $test) {
            if ($test['status'] === true) {
                $passed++;
            }
            if ($test['status'] === false) {
                $failed++;
            }
            if ($test['priority'] == 1) {
                $high++;
                $total_score += $high_score;
                if ($test['status'] == true) {
                    $high_passed++;
                } else {
                     $high_failed++;
                }
            }
            // if ($test['priority'] == 2) {
            //     $medium++;
            //     $total_score += $medium_score;
            //     if ($test['status'] == true) {
            //         $medium_passed++;
            //     } else {
            //         $medium_failed++;
            //     }
            // }
            // if ($test['priority'] == 3) {
            //     $low++;
            //     $total_score += $low_score;
            //     if ($test['status'] == true) {
            //         $low_passed++;
            //     } else {
            //         $low_failed++;
            //     }
            // }

            switch ($test['type']) {
                case ($test['type'] == 'seo' && $test['label'] == 'high'):
                    $count_section['seo']['total'] += 1;
                    if ($test['priority'] == 1 && $test['status'] == false)  $count_section['seo']['failed']++;
       
                    break;
                case 'performance':
                    $count_section['performance']['total'] += 1;
                    if ($test['priority'] == 1 && $test['status'] == false)  $count_section['performance']['failed']++;
                    
                    break;
                case 'security':
                    $count_section['security']['total'] += 1;
                    if ($test['priority'] == 1 && $test['status'] == false)  $count_section['security']['failed']++;
                  
                    break;
                case 'others':
                    $count_section['others']['total'] += 1;
                    if ($test['priority'] == 1 && $test['status'] == false)  $count_section['others']['failed']++;
                  
                    break;

                default:
                    break;
            }
        }


          $count_section['seo']['passed'] = $count_section['seo']['total'] - $count_section['seo']['failed'];
        $count_section['performance']['passed'] = $count_section['performance']['total'] -  $count_section['performance']['failed'];
        $count_section['security']['passed'] =   $count_section['security']['total']-  $count_section['security']['failed'];
        $count_section['others']['passed'] =   $count_section['others']['total']-  $count_section['others']['failed'];
        
        
        $percentage = round(($passed / $total) * 100, 2);
        $high_percentage = ($failed == 0) ? 0 : round(($high_passed / $total) * 100, 2);
        // $medium_percentage = ($failed == 0) ? 0 : round(($medium_passed / $total) * 100, 2);
        // $low_percentage = ($failed == 0) ? 0 : round(($low_passed / $total) * 100, 2);
        $page_score = $high_total_score + $medium_total_score + $low_total_score;
        $page_percentage = round(($page_score / $total_score) * 100, 0);

        return [
            'total' => ['total' => $total, 'passed' => $passed, 'failed' => $failed, 'percentage' => $percentage],
            'high' => ['total' => $high, 'passed' => $high_passed, 'failed' => $high_failed, 'percentage' => $high_percentage],
            
            'count_section' => $count_section,
            'score' => ['total' => $total_score, 'high' => $high_total_score, 'page_score' => $page_score, 'page_percentage' => $page_percentage],
        ];
    }

    private function headingTest($headings)
    {
        if ($headings['tags']['h1']['count'] != 0) {
            return true;
        }

        return false;
    }

    private function textTest($string, $min, $max, $tagCount = 1, $importance = 'high')
    {
        $passed = true;
        $error = null;
        $length = Str::length($string);
        $keywords = $this->findKeywords($string, 1);
        $longTailKeywords = $this->getLongTailKeywords($string, 2, 1);

        if (!is_null($string)) {
            if ($length < $min || $length > $max) {
                $passed = false;
                $error['Length'] = ['length' => $length, 'min' => $min, 'max' => $max];
            }

            if ($tagCount > 1) {
                $passed = false;
                $error['Tags'] = ['count' => $tagCount];
            }
        } else {
            $passed = false;
            $error['Missing'] = ['status' => true, 'min' => $min, 'max' => $max];
        }

        return compact('string', 'length', 'passed', 'keywords', 'longTailKeywords', 'importance', 'error');
    }

    private function checkImageFormats($document, $pageContent,$baseurl)
    {
        $imageFormats = collect([]);
        // Accepted nextgen formats
        $formats = ['webp', 'avif', 'svg'];
        $urlFormats = ['=webp', '=avif', 'data:image/svg'];
        foreach ($document->getElementsByTagName('img') as $node) {
            if (empty($node->getAttribute('src'))) continue;
            $extension = mb_strtolower(pathinfo($this->fixUrl($node->getAttribute('src')), PATHINFO_EXTENSION));
            
               
            
             if (!in_array($extension, $formats) && !Str::contains($node->getAttribute('src'), $urlFormats)) {
                 
                     if (preg_match("/cdn/i", $node->getAttribute('src'))) {
          
            $imgurl =  preg_replace('#' . preg_quote($baseurl) . '/cdn#', 'https://cdn',  $node->getAttribute('src'));
      
                } else {
    $imgurl = $node->getAttribute('src');
   
}
                 
                 
                $imageFormats->push([
                    'url' => $imgurl,
                    'text' => $node->getAttribute('alt')
                ]);
            }
            
            
            
        }

        return $imageFormats->unique('url')->toArray();
    }

    private function searchMixedContent($document)
    {
        $mixedContent = [];
        $total_requests =  0;
        // Search only if secure URL
        if (Str::startsWith($this->domainUrl, 'https://')) {
            foreach ($document->getElementsByTagName('img') as $node) {
                if (!empty($node->getAttribute('src')) && Str::startsWith($node->getAttribute('src'), 'http://')) {
                    $mixedContent['images'][] = $node->getAttribute('src');
                    $total_requests++;
                }
            }
            foreach ($document->getElementsByTagName('script') as $node) {
                if ($node->getAttribute('src') && Str::startsWith($node->getAttribute('src'), 'http://')) {
                    $mixedContent['javascript'][] = $node->getAttribute('src');
                    $total_requests++;
                }
            }
            foreach ($document->getElementsByTagName('link') as $node) {
                if (preg_match('/\bstylesheet\b/', $node->getAttribute('rel')) && Str::startsWith($node->getAttribute('href'), 'http://')) {
                    $mixedContent['css'][] = $node->getAttribute('href');
                    $total_requests++;
                }
            }
            foreach ($document->getElementsByTagName('source') as $node) {
                if (!empty($node->getAttribute('src')) && Str::startsWith($node->getAttribute('type'), 'video/') && Str::startsWith($node->getAttribute('src'), 'http://')) {
                    $mixedContent['videos'][] = $node->getAttribute('src');
                    $total_requests++;
                }
            }
            foreach ($document->getElementsByTagName('iframe') as $node) {
                if (!empty($node->getAttribute('src')) && Str::startsWith($node->getAttribute('src'), 'http://')) {
                    $mixedContent['iframes'][] = $node->getAttribute('src');
                    $total_requests++;
                }
            }
            foreach ($document->getElementsByTagName('source') as $node) {
                if (!empty($node->getAttribute('src')) && Str::startsWith($node->getAttribute('type'), 'audio/') && Str::startsWith($node->getAttribute('src'), 'http://')) {
                    $mixedContent['audios'][] = $node->getAttribute('src');
                    $total_requests++;
                }
            }
        }

        return [
            'total_requests' => $total_requests,
            'mixedContent' => $mixedContent,
        ];
    }

    private function deferJavaScript($document)
    {
        $deferScripts = [];
        foreach ($document->getElementsByTagName('script') as $node) {
            if ($node->getAttribute('src') && !$node->hasAttribute('defer')) {
                $deferScripts[] = $this->fixUrl($node->getAttribute('src'));
            }
        }

        return $deferScripts;
    }

    private function getSocialMediaLinks($document)
    {
        $socialLinks = [];
        foreach ($document->getElementsByTagName('a') as $node) {
            if (!empty($node->getAttribute('href')) && mb_substr($node->getAttribute('href'), 0, 1) != '#') {
                if (!$this->isInternal($node->getAttribute('href'))) {

                    $socials = ['twitter.com' => 'Twitter', 'www.twitter.com' => 'Twitter', 'fb.com' => 'Facebook', 'facebook.com' => 'Facebook', 'www.facebook.com' => 'Facebook', 'dribbble.com' => 'Dribble', 'www.dribbble.com' => 'Dribble', 'behance.net' => 'Behance', 'www.behance.net' => 'Behance', 'pinterest.com' => 'Pinterest', 'www.pinterest.com' => 'Pinterest', 'instagram.com' => 'Instagram', 'www.instagram.com' => 'Instagram', 'youtube.com' => 'YouTube', 'www.youtube.com' => 'YouTube', 'linkedin.com' => 'LinkedIn', 'www.linkedin.com' => 'LinkedIn'];
                    $host = parse_url($node->getAttribute('href'), PHP_URL_HOST);

                    if (!empty($host) && array_key_exists($host, $socials)) {
                        $socialLinks[$socials[$host]][] = [
                            'url' => $node->getAttribute('href'),
                            'text' => $node->textContent,
                        ];
                    }
                }
            }
        }

        return $socialLinks;
    }

    private function unsafeCrossOriginLinks($document)
    {
        $crossOriginLinks = [];
        foreach ($document->getElementsByTagName('a') as $node) {
            if (!$this->isInternal($this->fixUrl($node->getAttribute('href')))) {
                if ($node->getAttribute('target') == '_blank') {
                    if (!Str::contains(strtolower($node->getAttribute('rel')), 'noopener') && !Str::contains(strtolower($node->getAttribute('rel')), 'nofollow')) {
                        $crossOriginLinks[] = $this->fixUrl($node->getAttribute('href'));
                    }
                }
            }
        }

        return $crossOriginLinks;
    }

    private function countHttpRequests($document,$baseurl)
    {
        $httpRequests = [];
        $totalRequests = 0;
        foreach ($document->getElementsByTagName('img') as $node) {
            if (!empty($node->getAttribute('src'))) {
                if (!preg_match('/\blazy\b/', $node->getAttribute('loading')) && $node->getAttribute('src')) {
                    
                    
                     if (preg_match("/cdn/i", $this->fixUrl($node->getAttribute('src')))) {
            
            $replacedString = preg_replace('#' . preg_quote($baseurl) . 'cdn#', 'https://cdn', $this->fixUrl($node->getAttribute('src')));
             
                    $httpRequests['images'][] = $replacedString;
                    $totalRequests++;
                } else {
     
                
                    $httpRequests['images'][] = $this->fixUrl($node->getAttribute('src'));
                    $totalRequests++;
}
        
                }
            }
        }
        
           foreach ($document->getElementsByTagName('script') as $node) {
            if ($node->getAttribute('src')) {
             
                    
                    
                     if (preg_match("/cdn/i", $this->fixUrl($node->getAttribute('src')))) {
            
            $replacedString = preg_replace('#' . preg_quote($baseurl) . 'cdn#', 'https://cdn', $this->fixUrl($node->getAttribute('src')));
             
                    $httpRequests['javascript'][] = $replacedString;
                    $totalRequests++;
                } else {
     
                
                    $httpRequests['javascript'][] = $this->fixUrl($node->getAttribute('src'));
                    $totalRequests++;
}
        
                
            }
        }
        
      foreach ($document->getElementsByTagName('link') as $node) {
            if (preg_match('/\bstylesheet\b/', $node->getAttribute('rel'))) {
                
                
                 if (preg_match("/cdn/i",$this->fixUrl($node->getAttribute('href')))) {
            
            $replacedString = preg_replace('#' . preg_quote($baseurl) . 'cdn#', 'https://cdn', $this->fixUrl($node->getAttribute('href')));
             
                   
                $httpRequests['css'][] = $replacedString ;
                $totalRequests++;
                } else {
     
                 
                $httpRequests['css'][] = $this->fixUrl($node->getAttribute('href'));
                $totalRequests++;
}
            }
        }   
       
      foreach ($document->getElementsByTagName('audio') as $audioNode) {
            if ($audioNode->getAttribute('preload') != 'none') {
                foreach ($audioNode->getElementsByTagName('source') as $node) {
                    if (!empty($node->getAttribute('src')) && Str::startsWith($node->getAttribute('type'), 'audio/')) {
                        
                        
                         if (preg_match("/cdn/i", $this->fixUrl($node->getAttribute('src')))) {
            
            $replacedString = preg_replace('#' . preg_quote($baseurl) . 'cdn#', 'https://cdn', $this->fixUrl($node->getAttribute('src')));
                
                        $httpRequests['audios'][] = $replacedString;
                        $totalRequests++;
                } else {
     
                   
                        $httpRequests['audios'][] = $this->fixUrl($node->getAttribute('src'));
                        $totalRequests++;
}
          
                    }
                }
            }
        }
       foreach ($document->getElementsByTagName('video') as $videoNode) {
            if ($videoNode->getAttribute('preload') != 'none') {
                foreach ($videoNode->getElementsByTagName('source') as $node) {
                    if (!empty($node->getAttribute('src')) && Str::startsWith($node->getAttribute('type'), 'video/')) {
                        
                        
                        
                         if (preg_match("/cdn/i", $this->fixUrl($node->getAttribute('src')))) {
            
            $replacedString = preg_replace('#' . preg_quote($baseurl) . 'cdn#', 'https://cdn', $this->fixUrl($node->getAttribute('src')));
              $httpRequests['videos'][] =  $replacedString;
                        $totalRequests++;
                } else {
      $httpRequests['videos'][] = $this->fixUrl($node->getAttribute('src'));
                        $totalRequests++;
}
          
                       
                    }
                }
            }
        }
        foreach ($document->getElementsByTagName('iframe') as $node) {
            if (!empty($node->getAttribute('src'))) {
                if (!preg_match('/\blazy\b/', $node->getAttribute('loading')) && $node->getAttribute('src')) {
                    
                    
                     if (preg_match("/cdn/i", $this->fixUrl($node->getAttribute('src')))) {
            
            $replacedString = preg_replace('#' . preg_quote($baseurl) . 'cdn#', 'https://cdn', $this->fixUrl($node->getAttribute('src')));
               
                    $httpRequests['iframes'][] =$replacedString;
                    $totalRequests++;
                } else {
       
                    $httpRequests['iframes'][] = $this->fixUrl($node->getAttribute('src'));
                    $totalRequests++;
}
                }
            }
        }
        return [
            'total_requests' => $totalRequests,
            'requests' => $httpRequests,
        ];
    }

    private function getViewport($headNode)
    {
        $viewport = null;
        foreach ($headNode->getElementsByTagName('meta') as $node) {
            if (strtolower($node->getAttribute('name')) == 'viewport') {
                $viewport = $node->getAttribute('content');
            }
        }

        return $viewport;
    }

    // private function getcanonical($headNode)
    // {
    //     $canonical = null;
    //     foreach ($headNode->getElementsByTagName('link') as $node) {
    //         if (strtolower($node->getAttribute('rel')) == 'canonical') {
    //             $canonical = $node->getAttribute('content');
    //         }
    //     }

    //     return $canonical;
    // }

    private function plainTextEmail($httpContents)
    {
        $plainEmails = [];
        $httpContents = strip_tags($httpContents);
        preg_match_all('/([\w+\.]*\w+@[\w+\.]*\w+[\w+\-\w+]*\.\w+)/is', $httpContents, $matches);

        if (isset($matches[0])) {
            $plainEmails = array_filter($matches[0], function ($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL);
            });
        }

        return $plainEmails;
    }

    private function getFavicon($headNode,$baseurl)
    {
        $favicon = null;
        foreach ($headNode->getElementsByTagName('link') as $node) {
            if (preg_match('/\bicon\b/i', $node->getAttribute('rel'))) {
                $favicon = $this->fixUrl($node->getAttribute('href'));
                    if (preg_match("/cdn/i", $favicon)) {
            
            $replacedString = preg_replace('#' . preg_quote($baseurl) . 'cdn#', 'https://cdn', $favicon);
                return $replacedString;
                } else {
       return $favicon;
   
}
            }
        }

       
    }

    private function checkRobotsAndSitemap()
    {
        $sitemaps = null;
        $cacheKey = md5($this->domainUrl) . Str::random(3) . "-robots";
        $cacheKeys = md5($this->domainUrl) . Str::random(3) . "-ads";
        $disallowRules = [];
        $isDisallowed = [];
        $robotsResponse = Cache::rememberForever($cacheKey, function () {
            $robotsUrl =  Str::of($this->domainUrl)->finish('/')->finish('robots.txt')->toString();
            try {
                $robotsRequest = $this->client->get($robotsUrl);
                $robotsResponse = $robotsRequest->getBody()->getContents();

                return $robotsResponse;
            } catch (\Exception $e) {
            }
        });

        $adsResponse = Cache::rememberForever($cacheKeys, function () {
            $adsUrl =  Str::of($this->domainUrl)->finish('/')->finish('Ads.txt')->toString();
            try {
                $adsRequest = $this->client->get($adsUrl);
                $adsResponse = $adsRequest->getBody()->getContents();

                return $adsResponse;
            } catch (\Exception $e) {
            }
        });

        if ($robotsResponse) {
            if (Str::contains($robotsResponse, 'Sitemap:')) {
                preg_match_all('/Sitemap: ([^\r\n]*)/', $robotsResponse, $matchs);
                $sitemaps = $matchs[1] ?? false;
            }

            if (Str::of($robotsResponse)->lower()->contains('disallow:')) {
                preg_match_all('/Disallow: ([^\r\n]*)/', $robotsResponse, $robotsRules);
                foreach ($robotsRules[0] as $robotsRule) {
                    $rule = Str::of($robotsRule)->lower()->explode(':', 2);
                    $directive = trim($rule[0] ?? null);
                    $value = trim($rule[1] ?? null);

                    if ($directive == 'disallow' && $value) {
                        $disallowRules[] = $value;
                        if (preg_match($this->formatRobotsRule($value), $this->baseUrl)) {
                            $isDisallowed[] = $value;
                        }
                    }
                }
            }
        }

        return [
            'has_robots_txt' => !empty($robotsResponse),
            'has_ads_txt'=> !empty($adsResponse),
            'disallow_rules' => $disallowRules,
            'disallowed' => $isDisallowed,
            'sitemaps' => $sitemaps,
        ];
    }

    private function checkNoIndex($headNode)
    {
        $noIndex = null;
        foreach ($headNode->getElementsByTagName('meta') as $node) {
            if (strtolower($node->getAttribute('name')) == 'googlebot' || strtolower($node->getAttribute('name')) == 'robots') {
                if (preg_match('/\bnoindex\b/', $node->getAttribute('content'))) {
                    $noIndex = $node->getAttribute('content');
                }
            }
        }

        return $noIndex;
    }

    private function checkNotfoundPage()
    {
        $cacheKey = md5($this->domainUrl) . "-404-page";
        $hasNotfoundPage = Cache::remember($cacheKey, 30, function () {
            $hasNotfoundPage = false;
            $notFoundUrl =  Str::of($this->domainUrl)->finish('/')->finish('404-page-' . Str::uuid())->toString();
            try {
                $this->client->get($notFoundUrl);
            } catch (RequestException $e) {
                if ($e->hasResponse() && $e->getResponse()->getStatusCode() == '404') {
                    $hasNotfoundPage = true;
                }
            } catch (\Exception $e) {
            }

            return [
                'has_notfound' => $hasNotfoundPage,
                'test_url' => $notFoundUrl
            ];
        });

        return $hasNotfoundPage;
    }

    private function getPageContent($url)
    {
        $response = $this->client->request('GET', $url, [
            'on_stats' => function (TransferStats $stats) {
                $this->loadtime = $stats->getTransferTime();
                $this->http2 = $stats->getHandlerStat('http_version') === 2;
                $this->pagesize = $stats->getHandlerStat('size_download');
            },
            'on_headers' => function (ResponseInterface $response) {
                $servers = array_filter($response->getHeader('server'), function ($value) {
                    return !in_array($value, ['amazon', 'cloudflare', 'gws', 'Server', 'Apple', 'tsa_o', 'ATS']);
                });
                $this->hsts = count($response->getHeader('Strict-Transport-Security')) !== 0;
                $this->server = $servers;
                $this->encoding = $response->getHeader('x-encoded-content-encoding');
            },
        ]);

        $this->redirects = $this->trackRedirects($response, $url);

        $body = (string) $response->getBody();

        return $body;
    }

    private function trackRedirects($response, $url)
    {
        $fullRedirectReport = [];
        $redirectUriHistory = $response->getHeader('X-Guzzle-Redirect-History'); // retrieve Redirect URI history
        $redirectCodeHistory = $response->getHeader('X-Guzzle-Redirect-Status-History'); // retrieve Redirect HTTP Status history
        array_unshift($redirectUriHistory, $url);
        array_push($redirectCodeHistory, $response->getStatusCode());

        foreach ($redirectUriHistory as $key => $value) {
            $fullRedirectReport[$key] = ['location' => $value, 'code' => (int) $redirectCodeHistory[$key]];
        }

        return $fullRedirectReport;
    }

    private function getTextContent($text)
    {
        $text = preg_replace(
            [
                // Remove invisible content
                '@<head[^>]*?>.*?</head>@siu',
                '@<style[^>]*?>.*?</style>@siu',
                '@<script[^>]*?.*?</script>@siu',
                '@<object[^>]*?.*?</object>@siu',
                '@<embed[^>]*?.*?</embed>@siu',
                '@<applet[^>]*?.*?</applet>@siu',
                '@<noframes[^>]*?.*?</noframes>@siu',
                '@<noscript[^>]*?.*?</noscript>@siu',
                '@<noembed[^>]*?.*?</noembed>@siu',

                // Add line breaks before & after blocks
                '@<((br)|(hr))@iu',
                '@</?((address)|(blockquote)|(center)|(del))@iu',
                '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
                '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
                '@</?((table)|(th)|(td)|(caption))@iu',
                '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
                '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
                '@</?((frameset)|(frame)|(iframe))@iu',
            ],
            [
                ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
                "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
                "\n\$0", "\n\$0",
            ],
            $text
        );

        // Remove all remaining tags and comments and return.
        return html_entity_decode(strip_tags($text));
    }

    private function doStructuredData($document)
    {
        $data = [];
        $headNode = $document->getElementsByTagName('head')->item(0);
        foreach ($headNode->getElementsByTagName('meta') as $node) {
            if (Str::contains($node->getAttribute('property'), "og:") && !empty($node->getAttribute('content'))) {
                $data['og'][$node->getAttribute('property')] = $node->getAttribute('content');
            }

            if (Str::contains($node->getAttribute('name'), "twitter:") && !empty($node->getAttribute('content'))) {
                $data['twitter'][$node->getAttribute('name')] = $node->getAttribute('content');
            }
        }
        foreach ($document->getElementsByTagName('script') as $node) {
            if (Str::contains($node->getAttribute('type'), 'application/ld+json')) {
                preg_match('/\<!\[CDATA\[-html5-dom-document-internal-cdata(.*?)-html5-dom-document-internal-cdata\]\]>/s', $node->nodeValue, $nodeValue);
                if (isset($nodeValue[1])) {
                    $value = json_decode($nodeValue[1], true);
                    if (is_string($value['@context']) && Str::contains($value['@context'], 'schema.org')) {
                        $data['schema'] = $value;
                    }
                }
            }
        }

        return $data;
    }

    private function getWebsiteUsabelNode($nodes)
    {
        $node = $this->findLargestNode($nodes);

        return $node;
    }

    private function findLargestNode($nodes)
    {
        $largestNode = null;
        $largestTxtLength = 0;
        foreach ($nodes as $token => $node) {
            $length = strlen($this->getTextContent($node['node']->outerHTML));
            if ($largestTxtLength < $length) {
                $largestTxtLength = $length;
                $largestNode = $node;
            }
        }

        if ($largestNode === null) {
            return $nodes;
        }
        $largestChildNode = $this->findLargestChildNode($largestNode['childs'], $largestTxtLength);

        if ($largestChildNode === false) {
            return $largestNode;

            throw new Exception("Can't find main text block.");
        }

        return $largestChildNode;
    }

    private function parseHtml($body)
    {
        $dom = new HTML5DOMDocument();
        $dom->loadHTML($body, HTML5DOMDocument::ALLOW_DUPLICATE_IDS);

        return $dom;
    }

    private function parseHtmlIntoBlocks($document)
    {
        $bodyNode = $document->querySelector('body');

        $nodes = $this->loadChilds($bodyNode);

        return $nodes;
    }

    private function loadChilds($node)
    {
        if ($node === null) {
            return;
        }

        $parentTagName = $node->tagName;
        $parentToken = md5($node->outerHTML);
        $qry = $node->querySelectorAll('*');

        $childs = [];
        foreach ($qry as $child) {
            if (!isset($node->tagName)) {
                continue;
            }

            if (in_array($child->tagName, ['svg', 'script'])) {
                continue;
            }

            if ($parentTagName === $child->parentNode->tagName && $parentToken === md5($child->parentNode->outerHTML)) {
                $loadedChilds = $this->loadChilds($child);
                $childs[md5($child->outerHTML)] = [
                    'node'   => $child,
                    'childs' => $loadedChilds,
                ];
            }
        }

        return $childs;
    }

    private function findLargestChildNode($nodes, $maxLength)
    {
        $largestNode = null;
        $largestTxtLength = 0;
        foreach ($nodes as $token => $node) {
            $length = strlen($this->getTextContent($node['node']->outerHTML));
            if ($largestTxtLength < $length) {
                $largestTxtLength = $length;
                $largestNode = $node;
            }
        }

        if ($maxLength / 2 < $largestTxtLength) {
            if (count($largestNode['childs']) === 0) {
                return $largestNode;
            }

            $possibleLargestNode = $this->findLargestChildNode($largestNode['childs'], $maxLength);
            if ($possibleLargestNode !== false) {
                return $possibleLargestNode;
            }

            return $largestNode;
        }

        return false;
    }

    private function countWords($content)
    {
        return count(str_word_count(strtolower($content), 1));
    }

    private function findKeywords($content, $min = 3)
    {
        $words = $this->str_word_count($content);

        $word_count = array_count_values($words);
        arsort($word_count);

        foreach ($this->stopWords as $s) {
            unset($word_count[$s]);
        }

        $word_count = array_filter($word_count, function ($value) use ($min) {
            return $value >= $min;
        });

        return $word_count;
    }

    private function getLongTailKeywords($strs, $len = 3, $min = 3, $limit = 15)
    {
        $keywords = [];
        if (!is_array($strs)) {
            $strs = [$strs];
        }

        foreach ($strs as $str) {
            $str = preg_replace('/[^a-z0-9\s-]+/', '', strtolower($str));
            $str = preg_split('/\s+-\s+|\s+/', $str, -1, PREG_SPLIT_NO_EMPTY);
            while (0 < $len--) {
                for ($i = 0; $i < count($str) - $len; $i++) {
                    $word = array_slice($str, $i, $len + 1);
                    if (in_array($word[0], $this->stopWords) || in_array(end($word), $this->stopWords)) {
                        continue;
                    }

                    $word = implode(' ', $word);

                    if (!isset($keywords[$len][$word])) {
                        $keywords[$len][$word] = 0;
                    }

                    $keywords[$len][$word]++;
                }
            }
        }

        $return = [];
        foreach ($keywords as $keyword) {
            $keyword = array_filter($keyword, function ($v) use ($min) {
                return $v >= $min;
            });
            arsort($keyword);
            $return = array_merge($return, $keyword);
        }

        return collect($return)->take($limit)->toArray();
    }

    private function doHeaderResult($document)
    {
        $tags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
        $result = [];
        $totalHeaders = 0;

        foreach ($tags as $tag) {
            $elements = $document->querySelectorAll($tag);

            $content = [];
            foreach ($elements as $element) {
                $content[] = trim($this->getTextContent($element->outerHTML));
            }

            $txt = implode(' ', $content);
            $totalHeaders += count($content);
            $result[$tag] = [
                'count'            => count($content),
                'words'            => count(str_word_count(strtolower($txt), 1)),
                'keywords'         => $this->findKeywords($txt, 1),
                'longTailKeywords' => $this->getLongTailKeywords($content, 2, 1),
                'headers'          => $content,
            ];
        }

        return ['total' => $totalHeaders, 'tags' => $result];
    }

    private function doLinkResult($document)
    {
        $elements = $document->querySelectorAll('a');
        $internal = 0;
        $external = 0;
        $friendly = 0;
        $follow = 0;
        $nofollow = 0;

        $content = [];
        $links = collect([]);
        foreach ($elements as $element) {
            $content[] = $this->getTextContent($element->outerHTML);
            $attributes = $element->getAttributes();
            if (isset($attributes['href'])) {
                $url = $this->fixUrl($attributes['href']);
                if ($links->where('url', $url)->count() != 0) {
                    continue;
                }

                if (strpos(strtolower($url), 'javascript:') === 0) {
                    continue;
                }

                $linkAnchor = trim($this->getTextContent($element->outerHTML));
                if (empty($linkAnchor)) {
                    $linkAnchor = strpos($element->outerHTML, '<img') !== false ? 'image' : $linkAnchor;
                }

                $link = [
                    'url'      => $url,
                    'internal' => false,
                    'nofollow' => false,
                    'friendly' => true,
                    'content'  => $linkAnchor,
                ];

                if ($this->isInternal($url)) {
                    $link['internal'] = true;
                    $internal++;
                    if (!$this->isSeoFriendly($url)) {
                        $link['friendly'] = false;
                        $friendly++;
                    }
                } else {
                    $link['internal'] = false;
                    if (strpos(strtolower($url), 'tel:') === false && strpos(strtolower($url), 'mailto:') === false) {
                        $external++;
                    }
                }

                if (isset($attributes['rel'])) {
                    if (strpos($attributes['rel'], 'nofollow') !== false && strpos($attributes['rel'], 'nofollow') >= 0) {
                        $link['nofollow'] = true;
                        $nofollow++;
                    } else {
                        $follow++;
                    }
                } else {
                    $follow++;
                }

                $links->push($link);
            }
        }

        $txt = implode(' ', $content);

        return [
            'count'            => count($content),
            'words'            => count(str_word_count(strtolower($txt), 1)),
            'keywords'         => $this->findKeywords($txt, 1),
            'longTailKeywords' => $this->getLongTailKeywords($content, 2, 2),
            'internal'         => $internal,
            'external'         => $external,
            'friendly'         => $friendly,
            'follow'           => $follow,
            'nofollow'         => $nofollow,
            'links'            => $links,
        ];
    }

    private function isSeoFriendly($url)
    {
        return !preg_match('/[\?\=\_\%\,\ ]/ui', $url);
    }

    private function doImageResult($document,$baseurl)
    {
        $elements = $document->querySelectorAll('img');

        $content = [];
        $images = [];
        foreach ($elements as $element) {
            $attributes = $element->getAttributes();
            $img = [
                'src'   => $attributes['src'] ?? $attributes['data-src'] ?? $attributes['data-delayed-url'],
                'alt'   => $attributes['alt'] ?? null,
                'title' => $attributes['title'] ?? null,
            ];
            if (empty($img['src'])) {
                continue;
            }

            if (!empty($img['alt'])) {
                $content[] = $this->getTextContent($img['alt']);
            }


 if (preg_match("/cdn/i", $this->fixUrl($img['src']))) {
            
            $replacedString = preg_replace('#' . preg_quote($baseurl) . 'cdn#', 'https://cdn', $this->fixUrl($img['src']));
                 $img['src'] =  $replacedString;
                } else {
     
                $img['src'] = $this->fixUrl($img['src']);
   
}

            $images[] = $img;
        }

        $txt = implode(' ', $content);

        return [
            'count'            => count($images),
            'count_alt'        => count($content),
            'words'            => count(str_word_count(strtolower($txt), 1)),
            'keywords'         => $this->findKeywords($txt, 1),
            'longTailKeywords' => $this->getLongTailKeywords($content, 2, 2),
            'images'           => $images,
        ];
    }

    private function fixUrl($url)
    {
        $url = str_replace('\\?', '?', $url);
        $url = str_replace('\\&', '&', $url);
        $url = str_replace('\\#', '#', $url);
        $url = str_replace('\\~', '~', $url);
        $url = str_replace('\\;', ';', $url);

        if (strpos($url, '#') !== false) {
            $url = substr($url, 0, strpos($url, '#'));
        }

        if (strpos(strtolower($url), 'http://') === 0) {
            return $url;
        }

        if (strpos(strtolower($url), 'https://') === 0) {
            return $url;
        }

        if (strpos(strtolower($url), '/') === 0) {
            return rtrim($this->domainUrl, '/') . '/' . ltrim($url, '/');
        }

        if (strpos(strtolower($url), 'data:image') === 0) {
            return $url;
        }

        if (strpos(strtolower($url), 'tel:') === 0) {
            return $url;
        }

        if (strpos(strtolower($url), 'mailto:') === 0) {
            return $url;
        }

        if (strpos(strtolower($url), 'javascript:') === 0) {
            return $url;
        }

        $fixedUrl = $this->abs_url(ltrim($url, '/'), rtrim($this->baseUrl, '/'));
        if ($fixedUrl === false) {
            $fixedUrl = $url;
        }

        return $fixedUrl;
    }

    private function isInternal($url)
    {
        if (strpos($url, $this->domainname) > 0) {
            return true;
        }

        return false;
    }

    private function str_word_count($string)
    {
        $string = str_replace(["\n", "\r"], '', $string);

        $words = preg_split('~[\p{Z}\p{P}]+~u', mb_strtolower($string), -1, PREG_SPLIT_NO_EMPTY);

        $words = array_map(function ($word) {
            $word = trim($word);
            $word = $this->convertNumbers($word);

            return !($word == '' || is_numeric($word)) ? $word : null;
        }, $words);

        return array_filter($words);
    }

    /**
     * Converts non-english numbers to english numbers.
     *
     * @param $string
     *
     * @return string
     */
    private function convertNumbers($string)
    {
        return strtr($string, ['۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9']);
    }

    /**
     * Build a URL.
     *
     * @param array $parts An array that follows the parse_url scheme
     *
     * @return string
     */
    public function build_url($parts)
    {
        if (isset($parts['scheme']) && !in_array($parts['scheme'], ['http', 'https'])) {
            return false;
        }

        if (empty($parts['user'])) {
            $url = $parts['scheme'] . '://' . $parts['host'];
        } elseif (empty($parts['pass'])) {
            $url = $parts['scheme'] . '://' . $parts['user'] . '@' . $parts['host'];
        } else {
            $url = $parts['scheme'] . '://' . $parts['user'] . ':' . $parts['pass'] . '@' . $parts['host'];
        }

        if (!empty($parts['port'])) {
            $url .= ':' . $parts['port'];
        }

        if (!empty($parts['path'])) {
            $url .= $parts['path'];
        }

        if (!empty($parts['query'])) {
            $url .= '?' . $parts['query'];
        }

        if (!empty($parts['fragment'])) {
            return $url . '#' . $parts['fragment'];
        }

        return $url;
    }

    /**
     * Convert a relative path in to an absolute path.
     *
     * @param string $path
     *
     * @return string
     */
    public function abs_path($path)
    {
        $path_array = explode('/', $path);

        // Solve current and parent folder navigation
        $translated_path_array = [];
        $i = 0;
        foreach ($path_array as $name) {
            if ($name === '..') {
                unset($translated_path_array[--$i]);
            } elseif (!empty($name) && $name !== '.') {
                $translated_path_array[$i++] = $name;
            }
        }

        return '/' . implode('/', $translated_path_array);
    }

    /**
     * Convert a relative URL in to an absolute URL.
     *
     * @param string $url  URL or URI
     * @param string $base Absolute URL
     *
     * @return string
     */
    public function abs_url($url, $base)
    {
        $url_parts = parse_url($url);
        $base_parts = parse_url($base);

        // Handle the path if it is specified
        if (!empty($url_parts['path'])) {
            // Is the path relative
            if (substr($url_parts['path'], 0, 1) !== '/') {
                if (isset($base_parts['path']) && substr($base_parts['path'], -1) === '/') {
                    $url_parts['path'] = $base_parts['path'] . $url_parts['path'];
                } else {
                    $url_parts['path'] = dirname($base_parts['path'] ?? null) . '/' . $url_parts['path'];
                }
            }

            // Make path absolute
            $url_parts['path'] = $this->abs_path($url_parts['path']);
        }

        // Use the base URL to populate the unfilled components until a component is filled
        foreach (['scheme', 'host', 'path', 'query', 'fragment'] as $comp) {
            if (!empty($url_parts[$comp])) {
                break;
            }
            $url_parts[$comp] = $base_parts[$comp] ?? null;
        }

        return $this->build_url($url_parts);
    }

    private function doInlineCSS($document)
    {
        $inlineCss = [];
        foreach ($document->getElementsByTagName('*') as $node) {
            if ($node->nodeName != 'svg' && !empty($node->getAttribute('style'))) {
                $inlineCss[] = $node->getAttribute('style');
            }
        }

        return $inlineCss;
    }

    private function doDeprecatedTags($document)
    {
        $deprecatedTags = [];
        $total = 0;
        $tags = ['acronym', 'applet', 'basefont', 'big', 'center', 'dir', 'font', 'frame', 'frameset', 'isindex', 'noframes', 's', 'strike', 'tt', 'u','marquee'];
        $tags = implode(',', $tags);
        foreach ($document->querySelectorAll($tags) as $node) {
            $deprecatedTags[$node->nodeName] = isset($deprecatedTags[$node->nodeName]) ? $deprecatedTags[$node->nodeName] += 1 : 1;
            $total++;
        }

        return compact('total', 'deprecatedTags');
    }

    private function getCharset($headNode)
    {
        $charset = null;
        foreach ($headNode->getElementsByTagName('meta') as $node) {
            if ($node->getAttribute('charset')) {
                $charset = $node->getAttribute('charset');
            }
        }

        return $charset;
    }

    private function doNestedTablesTest($document)
    {
        return count($document->querySelectorAll('table table'));
    }

    private function doFramesetTest($document)
    {
        return count($document->querySelectorAll('frameset'));
    }

    private function doDepricatedAttributes($document)
    {
        $deprecatedAttributes = [];
        $attributes = [];

        return $deprecatedAttributes;
    }

    private function doHttp2AndHstsTest($url)
    {
        $http2 = false;
        $hsts = false;
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_HEADER         => true,
            CURLOPT_NOBODY         => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_2_0,
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        if ($response) {
            $http2 = Str::contains($response, 'HTTP/2');
            $hsts = Str::contains($response, "strict-transport-security");
        }

        return compact('http2', 'hsts');
    }

    private function formatRobotsRule($value)
    {
        $before = ['*' => '__ASTERISK', '$' => '__DOLLAR'];
        $after = ['__ASTERISK' => '.*', '__DOLLAR' => '$'];

        return '/' . str_replace(array_keys($after), array_values($after), preg_quote(str_replace(array_keys($before), array_values($before), $value), '/')) . '/i';
    }

 private function mediaquery($url,$document)
{

    $opts = array(
'http'=>array(
'method'=>"GET",
'header'=>"User-Agent: lashaparesha api script\r\n"
));

$ch = curl_init();

// Set the URL to fetch
curl_setopt($ch, CURLOPT_URL, $url);

// Set the option to return the response as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the request
$html = curl_exec($ch);

// Close cURL
curl_close($ch);
// Find all local css files
$query = preg_match( "(@media)", $html);

if($query == false){
    
    
     $minify = null;
        $css_files = 0;
        $csslinks= [];
       
        foreach ($document->getElementsByTagName('link') as $node) {
            if (preg_match('/\bstylesheet\b/', $node->getAttribute('rel'))) {
                 $minify = $this->fixUrl($node->getAttribute('href'));
                 if (preg_match("/cdn/i", $minify)) {
            
            $replacedString = preg_replace('#' . preg_quote($baseurl) . 'cdn#', 'https://cdn', $minify);
            
                 array_push($csslinks, $replacedString);
                $css_files++;
                } else {
     
                 array_push($csslinks, $minify);
                $css_files++;
   
}
            }

        }


foreach($csslinks as $cssfile){
    $ch = curl_init();

// Set the URL to fetch
curl_setopt($ch, CURLOPT_URL, $cssfile);

// Set the option to return the response as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the request
$html = curl_exec($ch);

// Close cURL
curl_close($ch);
// Find all local css files
$query = preg_match( "(@media)", $html);

if($query == true) break; else '';

}

}


// Return the number of files that we don't think are minified
return $query;
}




    private function isDirectoryBrowsingEnabled($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    if (strpos($response, 'Index of /') !== false) {
        // Directory browsing is enabled
        return true;
    } else {
        // Directory browsing is disabled
        return false;
    }
}

private function hasGoogleSiteVerification($document,$url)
{
    $result = false;
    
        $linkNodes = $document->querySelectorAll('meta');
        foreach ($linkNodes as $node) {
            $attributes = $node->getAttributes();
            if (isset($attributes['name']) &&  $attributes['name'] === 'google-site-verification') {
               $result = true;
            }
        }
  
    if($result == false){
    $r = dns_get_record($this->domainname, DNS_TXT);
    for($i = 0; $i<sizeof($r);$i++){
    if (preg_match('/google/i',$r[$i]['txt'])) {
       $result = true;
    }
        }
    }
    return $result;
}

// private function jsexecution($url)
// {
//     // API endpoint URL
//     $apiUrl = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=" . urlencode($url);

//     // API key (optional, but recommended for higher quota limits)
//     $apiKey = "";

//     // Add API key to the URL if available
//     if (!empty($apiKey)) {
//         $apiUrl .= "&key=" . $apiKey;
//     }

//     // Send the HTTP request and retrieve the response
//     $response = file_get_contents($apiUrl);

//     // Decode the JSON response
//     $data = json_decode($response, true);

//      return $data['lighthouseResult']['audits']['bootup-time'];
// }
// private function cls($url)
// {
//     // API endpoint URL
//     $apiUrl = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=" . urlencode($url);

//     // API key (optional, but recommended for higher quota limits)
//     $apiKey = "";

//     // Add API key to the URL if available
//     if (!empty($apiKey)) {
//         $apiUrl .= "&key=" . $apiKey;
//     }

//     // Send the HTTP request and retrieve the response
//     $response = file_get_contents($apiUrl);

//     // Decode the JSON response
//     $data = json_decode($response, true);

//       return $data['lighthouseResult']['audits']['cumulative-layout-shift'];
// }
private function errorinconsole($url)
{
    $apiUrl = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=" . urlencode($url)."&category=BEST_PRACTICES";

    // API key (optional, but recommended for higher quota limits)
    $apiKey = "";

    // Add API key to the URL if available
    if (!empty($apiKey)) {
        $apiUrl .= "&key=" . $apiKey;
    }

   $ch = curl_init();

// Set the URL to fetch
curl_setopt($ch, CURLOPT_URL, $apiUrl);

// Set the option to return the response as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the request
$response = curl_exec($ch);

// Close cURL
curl_close($ch);

    // Decode the JSON response
    $data = json_decode($response, true);

    return $data['lighthouseResult']['audits']['errors-in-console'];
}

 private function getPageSpeedInsights($url)
{
    $largestcontentfulpaint = [];
    $apiUrl = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=" . urlencode($url);

    // API key (optional, but recommended for higher quota limits)
    $apiKey = "AIzaSyAku8QRhr8d4hJylc8D1RJxhuOQ54xTvaA";

    // Add API key to the URL if available
    if (!empty($apiKey)) {
        $apiUrl .= "&key=" . $apiKey;
    }

    // Send the HTTP request and retrieve the response

   $ch = curl_init();

// Set the URL to fetch
curl_setopt($ch, CURLOPT_URL, $apiUrl);

// Set the option to return the response as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the request
$response = curl_exec($ch);

// Close cURL
curl_close($ch);

    // Decode the JSON response
    $data = json_decode($response, true);
    array_push($largestcontentfulpaint,$data['lighthouseResult']['audits']['largest-contentful-paint']);
    array_push($largestcontentfulpaint,$data['lighthouseResult']['audits']['lcp-lazy-loaded'],);
    return 
    [
        'jsexecution'            =>$data['lighthouseResult']['audits']['bootup-time'],
        'cls'        => $data['lighthouseResult']['audits']['cumulative-layout-shift'],
        'render-blocking-resources' =>$data['lighthouseResult']['audits']['render-blocking-resources'],
        'largest-contentful-paint'  => $largestcontentfulpaint,
    ];
}

private function isSafeBrowsing($url) {
    // Initialize cURL
    $curl = curl_init($url);

    // Set options
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_NOBODY, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');

    // Execute the request
    $response = curl_exec($curl);
    
    // Check for cURL errors
    if (curl_errno($curl)) {
        curl_close($curl);
        return false; // An error occurred while fetching the URL
    }

    // Get the response HTTP code
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    // Close cURL
    curl_close($curl);

    // Check if the URL is accessible
    if ($httpCode !== 200) {
        return false; // The URL is not safe or inaccessible
    }

    // Check if the response contains any malicious content
    $content = substr($response, strpos($response, "\r\n\r\n") + 4);
    $maliciousKeywords = ['malware', 'phishing', 'attack', 'virus', 'dangerous'];
    foreach ($maliciousKeywords as $keyword) {
        if (stripos($content, $keyword) !== false) {
            return false; // The URL contains potentially malicious content
        }
    }

    return true; // The URL is safe to browse
}

private function hasGoogleAnalytics($url) {
    $ch = curl_init();

// Set the URL to fetch
curl_setopt($ch, CURLOPT_URL, $url);

// Set the option to return the response as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the request
$html = curl_exec($ch);

// Close cURL
curl_close($ch);
    $result = false;
    // Search for the Google Analytics tracking code
    $gaCodePattern = '/(UA|YT|MO)-\d{4,}-\d{1,}/'; // Pattern for matching Google Analytics tracking code
    if (preg_match($gaCodePattern, $html, $matches)) {
      $trackingCode = $matches[0];
      $result= true;
    } else {
        $result= false;
    }
if( $result == false){
    $trackingDomain = 'www.google-analytics.com'; // Google Analytics tracking domain

    $domain = parse_url($url, PHP_URL_HOST); // Extract the domain from the URL
  
    // Perform a DNS lookup for the Google Analytics tracking domain
    $ipAddresses = gethostbynamel($trackingDomain);
    
    // Check if the domain is resolved to any IP address
    if (is_array($ipAddresses) && count($ipAddresses) > 0) {
        $result= true;
    } else {
        $result= false;
    }
}
return  $result;
  }
  
  
  private function cdnUsage($doc,$websiteUrl){
        $cdnUrls = [];
      // Find all <img> tags and extract the 'src' attribute
      $imgTags = $doc->getElementsByTagName('img');
      foreach ($imgTags as $tag) {
          $src = $tag->getAttribute('src');
          if (strpos($src, '//') === 0) {
              // Handle URLs starting with '//' (protocol-relative URLs)
              $src = 'https:' . $src;
          } elseif (strpos($src, 'http') !== 0) {
              // Handle relative URLs
              $src = $websiteUrl . '/' . ltrim($src, '/');
          }
  
          if (strpos($src, $websiteUrl) === false) {
              // Add only the URLs that are different from the website's domain
              $cdnUrls[] = $src;
          }
      }
  
      // Find all <link> tags and extract the 'href' attribute
      $linkTags = $doc->getElementsByTagName('link');
      foreach ($linkTags as $tag) {
          $href = $tag->getAttribute('href');
          if (strpos($href, '//') === 0) {
              $href = 'https:' . $href;
          } elseif (strpos($href, 'http') !== 0) {
              $href = $websiteUrl . '/' . ltrim($href, '/');
          }
  
          if (strpos($href, $websiteUrl) === false) {
              $cdnUrls[] = $href;
          }
      }
  
      // Print the CDN URLs
      // foreach ($cdnUrls as $cdnUrl) {
      //     echo $cdnUrl . '<br>';
      // }
      return $cdnUrls;
  
}

private function isMinified($url)
{
    // Initialize cURL session
    $ch = curl_init();
    
    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Execute the cURL request and fetch the CSS content
    $cssContent = curl_exec($ch);
    
    // Close the cURL session
    curl_close($ch);
    
    // Count the number of lines in the CSS content
    $lineCount = substr_count($cssContent, "\n") + 1;
    
    // If the line count is below a certain threshold, consider it as minified
    if ($lineCount <= 10) {
        return true;
    }
    
    return false;
}

}
