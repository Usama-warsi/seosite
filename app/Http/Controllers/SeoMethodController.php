<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use GuzzleHttp\TransferStats;
use GuzzleHttp\RequestOptions;
use IvoPetkov\HTML5DOMDocument;
use Illuminate\Support\Facades\Cache;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Artisan;

class SeoMethodController extends Controller
{
     private $domainUrl;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
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
    public function index()
    {
      
          try {
            Artisan::call('storage:link');
            return 'Cache cleared successfully.';
        } catch (\Exception $e) {
            return 'Error clearing cache: ' . $e->getMessage();
        }
    }


   public function minifycss(Request $request,$lines_per_file = 10)
    {
       
 
     
        // $baseurl= 'https://celebratesobrietygifts.com/';
         $baseurl = $request->url;
        $content = $this->getPageContent($baseurl);
         
        $document = $this->parseHtml($content);
        
     
        $minify = null;
        $css_files = 0;
        $csslinks= [];
        $unminimized_css_files = 0;
        $minimized_css_files = 0;
        $unminimized_css_links = [];
        $minimized_css_links = [];
        
        foreach ($document->getElementsByTagName('link') as $nodes) {
            
            if (preg_match('/\bstylesheet\b/', $nodes->getAttribute('rel')) ) {
                //  $minify = $this->fixUrl($node->getAttribute('href'),$baseurl);
//                  if (preg_match("/cdn\//i", $minify)) {
//             $replacedString = preg_replace('#' . preg_quote($baseurl) . 'cdn\/#', 'https://cdn', $minify);
//                  array_push($csslinks,'https:/'.$replacedString);
//                 $css_files++;
//                 } else {
//                  array_push($csslinks, $minify);
//                 $css_files++;
// }
if (preg_match('/^\/\/\S+/', $nodes->getAttribute('href'), $matches)  ) {
    array_push($csslinks, 'https:'.$nodes->getAttribute('href'));
                $css_files++;
} elseif (preg_match('/^\/\S+/', $nodes->getAttribute('href'), $matches) || !preg_match('/^\/\S+/', $nodes->getAttribute('href'), $matches) && !preg_match('/^http\S+/', $nodes->getAttribute('href'), $matches) ) {
    array_push($csslinks, $baseurl.$nodes->getAttribute('href'));
                $css_files++;
}elseif(empty($nodes->getAttribute('href'))){}else {
    array_push($csslinks, $nodes->getAttribute('href'));
                $css_files++;
}
            
            }

        }
        
        // return $csslinks;
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
    
  public function mediaquery(Request $request)
    {
       

     
        // $baseurl= 'https://celebratesobrietygifts.com/';
         $baseurl = $request->url;
        $content = $this->getPageContent($baseurl);
        
        $document = $this->parseHtml($content);
         
    $query = preg_match("/@media/", $content, $matches);

        $minify = null;
        $css_files = 0;
        $csslinks= [];
      
       
      


if($query == false){
    
    
     $minify = null;
        $css_files = 0;
        $csslinks= [];
       
        foreach ($document->getElementsByTagName('link') as $nodes) {
            
            if (preg_match('/\bstylesheet\b/', $nodes->getAttribute('rel')) ) {
if (preg_match('/^\/\/\S+/', $nodes->getAttribute('href'), $matches)  ) {
    array_push($csslinks, 'https:'.$nodes->getAttribute('href'));
                $css_files++;
} elseif (preg_match('/^\/\S+/', $nodes->getAttribute('href'), $matches) || !preg_match('/^\/\S+/', $nodes->getAttribute('href'), $matches) && !preg_match('/^http\S+/', $nodes->getAttribute('href'), $matches) ) {
    array_push($csslinks, $baseurl.$nodes->getAttribute('href'));
                $css_files++;
}elseif(empty($nodes->getAttribute('href'))){}else {
    array_push($csslinks, $nodes->getAttribute('href'));
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

  $urlEncoded = urlencode($baseurl);
   $apiUrl = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url={$urlEncoded}&strategy=MOBILE";
   $curl = curl_init();
   // Set cURL options
   curl_setopt($curl, CURLOPT_URL, $apiUrl);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   $response = curl_exec($curl);

   if ($response === false) {
      $error = curl_error($curl);
      curl_close($curl);
      return "cURL Error: " . $error;
   }
   curl_close($curl);
   $data = json_decode($response, true);
   $screenshot = $data['lighthouseResult']['audits']['final-screenshot']['details']['data'];
  
        
        return [
            'screenshot' => $screenshot,
            'mediaquery' => $query,
           

        ];
        
    }

 public function minifyjs(Request $request, $lines_per_file = 10)
    {
          $baseurl= $request->url;
          $content = $this->getPageContent($baseurl);
          $document = $this->parseHtml($content);
        $minify = null;
        $js_files = 0;
        $jslinks= [];
        $unminimized_js_files = 0;
        $minimized_js_files = 0;
        $unminimized_js_links = [];
        $minimized_js_links = [];
        
        foreach ($document->getElementsByTagName('script') as $nodes) {
          
            if ($nodes->getAttribute('src')) {
                 
            //   $minify = $this->fixUrl($nodes->getAttribute('src'),$baseurl);
            

if (preg_match('/^\/\/\S+/', $nodes->getAttribute('src'), $matches) ) {
    array_push($jslinks, 'https:'.$nodes->getAttribute('src'));
                $js_files++;
}  elseif (preg_match('/^\/\S+/', $nodes->getAttribute('src'), $matches) || !preg_match('/^\/\S+/', $nodes->getAttribute('src'), $matches) && !preg_match('/^http\S+/', $nodes->getAttribute('src'), $matches) ) {
    array_push($jslinks, $baseurl.$nodes->getAttribute('src'));
                $js_files++;
}elseif(empty($nodes->getAttribute('src'))){}else {
    array_push($jslinks, $nodes->getAttribute('src'));
                $js_files++;
}
              
              
//               if(preg_match("/^\/\/\S+/", $minify) ) {
//          array_push($jslinks, 'https:'.$nodes->getAttribute('src'));
//                 $js_files++;
   
// } elseif(preg_match("/email-decode.min.js/i", $minify)  ){
//                 //   array_push($jslinks, $nodes->getAttribute('src'));
//                 $js_files++;
//               }
//         elseif (preg_match("/\/cdn\//i", $minify)) {
            
//             $replacedString = preg_replace('#' . preg_quote($baseurl) . 'cdn#', 'https://cdn', $minify);
//             //  echo   $replacedString;
//               array_push($jslinks, 'https:/'.$replacedString);
//                 $js_files++;
//                 } elseif(preg_match("/assets.squarespace.com/i", $minify) ) {
//          array_push($jslinks, 'https:'.$nodes->getAttribute('src'));
//                 $js_files++;
   
// }elseif(preg_match("/^\/\/\S+/", $minify) ) {
//          array_push($jslinks, 'https:'.$nodes->getAttribute('src'));
//                 $js_files++;
   
// } else {
//          array_push($jslinks, $nodes->getAttribute('src'));
//                 $js_files++;
   
// }
               
            }
        }
            
        // return $jslinks;
        
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
    

   public function imgcaching(Request $request)
    {
          $baseurl= $request->url;
          $content = $this->getPageContent($baseurl);
          $document = $this->parseHtml($content);
        $minify = null;
        $img_files = 0;
        $imglinks= [];
        $img404 = [];
        $imgmeta = false;
        
        foreach ($document->getElementsByTagName('img') as $nodes) {
            if (!empty($nodes->getAttribute('src'))) {
                //  $minify = $this->fixUrlimg($node->getAttribute('src'),$baseurl);
//              if (preg_match("/cdn/i", $minify)) {
            
//             $replacedString = preg_replace('#' . preg_quote($baseurl) . 'cdn#', 'https://cdn', $node->getAttribute('src'));
//                 array_push($imglinks, $node->getAttribute('src'));
//                 $img_files++;
//                 } else {
//       array_push($imglinks, $node->getAttribute('src'));
//                 $img_files++;
   
// }
                // $totalRequests++;
                
                
                 if (preg_match('/^data:\S+/', $nodes->getAttribute('src'), $matches) ) {
                   
    array_push($imglinks, $nodes->getAttribute('src'));
                $img_files++;
                
} elseif (preg_match('/^\/\/\S+/', $nodes->getAttribute('src'), $matches) ) {
                   
    array_push($imglinks, 'https:'.$nodes->getAttribute('src'));
                $img_files++;
                
}  elseif (preg_match('/^\/\S+/', $nodes->getAttribute('src'), $matches) || !preg_match('/^\/\S+/', $nodes->getAttribute('src'), $matches) && !preg_match('/^http\S+/', $nodes->getAttribute('src'), $matches) ) {
   
    array_push($imglinks, $baseurl.$nodes->getAttribute('src'));
                $img_files++;
}
elseif(empty($nodes->getAttribute('src'))){}
else {
   array_push($imglinks, $nodes->getAttribute('src'));
                $img_files++;
} 
                
                
                
                
             
            }
        }

// return $imglinks;
    $imgWithCaching = array();
$imgWithoutCaching = array();

foreach ($imglinks as $imgUrl) {
  if ($this->isCachingEnabled($imgUrl)) {
    $imgWithCaching[] = $imgUrl;
  } else {
    $imgWithoutCaching[] = $imgUrl;
  }
}

$linecount =0; $lines_per_file = 11;
foreach ($imglinks as $imageUrl) {
    // Check if the URL returns a 200 status code
    $headers = get_headers($imageUrl);
    if ($headers && strpos($headers[0], '200 OK') !== false) {
        if (preg_match("/\.jpg$/i", $imageUrl)) {
            $imageData = exif_read_data($imageUrl);
        } elseif (preg_match("/\svg$/i", $imageUrl, $matches) || preg_match("/base64,([A-Za-z0-9+\/]+={0,2})/", $imageUrl, $matches) || preg_match("/cdn/i", $imageUrl, $matches) || preg_match("/\.webp/i", $imageUrl, $matches) || preg_match("/data:image,([A-Za-z0-9+\/]+={0,2})/", $imageUrl, $matches)) {
            $imageData = null;
        } else {
            $imageData = getimagesize($imageUrl);
        }

        if (is_array($imageData)) {
            $size = sizeof($imageData);
            if ($size > 10) {
                $imgmeta = true;
            }
        }
    } else {
         array_push($img404, $imageUrl);
        
    }
}

        
        return [
            'totalimgfiles' => $img_files,
            'totalimglinks' => $imglinks,
            'imgmeta'       => $imgmeta,
            'cache' => $imgWithCaching,
            'notcache' => $imgWithoutCaching,
            '404img' => $img404,
 
        ];
        
    }

 public function cdnUsage(Request $request){
       $baseurl= $request->url;
       $websiteUrl = $baseurl;
       $websiteUrls = str_replace('/', '\/', $websiteUrl);
    //   return  $websiteUrls;
          $content = $this->getPageContent($baseurl);
          $document = $this->parseHtml($content);
          $doc = $document;
     
        $cdnUrls = [];
      // Find all <img> tags and extract the 'src' attribute
      $imgTags = $doc->getElementsByTagName('img');
      foreach ($imgTags as $tag) {
          $src = $tag->getAttribute('src');
        //   $cdnUrls[] = $src;
          if (strpos($src, '//') === 0) {
              // Handle URLs starting with '//' (protocol-relative URLs)
              $src = 'https:' . $src;
          } elseif (strpos($src, 'http') !== 0) {
              // Handle relative URLs
              $src = $websiteUrl . '/' . ltrim($src, '/');
          }
  
  if (preg_match("/^".$websiteUrls."\S+/",  $src,$matches)) {
        $cdnUrls[] = $src;
       
        }
        //   if (strpos($src, $websiteUrl) === false) {
        //       // Add only the URLs that are different from the website's domain
        //       $cdnUrls[] = $src;
        //   }
      }
  
      // Find all <link> tags and extract the 'href' attribute
      $linkTags = $doc->getElementsByTagName('link');
      foreach ($linkTags as $tag) {
          $href = $tag->getAttribute('href');
        //   $cdnUrls[] = $href;
          if (strpos($href, '//') === 0) {
              $href = 'https:' . $href;
          } elseif (strpos($href, 'http') !== 0) {
              $href = $websiteUrl . '/' . ltrim($href, '/');
          }
  
  if (preg_match("/^".$websiteUrls."\S+/",$href  ,$matches)) {
        $cdnUrls[] = $href;
       
        }
        //   if (strpos($href, $websiteUrl) === false) {
        //       $cdnUrls[] = $href;
        //   }
      }
      
      $linkTags = $doc->getElementsByTagName('script');
      foreach ($linkTags as $tag) {
          $src = $tag->getAttribute('src');
          if (strpos($src, '//') === 0 && !empty($src)) {
              $src = 'https:' . $src;
          } elseif (strpos($src, 'http') !== 0 && !empty($src)) {
              $src = $websiteUrl . '/' . ltrim($src, '/');
          }
  
  if (preg_match("/^".$websiteUrls."\S+/",  $src,$matches) && !empty($src)) {
        $cdnUrls[] = $src;
       
        }
        //   if (strpos($href, $websiteUrl) === false) {
        //       $cdnUrls[] = $href;
        //   }
      }
  
      // Print the CDN URLs
      // foreach ($cdnUrls as $cdnUrl) {
      //     echo $cdnUrl . '<br>';
      // }
      return $cdnUrls;
  
}

 public function getPageSpeedInsights(Request $request)
{
      $url = $request->url;
    //   return $url;
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
    array_push($largestcontentfulpaint,$data['lighthouseResult']['audits']['lcp-lazy-loaded']);
    return 
    [
        'jsexecution'            =>$data['lighthouseResult']['audits']['bootup-time'],
        'cls'        => $data['lighthouseResult']['audits']['cumulative-layout-shift'],
        'renderblockingresources' =>$data['lighthouseResult']['audits']['render-blocking-resources'],
        'largestcontentfulpaint'  => $largestcontentfulpaint,
    ];
}

public function errorinconsole(Request $request)
{
    
    $url = $request->url;
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
  private function parseHtml($body)
    {
        $dom = new HTML5DOMDocument();
        $dom->loadHTML($body, HTML5DOMDocument::ALLOW_DUPLICATE_IDS);

        return $dom;
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

       private function fixUrlimg($url,$baseurl)
    {
      
        $this->domainUrl = parse_url($baseurl, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST);
        $this->baseUrl = parse_url($baseurl, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST) . '/' . ltrim(parse_url($url, PHP_URL_PATH), '/');
        $parsedUrl = parse_url($baseurl);
        $domain = $parsedUrl['host'];
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
   if (strpos(strtolower($url), '//') === 0) {
       $url = ltrim($url, '/');
       
        $url = 'https://'.$domain.'/'.$url;
        $parsedUrl = parse_url($url);
$hostname = $parsedUrl['host'];
$url = $parsedUrl['path'];
$url = $url.'?'.$parsedUrl['query'];

$url = preg_replace('/\/'.$hostname.'\//', '', $url);// Output the modified URL

$url = 'https://'. $hostname.'/'.$url;
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
    // curl_close($ch);
    
        // $cssContent = $this->getPageContent($url);
    // Count the number of lines in the CSS content
    $lineCount = substr_count($cssContent, "\n") + 1;
    
    // If the line count is below a certain threshold, consider it as minified
    if ($lineCount <= 10) {
        return true;
    }
    
    return false;
}
      private  function isCachingEnabled($url)
    {
         if (strpos($url, 'v=') !== false || strpos($url, 'ver=') !== false  || strpos($url, 'version=') !== false) {
        return false;
    }

    
  $headers = get_headers($url, 1);
  return isset($headers['Cache-Control']) || isset($headers['Expires']);
}

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
 

    public function report(Request $request)
    {
        // return $request;
        $html = $request->input('report');
        $sitename = $request->input('url');
        $siteshot = $request->input('ss');
        $id = Auth::user()->id;
        $name = Auth::user()->name;
// return $siteshot;
        // Generate a unique filename with a timestamp and random string
        $filename = 'report_' . now()->format('Ymd_His') . '_' . Str::random(10) . '.ssc';
        DB::table('reports')->insert([
            'user_id' =>$id, // Replace with the actual user_id
            'user_name' =>  $name, // Replace with the actual user_name
            'site_name' => $sitename, // Replace with the actual site_name
            'site_screen' =>$siteshot,
            'report_link' => $filename, // Replace with the actual report_link
            'created_at' => now(), // You can use the current timestamp or provide a specific date
        ]);
        // Save the HTML content to the storage/app/public directory with the generated filename
        $result = Storage::put('reports/' . $filename, $html);
    
        return $result;
    }
    public function showLivFile($filename,Request $request)
{
    $url = $request->input('url');
    // Ensure the file exists
    if (Storage::disk('public')->exists('reports/'.$filename)) {
        $response = Storage::disk('public')->get('reports/'.$filename);

        // Create a response with the .html content type
        // $ = new Response($livContent);
        // $response->header('Content-Type', 'text/html');

        // // Suggest the correct filename and extension
        // $response->header('Content-Disposition', 'inline; filename="' . pathinfo($filename, PATHINFO_FILENAME) . '.html"');

        return view('pages.report',compact('response','url'));
    }

    // Return a 404 response if the file doesn't exist
    abort(404);
}
}


