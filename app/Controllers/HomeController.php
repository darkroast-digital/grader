<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Mailgun\Mailgun;


class HomeController extends Controller
{
    public function index($request, $response, $args)
    {

        return $this->view->render($response, 'home.twig');
    }

    public function results($request, $response, $args) {

      $subheadings = file_get_contents('resources/content/subheadings.json');
      $headingsObj = json_decode($subheadings);

        $url = $request->getParam('website');
        $email = $request->getParam('email');

        if (!isset($_SESSION['email'])) {
          $_SESSION['email'] = $email;
        } 

        // $mg = Mailgun::create('key-1715c074f053673f6e3c4c79e8595390');

        // # Now, compose and send your message.
        // # $mg->messages()->send($domain, $params);
        // $mg->messages()->send('sandbox54da33a8b2644faebc547af411755bc1.mailgun.org', [
        //   'from'    => $_SESSION['email'],
        //   'to'      => 'kim@darkroast.co',
        //   'subject' => 'New website grade',
        //   'html'    => "Email: " . $_SESSION['email'] . "<br/>" .
        //               "Site Graded: " . $url
        // ]);

      //Mobile Code
        $mJson = file_get_contents('https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=' . $url . '&strategy=mobile&screenshot=true&key=AIzaSyCpKRh76fpRflQ33t6RT--FTYSh-_zZr1c');
        $mObj = json_decode($mJson);

          //For screenshot
          $mData    = str_replace('_','/',$mObj->screenshot->data);
          $mData    = str_replace('-','+',$mData);
          $mMimeType = $mObj->screenshot->mime_type;

          $securityTick = $mObj->id;
          if (strpos($securityTick, 'https') !== false) {
            $secure = "true";
          } else {
            $secure = "false";
          }

          //Rules
          $mSpeedScore = $mObj->ruleGroups->SPEED->score;
          $mUsabilityScore = $mObj->ruleGroups->USABILITY->score;

          $mRule = $mObj->formattedResults->ruleResults;

          $AvoidPlugins = $mRule->AvoidPlugins->ruleImpact;
          $ConfigureViewport = $mRule->ConfigureViewport->ruleImpact;
          $SizeContentToViewport = $mRule->SizeContentToViewport->ruleImpact;
          $SizeTapTargetsAppropriately = $mRule->SizeTapTargetsAppropriately->ruleImpact;
          $UseLegibleFontSizes = $mRule->UseLegibleFontSizes->ruleImpact;


        //Desktop Code

        $dJson = file_get_contents('https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=' . $url . '&strategy=desktop&screenshot=true&key=AIzaSyCpKRh76fpRflQ33t6RT--FTYSh-_zZr1c');
        $dObj = json_decode($dJson);

          //For screenshot
          $dData    = str_replace('_','/',$dObj->screenshot->data);
          $dData    = str_replace('-','+',$dData);
          $dMimeType = $dObj->screenshot->mime_type;

          //Rules
          $dSpeedScore = $dObj->ruleGroups->SPEED->score;

          //Rules shortcut variable
          $dRule = $dObj->formattedResults->ruleResults;

          //For varying minifying values
          $arrayVars = json_decode($dJson, true);

          //Page stats
          $numResources = $dObj->pageStats->numberResources;
          $numHosts = $dObj->pageStats->numberHosts;
          $totalRequestBytes = $dObj->pageStats->totalRequestBytes;
            $TRBlength = strlen((string)$totalRequestBytes);
            if($TRBlength >= 7) {
                $totalRequestBytes = $totalRequestBytes / 1000000;
                $totalRequestBytes = round($totalRequestBytes, 2);
                $totalRequestBytes .= "MB";
            } elseif ($TRBlength >= 4) {
                $totalRequestBytes = $totalRequestBytes / 1000;
                $totalRequestBytes = round($totalRequestBytes, 2);
                $totalRequestBytes .= "KB";
            } else {
              $totalRequestBytes .= "bytes";
            }

          $numStaticResources = $dObj->pageStats->numberStaticResources;
          $htmlResponseBytes = $dObj->pageStats->htmlResponseBytes;
            $HRBlength = strlen((string)$htmlResponseBytes);
            if($HRBlength >= 7) {
                $htmlResponseBytes = $htmlResponseBytes / 1000000;
                $htmlResponseBytes = round($htmlResponseBytes, 2);
                $htmlResponseBytes .= "MB";
            } elseif ($HRBlength >= 4) {
                $htmlResponseBytes = $htmlResponseBytes / 1000;
                $htmlResponseBytes = round($htmlResponseBytes, 2);
                $htmlResponseBytes .= "KB";
            } else {
              $htmlResponseBytes .= "bytes";
            }

          $cssResponseBytes = $dObj->pageStats->cssResponseBytes;
            $CRBlength = strlen((string)$cssResponseBytes);
            if($CRBlength >= 7) {
                $cssResponseBytes = $cssResponseBytes / 1000000;
                $cssResponseBytes = round($cssResponseBytes, 2);
                $cssResponseBytes .= "MB";
            } elseif ($CRBlength >= 4) {
                $cssResponseBytes = $cssResponseBytes / 1000;
                $cssResponseBytes = round($cssResponseBytes, 2);
                $cssResponseBytes .= "KB";
            } else {
              $cssResponseBytes .= "bytes";
            }

          $imageResponseBytes = $dObj->pageStats->imageResponseBytes;
            $IRBlength = strlen((string)$imageResponseBytes);
            if($IRBlength >= 7) {
                $imageResponseBytes = $imageResponseBytes / 1000000;
                $imageResponseBytes = round($imageResponseBytes, 2);
                $imageResponseBytes .= "MB";
            } elseif ($IRBlength >= 4) {
                $imageResponseBytes = $imageResponseBytes / 1000;
                $imageResponseBytes = round($imageResponseBytes, 2);
                $imageResponseBytes .= "KB";
            } else {
              $imageResponseBytes .= "bytes";
            }

          $jsResponseBytes = $dObj->pageStats->javascriptResponseBytes;
            $JRBlength = strlen((string)$jsResponseBytes);
            if($JRBlength >= 7) {
                $jsResponseBytes = $jsResponseBytes / 1000000;
                $jsResponseBytes = round($jsResponseBytes, 2);
                $jsResponseBytes .= "MB";
            } elseif ($JRBlength >= 4) {
                $jsResponseBytes = $jsResponseBytes / 1000;
                $jsResponseBytes = round($jsResponseBytes, 2);
                $jsResponseBytes .= "KB";
            } else {
              $jsResponseBytes .= "bytes";
            }

          $otherResponseBytes = $dObj->pageStats->otherResponseBytes;
            $ORBlength = strlen((string)$otherResponseBytes);
            if($ORBlength >= 7) {
                $otherResponseBytes = $otherResponseBytes / 1000000;
                $otherResponseBytes = round($otherResponseBytes, 2);
                $otherResponseBytes .= "MB";
            } elseif ($ORBlength >= 4) {
                $otherResponseBytes = $otherResponseBytes / 1000;
                $otherResponseBytes = round($otherResponseBytes, 2);
                $otherResponseBytes .= "KB";
            } else {
              $otherResponseBytes .= "bytes";
            }

          $numJsResources = $dObj->pageStats->numberJsResources;
          $numCssResources = $dObj->pageStats->numberCssResources;

          //Rule impacts
          $AvoidLandingPageRedirects = $dRule->AvoidLandingPageRedirects->ruleImpact;
          $EnableGzipCompression = $dRule->EnableGzipCompression->ruleImpact;
            if ($EnableGzipCompression != 0) {
              $EnableGzipCompressionBytes = $arrayVars["formattedResults"]["ruleResults"]["EnableGzipCompression"]["urlBlocks"]["0"]["header"]["args"]["1"]["value"];
              $EnableGzipCompressionPercentage = $arrayVars["formattedResults"]["ruleResults"]["EnableGzipCompression"]["urlBlocks"]["0"]["header"]["args"]["2"]["value"];
            } else {
              $EnableGzipCompressionBytes = 0;
              $EnableGzipCompressionPercentage = 0;
            }

          $ServerResponseTime = $dRule->MainResourceServerResponseTime->ruleImpact;
          $LeverageBrowserCaching = $dRule->LeverageBrowserCaching->ruleImpact;
          $PrioritizeVisibleContent = $dRule->PrioritizeVisibleContent->ruleImpact;
          $OptimizeImages = $dRule->OptimizeImages->ruleImpact;

          if ($OptimizeImages != 0) {
              $OptimizeImagesBytes = $arrayVars["formattedResults"]["ruleResults"]["OptimizeImages"]["urlBlocks"]["0"]["header"]["args"]["1"]["value"];
              $OptimizeImagesPercentage = $arrayVars["formattedResults"]["ruleResults"]["OptimizeImages"]["urlBlocks"]["0"]["header"]["args"]["2"]["value"];
            } else {
              $OptimizeImagesBytes = 0;
              $OptimizeImagesPercentage = 0;
            }

            //Convert all to KB and make number
              $sizeOfImageFiles = $OptimizeImagesBytes;

              if (strpos($sizeOfImageFiles, 'KiB') == false) {

                if (strpos($sizeOfImageFiles, 'MiB') !== false) {
                  $sizeOfImageFiles = str_replace('MiB', '', $sizeOfImageFiles);
                  $sizeOfImageFiles = $sizeOfImageFiles * 1000;
                } 

                if (strpos($sizeOfImageFiles, 'B') !== false) {
                  $sizeOfImageFiles = str_replace('B', '', $sizeOfImageFiles);
                  $sizeOfImageFiles = $sizeOfImageFiles / 1000;
                }

              } else {
                $sizeOfImageFiles = str_replace('KiB', '', $sizeOfImageFiles);
              }

              //Turn % into decimal
              $ImageDecimal = str_replace('%', '', $OptimizeImagesPercentage);
              $ImageDecimal = $ImageDecimal * 0.01;
              $ImageDecimal = round($ImageDecimal, 1);

              //figure out unoptimized size
              if ($ImageDecimal != 0) {
                $currentImageFileSize = $sizeOfImageFiles / $ImageDecimal;
              } else {
                $currentImageFileSize = $sizeOfImageFiles;
              }

              //optimized size
              $optimizedImageFileSize = $currentImageFileSize - $sizeOfImageFiles;

          
          $MinifyCss = $dRule->MinifyCss->ruleImpact;

          if ($MinifyCss != 0) {
              $MinifyCssBytes = $arrayVars["formattedResults"]["ruleResults"]["MinifyCss"]["urlBlocks"]["0"]["header"]["args"]["1"]["value"];
              $MinifyCssPercentage = $arrayVars["formattedResults"]["ruleResults"]["MinifyCss"]["urlBlocks"]["0"]["header"]["args"]["2"]["value"];
              $MinifyCssResults = $arrayVars["formattedResults"]["ruleResults"]["MinifyCss"]["urlBlocks"]["0"]["urls"];
              
            } else {
              $MinifyCssBytes = 0;
              $MinifyCssPercentage = 0;
              $MinifyCssResults = "";
            }

            //Convert all to KB and make number
              $sizeOfCssFiles = $MinifyCssBytes;

              if (strpos($sizeOfCssFiles, 'KiB') == false) {

                if (strpos($sizeOfCssFiles, 'MiB') !== false) {
                  $sizeOfCssFiles = str_replace('MiB', '', $sizeOfCssFiles);
                  $sizeOfCssFiles = $sizeOfCssFiles * 1000;
                } 

                if (strpos($sizeOfCssFiles, 'B') !== false) {
                  $sizeOfCssFiles = str_replace('B', '', $sizeOfCssFiles);
                  $sizeOfCssFiles = $sizeOfCssFiles / 1000;
                }

              } else {
                $sizeOfCssFiles = str_replace('KiB', '', $sizeOfCssFiles);
              }

              //Turn % into decimal
              $CssDecimal = str_replace('%', '', $MinifyCssPercentage);
              $CssDecimal = $CssDecimal * 0.01;
              $CssDecimal = round($CssDecimal, 1);

              //figure out unoptimized size
              if ($CssDecimal != 0) {
                $currentCssFileSize = $sizeOfCssFiles / $CssDecimal;
              } else {
                $currentCssFileSize = $sizeOfCssFiles;
              }

              //optimized size
              $optimizedCssFileSize = $currentCssFileSize - $sizeOfCssFiles;

          $MinifyHTML = $dRule->MinifyHTML->ruleImpact;

          if ($MinifyHTML != 0) {
              $MinifyHTMLBytes = $arrayVars["formattedResults"]["ruleResults"]["MinifyHTML"]["urlBlocks"]["0"]["header"]["args"]["1"]["value"];
              $MinifyHTMLPercentage = $arrayVars["formattedResults"]["ruleResults"]["MinifyHTML"]["urlBlocks"]["0"]["header"]["args"]["2"]["value"];
              $MinifyHTMLResults = $arrayVars["formattedResults"]["ruleResults"]["MinifyHTML"]["urlBlocks"]["0"]["urls"];

            } else {
              $MinifyHTMLBytes = 0;
              $MinifyHTMLPercentage = 0;
              $MinifyHTMLResults = "";
            }

            //Convert all to KB and make number
              $sizeOfHTMLFiles = $MinifyHTMLBytes;

              if (strpos($sizeOfHTMLFiles, 'KiB') == false) {

                if (strpos($sizeOfHTMLFiles, 'MiB') !== false) {
                  $sizeOfHTMLFiles = str_replace('MiB', '', $sizeOfHTMLFiles);
                  $sizeOfHTMLFiles = $sizeOfHTMLFiles * 1000;
                } 

                if (strpos($sizeOfHTMLFiles, 'B') !== false) {
                  $sizeOfHTMLFiles = str_replace('B', '', $sizeOfHTMLFiles);
                  $sizeOfHTMLFiles = $sizeOfHTMLFiles / 1000;
                }

              } else {
                $sizeOfHTMLFiles = str_replace('KiB', '', $sizeOfHTMLFiles);
              }

              //Turn % into decimal
              $HTMLDecimal = str_replace('%', '', $MinifyHTMLPercentage);
              $HTMLDecimal = $HTMLDecimal * 0.01;
              $HTMLDecimal = round($HTMLDecimal, 1);

              //figure out unoptimized size
              if ($HTMLDecimal != 0) {
                $currentHTMLFileSize = $sizeOfHTMLFiles / $HTMLDecimal;
              } else {
                $currentHTMLFileSize = $sizeOfHTMLFiles;
              }

              //optimized size
              $optimizedHTMLFileSize = $currentHTMLFileSize - $sizeOfHTMLFiles;


          $MinifyJavaScript = $dRule->MinifyJavaScript->ruleImpact;

          if ($MinifyJavaScript != 0) {
              $MinifyJSBytes = $arrayVars["formattedResults"]["ruleResults"]["MinifyJavaScript"]["urlBlocks"]["0"]["header"]["args"]["1"]["value"];
              $MinifyJSPercentage = $arrayVars["formattedResults"]["ruleResults"]["MinifyJavaScript"]["urlBlocks"]["0"]["header"]["args"]["2"]["value"];
              $MinifyJSResults = $arrayVars["formattedResults"]["ruleResults"]["MinifyJavaScript"]["urlBlocks"]["0"]["urls"];

              
            } else {
              $MinifyJSBytes = 0;
              $MinifyJSPercentage = 0;
              $MinifyJSResults = "";
            }

            //Convert all to KB and make number
              $sizeOfJSFiles = $MinifyJSBytes;

              if (strpos($sizeOfJSFiles, 'KiB') == false) {

                if (strpos($sizeOfJSFiles, 'MiB') !== false) {
                  $sizeOfJSFiles = str_replace('MiB', '', $sizeOfJSFiles);
                  $sizeOfJSFiles = $sizeOfJSFiles * 1000;
                } 

                if (strpos($sizeOfJSFiles, 'B') !== false) {
                  $sizeOfJSFiles = str_replace('B', '', $sizeOfJSFiles);
                  $sizeOfJSFiles = $sizeOfJSFiles / 1000;
                }

              } else {
                $sizeOfJSFiles = str_replace('KiB', '', $sizeOfJSFiles);
              }

              //Turn % into decimal
              $JSDecimal = str_replace('%', '', $MinifyJSPercentage);
              $JSDecimal = $JSDecimal * 0.01;
              $JSDecimal = round($JSDecimal, 1);

              //figure out unoptimized size
              if ($JSDecimal != 0) {
                $currentJSFileSize = $sizeOfJSFiles / $JSDecimal;
              } else {
                $currentJSFileSize = $sizeOfJSFiles;
              }

              //optimized size
              $optimizedJSFileSize = $currentJSFileSize - $sizeOfJSFiles;


          $RenderBlockingResources = $dRule->MinimizeRenderBlockingResources->ruleImpact;

          if ($RenderBlockingResources != 0) {
              $numRenderBlockingResources = $arrayVars["formattedResults"]["ruleResults"]["MinimizeRenderBlockingResources"]["summary"]["args"]["0"]["value"];
            } else {
              $numRenderBlockingResources = 0;
            }

              //Get the urls of render blocking resources
            if ($RenderBlockingResources != 0) {
              $RenderBlockingResourcesUrls = $arrayVars["formattedResults"]["ruleResults"]["MinimizeRenderBlockingResources"]["urlBlocks"]["1"]["urls"];
            } else {
              $RenderBlockingResourcesUrls = "";
            }

          $optimizedArray = [round($optimizedImageFileSize, 2), round($optimizedCssFileSize, 2), round($optimizedJSFileSize, 2), round($optimizedHTMLFileSize, 2)];
          $unoptimizedArray = [round($currentImageFileSize, 2), round($currentCssFileSize, 2), round($currentJSFileSize, 2), round($currentHTMLFileSize, 2)];


            $content = file_get_contents($url);
            $ogdata = [
                'og:title',
                'og:description',
                'og:type',
                'og:url',
                'og:site_name',
                'og:image'
            ];

            $meta = [
                '/title',
                'name="description"',
                'name="keywords"',
                '/h1'
            ];

            $ogi = 0;

            foreach ($ogdata as $check) {
              if (strpos($content, $check) !== false) {
                  $ogi++;
              }
            }

            $metai = 0;

            foreach ($meta as $check) {
              if (strpos($content, $check) !== false) {
                  $metai++;
              }
            }

            $seoScore = 0 + $ogi + $metai;

            if (strpos($content, $ogdata[0]) !== false) {
                $ogTitle = "true";
            } else {
                $ogTitle = "false";
            }
            if (strpos($content, $ogdata[1]) !== false) {
                $ogDesc = "true";
            } else {
                $ogDesc = "false";
            }
            if (strpos($content, $ogdata[2]) !== false) {
                $ogType = "true";
            } else {
                $ogType = "false";
            }
            if (strpos($content, $ogdata[3]) !== false) {
                $ogUrl = "true";
            } else {
                $ogUrl = "false";
            }
            if (strpos($content, $ogdata[4]) !== false) {
                $ogSiteName = "true";
            } else {
                $ogSiteName = "false";
            }
            if (strpos($content, $ogdata[5]) !== false) {
                $ogImage = "true";
            } else {
                $ogImage = "false";
            }
            if (strpos($content, $meta[0]) !== false) {
                $metaTitle = "true";
            } else {
                $metaTitle = "false";
            }
            if (strpos($content, $meta[1]) !== false) {
                $metaDesc = "true";
            } else {
                $metaDesc = "false";
            }
            if (strpos($content, $meta[2]) !== false) {
                $metaKeywords = "true";
            } else {
                $metaKeywords = "false";
            }
            if (strpos($content, $meta[3]) !== false) {
                $h1Exists = "true";
            } else {
                $h1Exists = "false";
            }

            if ($secure == "true") {
              $securityScore = 10;
            } else {
              $securityScore = 0;
            }

          $overallSpeed = ($mSpeedScore + $dSpeedScore)/2;
          $overallGrade = ($overallSpeed + $mUsabilityScore + (10 * $securityScore) + (10 * $seoScore))/4;
          



        return $this->view->render($response, 'results.twig', compact("headingsObj", "url", "mData", "mMimeType", "mSpeedScore", "mUsabilityScore", "AvoidPlugins", "ConfigureViewport", "SizeContentToViewport", "SizeTapTargetsAppropriately", "UseLegibleFontSizes", "dData", "dMimeType", "dSpeedScore", "AvoidLandingPageRedirects", "EnableGzipCompression", "ServerResponseTime", "LeverageBrowserCaching", "PrioritizeVisibleContent", "OptimizeImages", "MinifyCss", "MinifyCssBytes", "MinifyCssPercentage", "MinifyHTML", "MinifyHTMLPercentage", "MinifyHTMLBytes", "MinifyJSPercentage", "MinifyJSBytes", "MinifyJavaScript", "RenderBlockingResources", "numRenderBlockingResources", "RenderBlockingResourcesUrls", "MinifyCssResults", "MinifyHTMLResults", "MinifyJSResults", "overallGrade", "overallSpeed", "OptimizeImagesPercentage", "OptimizeImagesBytes", "numResources", "numHosts", "totalRequestBytes", "numStaticResources", "htmlResponseBytes", "cssResponseBytes", "imageResponseBytes", "jsResponseBytes", "otherResponseBytes", "numJsResources", "numCssResources", "EnableGzipCompressionBytes", "EnableGzipCompressionPercentage", "securityTick", "secure", "optimizedArray", "unoptimizedArray", "ogTitle", "ogDesc", "ogType", "ogUrl", "ogSiteName", "ogImage", "metaTitle", "metaDesc", "metaKeywords", "h1Exists", "seoScore"));

    }

    public function post($request, $response, $args)
    {
        //

    }
}
