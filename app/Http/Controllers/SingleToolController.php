<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Tool;
use Illuminate\Http\Request;
use Butschster\Head\Facades\Meta;
use App\Helpers\Classes\ArtisanApi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Support\Facades\Validator;
use App\Models\Faqs;
use App\Models\Property;
use App\Helpers\Facads\SEO;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Contracts\ToolInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use GuzzleHttp\TransferStats;
use GuzzleHttp\RequestOptions;
use IvoPetkov\HTML5DOMDocument;
use Illuminate\Support\Facades\Cache;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use DOMDocument;
use DOMXPath;

class SingleToolController extends Controller
{    
   
  
   function parseHtml($body)
    {
        $dom = new HTML5DOMDocument();
        $dom->loadHTML($body, HTML5DOMDocument::ALLOW_DUPLICATE_IDS);
        return $dom;
    }
   
 
   
 function fixUrl($url)
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
function isMinified($url)
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

   function isCachingEnabled($url)
    {
  $headers = get_headers($url, 1);
  return isset($headers['Cache-Control']) || isset($headers['Expires']);
}


    function minifycss(Request $data)
    {
      
        $baseurl = $data['url'];
      
          $client = new Client();

        // Make a GET request to the URL
       
        $response = $client->get($baseurl);

        // Get the HTML content from the response
        $htmlContent = $response->getBody()->getContents();

        // Create a DOMDocument instance and load the HTML content
        $dom = new DOMDocument();
        @$dom->loadHTML($htmlContent);

        // Create a DOMXPath instance
        $xpath = new DOMXPath($dom);

        // Query all <link> tags with rel="stylesheet"
        $stylesheets = $xpath->query('//link[@rel="stylesheet"]');

    //     // Loop through the <link> tags and output their href attributes
    //     foreach ($stylesheets as $stylesheet) {
    //         $href = $stylesheet->getAttribute('href');
    //         echo $href . "<br>";
    //     }
   
    //   exit();
    //     $document = parseHtml($content);
        
      
        $minify = null;
        $css_files = 0;
        $csslinks= [];
        $unminimized_css_files = 0;
        $minimized_css_files = 0;
        $unminimized_css_links = [];
        $minimized_css_links = [];
        
        foreach ($stylesheets as $node) {
            if (preg_match('/\bstylesheet\b/', $node->getAttribute('rel'))) {
                 $minify = fixUrl($node->getAttribute('href'));
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
        
        // print_r($csslinks);
        // exit();
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
       
        if (isMinified($url)) {
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
  if (isCachingEnabled($cssUrl)) {
    $cssWithCaching[] = $cssUrl;
  } else {
    $cssWithoutCaching[] = $cssUrl;
  }
}

        return [
            'cssminification'       =>[
            'totalcssfiles' => $css_files,
            'totalcsslinks' => $csslinks,
            'minimizedcssfiles' => $minimized_css_files,
            'minimizedcsslinks' =>  $minimized_css_links,
              'unminimizedcssfiles' => $unminimized_css_files,
            'unminimizedcsslinks' =>  $unminimized_css_links,
            'cache' => $cssWithCaching,
            'notcache' => $cssWithoutCaching,],
            'result' =>['cssminification' => ['status' => count($minimized_css_links) == 0 ? true : false, 'priority' => "3", 'label' => "low", 'type' => "performance"]]

        ];
        
    }
   
   
   
}

