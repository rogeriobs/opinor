<?php

namespace App\Controller;

use App\Controller\AppController;

class ConfiguracoesDoSiteController extends AppController
{

    public function minifysssssssss()
    {
        require_once (PATH_VENDOR_OPINOR . "phpwee/phpwee.php");

        $pathTemplates = DIR_FRONT . 'src' . DS . 'Template' . DS;

        pr(scandir($pathTemplates));

        $html = file_get_contents("{$pathTemplates}Artigo/get_poll_details.ctp");

        $html = htmlentities($html);

        $minified_html = \PHPWee\Minify::html($html);

        $minified_html = html_entity_decode($minified_html);

        $minified_html = str_replace("<html><body><p>", "", $minified_html);
        $minified_html = str_replace("</p></body></html>", "", $minified_html);

        file_put_contents("{$pathTemplates}Artigo/viewTest.ctp", $minified_html);

        chmod("{$pathTemplates}Artigo/viewTest.ctp", 0777);

        die();

    }

    public function minify()
    {
        require_once (PATH_VENDOR_OPINOR . "phpwee/phpwee.php");

        $pathTemplatesFront = DIR_FRONT . 'src' . DS . 'Template' . DS;

        $directory                     = new \RecursiveDirectoryIterator($pathTemplatesFront);
        $iterator                      = new \RecursiveIteratorIterator($directory);
        $ignore_files_remove_html_body = [
            "Layout/error.ctp",
            "Layout/article.ctp",
            "Layout/default.ctp",
            "Layout/public.ctp",
            "Layout/usuario.ctp",
        ];

        $ignore_template_folder = ["Email"];

        $i = 0;

        foreach($iterator as $value)
        {
            if($value->isFile()){

                $i++;

                if($i == 1000)
                    die();

                $fullpathname = $value->getPathname();

                pr($fullpathname);

                if(in_array(basename(dirname(dirname($fullpathname))), $ignore_template_folder)){
                    continue;
                }

                $html = file_get_contents("{$fullpathname}");

                $html = preg_replace_callback("/<style([\S\s]*?)>([\S\s]*?)<\/style>/i", function($matches)
                {

                    $blockCSS = $matches[2];

                    $css = \PHPWee\Minify::css($blockCSS);

                    return "<style type=\"text/css\">{$css}</style>";
                }, $html);


                $html = preg_replace_callback("/<script[\s\S]*?>[\s\S]*?<\/script>/i", function($matches)
                {
                    $dom = new \DOMDocument();

                    $blockScript = $matches[0];

                    if(@$dom->loadHTML($matches[0])){

                        $script_tag = $dom->getElementsByTagName('script');

                        foreach($script_tag as $script):

                            if($script->hasAttribute("data-no-min")){

                                return $blockScript;
                            }

                            return "<script>" . \PHPWee\Minify::js($script->nodeValue) . "</script>";

                        endforeach;
                    }
                }, $html);

                $html = htmlentities($html);

                $minified_html = \PHPWee\Minify::html($html);

                $minified_html = html_entity_decode($minified_html);

                $minified_html = str_replace("<html><body><p>", "", $minified_html);
                $minified_html = str_replace("</p></body></html>", "", $minified_html);

                file_put_contents($fullpathname, $minified_html);

                echo "<hr>";
            }
        }

        die();

    }

    public function minifyTest()
    {
        require_once (PATH_VENDOR_OPINOR . "phpwee/phpwee.php");

        $html          = file_get_contents("file:///var/www/opinor/site/src/Template/Login/success.ctp");
        $minified_html = \PHPWee\Minify::html($html);

        pr(htmlspecialchars($minified_html));

        die();

    }

}
